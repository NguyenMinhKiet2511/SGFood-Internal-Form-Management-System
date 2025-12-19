@extends('layout.main')

@section('content')



{{-- 📋 List of Forms --}}
<div class="container mt-5">
  <h3>📋 Forms Needing Approval</h3>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Form Number</th>
        <th>Proposal By</th>
        <th>Factory</th>
        <th>Content</th>
        <th>Completion Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($forms as $form)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><a href="{{ route('manager.forms.show', $form->id) }}">{{ $form->form_number }}</a></td>
          <td>{{ $form->name }}</td>
          <td>{{ $form->factory }}</td>
          <td>{{ $form->content }}</td>
          <td>{{ $form->completion_date }}</td>
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
                <span>{{ ucfirst($form->status) }}</span>
              @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection

@section('scripts')
<script>
function confirmDeny(form) {
  const note = form.querySelector('input[name="note"]').value.trim();
  if (!note) {
    alert("Bạn phải nhập lý do từ chối!");
    return false;
  }
  return confirm("Bạn có chắc muốn từ chối phiếu này?");
}
</script>
<script>
    const userId = {{ Auth::id() }};

    Pusher.logToConsole = true;

    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    const channel = pusher.subscribe('user.' + userId);

    channel.bind('form.created', function(data) {
        alert(`📥 New Form: ${data.content} (from ${data.by})`);
    });
</script>
@endsection
