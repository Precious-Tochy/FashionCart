@extends('layouts.admin layout')
@section('content')
@include('sweetalert::alert')

<div class="form-container">
    <h2><i class="ri-shirt-line"></i> Edit Women’s Wear</h2>
    <form action="{{ route('update_dress', $dress->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name & Brand -->
        <div class="form-row">
            <div class="form-group">
                <label for="name">Cloth Name</label>
                <input type="text" id="name" name="name" value="{{$dress->name}}" placeholder="e.g. Floral Maxi Dress" required>
            </div>
            <div class="form-group">
                <label for="brand">Brand/Designer</label>
                <input type="text" id="brand" name="brand" value="{{$dress->brand}}" placeholder="e.g. Zara, Gucci, Shein">
            </div>
        </div>

        <!-- Category & Price -->
        <div class="form-row">
           <div class="form-group">
    <label for="category">Category</label>
    <select id="category" name="category_id" required>
      <option value="">-- Select Category --</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
</div>
<style>
    @media(max-width:768px){
    option{
        font-size: 11px;
    }}
</style>
            <div class="form-group">
                <label for="price">Price (₦)</label>
                <input type="number" id="price" name="price" value="{{$dress->price}}" placeholder="e.g. 15000" required>
            </div>
        </div>

        <!-- Material & Description -->
        <div class="form-group">
            <label for="material">Material/Fabric</label>
            <input type="text" id="material" name="material" value="{{$dress->material ?? ''}}" placeholder="e.g. Cotton, Silk, Denim">
        </div>

        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea id="description" name="description" placeholder="Enter product details, fitting, and washing instructions">{{ $dress->description ?? '' }}</textarea>
        </div>

        <!-- Variants (Color + Sizes + Stock) -->
        @php
            $variants = json_decode($dress->variants, true) ?? [];

        @endphp

        <div class="variants-container">
            <h3>Variants</h3>
            <div id="variants_wrapper">
                @if(count($variants))
                    @foreach($variants as $color => $sizes)
                    <div class="variant_block">
                        <div class="variant-header">
                            <label>Color</label>
                            <input type="text" name="color_name[]" value="{{ $color }}" placeholder="Color e.g. Red" required>
                            <button type="button" class="remove-variant" onclick="removeVariant(this)">✕ Remove Color</button>
                        </div>

                        <div class="sizes_wrapper">
                            @foreach($sizes as $size => $stock)
                            <div class="size_item">
                                <input type="text" name="variant_size[{{ $color }}][]" value="{{ $size }}" placeholder="Size (e.g S)" required>
                                <input type="number" name="variant_stock[{{ $color }}][]" value="{{ $stock }}" placeholder="Stock" required>
                                <button type="button" class="remove-size" onclick="removeSize(this)">✕</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="add-size-btn" onclick="addSize(this)">+ Add Size</button>
                    </div>
                    @endforeach
                @else
                    <div class="variant_block">
                        <div class="variant-header">
                            <label>Color</label>
                            <input type="text" name="color_name[]" placeholder="Color e.g. Red" required>
                        </div>
                        <div class="sizes_wrapper">
                            <div class="size_item">
                                <input type="text" name="variant_size[newcolor][]" placeholder="Size (e.g S)" required>
                                <input type="number" name="variant_stock[newcolor][]" placeholder="Stock" required>
                                <button type="button" class="remove-size" onclick="removeSize(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" class="add-size-btn" onclick="addSize(this)">+ Add Size</button>
                    </div>
                @endif
            </div>
            <button type="button" class="add-variant-btn" onclick="addVariant()">+ Add Color</button>
        </div>

        <!-- Current Images -->
        @if($dress->image1)
        <div class="form-group">
            <label>Current Image 1</label>
            <img src="{{ asset('uploads/dress_pic/'.$dress->image1) }}" class="product-image">
        </div>
        @endif

        @if($dress->image2)
        <div class="form-group">
            <label>Current Image 2</label>
            <img src="{{ asset('uploads/dress_pic/'.$dress->image2) }}" class="product-image">
        </div>
        @endif

        <!-- Upload New Images -->
        <div class="form-row">
            <div class="form-group">
                <label>Image 1</label>
                <input type="file" name="image1" accept="image/*">
            </div>
            <div class="form-group">
                <label>Image 2</label>
                <input type="file" name="image2" accept="image/*">
            </div>
        </div>

        <button type="submit" class="submit-btn">Update Product</button>
    </form>
</div>

@endsection

<style>
body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    margin: 0;
    padding: 0;
}

.form-container {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

h3 {
    margin-bottom: 15px;
    color: #555;
}

.form-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.form-group {
    flex: 1;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
}

input, select, textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

.product-image {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 10px;
}

button {
    cursor: pointer;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-weight: bold;
    transition: 0.3s;
}

.submit-btn {
    width: 100%;
    background: #4CAF50;
    color: #fff;
    font-size: 16px;
    margin-top: 20px;
}

.submit-btn:hover {
    background: #45a049;
}

.variants-container {
    margin-top: 20px;
}

.variant_block {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}

.variant-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.variant-header input {
    flex: 1;
}

.add-size-btn, .add-variant-btn {
    margin-top: 10px;
    background: #2196F3;
    color: #fff;
}

.add-size-btn:hover, .add-variant-btn:hover {
    background: #0b7dda;
}

.remove-variant, .remove-size {
    background: #f44336;
    color: #fff;
    padding: 3px 8px;
    font-size: 14px;
    border-radius: 5px;
}

.remove-variant:hover, .remove-size:hover {
    background: #d32f2f;
}

.size_item {
    display: flex;
    gap: 10px;
    margin-bottom: 8px;
}
.size_item input {
    flex: 1;
}
</style>

<script>
function addSize(btn){
    const wrapper = btn.previousElementSibling;
    const colorInput = btn.parentElement.querySelector('input[name^="color_name"]').value || 'newcolor';
    wrapper.insertAdjacentHTML('beforeend',`
        <div class="size_item">
            <input type="text" name="variant_size[${colorInput}][]" placeholder="Size (e.g M)" required>
            <input type="number" name="variant_stock[${colorInput}][]" placeholder="Stock" required>
            <button type="button" class="remove-size" onclick="removeSize(this)">✕</button>
        </div>
    `);
}

function addVariant(){
    const wrapper = document.getElementById('variants_wrapper');
    wrapper.insertAdjacentHTML('beforeend',`
        <div class="variant_block">
            <div class="variant-header">
                <label>Color</label>
                <input type="text" name="color_name[]" placeholder="Color e.g. Blue" required>
                <button type="button" class="remove-variant" onclick="removeVariant(this)">✕ Remove Color</button>
            </div>
            <div class="sizes_wrapper">
                <div class="size_item">
                    <input type="text" name="variant_size[newcolor][]" placeholder="Size (e.g S)" required>
                    <input type="number" name="variant_stock[newcolor][]" placeholder="Stock" required>
                    <button type="button" class="remove-size" onclick="removeSize(this)">✕</button>
                </div>
            </div>
            <button type="button" class="add-size-btn" onclick="addSize(this)">+ Add Size</button>
        </div>
    `);
}

function removeVariant(btn){
    btn.closest('.variant_block').remove();
}

function removeSize(btn){
    btn.closest('.size_item').remove();
}
</script>
