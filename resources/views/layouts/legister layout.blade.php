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
            <li><a href="{{ route('check.email') }}"><i class="ri-user-fill"></i></a></li>
            <li><a href="{{ route('map') }}"><i class="ri-map-pin-line"></i></a></li>
            <li><a href="{{ route('wishlist') }}"><i class="ri-heart-line"></i></a></li>
            <li><a href="{{ route('bag') }}" title="Add to Bag"><i class="ri-shopping-bag-line"></i></a></li>
          </ul>
        </div>
</div>
</div>
    
    
  
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid" id="pol">
    <a class="navbar-brand" href="#">SHOP HERE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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



    </div>
  </div>
</nav>
<style>
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
</style>
    

    <!-- Dynamic Content -->
    @yield('content')
    


      <footer class="footer">
        <p>&copy; 2025 Ify's fashion Inspired. All rights reserved.</p>
    </footer>

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
</body>
</html>
