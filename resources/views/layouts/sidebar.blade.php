<style>
    /* Menempatkan logout di bagian bawah sidebar */
.sidebar-footer {
    margin-top: auto; /* Menggeser logout ke bawah */
    padding: 10px 20px;
    border-top: 1px solid #ddd; /* Membuat garis pemisah */
}

/* Menata tampilan tombol logout */
.logout-btn {
    display: flex;
    align-items: center;
    color: #dc3545; /* Warna merah untuk logout */
    text-decoration: none;
    font-weight: 600;
    padding: 10px 0;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #f8d7da; /* Warna latar belakang saat hover */
    border-radius: 5px;
}

.logout-btn i {
    margin-right: 10px; /* Memberikan jarak antara ikon dan teks */
}
/* Card Styling */
.user-card {
    border: none; /* Hilangkan border */
    background-color: #f8f9fa; /* Warna latar belakang lembut */
    border-radius: 10px; /* Membuat sudut membulat */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan ringan */
}

/* Avatar Styling */
.avatar {
    width: 50px;
    height: 50px;
    overflow: hidden;
    flex-shrink: 0; /* Pastikan avatar tidak mengecil */
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* User Info */
.user-card h5 {
    font-size: 1rem; /* Ukuran teks nama */
    margin: 0; /* Hilangkan margin default */
    font-weight: bold;
    color: #333; /* Warna teks lebih gelap */
}

.user-card h6 {
    font-size: 0.85rem; /* Ukuran teks username */
    margin: 0;
    color: #6c757d; /* Warna teks abu-abu */
}

</style>
<div id="sidebar">
    <div class="sidebar-wrapper active">
<div class="sidebar-header position-relative">
<div class="d-flex flex-column justify-content-between align-items-start">
    
    <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
            role="img" class="iconify iconify--system-uicons" width="20" height="20"
            preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"stroke-linejoin="round">
                <path
                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                    opac ity=".3"></path>
                <g transform="translate(-210 -1)">
                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                    <circle cx="220.5" cy="11.5" r="4"></circle>
                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                </g>
            </g>
        </svg>
        <div class="form-check form-switch fs-6">
            <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
            <label class="form-check-label"></label>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
            role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
            viewBox="0 0 24 24">
            <path fill="currentColor"
                d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
            </path>
        </svg><!-- Username -->    
    </div>
    <div class="sidebar-toggler  x">
        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
    </div>
</div>


<div class="sidebar-menu">
<ul class="menu">
    <li class="sidebar-title">Menu</li>
    
    <!-- Dashboard -->
    <li class="sidebar-item {{ Request::is('dashboard*') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <li class="sidebar-item has-sub {{ Request::is('kategori*') || Request::is('lokasi*')  ? 'active' : '' }}">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-layers-half"></i>
            <span>Data Master</span>
        </a>
        <ul class="submenu">
             <!-- kategori -->
            <li class="submenu-item {{ Request::is('admin/kategori*') ? 'active' : '' }}">
                <a href="{{ route('kategori.index') }}" class="submenu-link">Kategori</a>
            </li>
            <!-- lokasi -->
            <li class="submenu-item {{ Request::is('admin/lokasi*') ? 'active' : '' }}">
                <a href="{{ route('lokasi.index') }}" class="submenu-link">Lokasi</a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item has-sub {{ Request::is('barang-masuk*') || Request::is('barang-keluar*')  ? 'active' : '' }}">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Manajemen Barang</span>
        </a>
        <ul class="submenu">
             <!-- masuk -->
            <li class="submenu-item {{ Request::is('admin/barang_masuk*') ? 'active' : '' }}">
                <a href="{{ route('barang-masuk.index') }}" class="submenu-link">Barang Masuk</a>
            </li>
            <!-- keluar -->
            <li class="submenu-item {{ Request::is('admin/lokasi*') ? 'active' : '' }}">
                <a href="{{ route('barang-keluar.index') }}" class="submenu-link">Barang Keluar</a>
            </li>
        </ul>
    </li>   
     
    <li>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link text-danger" style="background: none; border: none;">
                <i class="bi bi-person-dash"></i>
                <span>Logout</span>
            </button>
        </form>
    </div></li>
        </ul>
    
        
        
    </li>
    
</ul>

</div>
</div>
</div>
</div>
