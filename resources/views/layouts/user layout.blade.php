<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard | Ify's Fashion Wears</title>

  <link rel="stylesheet" href="{{ asset('project/css/user_dashboard.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    :root {
      --accent-color: #ac5b8c;
      --bg-light: #f9f9f9;
      --text-dark: #333;
      --sidebar-bg: #4b2f4f;
      --card-bg: #fff;
      --card-shadow: rgba(0,0,0,0.08);
      --sidebar-width: 260px;
      --header-height: 80px;
    }

    * { box-sizing:border-box; margin:0; padding:0; font-family:'Poppins', sans-serif; }
    body { background:var(--bg-light); color:var(--text-dark); }
    a { text-decoration:none; color:inherit; }

    /* HEADER */
    header.header {
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:15px 20px;
      background:#fff;
      box-shadow:0 4px 15px rgba(0,0,0,0.08);
      position:sticky;
      top:0;
      z-index:120;
    }

    header .logo {
      font-size:26px;
      font-weight:bold;
      color:var(--accent-color);
    }

    /* DESKTOP NAV */
    header .nav {
      display:flex;
      gap:25px;
    }

    /* MOBILE NAV */
    .mobile-nav-toggle {
      display:none;
      font-size:24px;
      cursor:pointer;
    }

    .mobile-nav {
      display:none;
      flex-direction:column;
      background:#fff;
      padding:15px 20px;
      box-shadow:0 4px 15px rgba(0,0,0,0.08);
    }

    .mobile-nav a {
      padding:12px 0px;
      font-weight:600;
      border-bottom:1px solid #eee;
    }

    header .icons {
      display:flex;
      gap:15px;
      font-size:22px;
    }

    .bag-count {
      background:#e53935; color:#fff;
      font-size:10px; font-weight:bold;
      padding:2px 6px;
      border-radius:50%;
      position:absolute; top:-5px; right:-8px;
    }

    /* BREADCRUMB */
    .breadcrumb {
      max-width:1200px;
      margin:20px auto;
      padding:12px 20px;
      background:#fff;
      border-radius:10px;
      box-shadow:0 3px 8px rgba(0,0,0,0.05);
      font-size:14px;
    }

    /* DASHBOARD */
    .dashboard {
      display:flex;
      max-width:1200px;
      margin:20px auto;
      gap:25px;
    }

    /* SIDEBAR */
    .sidebar {
      width:var(--sidebar-width);
      background:var(--sidebar-bg);
      padding:25px 15px;
      border-radius: 5px;
      color:#fff;
      position:sticky;
      top:150px;
      height:max-content;
      max-height:80vh;
      overflow-y:auto;
      display:block;
    }

    .sidebar ul { list-style:none; }
    .sidebar ul li a {
      display:flex;
      align-items:center;
      padding:12px 18px;
      border-radius:8px;
      font-weight:500;
      transition:0.3s;
    }

    .sidebar ul li a i { margin-right:10px; }

    .sidebar ul li a:hover,
    .sidebar ul li.active a {
      background:var(--accent-color);
    }

    /* MOBILE SIDEBAR BUTTON */
    .mobile-sidebar-toggle {
      display:none;
      width:100%;
      background:var(--accent-color);
      color:#fff;
      padding:12px;
      margin-bottom: -1.6rem;
      border-radius:8px;
      
      font-weight:600;
      cursor:pointer;
    }

    /* MAIN CONTENT */
    .dashboard-content {
      flex:1;
      background:#fff;
      padding:30px;
      border-radius:15px;
      box-shadow:0 6px 20px var(--card-shadow);
      
    }

    /* FOOTER */
    footer.footer {
      text-align:center;
      padding:18px;
      margin-top:40px;
      background:var(--accent-color);
      color:#fff;
      
    }

    /* TABLET */
    @media(max-width:1024px) {
      .dashboard { flex-direction:column; }
    }
    /* HIDE SIDEBAR on iPad + Phones */
@media(max-width:1024px) {

    /* Hide sidebar */
    .sidebar {
        display: none;
        
    }

    /* Show mobile toggle button */
    .mobile-sidebar-toggle {
        display: block;
        
    }
}

    

    /* MOBILE SCREEN */
    @media(max-width:768px) {
      header .nav { display:none; }
      .mobile-nav-toggle { display:block; }

      .breadcrumb {
        padding:10px 15px;
      }

      .dashboard-content {
        padding:20px;
      
      }

      /* SIDEBAR collapsible */
      .mobile-sidebar-toggle { display:block; }
      .sidebar { display:none; width:100%; }
    }
  </style>
</head>
<body>

<header class="header">

  <div class="logo">Ify's Fashion Wears</div>

  <!-- Mobile Menu Button -->
  

  <!-- Desktop Navigation -->
  <nav class="nav">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/') }}">Shop</a>
    <a href="{{ route('category.show','new-trending') }}">New In</a>
    <a href="{{ route('map') }}">Store Locator</a>
    <a href="{{ route('contact') }}">Contact</a>
   
  </nav>

  <!-- Icons -->
  <div class="icons">
    <a href="{{ url('/user-wishlist') }}"><i class="ri-heart-line"></i></a>

    <a href="{{ url('/bag') }}" style="position:relative;">
      <i class="ri-shopping-bag-line"></i>
      <span id="cartCount" class="bag-count">{{ $cartCount ?? 0 }}</span>
    </a>

    <a href="{{ url('/dashboard/profile') }}"><i class="ri-user-line"></i></a>


<div class="mobile-nav-toggle">
  <i class="ri-menu-line"></i>
</div></div>


</header>

<!-- Mobile Dropdown Nav -->
<div class="mobile-nav">
  <a href="{{ url('/') }}">Home</a>
  <a href="{{ url('/') }}">Shop</a>
  <a href="{{ route('category.show','new-trending') }}">New In</a>
  <a href="{{ route('map') }}">Store Locator</a>
  <a href="{{ route('contact') }}">Contact</a>
</div>

<script>
  $(document).ready(function() {
    $.get("{{ route('cart.count') }}", function(data) {
      $('#cartCount').text(data.count);
    });
  });
</script>

<section class="breadcrumb">Home > My Account > Dashboard</section>

<main class="dashboard">

  <!-- Mobile Sidebar Toggle -->
  <div class="mobile-sidebar-toggle">☰ Menu</div>

  <!-- Sidebar -->
  <aside class="sidebar">
    <ul>
      <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ url('/dashboard') }}"><i class="ri-dashboard-line"></i> Dashboard</a>
      </li>

      <li class="{{ request()->is('dashboard/profile') ? 'active' : '' }}">
        <a href="{{ url('/dashboard/profile') }}"><i class="ri-user-line"></i> Profile</a>
      </li>

      <li class="{{ request()->is('dashboard/orders') ? 'active' : '' }}">
        <a href="{{ url('/orders') }}"><i class="ri-shopping-bag-line"></i> Orders</a>
      </li>

      <li class="{{ request()->is('dashboard/wishlist') ? 'active' : '' }}">
        <a href="{{ url('/user-wishlist') }}"><i class="ri-heart-line"></i> Wishlist</a>
      </li>

      <li>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="ri-logout-box-r-line"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <section class="dashboard-content">
    @yield('content')
  </section>

</main>

<footer class="footer">&copy; 2025 Ify's Fashion Wears. All rights reserved.</footer>

<!-- NAV + SIDEBAR TOGGLE SCRIPT -->
<script>
$(document).ready(function() {

  // Mobile Navbar Toggle
  $(".mobile-nav-toggle").on("click", function() {
    $(".mobile-nav").slideToggle(250);
  });

  // Mobile Sidebar Toggle
  $(".mobile-sidebar-toggle").on("click", function() {
    $(".sidebar").slideToggle(250);
  });

  // Auto-close sidebar when user scrolls
  let lastScrollTop = 0;
  $(window).on("scroll touchmove", function() {
    const st = $(this).scrollTop();

    // If sidebar is visible and user scrolls up or down
    if ($(".sidebar").is(":visible")) {
      $(".sidebar").slideUp(250);
    }

    lastScrollTop = st;
  });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
