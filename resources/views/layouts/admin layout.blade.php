<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Ify's Fashion Wears</title>
    <link rel="stylesheet" href="{{ asset('project/css/admin dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('project/css/bootstrap.min.css')}}">
    
</head>
@include('sweetalert::alert')

<body>
    <!-- Sidebar -->
   <!-- Sidebar -->
<aside class="sidebar">
    <div class="logo">IFY'S Admin</div>

    <ul>
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('users') }}">
                <i class="ri-user-line"></i> Users
            </a>
        </li>

        <!-- Dress Dropdown -->
       <!-- Dress Dropdown -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="dressDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-shirt-line"></i>
        <span class="ms-2">Dress</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-start custom-dropdown" aria-labelledby="dressDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('add_dress') }}">
                <i class="ri-add-line me-2"></i> Add Product
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('manage_dress') }}">
                <i class="ri-stack-line me-2"></i> Manage Products
            </a>
        </li>
    </ul>
</li>

<style>
/* Make dropdown items smaller and compact */
.custom-dropdown .dropdown-item {
    font-size: 15px;       /* smaller font */
    padding: 3px ;     /* compact padding */
    display: flex;
    align-items: center;   /* vertically center icons and text */
    gap: 4px;              /* space between icon and text */
    color: #555;
    transition: background 0.3s, color 0.3s;
}

.custom-dropdown .dropdown-item:hover {
    background-color: #f5f1ef;
    color: #3d210b;
}

/* ===============================
   GENERAL FIX
================================ */
body {
    overflow-x: hidden;
    background: #f5f5f5;
}

.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    
    z-index: 1000;
    transition: transform 0.3s ease;
}
.dropdown-menu {
    border-radius: 10px;
    padding: 6px;
}

.main {
    margin-left: 260px;
    transition: margin 0.3s ease;
}

/* ===============================
   TOPBAR
================================ */

.menu-toggle {
    display: none;
    font-size: 26px;
    cursor: pointer;
}

/* ===============================
   TABLET VIEW (iPad)
================================ */
@media (max-width: 992px) {
    .sidebar {
        width: 220px;
    
        padding: 10px;
    }

    .main {
        margin-left: 220px;
    }

    .topbar h1 {
        font-size: 20px;
    }
    .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    background: #fff;
    border-bottom: 1px solid #ddd;
}

}

/* ===============================
   MOBILE VIEW
================================ */
@media (max-width: 768px) {
    .menu-toggle {
        display: block;
    }

    .sidebar {
        transform: translateX(-100%);
    }


    .sidebar.active {
        transform: translateX(0);
    }

    .main {
        margin-left: 0;
    }

    .topbar {
        gap: 10px;
    }

    .topbar h1 {
        font-size: 18px;
    }

    .admin-info span {
        display: none;
    }
}

/* ===============================
   SMALL PHONES
================================ */
@media (max-width: 480px) {
    .topbar h1 {
        font-size: 16px;
    }

    .profile img {
        width: 28px;
        height: 28px;
    }

    .custom-dropdown .dropdown-item {
        font-size: 14px;
    }
}
.profile img{
    width: 35px;
    height: 35px;
    border-radius: 50%;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const menu = btn.nextElementSibling; // the <ul class="dropdown-menu">
            menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
            btn.classList.toggle('active');
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('active');
    });
});
</script>


        <li>
            <a href="{{ route('admin.orders') }}">
                <i class="ri-shopping-bag-line"></i> Orders
            </a>
        </li>

        <li>
            <a href="{{ route('admin.categories') }}">
                <i class="ri-layout-grid-line"></i> Categories
            </a>
        </li>

        <li>
            <a href="{{ route('admin.deliveries') }}">
                <i class="ri-truck-line"></i> Delivery Fees
            </a>
        </li>

        <!-- Logout -->
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ri-logout-box-r-line"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>


    <!-- Main Panel -->
    <main class="main">
        <!-- Topbar -->
        <header class="topbar">
    <i class="ri-menu-line menu-toggle"></i>

    <h1 style="color:#ac708e;">Dashboard Overview</h1>

    <div class="admin-info">
        <i class="ri-notification-3-line"></i>
        <div class="profile">
            <img src="{{ asset('project/image/Curtains Photography Backdrop with Scenic Stage….jpg') }}" alt="Admin">
            <span>Admin</span>
        </div>
    </div>
</header>



        </section>
        @yield('content')
        <br>
        
        <footer class="footer">
            <p>&copy; 2025 Ify's fashion wears Inspired. All rights reserved.</p>
        </footer>
    </main>

</body>

</html>
<script src="{{ asset('project/js/bootstrap.bundle.min.js') }}"></script>