@extends('layouts.admin layout')
@section('content')
@include('sweetalert::alert')
<div class="container">
    <h2>Categories</h2>
    <a href="{{ route('admin.create') }}" class="btn btn-success mb-2">➕ Add Category</a>
    <div class="categories-table-wrapper">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent ? $category->parent->name : 'Main' }}</td>
                <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.delete', $category->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<style>
    /* ===============================
   CATEGORIES TABLE SCROLL
   (Laptop untouched)
================================ */

/* Default: Desktop & Laptop */
.categories-table-wrapper {
    overflow: visible;
}

/* iPad & Phone ONLY */
@media (max-width: 1024px) {
    .categories-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .categories-table-wrapper table {
        min-width: 700px;
    }
}

/* Phones */
@media (max-width: 768px) {
    .categories-table-wrapper table {
        min-width: 500px;
    }
}

</style>
@endsection
