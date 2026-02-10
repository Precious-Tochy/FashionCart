<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ify's Fashion Wears</title>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ asset('project/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('project/css/index.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
  
    <!-- Top Notice Bar -->
    <nav class="shop">
      <p>Shop with confidence - local taxes & duties are calculated at checkout.</p>
    </nav>
    <style>
        .ify{
            background-color: rgb(220, 181, 205);
            padding: 1rem;
        }
    </style>
    <!-- Header -->
    <div class="ify">
      <div class="container-fluid" id="second-nav">

        <!-- Search Bar -->
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

        <!-- Logo -->
        <div class="mek text-center">
          <i>IFY'S <br></i>
          <span>FASHION WORLD</span>
        </div>

        <!-- Icons -->
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

</style>


          </ul>
        </div>
      </div>
    </div>


    

    <!-- Dynamic Content -->
    @yield('content')
    


     
  <!-- JS Files -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="{{ asset('project/js/bootstrap.bundle.js') }}"></script>

  <script>
    AOS.init({
      duration: 1000,
      once: true,
      offset: 0,
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
</html>


 