<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // 1) Validasi dasar dulu (qty boleh 0)
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_address' => 'required|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.qty' => 'nullable|integer|min:0|max:1000', // <-- UBAH min:0
        ]);

        // 2) Filter item yang qty > 0
        $items = collect($request->input('items', []))
            ->filter(fn($it) => isset($it['qty']) && (int) $it['qty'] > 0)
            ->values()
            ->all();

        // 3) Kalau semua 0, tolak
        if (count($items) === 0) {
            return back()
                ->withErrors(['items' => 'Pilih minimal 1 menu (qty harus > 0).'])
                ->withInput();
        }

        // 4) Pakai data yang sudah bersih
        $data = [
            'merchant_id' => (int) $request->merchant_id,
            'delivery_date' => $request->delivery_date,
            'delivery_address' => $request->delivery_address,
            'items' => $items,
        ];

        $customer = auth()->user();

        return DB::transaction(function () use ($data, $customer) {

            // Ambil menu dan pastikan semua milik merchant yang sama
            $menuIds = collect($data['items'])->pluck('menu_id')->all();
            $menus = Menu::whereIn('id', $menuIds)->lockForUpdate()->get()->keyBy('id');

            foreach ($data['items'] as $it) {
                $m = $menus->get($it['menu_id']);
                if (!$m || $m->merchant_id != $data['merchant_id'] || !$m->is_active) {
                    abort(422, 'Item menu tidak valid untuk merchant ini.');
                }
            }

            // Generate invoice number (harian)
            $today = now()->format('Ymd');
            $countToday = Order::whereDate('created_at', now()->toDateString())->count();
            $seq = str_pad((string) ($countToday + 1), 4, '0', STR_PAD_LEFT);
            $invoiceNumber = "INV-{$today}-{$seq}";

            $subtotal = 0;
            foreach ($data['items'] as $it) {
                $m = $menus[$it['menu_id']];
                $subtotal += ((float) $m->price) * ((int) $it['qty']);
            }

            $tax = 0;
            $total = $subtotal + $tax;

            $order = Order::create([
                'customer_id' => $customer->id,
                'merchant_id' => $data['merchant_id'],
                'delivery_date' => $data['delivery_date'],
                'delivery_address' => $data['delivery_address'],
                'status' => 'pending',
                'invoice_number' => $invoiceNumber,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);

            foreach ($data['items'] as $it) {
                $m = $menus[$it['menu_id']];
                $qty = (int) $it['qty'];
                $line = ((float) $m->price) * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $m->id,
                    'menu_name_snapshot' => $m->name,
                    'price_snapshot' => $m->price,
                    'qty' => $qty,
                    'line_total' => $line,
                ]);
            }

            return redirect()
                ->route('customer.invoices.show', $order)
                ->with('success', 'Order dibuat. Invoice tersedia.');
        });
    }
}