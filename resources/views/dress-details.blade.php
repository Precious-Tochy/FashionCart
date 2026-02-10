@extends('layouts.index layout')

@section('content')

<link rel="stylesheet" href="{{ asset('project/css/ass.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@php
$wishlistIds = Auth::check() ? Auth::user()->wishlists()->pluck('dress_id')->toArray() : [];
$isLoggedIn = Auth::check();

// Safe decoding of variants
$variants = is_string($dress->variants) ? json_decode($dress->variants, true) : $dress->variants;

// Get all colors and map images
$availableColors = array_map('strtolower', array_keys($variants));
$images = [];
foreach($availableColors as $i => $color){
    $imgField = 'image'.($i+1); // image1, image2...
    if(!empty($dress->$imgField)){
        $images[strtolower($color)] = $dress->$imgField;
    }
}
@endphp

<div class="container" style="max-width:900px;margin:40px auto;">
    <div class="dress-card" style="display:flex; gap:20px; flex-wrap:wrap;">
        <div class="images" style="flex:1; min-width:300px;">
            <img id="frontImg" src="{{ asset('uploads/dress_pic/'.(reset($images) ?? $dress->image1)) }}" style="width:100%; border-radius:10px; margin-bottom:10px;">
        </div>

        <div class="details" style="flex:1; min-width:300px;">
            <h2>{{ $dress->name }}</h2>
            <p><b>Brand:</b> {{ $dress->brand }}</p>
            <p><b>Material:</b> {{ $dress->material }}</p>
            <p>{{ $dress->description }}</p>
            <p style="font-size:20px; font-weight:bold;">&#8358;{{ number_format($dress->price) }}</p>

            <div style="margin:10px 0;">
                <i class="wishlist-toggle {{ in_array($dress->id, $wishlistIds) ? 'ri-heart-fill' : 'ri-heart-line' }}"
                   data-id="{{ $dress->id }}"
                   style="font-size:22px; cursor:pointer;"></i>
            </div>

            <label>Colors</label>
            <div id="dColorBox" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px;"></div>

            <label>Sizes</label>
            <div id="dSizeBox" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px;"></div>

            <label>Quantity</label>
            <input id="dQty" type="number" min="1" value="1" style="width:100%; padding:6px; margin-bottom:12px;">

            <button id="addCart" style="width:100%; padding:12px; background:black; color:white; border:none; border-radius:6px;">
                Add to Cart
            </button>
            
            <a href="{{ url('/') }}" class="btn btn-secondary mt-2">Back to Shop</a>
        </div>
    </div>
</div>

<div id="toast" style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #ae5a8d;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    display: none;
    z-index: 99999;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
">Item added to cart!</div>

<style>
.colorBtn { padding:6px 12px; border:1px solid #000; border-radius:30px; cursor:pointer; }
.colorBtn.active { background:rgb(170,112,148); color:white; }
.sizeBtn { padding:6px 12px; border:1px solid #000; border-radius:30px; cursor:pointer; }
.sizeBtn.active { background:rgb(170,112,148); color:white; }
.sizeBtn.out-of-stock { opacity:0.5; cursor:not-allowed; }
.colorShape { display:inline-block; width:24px; height:24px; border-radius:50%; margin-right:6px; border:1px solid #000; vertical-align:middle; }
.wishlist-toggle.ri-heart-fill { color: #ae5a8d !important; }
</style>

<script>
$(function(){
    let dressId = {{ $dress->id }};
    let variantsData = {!! json_encode($variants) !!};
    let colorImages = {!! json_encode($images) !!}; // color => image mapping

    // Populate colors
    Object.keys(variantsData).forEach(color => {
        $('#dColorBox').append(`<div class="colorBtn" data-color="${color}"><span class="colorShape" style="background:${color}"></span>${color}</div>`);
    });

    // Default selection
    $('.colorBtn').first().addClass('active');
    populateSizes($('.colorBtn.active').data('color'));
    updateImages($('.colorBtn.active').data('color'));

    function populateSizes(color){
        $('#dSizeBox').empty();
        let sizes = variantsData[color];
        Object.keys(sizes).forEach(size=>{
            let stock = sizes[size];
            let out = stock <=0 ? 'out-of-stock' : '';
            let text = stock <=0 ? `${size} (Out of stock)` : size;
            $('#dSizeBox').append(`<div class="sizeBtn ${out}" data-size="${size}" data-stock="${stock}">${text}</div>`);
        });
    }

    function updateImages(color){
        color = color.toLowerCase();
        let img = colorImages[color] ?? Object.values(colorImages)[0]; // fallback
        $('#frontImg').attr('src', '{{ asset("uploads/dress_pic/") }}/' + img);
    }

    // Color click
    $(document).on('click', '.colorBtn', function(){
        $('.colorBtn').removeClass('active');
        $(this).addClass('active');
        let color = $(this).data('color');
        populateSizes(color);
        updateImages(color);
    });

    // Size click
    $(document).on('click', '.sizeBtn', function(){
        if($(this).hasClass('out-of-stock')) return;
        $('.sizeBtn').removeClass('active');
        $(this).addClass('active');
        $('#dQty').val(1);
    });

    // Add to cart
    $('#addCart').on('click', function(){
        let colorBtn = $('.colorBtn.active');
        let sizeBtn = $('.sizeBtn.active');
        let qty = parseInt($('#dQty').val());

        if(!colorBtn.length){ showToast('Select a color'); return; }
        if(!sizeBtn.length){ showToast('Select a size'); return; }

        let color = colorBtn.data('color').toLowerCase();
        let size = sizeBtn.data('size').toLowerCase();
        let stock = parseInt(sizeBtn.data('stock'));

        if(qty>stock){ $('#dQty').val(stock); showToast(`Only ${stock} available.`); return; }

        $.post("{{ route('add.to.cart') }}", {_token:"{{ csrf_token() }}", dress_id:dressId, color, size, quantity:qty}, function(res){
            showToast(res.message);
            if(res.status){
                $('#dQty').val(1);
                let $cartCount = $('#cartCount');
                $cartCount.text(res.cart_count);
                $cartCount.addClass('animate');
                setTimeout(()=>{ $cartCount.removeClass('animate'); }, 300);
            }
        });
    });

    function showToast(msg){ $('#toast').text(msg).fadeIn(300).delay(1500).fadeOut(300); }

    // Wishlist toggle
    const isLoggedIn = {{ $isLoggedIn ? 'true' : 'false' }};
    $(document).on('click', '.wishlist-toggle', function(){
        const icon = $(this);
        const id = '{{ $dress->id }}';
        if(isLoggedIn){
            if(icon.hasClass('ri-heart-fill')){
                $.post("/wishlist/remove/"+id,{_token:"{{ csrf_token() }}"},()=>icon.removeClass('ri-heart-fill').addClass('ri-heart-line'));
            } else {
                $.post("/wishlist/add/"+id,{_token:"{{ csrf_token() }}"},()=>icon.removeClass('ri-heart-line').addClass('ri-heart-fill'));
            }
        } else {
            let wishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
            wishlist = wishlist.map(String);
            if(icon.hasClass('ri-heart-fill')){
                wishlist = wishlist.filter(x=>x!==id); icon.removeClass('ri-heart-fill').addClass('ri-heart-line');
            } else { wishlist.push(id); icon.removeClass('ri-heart-line').addClass('ri-heart-fill'); }
            localStorage.setItem('guest_wishlist', JSON.stringify(wishlist));
        }
    });
});
</script>

@endsection
