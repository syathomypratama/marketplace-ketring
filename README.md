Rangkuman Proyek
Aplikasi Marketplace Katering (Laravel)
Saya membangun sebuah aplikasi web berbasis Laravel bernama Marketplace Katering, yang berfungsi sebagai platform penghubung antara perusahaan katering (merchant) dan kantor (customer) untuk kebutuhan makan siang karyawan.
________________________________________
🏗 1. Arsitektur & Konsep
✅ Framework
•	Laravel 12
•	MVC Pattern (Model–View–Controller)
•	Middleware Role-based Access Control
•	Eloquent ORM
✅ Konsep yang diterapkan
•	Authentication manual (tanpa Breeze/Fortify/Filament)
•	Role-based authorization (merchant & customer)
•	Relasi database (One-to-One, One-to-Many)
•	Transaction handling (DB::transaction pada checkout)
•	Invoice number auto-generation
•	Validasi form
•	Route grouping & prefixing
•	Error handling & access restriction
________________________________________
👤 2. Portal Merchant (Katering)
🔐 Registrasi & Login
•	Merchant dapat mendaftar akun
•	Role otomatis diset sebagai merchant
•	Middleware role:merchant membatasi akses
________________________________________
🏢 Pengelolaan Profil
Merchant dapat mengelola:
•	Nama perusahaan
•	Alamat
•	Kota
•	Kontak person
•	Nomor telepon
•	Deskripsi perusahaan
Data ini otomatis ditampilkan di portal customer.
________________________________________
🍱 Pengelolaan Menu
Merchant dapat:
•	Tambah menu
•	Edit menu
•	Hapus menu
•	Upload foto menu
•	Set harga
•	Set kategori
•	Aktif / nonaktifkan menu
Validasi:
•	Foto harus image
•	Harga numeric
•	Deskripsi optional
•	Status aktif boolean
________________________________________
📦 Order Masuk
Merchant dapat:
•	Melihat daftar order
•	Melihat detail order
•	Melihat invoice
•	Update status:
o	pending
o	confirmed
o	processing
o	delivered
o	canceled
________________________________________
🏢 3. Portal Customer (Kantor)
🔐 Registrasi & Login
•	Customer memiliki role customer
•	Middleware role:customer
________________________________________
🔎 Pencarian Katering
Customer dapat:
•	Melihat daftar merchant
•	Melihat profil merchant
•	Melihat sebagian menu
•	Filter berdasarkan kota/kategori (jika ditambahkan)
________________________________________
🛒 Checkout & Pembelian
Customer dapat:
•	Memilih menu
•	Menentukan jumlah porsi
•	Menentukan tanggal pengiriman
•	Mengisi alamat pengiriman
Sistem:
•	Validasi qty minimal 1
•	Validasi tanggal ≥ hari ini
•	Validasi menu milik merchant yang dipilih
•	Menggunakan DB transaction untuk konsistensi data
________________________________________
🧾 Invoice System
Setiap order menghasilkan:
•	Invoice number otomatis (format: INV-YYYYMMDD-0001)
•	Snapshot harga & nama menu (untuk menjaga histori)
•	Subtotal
•	Pajak (opsional)
•	Total akhir
Invoice dapat diakses:
•	Dari sisi customer
•	Dari sisi merchant
________________________________________
🗂 4. Database Design
Relasi utama:
User
↳ hasOne Merchant
↳ hasMany Orders (as customer)
Merchant
↳ hasMany Menus
↳ hasMany Orders
Order
↳ belongsTo Customer
↳ belongsTo Merchant
↳ hasMany OrderItems
OrderItem
↳ belongsTo Order
Menggunakan:
•	Foreign key constraints
•	Cascade delete
•	Decimal untuk harga
•	Snapshot data pada order_items
________________________________________
🎨 5. UI / Layout
•	Sidebar dynamic berdasarkan role
•	Responsive layout
•	Offcanvas sidebar di mobile
•	Table scrollable di mobile
•	Flash message system
•	Error validation display
________________________________________
🔒 6. Keamanan
•	CSRF Protection
•	Middleware role
•	Auth middleware
•	Validasi input
•	Abort 403 jika akses tidak sesuai role
•	Session invalidation saat logout
________________________________________
⚙ 7. Error Handling
Sudah menangani:
•	MethodNotAllowed (PUT/POST mismatch)
•	RouteNotFound
•	Foreign key constraint
•	Image validation error
•	Qty minimal validation
•	Unauthorized access


## Tech Stack
- Laravel 12
- PHP 8.2
- MySQL

## Cara Menjalankan

1. Clone repository
2. Copy .env.example menjadi .env
3. Jalankan:
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan serve
<img width="960" height="449" alt="mer" src="https://github.com/user-attachments/assets/710e2ee7-887a-4cf2-89c5-3cece38096bb" />
<img width="960" height="451" alt="cus" src="https://github.com/user-attachments/assets/b91efa4a-40ca-4ccd-a8e9-c20186cd7eee" />

