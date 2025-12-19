<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Repair and Maintenance Request</title>
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
    .btn-submit {
      background-color: #003366;
      color: white;
    }
    .btn-submit:hover {
      background-color: #002244;
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
    <img src="/sgflogo.png" alt="Company Logo" class="logo">
    <h2>Repair and Maintenance Request Form</h2>

    {{-- Hiển thị lỗi chung --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('form.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name"
          value="{{ old('name', Auth::user()->name) }}" required readonly>
      </div>

      <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <input type="text" class="form-control" id="department" name="department"
          value="{{ old('department', Auth::user()->department) }}" required readonly>
      </div>

      <div class="mb-3">
        <label for="factory" class="form-label">Factory</label>
        <input type="text" class="form-control" id="factory" name="factory"
          value="{{ old('factory') }}" required>
        @error('factory')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content') }}</textarea>
        @error('content')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="damage" class="form-label">Damage Description</label>
        <textarea class="form-control" id="damage" name="damage_description" rows="3" required>{{ old('damage_description') }}</textarea>
        @error('damage_description')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>


      {{-- Select Manager --}}
      <div class="mb-3">
        <label>Choose Manager</label>
        <select class="form-select" name="manager_id" required>
          <option value="" disabled selected>----------</option>
          @foreach($managers as $manager)
            <option value="{{ $manager->id }}"
              {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
              {{ $manager->name }} ({{ $manager->department }})
            </option>
          @endforeach
        </select>
        @error('manager_id')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>


      {{-- Select Director --}}
      <div class="mb-3">
        <label>Choose Director</label>
        <select class="form-select" name="director_id" required>
          <option value="" disabled selected>----------</option>
          @foreach($directors as $director)
            <option value="{{ $director->id }}"
              {{ old('director_id') ==$director->id ? 'selected' : '' }}>
              {{ $director->name }} ({{ $director->department }})
            </option>
          @endforeach
        </select>
        @error('director_id')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="completion" class="form-label">Proposed Completion Date</label>
        <input type="date" class="form-control" id="completion" name="completion_date"
          value="{{ old('completion_date') }}" required>
        @error('completion_date')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="priority_level" class="form-label">Priority Level</label>
        <select class="form-select" id="priority_level" name="priority_level" required>
          <option disabled selected>Select priority</option>
          <option value="Low" {{ old('priority_level') == 'Low' ? 'selected' : '' }}>Low</option>
          <option value="Medium" {{ old('priority_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
          <option value="High" {{ old('priority_level') == 'High' ? 'selected' : '' }}>High</option>
        </select>
        @error('priority_level')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="processing_department" class="form-label">Processing Department</label>
        <select class="form-select" id="processing_department" name="processing_department" required>
          <option disabled selected>----------</option>
          @foreach (['IT', 'HR', 'Finance', 'Sale', 'Logistic', 'Production'] as $dept)
            <option value="{{ $dept }}" {{ old('processing_department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
          @endforeach
        </select>
        @error('processing_department')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-submit btn-lg">Submit Request</button>
      </div>
      <div class="d-grid mt-4">
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
      </div>

    </form>
  </div>
</body>
</html>
