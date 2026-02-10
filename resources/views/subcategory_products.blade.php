@extends('layouts.index layout')

@section('content')

<link rel="stylesheet" href="{{ asset('project/css/ass.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@php
$wishlistIds = Auth::check() ? Auth::user()->wishlists()->pluck('dress_id')->toArray() : [];
$isLoggedIn = Auth::check();
@endphp

<section class="dresses-section">
    @foreach($dresses as $dress)
    <div class="box">
        <div class="img">
            <img src="{{ asset('uploads/dress_pic/'.$dress->image1) }}" alt="{{ $dress->name }}">

            @if($dress->isOutOfStockConsideringCart())
                <button style="background:#444; color:#fff; opacity:0.6;" disabled>OUT OF STOCK</button>
            @else
                <button class="openSlide" data-id="{{ $dress->id }}">ADD TO BAG</button>
            @endif
        </div>

        <div class="eva">
            <h3>{{ $dress->name }}</h3>
            <span>&#8358;{{ number_format($dress->price) }}</span>

            <div>
                <i class="wishlist-toggle {{ in_array($dress->id, $wishlistIds) ? 'ri-heart-fill' : 'ri-heart-line' }}"
   data-id="{{ (string)$dress->id }}"
   style="cursor:pointer; font-size:18px;"></i>

            </div>
        </div>
    </div>
    @endforeach
</section>

<!-- Slide Overlay -->
<div id="slideOverlay" class="slide-overlay">
    <div class="slide-panel">
        <button id="closeSlide" class="close-btn">×</button>

        <img id="frontImg" style="width:100%;border-radius:10px;margin-bottom:8px;">
        <img id="backImg" style="width:100%;border-radius:10px;margin-bottom:8px;display:none;">

        <h2 id="dName"></h2>
        <p><b>Brand:</b> <span id="dBrand"></span></p>
        <p><b>Material:</b> <span id="dMaterial"></span></p>
        <p id="dDesc"></p>

        <label>Available Colors</label>
        <div id="dColorBox" style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px;"></div>

        <label>Select Size</label>
        <div id="dSizeBox" style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px;"></div>

        <label>Quantity</label>
        <input id="dQty" type="number" min="1" value="1" style="width:100%;padding:6px">

        <button id="addCart" style="margin-top:12px;width:100%;padding:10px;background:black;color:white;border:none;border-radius:6px;">
            Add to Cart
        </button>
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
/* your CSS here */
.slide-overlay{
    position:fixed; top:0; right:0; width:0; height:100vh;
    background:rgba(0,0,0,0.4);
    backdrop-filter:blur(2px);
    overflow:hidden;
    transition:0.3s; z-index:9999;
}
.slide-panel{
    position:absolute; top:0; right:0; width:340px; height:100%;
    background:white; padding:20px; overflow-y:auto;
    transform:translateX(100%);
    transition:0.3s;
}
.slide-overlay.active{ width:100%; }
.slide-overlay.active .slide-panel{ transform:translateX(0); }
.close-btn{ font-size:25px; background:none; border:none; float:right; cursor:pointer; margin-bottom:12px; }

.sizeBtn, .colorBtn{
    padding:6px 14px; cursor:pointer; font-size:14px; margin-bottom:4px;
}
.sizeBtn.active, .colorBtn.active{ background:rgb(170,112,148); color:#fff; }
.sizeBtn.out-of-stock{ opacity:0.5; cursor:not-allowed; }
.sizeBtn{ border:1px solid #000; border-radius:30px; }

.colorShape {
    display: inline-block;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    margin-right: 6px;
    border: 1px solid #000;
    vertical-align: middle;
}
/* Purple color for filled heart */
.wishlist-toggle.ri-heart-fill {
    color: #ae5a8d !important;  /* ← your purple shade */
}

/* Make the image box a stacking context */


/* Position Add-to-Bag button correctly & BELOW the heart */


/* Ensure the wishlist heart icon is on TOP and clickable */
.wishlist-toggle {
    position: absolute !important;
    top:-20%;

    font-size: 20px !important;
    z-index: 999999 !important; /* TOP OF EVERYTHING */
    cursor: pointer !important;
    pointer-events: auto !important;
}





</style>





<style>
.slide-overlay{
    position:fixed; top:0; right:0; width:0; height:100vh;
    background:rgba(0,0,0,0.4);
    backdrop-filter:blur(2px);
    overflow:hidden;
    transition:0.3s; z-index:9999;
}
.slide-panel{
    position:absolute; top:0; right:0; width:340px; height:100%;
    background:white; padding:20px; overflow-y:auto;
    transform:translateX(100%);
    transition:0.3s;
}
.slide-overlay.active{ width:100%; }
.slide-overlay.active .slide-panel{ transform:translateX(0); }
.close-btn{ font-size:25px; background:none; border:none; float:right; cursor:pointer; margin-bottom:12px; }

.sizeBtn, .colorBtn{
    padding:6px 14px; cursor:pointer; font-size:14px; margin-bottom:4px;
}
.sizeBtn.active, .colorBtn.active{ background:rgb(170,112,148); color:#fff; }
.sizeBtn.out-of-stock{ opacity:0.5; cursor:not-allowed; }
.sizeBtn{ border:1px solid #000; border-radius:30px; }

.colorShape {
    display: inline-block;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    margin-right: 6px;
    border: 1px solid #000;
    vertical-align: middle;
}

.wishlist-toggle {
    position: relative !important;
    z-index: 999999 !important;
    pointer-events: auto !important;
}


</style>

<script>
$(function(){

    let currentProductId = null;
    let variantsData = null;

    // === OPEN PRODUCT SLIDE ===
    $(document).on('click', '.openSlide', function(){
        currentProductId = $(this).data('id');

        $.get('/dress/' + currentProductId, function(d){
            variantsData = typeof d.variants === 'string' ? JSON.parse(d.variants) : d.variants;

            $('#frontImg').attr('src', '/uploads/dress_pic/' + d.image1);
            if(d.image2){ $('#backImg').attr('src','/uploads/dress_pic/' + d.image2).show(); }
            else{ $('#backImg').hide(); }

            $('#dName').text(d.name);
            $('#dBrand').text(d.brand);
            $('#dMaterial').text(d.material);
            $('#dDesc').text(d.description);

            $('#dColorBox').empty();
            Object.keys(variantsData).forEach(color => {
                $('#dColorBox').append(`
                    <div class="colorBtn" data-color="${color}">
                        <span class="colorShape" style="background:${color};"></span> ${color}
                    </div>
                `);
            });

            $('.colorBtn').first().addClass('active');
            populateSizes($('.colorBtn.active').data('color'));
            $('#slideOverlay').addClass('active');
        });
    });

    function populateSizes(color){
        $('#dSizeBox').empty();
        let sizes = variantsData[color];
        Object.keys(sizes).forEach(size => {
            let stock = sizes[size];
            let out = stock <= 0 ? 'out-of-stock' : '';
            let text = stock <= 0 ? `${size} (Out of stock)` : size;
            $('#dSizeBox').append(`<div class="sizeBtn ${out}" data-size="${size}" data-stock="${stock}">${text}</div>`);
        });
    }

    $(document).on('click', '.colorBtn', function(){
        $('.colorBtn').removeClass('active');
        $(this).addClass('active');
        populateSizes($(this).data('color'));
    });

    $(document).on('click', '.sizeBtn', function(){
        if($(this).hasClass('out-of-stock')) return;
        $('.sizeBtn').removeClass('active');
        $(this).addClass('active');
        $('#dQty').val(1);
    });

    $('#dQty').on('input', function(){
        let qty = parseInt($(this).val());
        let activeSize = $('.sizeBtn.active');
        if(activeSize.length){
            let maxStock = parseInt(activeSize.data('stock'));
            if(qty > maxStock){
                $(this).val(maxStock);
                showToast(`Only ${maxStock} available for this variant.`);
            }
        }
    });

    $('#closeSlide').on('click', function(){
        $('#slideOverlay').removeClass('active');
        $('#dColorBox, #dSizeBox').empty();
        $('#dQty').val(1);
    });

    $('#addCart').off('click').on('click', function(){
        let sizeBtn = $('.sizeBtn.active');
        let colorBtn = $('.colorBtn.active');

        let color = colorBtn.length ? colorBtn.data('color').toLowerCase() : null;
        let size = sizeBtn.length ? sizeBtn.data('size').toLowerCase() : null;
        let stock = sizeBtn.length ? parseInt(sizeBtn.data('stock')) : 0;
        let qty = parseInt($('#dQty').val());
        let dressId = currentProductId;

        if(!dressId) { showToast('No product selected.'); return; }
        if(!color) { showToast('Please select a color.'); return; }
        if(!size) { showToast('Please select a size.'); return; }
        if(stock <= 0) { showToast('This item is out of stock.'); return; }
        if(qty > stock){ $('#dQty').val(stock); showToast(`Only ${stock} available.`); return; }

        $.post("{{ route('add.to.cart') }}", 
        {
            _token: "{{ csrf_token() }}", 
            dress_id: dressId, 
            color: color, 
            size: size, 
            quantity: qty
        }, function(res){
            showToast(res.message);
            if(res.status){
                $('#slideOverlay').removeClass('active');
                $('#dColorBox, #dSizeBox').empty();
                $('#dQty').val(1);

                const $cartCount = $('#cartCount');
                $cartCount.text(res.cart_count);
                $cartCount.addClass('animate');
                setTimeout(() => { $cartCount.removeClass('animate'); }, 300);
            }
        });
    });

    function showToast(message){
        $('#toast').text(message).fadeIn(300).delay(1500).fadeOut(300);
    }

    // Update stock buttons dynamically
    function updateStockButtons() {
        $('.openSlide').each(function(){
            let btn = $(this);
            let dressId = btn.data('id');

            $.get('/dress/' + dressId, function(d){
                let variants = typeof d.variants === 'string' ? JSON.parse(d.variants) : d.variants;
                let hasStock = false;
                Object.values(variants).forEach(sizes => Object.values(sizes).forEach(stock => { if(stock>0) hasStock=true; }));

                if(!hasStock){
                    btn.text('OUT OF STOCK').css({background:'#444', color:'#fff', opacity:0.6}).prop('disabled', true);
                } else {
                    btn.text('ADD TO BAG').css({background:'', color:'', opacity:1}).prop('disabled', false);
                }
            });
        });
    }

    updateStockButtons();
    setInterval(updateStockButtons, 30000);

});
</script>

<script>
$(document).ready(function() {
    const isLoggedIn = {{ $isLoggedIn ? 'true' : 'false' }};

    // Initialize wishlist icons for guests
    if(!isLoggedIn){
        let guestWishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
        guestWishlist = guestWishlist.map(String); // ensure all strings
        $('.wishlist-toggle').each(function() {
            const id = $(this).data('id').toString();
            if(guestWishlist.includes(id)){
                $(this).removeClass('ri-heart-line').addClass('ri-heart-fill');
            } else {
                $(this).removeClass('ri-heart-fill').addClass('ri-heart-line');
            }
        });
    }

    // Handle wishlist toggle click
    $(document).on('click', '.wishlist-toggle', function() {
        const icon = $(this);
        const dressId = icon.data('id').toString();
        
        if(isLoggedIn){
            // Logged-in → update DB
            if(icon.hasClass('ri-heart-fill')){
                $.post("/wishlist/remove/" + dressId, {_token: "{{ csrf_token() }}"}, function() {
                    icon.removeClass('ri-heart-fill').addClass('ri-heart-line');
                });
            } else {
                $.post("/wishlist/add/" + dressId, {_token: "{{ csrf_token() }}"}, function() {
                    icon.removeClass('ri-heart-line').addClass('ri-heart-fill');
                });
            }
        } else {
            // Guest → localStorage
            let wishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
            wishlist = wishlist.map(String);
            
            if(icon.hasClass('ri-heart-fill')){
                icon.removeClass('ri-heart-fill').addClass('ri-heart-line');
                wishlist = wishlist.filter(id => id !== dressId);
            } else {
                icon.removeClass('ri-heart-line').addClass('ri-heart-fill');
                if(!wishlist.includes(dressId)) wishlist.push(dressId);
            }
            
            localStorage.setItem('guest_wishlist', JSON.stringify(wishlist));
        }
    });
});
</script>


@endsection
