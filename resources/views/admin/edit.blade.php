@extends('layouts.admin layout')
@section('content')
@include('sweetalert::alert')

<div class="container mt-4">
    <h2>Edit Category / Subcategory</h2>

    <form action="{{ route('admin.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Category Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <!-- Parent Category Selector -->
        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category (Leave blank for main category)</label>
            <select id="parent_id" name="parent_id" class="form-select">
                <option value="">-- Main Category --</option>
                @foreach($mainCategories as $main)
                    <option value="{{ $main->id }}" @if($category->parent_id == $main->id) selected @endif>{{ $main->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Existing Images Preview -->
        @if($category->images->count())
            <div class="mb-3">
                <label>Existing Images</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($category->images as $image)
                        <div style="position: relative;">
                            <img src="{{ asset('uploads/category/' . $image->filename) }}" 
                                 alt="{{ $category->name }}" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 1px solid #ccc;">

                            <!-- Delete image link -->
                            <a href="{{ route('admin.deleteImage', $image->id) }}"
                               onclick="return confirm('Are you sure you want to delete this image?')"
                               style="position: absolute; top: 2px; right: 2px; color: red; font-weight: bold; text-decoration: none;">×</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Add More Images (only for subcategories) -->
        <!-- Add / Replace Image (only for subcategories) -->
<div class="mb-3" id="image-upload-section" style="display: {{ $category->parent_id ? 'block' : 'none' }};">
    <label>{{ $category->images->count() ? 'Replace Image' : 'Add Image' }}</label>
    <input type="file" name="image" class="form-control">
    <small class="text-muted">Only one image is allowed per subcategory. Uploading a new image will replace the existing one.</small>
</div>


        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

<script>
    // Toggle image upload field based on parent category
    const parentSelect = document.getElementById('parent_id');
    const imageSection = document.getElementById('image-upload-section');

    parentSelect.addEventListener('change', function() {
        if (this.value === "") {
            imageSection.style.display = "none"; // hide for main category
        } else {
            imageSection.style.display = "block"; // show for subcategory
        }
    });
</script>
<style>
    @media(max-width:768px){
        option{
            font-size: 8px !important;
        }
    }
     @media(max-width:1024px){
        option{
            font-size: 8px !important;
        }
    }
</style>
@endsection
