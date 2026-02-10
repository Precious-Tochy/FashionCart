@extends('layouts.admin layout')
@section('content')
@include('sweetalert::alert')
    <div class="form-container">
    <h2><i class="ri-shirt-line"></i> Add Women’s Wear</h2>
    <form action="{{ route('create_dress') }}" method="POST" enctype="multipart/form-data">
    @csrf
      <!-- Product Name -->
      <div class="form-group">
        <label for="name">Cloth Name</label>
        <input type="text" id="name" name="name" placeholder="e.g. Floral Maxi Dress" required>
      </div>

      <!-- Brand -->
      <div class="form-group">
        <label for="brand">Brand/Designer</label>
        <input type="text" id="brand" name="brand" placeholder="e.g. Zara, Gucci, Shein">
      </div>

      <!-- Category -->
      <div class="form-group">
    <label for="category">Category</label>
    <select id="category" name="category_id" required>
      <option value="">-- Select Category --</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
</div>

      <!-- Sizes & Colors inline -->
      <div class="form-group-inline">
        <div id="variant_wrapper"></div>

<button type="button" onclick="addColorBlock()" style="margin:10px 0;padding:6px 12px;">+ Add Color Variant</button>

<script>
function addColorBlock(){
    let blockId = Date.now();

    document.getElementById('variant_wrapper').insertAdjacentHTML('beforeend', `
        <div class="color_block" style="border:1px solid #ccc;padding:12px;margin-bottom:10px;border-radius:8px;">
            
            <label>Color</label>
            <input type="text" name="color_name[]" placeholder="e.g Black" required>

            <div class="sizes_area" data-block="${blockId}">
            </div>

            <button type="button" onclick="addSizeRow(${blockId})" style="margin-top:8px;padding:4px 8px">+ Add Size</button>
        </div>
    `);
}

function addSizeRow(blockId){
    let sizeAreas = document.querySelector(`.sizes_area[data-block='${blockId}']`);

    sizeAreas.insertAdjacentHTML('beforeend', `
        <div style="display:flex;gap:10px;margin-top:6px;">
            <input type="text" name="variant_size[${blockId}][]" placeholder="Size (e.g S)">
            <input type="number" name="variant_stock[${blockId}][]" placeholder="Stock">
        </div>
    `);
}


</script>

      </div>

      <!-- Price & Stock inline -->
      <div class="form-group-inline">
        <div class="form-group">
          <label for="price">Price (₦)</label>
          <input type="number" id="price" name="price" placeholder="e.g. 15000" required>
        </div>
         {{-- <div class="form-group">
          <label for="stock">Stock Quantity</label>
          <input type="number" id="stock" name="stock" placeholder="e.g. 50" required>
        </div>   --}}
      </div>

      <!-- Material -->
      <div class="form-group">
        <label for="material">Material/Fabric</label>
        <input type="text" id="material" name="material" placeholder="e.g. Cotton, Silk, Denim">
      </div>

      <!-- Description -->
      <div class="form-group">
        <label for="description">Product Description</label>
        <textarea id="description" name="description" placeholder="Enter product details, fitting, and washing instructions"></textarea>
      </div>

      <!-- Images -->
      
        <div class="form-group">
    <label>Image 1</label>
    <input type="file" name="image1"  id="image1" accept="image/*" required>
</div>

<div class="form-group">
    <label>Image 2</label>
    <input type="file" name="image2" id="image2" accept="image/*">
</div>

      

      <button type="submit">Save Product</button>
    </form>
  </div>
  @endsection

<style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .form-container {
    max-width: 900px;
      margin: 40px auto;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
      color: #444;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
    }

    textarea {
      resize: none;
      height: 100px;
    }

    .form-group-inline {
      display: flex;
      gap: 15px;
    }

    .form-group-inline .form-group {
      flex: 1;
    }

    button {
      display: block;
      width: 100%;
      padding: 12px;
      background: #4CAF50;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover {
      background: #45a049;
    }
</style>