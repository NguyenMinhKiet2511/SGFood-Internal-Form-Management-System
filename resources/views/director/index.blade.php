@extends('layout.main')

@section('content')
<div class="container mt-4">
  <h3 class="mb-4">📋 Forms Pending Director Approval</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No.</th>
        <th>Form Number</th>
        <th>Created By</th>
        <th>Department</th>
        <th>Content</th>
        <th>Completion Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($forms as $index => $form)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td><a href="{{ route('director.forms.show', $form->id) }}">{{ $form->form_number }}</a></td>
        <td>{{ $form->name }}</td>
        <td>{{ $form->department }}</td>
        <td>{{ $form->content }}</td>
        <td>{{ $form->completion_date }}</td>
        <td>
          @php
            $myApproval = $form->approveForms
                            ->where('manager_id', Auth::id())
                            ->where('role', 'director')
                            ->first();
          @endphp

          @if($myApproval && $myApproval->status === 'pending')
          <form action="{{ route('director.forms.approve', $form->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button class="btn btn-sm btn-success" onclick="return confirm('Approve this form?')">
              Approve
            </button>
          </form>

          <!-- Deny form with note -->
          <form action="{{ route('director.forms.deny', $form->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button class="btn btn-sm btn-danger" onclick="return confirm('Deny this form?')"> 
              Deny
            </button>
            <input type="text" name="note" class="form-control d-inline-block" style="width: 160px;" placeholder="Reason (required)" required>
          
          </form>
          @else
            <span class="text-muted">Done</span>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" class="text-center">No forms to approve</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
