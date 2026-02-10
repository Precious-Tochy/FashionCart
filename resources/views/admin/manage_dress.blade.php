@extends('layouts.admin layout')

@section('content')

<div class="container mt-4">

    <div class="mb-4">
        <h1>Manage Dress</h1>
        <p>Manage all your product inventory</p>
    </div>

    @include('sweetalert::alert')
    <div class="table-responsive admin-table">
    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Dress Cover</th>
                <th>Dress Back</th>
                <th>Dress Name</th>
                <th>Category</th>
                <th>Color</th>
                <th>Dress Size</th>
                <th>Price (₦)</th>
                <th>Stock Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @php $rowNumber = 1; @endphp

            @foreach($dresses as $dress)
            <tr>
                <td>{{ $rowNumber++ }}</td>

                {{-- FRONT IMAGE --}}
                <td>
                    <img 
                        src="{{ asset('uploads/dress_pic/' . $dress->image1) }}" 
                        width="80" 
                        height="80"
                        style="border-radius: 10px; object-fit: cover;">
                </td>

                {{-- BACK IMAGE --}}
                <td>
                    @if($dress->image2)
                        <img 
                            src="{{ asset('uploads/dress_pic/' . $dress->image2) }}" 
                            width="80" 
                            height="80"
                            style="border-radius: 10px; object-fit: cover;">
                    @else
                        <span class="text-muted">No Back Image</span>
                    @endif
                </td>

                <td>{{ $dress->name }}</td>

                <td>
    @if($dress->category)
        {{ $dress->category->parent ? $dress->category->parent->name . ' > ' : '' }}
        {{ $dress->category->name }}
    @else
        No Category
    @endif
</td>


                <td>
    @php
        $variants = json_decode($dress->variants, true);
    @endphp

    @if(empty($variants))
        <span class="text-danger">Not added</span>
    @else
        {{ implode(', ', array_keys($variants)) }}
    @endif
</td>


                <td>
    @if(empty($variants))
        <span class="text-danger">Not added</span>
    @else
        @php
            $sizes = [];
            foreach ($variants as $color => $colorSizes) {
                $sizes = array_merge($sizes, array_keys($colorSizes));
            }
        @endphp
        {{ implode(', ', array_unique($sizes)) }}
    @endif
</td>


                <td>₦{{ number_format($dress->price) }}</td>

                {{-- STOCK STATUS --}}
               <td>
    @php
        $inStock = false;

        if (!empty($variants)) {
            foreach ($variants as $color => $sizes) {
                foreach ($sizes as $size => $qty) {
                    if ($qty > 0) {
                        $inStock = true;
                        break 2;
                    }
                }
            }
        }
    @endphp

    @if($inStock)
        <span class="badge bg-success">In Stock</span>
    @else
        <span class="badge bg-danger">Out of Stock</span>
    @endif
</td>


                {{-- ACTION BUTTONS --}}
                <td style="white-space: nowrap;">
                    <a href="{{ route('view_dress', $dress->id) }}">
                        <button class="btn btn-secondary btn-sm">View</button>
                    </a>

                    <a href="{{ route('edit_dress', $dress->id) }}" 
                       onclick="return confirm('Are you sure you want to edit this item?')">
                        <button class="btn btn-primary btn-sm">Edit</button>
                    </a>

                    <a href="{{ route('delete_dress', $dress->id) }}" 
                       onclick="return confirm('Are you sure you want to delete this item?')">
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
</div>
<style>
    /* ===============================
   ADMIN TABLE – SAME LAYOUT
================================ */



/* iPad */
@media (max-width: 1024px) {
    .admin-table table {
        font-size: 14px;
    }

    .admin-table th,
    .admin-table td {
        padding: 8px;
    }
}

/* Phones */
@media (max-width: 768px) {

    .admin-table table {
        min-width: 900px;
        font-size: 13px;
    }

    .admin-table img {
        width: 50px;
        height: 50px;
    }

    .admin-table .btn {
        padding: 4px 8px;
        font-size: 12px;
    }
}

</style>
@endsection
