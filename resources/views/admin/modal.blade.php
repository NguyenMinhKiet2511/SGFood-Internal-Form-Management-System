<!-- Modal: Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    
        <div class="modal-header">
        <h5 class="modal-title">Create New User</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control create-name">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control create-email">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control create-password">
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select class="form-select create-role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="director">Director</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Department</label>
            <select class="form-select create-department">
            <option>IT</option><option>HR</option><option>Finance</option>
            <option>Sale</option><option>Logistic</option><option>Production</option>
            </select>
        </div>
        </div>

        <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-create-user">Create</button>
        </div>
    </div>
    </div>
</div>


@foreach($users as $user)
<!-- Modal: Edit User #{{ $user->id }} -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title">Edit User #{{ $user->id }}</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" class="user-id" value="{{ $user->id }}">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control name-input" value="{{ $user->name }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control email-input" value="{{ $user->email }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Department</label>
          <select class="form-select department-input">
            @foreach(['IT','HR','Finance','Sale','Logistic','Production'] as $dept)
              <option value="{{ $dept }}" @if($user->department == $dept) selected @endif>{{ $dept }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Role</label>
          <select class="form-select role-input">
            <option value="user" @if($user->role == 'user') selected @endif>User</option>
            <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
            <option value="manager" @if($user->role == 'manager') selected @endif>Manager</option>
            <option value="director" @if($user->role == 'director') selected @endif>Director</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary btn-save-user" data-user-id="{{ $user->id }}">Save</button>
      </div>

    </div>
  </div>
</div>
@endforeach
