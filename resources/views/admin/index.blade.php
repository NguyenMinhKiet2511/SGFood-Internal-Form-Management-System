@extends('layout.main')

@section('content')
<div class="container">
  <h2 class="mb-4">🔐 Admin Dashboard</h2>

  {{-- Success Message --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Validation Errors --}}
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="col-md-4 align-self-end">
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
      Create
    </button>
  </div>
  {{-- User List Table --}}
  <div class="table-section">
    <h4>👥 User & Admin List</h4>
    <table class="table table-bordered table-hover bg-white" id="user_table">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Department</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr id="user-row-{{ $user->id }}">
          <td>{{ $user->id }}</td>
          <td class="user-name">{{ $user->name }}</td>
          <td class="user-email">{{ $user->email }}</td>
          <td class="user-role">{{ ucfirst($user->role) }}</td>
          <td class="user-department">{{ $user->department }}</td>
          <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
              <i class="bi bi-pen"></i>
            </button>
            <form action="{{ route('admin.delete.user', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@include('admin.modal')
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
