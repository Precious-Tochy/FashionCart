@extends('layouts.admin layout')
@section('content')
<div>
    <div>
        <h1>
            <a href="{{route('manage_dress')}}">
                <i class="ri-arrow-left-s-line"></i>
            </a>
            View Dress
        </h1>
        <p>View all Informations about this dress</p>
    </div>

    <div class="mt-4">

        <!-- Images -->
        <div class="gr">
            <img src="{{asset('uploads/dress_pic/' . $dress->image1) }}" 
                 style="width: 400px; height: 300px; object-fit: cover; border-radius:10px;">

            @if($dress->image2)
                <img src="{{asset('uploads/dress_pic/' . $dress->image2) }}" 
                     style="width: 400px; height: 300px; object-fit: cover; margin-top:15px; border-radius:10px;">
            @endif
        </div>

        <!-- Basic Info -->
        <div class="form-group mt-3">
            <label>Cloth Name</label>
            <input type="text" value="{{ $dress->name }}" readonly>
        </div>

        <div class="form-group mt-3">
            <label>Brand/Designer</label>
            <input type="text" value="{{ $dress->brand }}" readonly>
        </div>

        <div class="form-group mt-3">
            <label>Category/Subcategory</label>
            <input type="text" value="{{ $dress->category ? ($dress->category->parent ? $dress->category->parent->name . ' > ' : '') . $dress->category->name : 'No Category' }}" readonly>

        </div>

        <!-- Variants Section -->
        @php
            $variants = json_decode($dress->variants, true) ?? [];
        @endphp

        <div class="form-group mt-4">
            <label><strong>Colors, Sizes & Available Stock</strong></label>

            @if(count($variants))
                @foreach($variants as $color => $sizes)
                    <div style="margin-top: 10px; padding:10px; background:#f5f5f5; border-radius:8px;">
                        <strong>Color: {{ $color }}</strong>

                        <ul style="margin-top: 5px; margin-left:15px;">
                            @foreach($sizes as $size => $stock)
                                <li>{{ $size }} — {{ $stock }} left</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                <p>No variants added.</p>
            @endif
        </div>

        <!-- Price -->
        <div class="form-group mt-3">
            <label>Price (₦)</label>
            <input type="text" value="{{ $dress->price }}" readonly>
        </div>

        <!-- Material -->
        <div class="form-group mt-3">
            <label>Material/Fabric</label>
            <input type="text" value="{{ $dress->material }}" readonly>
        </div>

        <!-- Description -->
        <div class="form-group mt-3">
            <label>Product Description</label>
            <textarea readonly>{{ $dress->description }}</textarea>
        </div>

    </div>
</div>
<style>
    @media(max-width:768px){
        .gr img{
            width: 280px !important;;
        }
    }
</style>
@endsection
