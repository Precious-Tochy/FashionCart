@extends('layouts.admin layout')
@section('content')

<div>
    <h1>Manage Users</h1>
</div>

<div class="table-wrapper">
<table class="table custom-table">
  <thead>
    @include('sweetalert::alert')
    <tr>
      <th>#</th>
      <th>Full Name</th>
      <th>Email Address</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @php $rowNumber = 1 @endphp
    @foreach ($users as $users)
    <tr>
      <td data-label="#"> {{ $rowNumber++ }} </td>
      <td data-label="Full Name">{{ $users->name }}</td>
      <td data-label="Email">{{ $users->email }}</td>
      <td data-label="Status">
        @if ($users->banned_status == 0)
          <span class="status active">Active</span>
        @else
          <span class="status banned">Banned</span>
        @endif
      </td>
      <td data-label="Action">
        @if ($users->banned_status == 0)
          <a href="{{ route('banned_status', $users->id) }}" onclick="return confirm('Ban user?')">
            <button class="btn ban">Ban</button>
          </a>
        @else
          <a href="{{ route('unbanned_status', $users->id) }}" onclick="return confirm('Unban user?')">
            <button class="btn unban">Unban</button>
          </a>
        @endif
        <a href="{{ route('deleteuser', $users->id) }}" onclick="return confirm('Delete user?')">
          <button class="btn delete">Delete</button>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<style>
  /* TABLE BASE */
.custom-table {
    width: 100%;
    border-collapse: collapse;
}

.custom-table th,
.custom-table td {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
}

.custom-table th {
    background: #f8f9fa;
    text-align: left;
}

/* STATUS */
.status.active { color: green; font-weight: 600; }
.status.banned { color: red; font-weight: 600; }

/* BUTTONS */
.btn {
    padding: 6px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.btn.ban { background: #dc3545; color: #fff; }
.btn.unban { background: #28a745; color: #fff; }
.btn.delete { background: #6c757d; color: #fff; }

/* =========================
   iPAD VIEW (SCROLLABLE)
========================= */
@media (max-width: 1024px) {
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}

/* =========================
   PHONE VIEW (STACKED)
========================= */
@media (max-width: 768px) {

    .custom-table thead {
        display: none;
    }

    .custom-table,
    .custom-table tbody,
    .custom-table tr,
    .custom-table td {
        display: block;
        width: 100%;
    }

    .custom-table tr {
        background: #fff;
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 10px;
    }

    .custom-table td {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border: none;
        border-bottom: 1px solid #eee;
    }

    .custom-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
    }

    .custom-table td:last-child {
        border-bottom: none;
        flex-wrap: wrap;
        gap: 8px;
    }
}

</style>
@endsection
