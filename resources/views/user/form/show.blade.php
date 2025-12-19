<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Details - {{ $form->form_number }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #94C23D;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 30px;
    }
    .form-container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #003366;
    }
    .form-label {
      font-weight: 500;
    }
    .form-value {
      padding: 8px 12px;
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 5px;
    }
    .logo {
      display: block;
      margin: 0 auto 20px;
      max-width: 100px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <p>{{ $form->form_number }}</p>
    <img src="/sgflogo.png" alt="Company Logo" class="logo">
    <h2>Repair and Maintenance Request</h2>

    <div class="mb-3">
      <label class="form-label">Name</label>
      <div class="form-value">{{ $form->name }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Department</label>
      <div class="form-value">{{ $form->department }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Factory</label>
      <div class="form-value">{{ $form->factory }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Content</label>
      <div class="form-value">{{ $form->content }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Damage Description</label>
      <div class="form-value">{{ $form->damage_description }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Proposed Completion Date</label>
      <div class="form-value">{{ $form->completion_date }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Priority Level</label>
      <div class="form-value text-capitalize">{{ $form->priority_level }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Processing Department</label>
      <div class="form-value">{{ $form->processing_department }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <div class="form-value text-capitalize">{{ $form->status }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Approver</label>
      <div class="form-value text-capitalize">
        @forelse($form->approveForms as $approval)
          <div class="mb-2">
            <strong>{{ $approval->manager->name }}</strong> 
            @if($approval->status === 'approved')
              <span class="badge bg-success">Approved</span>
            @elseif($approval->status === 'denied' && $approval->note)
              <span class="badge bg-danger">Denied</span>
              <br><small class="text-muted">Reason for dening: {{ $approval->note }}</small>
            @else
              <span class="badge bg-secondary">Pending</span>
            @endif
          </div>
        @empty
          <em>No approver have been checked yet..</em>
        @endforelse</div>
    </div>
    <div class="mt-4">
      <a href="{{ route('user.index') }}" class="btn btn-secondary">Back to My Form</a>
    </div>
  </div>
</body>
</html>
