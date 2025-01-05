<!--header-->  
<header class="mb-3">
    <!-- Burger Button -->
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>

    <!-- Page Heading -->
    <div class="page-heading">
        <h3>@yield('header')</h3>
    </div>

    <!-- User Card -->
    <div class="card user-card">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-lg">
                    <img src="{{ asset('dist/assets/compiled/jpg/logo.png') }}" alt="User Avatar" />
                </div>
                <div class="ms-3">
                    <h5 class="font-bold mb-0">{{ Auth::user()->name }}</h5>
                    <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-card {
    max-width: 250px; /* Atur lebar kartu agar tidak terlalu besar */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Tambahkan efek bayangan */
    border-radius: 8px; /* Sudut membulat */
}

</style>