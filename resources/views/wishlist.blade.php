@extends('layouts.index layout')

@section('content')

<link rel="stylesheet" href="{{ asset('project/css/heart.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="my">
    <strong>MY WISHLIST</strong>

    @if($dresses->isEmpty())
        <p>OH NO! YOU HAVE NO STYLES IN YOUR WISHLIST YET</p>
        <div class="but">
        <button onclick="window.location='{{ url('/') }}'">START SHOPPING</button>
    </div>
</div>
    @else
        <div class="wishlist-items">
            @foreach($dresses as $dress)
                <div class="wishlist-item">
                    <img src="{{ asset('uploads/dress_pic/'.$dress->image1) }}" alt="{{ $dress->name }}" width="150">
                    <h4>{{ $dress->name }}</h4>
                    <p>&#8358;{{ number_format($dress->price) }}</p>
                    <i class="wishlist-toggle {{ in_array($dress->id, Auth::check() ? Auth::user()->wishlists()->pluck('dress_id')->toArray() : []) ? 'ri-heart-fill' : 'ri-heart-line' }}" 
                       data-id="{{ $dress->id }}"></i>
                </div>
            @endforeach
        </div>
    @endif

    
</div>

<style>
.wishlist-toggle {
    position: relative;
    z-index: 10;
    pointer-events: auto;
    font-size: 22px;
    cursor: pointer;
    transition: color 0.2s;
}
.wishlist-toggle.ri-heart-fill {
    color: #ae5a8d; /* Purple fill */
}
.wishlist-toggle.ri-heart-line {
    color: #444; /* Gray outline */
}
.wishlist-item {
    display: inline-block;
    margin: 10px;
    text-align: center;
    position: relative;
}
.wishlist-item img {
    border-radius: 6px;
}
</style>

<script>
$(function(){
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    const container = $('.wishlist-items');

    // Load guest wishlist items
    if(!isLoggedIn){
        let guestWishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
        if(guestWishlist.length > 0){
            guestWishlist.forEach(id => {
                $.get('/dress/' + id, function(d){
                    const item = `
                        <div class="wishlist-item">
                            <img src="/uploads/dress_pic/${d.image1}" alt="${d.name}" width="150">
                            <h4>${d.name}</h4>
                            <p>&#8358;${Number(d.price).toLocaleString()}</p>
                            <i class="wishlist-toggle ri-heart-fill" data-id="${d.id}"></i>
                        </div>
                    `;
                    container.append(item);
                });
            });
        } else {
            $('.my p').show();
        }
    }

    // Toggle wishlist icon
    $(document).on('click', '.wishlist-toggle', function(){
        const icon = $(this);
        const dressId = icon.data('id').toString();

        // Visual toggle
        if(icon.hasClass('ri-heart-fill')){
            icon.removeClass('ri-heart-fill').addClass('ri-heart-line');
        } else {
            icon.removeClass('ri-heart-line').addClass('ri-heart-fill');
        }

        if(isLoggedIn){
            if(icon.hasClass('ri-heart-fill')){
                $.post("/wishlist/add/" + dressId, {_token: "{{ csrf_token() }}"});
            } else {
                $.post("/wishlist/remove/" + dressId, {_token: "{{ csrf_token() }}"}, function(){
                    icon.closest('.wishlist-item').remove();
                });
            }
        } else {
            let wishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
            if(icon.hasClass('ri-heart-fill')){
                if(!wishlist.includes(dressId)) wishlist.push(dressId);
            } else {
                wishlist = wishlist.filter(id => id !== dressId);
                icon.closest('.wishlist-item').remove();
            }
            localStorage.setItem('guest_wishlist', JSON.stringify(wishlist));
        }
    });
});
</script>

@endsection
