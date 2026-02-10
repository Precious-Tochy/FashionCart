@extends('layouts.admin layout')

@section('content')
<div>
    <h1>Manage Delivery Fees</h1>
    <p>Add, edit, or delete delivery fees for each state.</p>

    @include('sweetalert::alert')

    <!-- Add New Delivery Fee -->
    <div style="margin-bottom:20px;">
        <form action="{{ route('admin.deliveries.store') }}" method="POST" style="display:flex; gap:10px;">
            @csrf
            <input type="text" name="state" placeholder="State Name" required class="form-control">
            <input type="number" name="fee" placeholder="Delivery Fee" step="0.01" min="0" required class="form-control">
            <button type="submit" class="btn btn-success">Add Delivery Fee</button>
        </form>
    </div>

    <!-- Delivery Table -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>State</th>
                <th>Fee (₦)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deliveries as $index => $delivery)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $delivery->state }}</td>
                <td>{{ number_format($delivery->fee, 2) }}</td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-primary" onclick="editDelivery({{ $delivery->id }}, '{{ $delivery->state }}', {{ $delivery->fee }})">Edit</button>

                    <!-- Delete Form -->
                    <form action="{{ route('admin.deliveries.delete', $delivery->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this fee?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:20px; border-radius:10px; width:400px; position:relative;">
        <button onclick="closeEditModal()" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:20px; cursor:pointer;">×</button>
        <h3>Edit Delivery Fee</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:10px;">
                <label>State</label>
                <input type="text" name="state" id="editState" class="form-control" required>
            </div>
            <div style="margin-bottom:10px;">
                <label>Fee</label>
                <input type="number" name="fee" id="editFee" class="form-control" step="0.01" min="0" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</div>

<script>
function editDelivery(id, state, fee){
    document.getElementById('editState').value = state;
    document.getElementById('editFee').value = fee;
    document.getElementById('editForm').action = '/admin/deliveries/' + id;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal(){
    document.getElementById('editModal').style.display = 'none';
}
</script>

@endsection
