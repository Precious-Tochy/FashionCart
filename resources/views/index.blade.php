<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ify's Fashion Wears</title>
  <link rel="stylesheet" href="{{asset('project/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('project/css/index.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <!-- In <head> -->
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />




</head>

<body>
  <section>
    <nav class="shop">
      <p>Shop with confidence - local taxes & duties
        are calculated at checkout.</p>
        

        
        
        
    </nav>
    
    <div class="ify">
      <div class="container-fluid" id="second-nav">
        <form class="d-flex" role="search" action="{{ route('search') }}" method="GET">
    <input 
        class="form-control me-2" 
        type="search" 
        name="query"
        placeholder="Search for styles, colors, brands..."  style="width: 300px"
        required 
    />
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>

        <div class="mek text-center">
          <i>IFY'S <br></i>
          <span>FASHION WORLD</span>
        </div>

        <div class="fill">

          <ul>
            
          
    
    
<li style="font-size: 28px"><a href="{{route('check.email')}}"><i class="ri-user-fill"></i></a></li>
            <li style="font-size: 28px"><a href="{{route('map')}}"><i class="ri-map-pin-line"></i></a></li>
            <li style="font-size: 28px"><a href="{{route('wishlist')}}"><i class="ri-heart-line" id="wishlistIcon"></i>
</a></li>
          <li class="bag-icon" style="position: relative; font-size:28px">
   <a href="{{ route('bag') }}" title="Bag">
      <i class="ri-shopping-bag-line"></i>
      <span id="cartCount" class="bag-count">0</span>
   </a>
</li>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateCartCount() {
    $.get("{{ route('cart.count') }}", function(data) {
        $('#cartCount').text(data.count);
    });
}

// Update cart count on page load
$(document).ready(function() {
    updateCartCount();
});
</script>

<style>
  .bag-count {
    position: absolute;
    top: -5px;     /* position above the icon */
    right: -8px;   /* position to the right */
    background: #e53935; /* red color badge */
    color: #fff;   /* white text */
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 50%; /* makes it circular */
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    min-height: 18px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.cart-count {
    display: inline-block;
    transition: transform 0.3s;
}

.cart-count.animate {
    transform: scale(1.5);
}

</style>


          </ul>
        </div>
      </div>
    </div>


    <div class="desktop-nav">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid" id="pol">
    <a class="navbar-brand" href="#">SHOP HERE</a>
    <button class="navbar-toggler" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#poll" 
        aria-controls="poll" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

    <div class="collapse navbar-collapse" id="poll">
      @php
    $categories = \App\Models\Category::with('subcategories')->whereNull('parent_id')->get();
@endphp

      <ul class="navbar-nav">
    @foreach($categories as $category)
        <li class="nav-item category-hover" style="position: relative;">
            <a href="{{ route('category.show', $category->slug) }}" style="font-size: 13px; ">{{ $category->name }}</a>

            @if($category->subcategories->count())
                <div class="subcategories-panel" style="display: none; position: absolute; top: 100%; left: 0; z-index: 1000;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach($category->subcategories as $sub)
                            <li style="padding: 5px 10px; font-size: 14px;">{{ $sub->name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </li>
    @endforeach

    <li class="nav-item">
        <a href="{{ route('inspiration') }}" style="font-size: 13px;">BE INSPIRED</a>
    </li>
</ul>


<script>
    // Simple hover to show subcategories
    document.querySelectorAll('.category-hover').forEach(item => {
        item.addEventListener('mouseenter', () => {
            const panel = item.querySelector('.subcategories-panel');
            if (panel) panel.style.display = 'block';
        });
        item.addEventListener('mouseleave', () => {
            const panel = item.querySelector('.subcategories-panel');
            if (panel) panel.style.display = 'none';
        });
    });
</script>

<style>
  /* Default: desktop visible, others hidden */
.desktop-nav { display: block; }
.ipad-category-bar, .mobile-category-scroll { display: none; }

/* iPad view */
@media (min-width: 768px) and (max-width: 1024px) {
  .desktop-nav { display: none; }
  .ipad-category-bar { display: block!important; }
  .mobile-category-scroll { display: none !important; }
}

/* Mobile view */
@media (max-width: 767px) {
  .desktop-nav, .ipad-category-bar { display: none; }
  .mobile-category-scroll { display: block; }
}

</style>

    </div>
  </div>
</nav>
</div>
@php
    $categories = \App\Models\Category::whereNull('parent_id')->get();
@endphp

<div class="ipad-category-bar">
    <div class="ipad-category-track">
        <a href="#" class="ipad-brand">SHOP HERE</a>

        @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}" class="ipad-category">
                {{ strtoupper($category->name) }}
            </a>
        @endforeach

        <a href="{{ route('inspiration') }}" class="ipad-category">BE INSPIRED</a>
    </div>
</div>

<style>
  /* ===============================
   DEFAULT: HIDDEN
================================ */
.ipad-category-bar {
    display: none;
}

/* ===============================
   IPAD ONLY CATEGORY BAR
================================ */
@media (min-width: 768px) and (max-width: 1024px) {

    .ipad-category-bar {
        display: block;
        position: sticky;
        top: 0;
        z-index: 999;
        background: rgb(108, 19, 74);
        border-bottom: 1px solid rgba(255,255,255,0.2);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
         
        /* edge fade */
        mask-image: linear-gradient(
            to right,
            transparent,
            black 6%,
            black 94%,
            transparent
        );
    }

    .ipad-category-track {
        display: flex;
        align-items: center;
        gap: 28px;
        padding: 10px 16px;
        min-width: max-content;
        scroll-snap-type: x mandatory;
    }

    .ipad-brand {
        color: #f4eeee;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        letter-spacing: 1px;
        scroll-snap-align: start;
        font-size: 2rem;
        padding-right: 4rem;
    }

    .ipad-category {
        color: #ffffff;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        white-space: nowrap;
        letter-spacing: 1px;
        scroll-snap-align: start;
        position: relative;
        font-family: Arial, sans-serif;
    }

    /* Active underline */
    .ipad-category.active::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 2px;
        background: #ac708e;
        border-radius: 4px;
    }

    /* Hide scrollbar */
    .ipad-category-bar::-webkit-scrollbar {
        display: none;
    }
    .ipad-category-bar {
        scrollbar-width: none;
    }
    
}
/* Desktop nav */
.desktop-nav { display: none; }
@media (min-width: 1025px) {
  .desktop-nav { display: block; }
}

/* iPad nav */
.ipad-category-bar { display: none; }
@media (min-width: 768px) and (max-width: 1024px) {
  .ipad-category-bar { display: block; }
  .desktop-nav, .mobile-category-scroll { display: none; } /* ensure others hidden */
}

/* Mobile nav */
.mobile-category-scroll { display: none; }
@media (max-width: 767px) {
  .mobile-category-scroll { display: block; }
  .desktop-nav, .ipad-category-bar { display: none; } /* ensure others hidden */
}

    @media  (max-width: 1024px) {
    .navbar {
        display: none;
    }
}


    
    @media (max-width:768px){
      body{
        background-color: #f0eeee;
      }
    }
    /* @media(max-width:1024px){
      .navbar{
        display: none;
      }
      .mobile-category-scroll{
        display: block;
      }
      .mobile-menu{
        display: block;
      }
    } */
    /* Ensures dropdown stays under the category */
.subcategories-panel {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border: 1px solid #ddd;
    width: 150px;
    padding: 0;
    margin: 0;
}

.subcategories-panel ul {
    padding: 0;
    margin: 0;
    list-style: none;
}

.subcategories-panel li {
    padding: 0;
    margin: 0;
    line-height: 1;        /* no extra height */
}

.subcategories-panel li a,
.subcategories-panel li {
    display: block;
    font-size: 12px;
    padding: 2px 5px !important; /* smallest possible spacing */
    margin: 0 !important;
}
.subcategories-panel ul {
    display: block !important;   /* override Bootstrap flex */
    flex-direction: column !important; /* just in case */
    padding: 0;
    margin: 0;
    list-style: none;
}

.subcategories-panel li {
    display: block !important;   /* each item on its own line */
    padding: 2px 5px !important;
    margin: 0 !important;
    font-size: 12px;
    line-height: 1.2;
}



    /* Top Navbar */
    .vbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
      background: #d9d9d9;
      
    }

    /* Left icons */
    .vbar-left {
      display: flex;
      align-items: center;
      gap: 15px;
      font-size: 22px;
      
    }
    

    /* Logo */
    .vbar-center {
      text-align: center;
      font-size: 26px;
      font-weight: bold;
      letter-spacing: 2px;
      
    }
    .vbar-center small {
      display: block;
      font-size: 12px;
      letter-spacing: 3px;
    }

    /* Right icons */
    .vbar-right {
      display: flex;
      align-items: cente
      gap: 15px;
      font-size: 22px;
    }

    /* Menu links */
    .menu {
      display: flex;
      justify-content: center;
      gap: 30px;
      background: #cfcfcf;
      padding: 8px ;
      align-items: center;

    }
    .menu a {
  text-decoration: none;
  color: black;
  font-size: 15px;
  letter-spacing: 2px;
  animation: marquee s linear infinite;
}
@media(max-width:768px){
  .menu{
    width: 100%;
  }
  .menu a{
    font-size: 14.1px;
  }

}

 @keyframes marquee {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }

    /* Search */
    .search-bar {
      display: flex;
      justify-content: center;
      align-items: center;
      background: #e5e5e5;
      padding: 12px;
    }
    .search-bar input {
      width: 80%;
      padding: 10px;
      border: none;
      border-bottom: 1px solid #aaa;
      font-size: 15px;
      background: transparent;
      outline: none;
    }
    .search-bar {
      background: none;
      border: none;
      font-size: 20px;
      margin-left: 8px;
      cursor: pointer;
    }
    .search-bar i{
      font-size: 21px;
    }
    .nkl{
      display: none;
    }
     #mm {
        text-decoration: none;
      }
    @media (max-width:768px){
      .nkl{
        display: block;
      }
      #mm {
        text-decoration: none;
      }
    }
  </style>
<div class="nkl">

  <!-- Top Navbar -->
  <div class="vbar">
    <div class="vbar-left">
      <style>
    

    /* Hamburger icon button */
    .menu-btn {
  font-size: 30px;
  cursor: pointer;
  background: none;
  border: none;
  
}

/* Dropdown container */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown content */
.dropdown-content {
  display: none;
  position: absolute;
  left: 0;
  background-color: rgb(202, 196, 200);
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
  z-index: 1000;
  margin-top: 2rem;
}

/* Links */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  font-size: 16px;
}

.dropdown-content a:hover {
  background-color: rgb(189, 159, 177);
  color: #fff;
}

/* Show menu */
.show {
  display: block;
}

/* ===============================
   MOBILE FULL WIDTH
================================ */
@media (max-width: 768px) {
  .dropdown-content {
    position: fixed;
    top: 60px;
    left: 0;
    width: 40%;
    min-width: 40%;
    border-radius: 0;
  }
}

    
  </style>

 <div class="dropdown">
  <button class="menu-btn" id="menuBtn">☰</button>

  <div id="myDropdown" class="dropdown-content">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/contact') }}">Contact</a>
  </div>
</div>


 <script>
  const menuBtn = document.getElementById("menuBtn");
  const dropdown = document.getElementById("myDropdown");

  menuBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    dropdown.classList.toggle("show");

    // Toggle ☰ ↔ ✕
    menuBtn.innerHTML = dropdown.classList.contains("show") ? "✕" : "☰";
  });

  // Close when clicking outside
  document.addEventListener("click", function () {
    dropdown.classList.remove("show");
    menuBtn.innerHTML = "☰";
  });
</script>




     <!-- hamburger -->
     <a href="{{route('map')}}" id="mm"> &#128205;</a> <!-- location -->
    </div>
    <div class="vbar-center" >
      IFY'S
      <small>FASHION WORLD</small>
    </div>
    <div class="vbar-right" id="mn"><a href="{{route('check.email')}}">&#128100;</a> 
      <li style="color: rgb(102, 58, 85)"><a href="{{route('wishlist')}}"><i class="ri-heart-line" id="wishlistIcon"></i>
</a></li><!-- user -->
      <span style="position: relative;">
       <a href="{{route('bag')}}"> &#128722;</a> <!-- cart -->
        <span style="position: absolute; top: -8px; right: -10px; 
          background: black; color: white; font-size: 12px; 
          padding: 2px 6px; border-radius: 50%;">0</span>
      </span>
    </div>
  </div>
  
<style>
  #wishlistIcon{
    color: rgb(102, 58, 85);
  }
  .vbar-right a:hover {
  text-decoration: none;
  opacity: 0.8;
}
/* Remove underline from right navbar links */
.vbar-right a {
  text-decoration: none;
  color: inherit;
}
/* Horizontal scroll menu */
.menu-scroll {
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

/* Menu items inline */
.menu {
  display: inline-flex;
  gap: 20px;
  padding: 10px 0;
}

/* Links styling */
.menu a {
  text-decoration: none;
  color: #333;
  font-weight: 600;
  white-space: nowrap;
}

/* Optional: hide scrollbar (still scrolls) */
.menu-scroll::-webkit-scrollbar {
  display: none;
}
.menu-scroll {
  scrollbar-width: none;
}

</style>
  <!-- Menu -->
  @php
    $categories = \App\Models\Category::whereNull('parent_id')->get();
@endphp

<div class="mobile-category-scroll">
    <div class="mobile-menu">
      <a style="text-decoration: none; color:#c3c1c1; font-weight: 700;
        
        white-space: nowrap;
        letter-spacing: 1px;
        scroll-snap-align: start;
        font-size: 1.4rem;
        " href="#">SHOP HERE
<span class="arrow-right"></span></a>
        @foreach($categories as $category)
           
            <a href="{{ route('category.show', $category->slug) }}" class="mobile-cat">
                {{ strtoupper($category->name) }}
            </a>
        @endforeach

        <a href="{{ route('inspiration') }}" class="mobile-cat">BE INSPIRED</a>
    </div>
</div>

<style>
  /* ===============================
   DESKTOP VS MOBILE
================================ */
.desktop-nav {
  display: block;
}
.mobile-category-scroll {
  display: none;
}

/* ===============================
   MOBILE CATEGORY BAR
================================ */
@media (max-width: 768px) {

  /* Hide desktop nav */
  .desktop-nav {
    display: none;
  }
.arrow-right {
  display: inline-block;
  width: 10px;
  height: 10px;
  border-top: 2px solid #fff;
  border-right: 2px solid #fff;
  transform: rotate(45deg);
  padding-bottom: 10px;
}

  /* Sticky scroll bar */
  .mobile-category-scroll {
    display: block;
    position: sticky;
    top: 0;
    z-index: 999;
    background:rgb(108, 19, 74);
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-bottom: 1px solid #eee;
    
    

    /* Fade edges */
    mask-image: linear-gradient(
      to right,
      transparent,
      black 10%,
      black 90%,
      transparent
    );
  }

  .mobile-menu {
    display: flex;
    align-items: center;   /* ✅ THIS centers text vertically */
    height: 100%;          /* fill the bar height */
    gap: 22px;
    padding: 6px 12px;       /* remove vertical padding */
    min-width: max-content;
    scroll-snap-type: x mandatory;
  }

  .mobile-cat {
    text-decoration: none;
    font-size: 17px;
    font-weight: 600;
    color: #fff;
    white-space: nowrap;
    
    position: relative;
    scroll-snap-align: start;
    font-family: Arial, sans-serif;
    letter-spacing: 1px;
  }

  /* Active underline */
  .mobile-cat.active::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 2px;
    background: #ac708e;
    border-radius: 4px;
  }

  /* Hide scrollbar */
  .mobile-category-scroll::-webkit-scrollbar {
    display: none;
  }
  .mobile-category-scroll {
    scrollbar-width: none;
  }
}

</style>


  <!-- Search -->
  <div class="mobile-search-bar">
    <form action="{{ route('search') }}" method="GET">
        <input type="text" name="query" placeholder="Search for styles, colors, brand..." required>
        <button type="submit"><i class="ri-search-line"></i></button>
    </form>
</div>

</div>
<style>
  /* Default: desktop visible, mobile hidden */
.desktop-search {
    display: block;
}

.mobile-search-bar {
    display: none;
}

/* MOBILE view */
@media (max-width: 768px) {
    .desktop-search {
        display: none;
    }

    .mobile-search-bar {
        display: block;
        padding: 8px 10px;
        position: relative;
    }

    .mobile-search-bar input {
        width: 100%;
        padding: 10px 40px 10px 12px;
        border-radius: 25px;
        border: 1px solid #ccc;
        outline: none;
    }

    .mobile-search-bar button {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        font-size: 20px;
        cursor: pointer;
        color: #333;
    }
}

</style>


    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
      aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
  </div>

  <!-- Slides -->
  <div class="carousel-inner">
    <!-- First Slide -->
    <div class="carousel-item active" id="black">
      <img src="{{asset('project//image/High quality crepe back satin fabric_ This fabric….jpg')}}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-md-block d-flex justify-content-center align-items-center" id="me">
        <h5>LIMITED TIME ONLY</h5>
        <h3>25% OFF DRESSES</h3>
        <p>IN OUR NEW SEASON COLLECTION</p>
        <button><a href="{{url('/')}}">SHOP NOW</a></button>
      </div>
    </div>

    <!-- Second Slide -->
    <div class="carousel-item" id="leg">
      <div class="circle"></div>
      <div class="carousel-caption d-md-block" id="men">
        <h5>SHOW YOUR <br> <span>UNIQUENESS</span></h5>
        <p>
          "Discover your personal style with our curated collection of clothing,
          where comfort meets fashion and every <br> piece tells a story.
          Elevate your wardrobe with our unique designs and make a statement wherever you go".
        </p>
        <div class="now">
          <button><a href="{{url('/')}}">SHOP NOW</a></button>
        </div>
      </div>
    </div>
  </div>
<style>
  @media(max-width:768px){
    #men{
      padding-left: 3.5rem !important;
    }
  }
</style>
  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1000">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    

     
    <div class="dress mt-1">

    <div class="tops" data-aos="zoom-in" id="hh">
        <img src="{{ asset('project/image/IMG-20250524-WA0055.jpg') }}" alt="Tops">
        <span>TOPS</span>
    </div>

    <div class="tops" data-aos="fade-up" data-aos-delay="100" id="hh">
        <img src="{{ asset('project/image/IMG-20250524-WA0064.jpg') }}" alt="Gowns">
        <span>GOWNS</span>
    </div>

    <div class="tops" data-aos="fade-up" data-aos-delay="200" id="hh">
        <img src="{{ asset('project/image/IMG-20250524-WA0022.jpg') }}" alt="Jackets">
        <span>JACKETS</span>
    </div>

    <div class="tops" data-aos="fade-up" data-aos-delay="300" id="hh">
        <img src="{{ asset('project/image/IMG-20250524-WA0037.jpg') }}" alt="Knits">
        <span>KNITS</span>
    </div>

</div>


  
     <div class="container-fluid">
     <div class="row my-image">
      <div class="col-6" data-aos="slide-left">
        <h1>LIMITED EDITION</h1>
        <p>Contemporary yet refined, tap into new trends and distinctive designs , Elevate your 
          wardrobe with this rare and unique piece. <br> Limited edition, timeless style.
        </p>
      </div>

      <div class="col-2" id="kk" data-aos="slide-right">
        <img src="{{asset('project/image/IMG-20250524-WA0086.jpg')}}" alt="">
     </div>
     <div class="col-2" id="kk"data-aos="slide-right">
      <img src="{{asset('project/image/IMG-20250524-WA0088.jpg')}}" alt="">
     </div>
     <div class="col-2"data-aos="slide-right">
      <div class="im">
      <img src="{{asset('project/image/IMG-20250524-WA0080.jpg')}}" alt="">
      </div>

     </div>
    </div></div>
    

     <!-- Section 1: NEW & NOW -->
<div class="row myt">
  <div class="col-5" data-aos="slide-right">
    <div class="bit1">
      <div class="byte"></div>
    </div>
  </div>

  <div class="col-7 moot" data-aos="slide-left">
    <h3>NEW & NOW</h3>
    <h1>SUMMER WHITES</h1>
    <p>Imbued with wear-everyone ease, brighten your <br> wardrobe with stylish white
      separates made to mix and match.</p>
  </div>
</div>

<!-- Section 2: WEDDING -->
<div class="row wedding">
  <div class="col-7 wedding-2" data-aos="slide-right">
    <h3>UPCOMING EVENTS</h3>
    <h1>WEDDING GUEST <br><span>SEASON</span></h1>
    <p>Destination wedding or marquee style, watch them <br>
      say 'I do' in our occasion styles made for every kind <br> of celebration.</p>
    <div class="own"><h4>OWN YOUR STYLE</h4></div>
  </div>

  <div class="col-5 rule-2" data-aos="slide-left">
    <div class="bytes"></div>
  </div>
</div>

<!-- Section 3: TRENDING NOW -->
<div class="row bit2">
  <div class="col-5" data-aos="slide-right">
    <div class="bit22">
      <div class="byte2"></div>
    </div>
  </div>

  <div class="col-7 rule-11" data-aos="slide-left">
    <h3>TRENDING NOW</h3>
    <h1>MATCHING SETS</h1>
    <p>High impact yet effortless to style, shop our <br> matching sets refreshed in
      palette-cleansing <br> prints, don't forget to mix and match.</p>
    <div class="own"><h4>STYLE THAT SPEAKS</h4></div>
  </div>
</div>

<!-- Section 4: SILK SOPHISTICATION -->
<div class="row wedding1">
  <div class="col-7 wedding-22" data-aos="slide-right">
    <h3>EVENT SEASON</h3>
    <h1>SILK <br><span>SOPHISTICATION</span></h1>
    <p>Destination wedding or race day elegance, lean <br> on luxurious silk
      silhouettes for all your <br> upcoming events.</p>
  </div>

  <div class="col-5 rule-22" data-aos="slide-left">
    <div class="bytes3"></div>
  </div>
</div>

  
<style>
   @media(max-width:768px){
    .designer{
      width: 100%;
      margin-top: 2rem;
      
    }
    .new{
      display: grid;
      margin: 0;
      grid-template-columns: repeat(2,1fr);
      width: 100%;
      margin-left: .2em;
      

    }
   .new .news img {
      width: 200px;
      height: 260px;
      object-fit: cover;
      
      
    }
    
    }
   .new .news{
      width: 200px;
      height: 345px;
      
    
      
      
      
    }
    
   
</style>



    <div class="designer">
      <p>MOST LOVED <br> STYLES </p>
    </div>
    <div class="new" id="lk">
      <div class="news">
        <img src="{{asset('project/image/IMG-20250524-WA0059.jpg')}}" alt="">
        <h3>Hariet Belted Dress</h3>
        <div class="magic d-flex flex-row">
          <span>&#8358;42,000</span>
          <s>&#8358;168,000</s>
        </div>
        <p>25% off</p>
      </div>

      <div class="news">
        <img src="{{asset('project/image/IMG-20250521-WA0008.jpg')}}" alt="">
        <h3>Skylar Flay Dress</h3>
        <div class="magic d-flex flex-row">
          <span>&#8358;75,000</span>
          <s>&#8358;300,000</s>
        </div>
        <p>25% off</p>
      </div>
      
     <div class="news">
        <img src="{{asset('project/image/IMG-20250514-WA0017.jpg')}}" alt="">
        <h3>Allesia Dress</h3>
        <div class="magic d-flex flex-row">
          <span>&#8358;65,000</span>
          <s>&#8358;260,000</s>
        </div>
        <p>25% off</p>
      </div>

      <div class="news">
        <img src="{{asset('project/image/IMG-20250524-WA0087.jpg')}}" alt="">
        <h3>Syon Dress</h3>
        <div class="magic d-flex flex-row">
          <span>&#8358;48,000</span>
          <s>&#8358;192,000</s>
        </div>
        <p>25% off</p>
      </div>
    </div>

    <div class="why" id="whyl">
      <h2>Why Choose Us</h2>

      <div class="mine">
        <div class="fast">
          <i class="ri-truck-line" style="color: rgb(108, 19, 74); font-size: 2rem;"></i>
          <h6>Fast Delivery</h6>
          <p>it is a long fact that a reader will be distracted by the <br>
            readale content of a
            page when looking at its layout. The point <br> of using.</p>
        </div>
        <div class="fast">
          <i class="ri-checkbox-multiple-fill" style="color: rgb(108, 19, 74); font-size: 2rem;"></i>
          <h6>Original Products</h6>
          <p>it is a long fact that a reader will be distracted by the <br>
            readale content of a
            page when looking at its layout. The point <br> of using.</p>
        </div>
        <div class="fast">
          <i class="ri-service-line" style="color: rgb(108, 19, 74); font-size: 2rem;"></i>
          <h6>100% satisfaction</h6>
          <p>it is a long fact that a reader will be distracted by the <br>
            readale content of a
            page when looking at its layout. The point <br> of using.</p>
        </div>
        <div class="fast">
          <i class="ri-customer-service-line" style="color: rgb(108, 19, 74); font-size: 2rem;"></i>
          <h6>24/7 service</h6>
          <p>it is a long fact that a reader will be distracted by the <br>
            readale content of a
            page when looking at its layout. The point <br> of using.</p>
        </div>
      </div>
    </div>
    



    <div class="newbe" id="yh">
      <div class="item d-flex flex-row">
        <h4>NEWBE Q&A</h4>
        <h3>
          Follow us on Social Media <i class="ri-facebook-fill"><i class="ri-twitter-fill"></i></i><i
            class="ri-instagram-line"></i> </h3>
      </div>

      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item" id="acc" itemid="iy">
          <h2 class="accordion-header" id="blow">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              Ordering & Payment
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body" id="jg"> How do I place an order? <br> Simply browse our collection or choose from the
              nav-bar, select your favourite items, Choose
              your size, and click "Add to Cart." Once you're ready,head to your cart and follow the checkout steps to
              complete your
              purchase. <br> What payment methods do you accept? <br> We accept all major credit
              and debit cards(Visa, Mastercard,Amex),Paypal,ApplePay,Google Pay, and select local payment
              options depending on your country.</div>
          </div>
        </div>
        <div class="accordion-item" id="acc">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              Shipping & Delivery
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body" id="jg">We accept all major credit and debit cards(Visa, Mastercard, Amex), Paypal,
              Apple Pay,
              Google Pay, and select local payment options depending on your country.
            </div>
          </div>
        </div>
        <div class="accordion-item" id="acc">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              Returns & Exchanges
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body" id="jg">We process orders quickly or cancellations must be made within 1 hour of
              placing your order. please contact us at(precioustochy72@gmail.com) as soon as possible.</div>
          </div>
        </div>
      </div>




      <p id="tija">2025 Educate. All Right Reserved</p>
    </div>




























  </section>
  


<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000, // animation duration in ms
      once:true,    // animate only once
          offset:0,
  });
</script>
<script>
$(document).ready(function () {

    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

    function updateWishlistHeaderIcon() {
        const icon = $("#wishlistIcon");

        if (isLoggedIn) {
            // Logged-in user → check backend count
            $.get("/wishlist/count", function (count) {
                if(count > 0){
                    icon.removeClass("ri-heart-line").addClass("ri-heart-fill").css("color", "#ae5a8d");
                } else {
                    icon.removeClass("ri-heart-fill").addClass("ri-heart-line").css("color", "");
                }
            });

        } else {
            // Guest → localStorage
            let wishlist = JSON.parse(localStorage.getItem("guest_wishlist")) || [];

            if(wishlist.length > 0){
                icon.removeClass("ri-heart-line").addClass("ri-heart-fill").css("color", "#ae5a8d");
            } else {
                icon.removeClass("ri-heart-fill").addClass("ri-heart-line").css("color", "");
            }
        }
    }

    // Call once on page load
    updateWishlistHeaderIcon();

    // Call again anytime the heart icon is clicked on a product
    $(document).on("click", ".wishlist-toggle", function () {
        setTimeout(updateWishlistHeaderIcon, 150);
    });

});
</script>


</body>
<script src="{{asset('project/js/bootstrap.bundle.js')}}"></script>


</html>