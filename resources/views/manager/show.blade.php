@extends('layout.main')

@section('content')
<div class="container mt-5">
  <h3>📄 Form Detail: {{ $form->form_number }}</h3>

  <table class="table table-bordered">
    <tr><th>Name</th><td>{{ $form->name }}</td></tr>
    <tr><th>Department</th><td>{{ $form->department }}</td></tr>
    <tr><th>Factory</th><td>{{ $form->factory }}</td></tr>
    <tr><th>Content</th><td>{{ $form->content }}</td></tr>
    <tr><th>Damage Description</th><td>{{ $form->damage_description }}</td></tr>
    <tr><th>Completion Date</th><td>{{ $form->completion_date }}</td></tr>
    <tr><th>Priority Level</th><td>{{ $form->priority_level }}</td></tr>
    <tr><th>Processing Department</th><td>{{ $form->processing_department }}</td></tr>
    <tr><th>Action</th>
          <td>
            @if($form->status === 'pending')
              {{-- Approve --}}
              <form action="{{ route('manager.forms.approve', $form->id) }}" method="POST" class="d-inline-block">
                @csrf
                <button class="btn btn-success btn-sm">Approve</button>
              </form>

              {{-- Deny --}}
              <form action="{{ route('manager.forms.deny', $form->id) }}" method="POST" class="d-inline-block" onsubmit="return confirmDeny(this)">
                @csrf
                <button class="btn btn-danger btn-sm">Deny</button>
                <input type="text" name="note" class="form-control d-inline-block" style="width: 160px;" placeholder="Reason (required)" required>
              </form>
            @else
              {{-- Show status  --}}
              <span >
                  {{ ucfirst($form->status) }}
              </span>
            @endif
         </td>
    </tr>
    <tr>
      <th>Approvers</th>
      <td>
        @forelse($form->approveForms as $approval)
          <div class="mb-2">
            <strong>{{ $approval->manager->name }}</strong> 
            @if($approval->status === 'approved')
              <span class="badge bg-success">Approved</span>
            @elseif($approval->status === 'denied')
              <span class="badge bg-danger">Denied</span>
            @else
              <span class="badge bg-secondary">Pending</span>
            @endif
            @if($approval->status === 'denied' && $approval->note)
              <br><small class="text-muted">Reason for dening: {{ $approval->note }}</small>
            @endif
          </div>
        @empty
          <em>No approver have been checked yet..</em>
        @endforelse
      </td>

  </table>

  <a href="{{ route('manager.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection