@extends('layout.main')

@section('content')
<div class="container mt-5">
  <h3>🔍 Assigned Form Detail: {{ $form->form_number }}</h3>

  <table class="table table-bordered">
    <tr><th>Name</th><td>{{ $form->name }}</td></tr>
    <tr><th>Department</th><td>{{ $form->department }}</td></tr>
    <tr><th>Factory</th><td>{{ $form->factory }}</td></tr>
    <tr><th>Content</th><td>{{ $form->content }}</td></tr>
    <tr><th>Damage Description</th><td>{{ $form->damage_description }}</td></tr>
    <tr><th>Completion Date</th><td>{{ $form->completion_date }}</td></tr>
    <tr><th>Priority Level</th><td>{{ $form->priority_level }}</td></tr>
    <tr><th>Processing Department</th><td>{{ $form->processing_department }}</td></tr>
    <tr><th>Status</th><td>{{ $form->status }}</td></tr>
    <tr>
      <th>Approver(s)</th>
      <td>
        @foreach ($form->approveForms as $approve)
          {{ $approve->manager->name ?? 'N/A' }} ({{ ucfirst($approve->role) }})
          @if (!$loop->last)</br> @endif
        @endforeach
      </td>
    </tr>

    <tr>
      <th>Action</th>
      <td>
        @php
            $processingRecord = $form->processingForms()
                ->where('user_id', Auth::id())
                ->first();
        @endphp
        @if($processingRecord && $processingRecord->status == 'pending')
            <form method="POST" action="{{ route('form.accept', $processingRecord->id) }}" style="display:inline-block;">
                @csrf
                <button class="btn btn-sm btn-success">Accept</button>
            </form>

            <form method="POST" action="{{ route('form.reject', $processingRecord->id) }}" style="display:inline-block;">
                @csrf
                <button class="btn btn-sm btn-danger">Deny</button>
                <input type="text" name="note" class="form-control d-inline-block" style="width: 160px;" placeholder="Reason (required)" required>
            </form>
            @elseif($processingRecord && $processingRecord->status == 'accepted')
            <form method="POST" action="{{ route('form.done', $processingRecord->id) }}">
                @csrf
                <button class="btn btn-sm btn-primary">Mark Done</button>
            </form>
            @else
            <span>{{ ucfirst($processingRecord->status) }}</span>
      </td>
    </tr>
    @endif
  </table>

  <a href="{{ route('user.assigned.forms') }}" class="btn btn-secondary">← Back to Assigned Forms</a>
</div>
@endsection
