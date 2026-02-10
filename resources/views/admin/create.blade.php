@extends('layouts.admin layout')
@section('content')
@include('sweetalert::alert')

<div class="container mt-4">
    <h2>Add Category / Subcategory</h2>

    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Category Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <!-- Parent Category Selector -->
        <div class="mb-3">
            <label class="form-label">Parent Category (Select a parent only if this is a subcategory)</label>
            <select id="parent_id" name="parent_id" class="form-select">
                <option value="">-- Main Category --</option>
                @foreach($mainCategories as $main)
                    <option value="{{ $main->id }}">{{ $main->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Image (ONLY for subcategories) -->
        <div class="mb-3" id="image-section" style="display: none;">
            <label>Subcategory Image</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Only one image is allowed per subcategory.</small>
        </div>

        <button type="submit" class="btn btn-success">Add Category</button>
    </form>
</div>

<script>
    const parentSelect = document.getElementById('parent_id');
    const imageSection = document.getElementById('image-section');

    parentSelect.addEventListener('change', function () {
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
            font-size: 9px;
        }
    }
</style>
@endsection
