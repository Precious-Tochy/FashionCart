@extends('layouts.index layout')

@section('content')

<link rel="stylesheet" href="{{ asset('project/css/ass.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

<style>
.search-container {
    max-width: 1100px;
    margin: 40px auto;
}

.search-header {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 25px;
}

.result-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.1);
    transition: 0.3s ease-in-out;
}

.result-card:hover {
    transform: translateY(-5px);
}

.result-card img {
    width: 100%;
    height: 270px;
    object-fit: cover;
    border-radius: 10px;
}

.result-card h4 {
    font-size: 17px;
    margin-top: 10px;
    font-weight: 600;
    color: #333;
}

.result-card p {
    font-size: 16px;
    font-weight: bold;
    color: #9b3c72;
}

.view-btn {
    display: block;
    text-align: center;
    width: 100%;
    margin-top: 10px;
    padding: 10px 0;
    border-radius: 8px;
    background: #ae5a8d;
    color: #fff;
    text-decoration: none;
    transition: .3s ease;
}

.view-btn:hover {
    background: #8e3f72;
}

.no-results {
    font-size: 18px;
    text-align: center;
    margin-top: 40px;
}
</style>

<div class="search-container">

    <div class="search-header">
        Search Results for: <span style="color:#ae5a8d;">"{{ $search }}"</span>
    </div>

    @if($dresses->isEmpty())
        <p class="no-results">
            No items found matching <strong>"{{ $search }}"</strong>.
        </p>
    @else
        <div class="results-grid">
           @foreach($dresses as $dress)
    @php
        $variants = json_decode($dress->variants, true); // decode variants JSON
        $searchColor = strtolower($search); // search term from controller

        $availableColors = array_map('strtolower', array_keys($variants)); // all colors

        // Map images to colors based on order
        $images = [];
        $i = 1;
        foreach ($availableColors as $color) {
            $imgField = 'image'.$i;
            if (!empty($dress->$imgField)) {
                $images[strtolower($color)] = $dress->$imgField;
            }
            $i++;
        }

        // Choose the image based on search color, fallback to image1
        $imageToShow = $images[$searchColor] ?? $dress->image1;
    @endphp

    <div class="result-card">
        <img src="{{ asset('uploads/dress_pic/'.$imageToShow) }}" alt="{{ $dress->name }}">
        <h4>{{ $dress->name }}</h4>
        <p>&#8358;{{ number_format($dress->price) }}</p>
        <a href="{{ route('view.product', $dress->id) }}" class="view-btn">View Product</a>
    </div>
@endforeach

        </div>
    @endif

</div>

@endsection
