



@extends('layout.main')

@section('content')
<style>
    body {
        background: url('/bg10.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
    }

    .glass-container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        margin-top: 60px;
        color: #fff;
    }

    h1 {
        font-weight: bold;
        
        margin-bottom: 20px;
        color:  #fff;
        text-align: center;
    }

    table {
        background-color: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    table thead {
        background-color: rgba(0, 0, 0, 0.7);
    }

    table th, table td {
        vertical-align: middle;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .form-control::placeholder {
        color: #eee;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.25);
        border-color: #fff;
        box-shadow: none;
        color: #fff;
    }
</style>

<div class="container glass-container">
    <h1> 🛠 Repair and Maintenance Request Form</h1>
    <a href="{{route('user.assigned.forms')}}" class="btn btn-danger mb-3">
        <i class="bi bi-house-gear-fill"></i>
        Assigned Form
    </a>
    <a href="{{route('form.create')}}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-lg"></i>
        Create Form
    </a>

    <table class="table table-bordered" id="user_table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Form ID</th>
                <th>Date Created</th>
                <th>Department</th>
                <th>Factory</th>
                <th>Content</th>
                <th>Completion Date</th>
                <th>Processing Dept.</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
            <tr>
                <td>{{ $loop->iteration + $forms->firstItem() - 1 }}</td>
                <td><a class="form-link" href="{{ route('form.show', $form->id) }}">{{ $form->form_number }}</a></td>
                <td>{{ $form->date_created }}</td>
                <td>{{ $form->department }}</td>
                <td>{{ $form->factory }}</td>
                <td>{{ $form->content }}</td>
                <td>{{ $form->completion_date }}</td>
                <td>{{ $form->processing_department }}</td>
                <td>{{ ucfirst($form->status) }}</td>
                <td>
                    <form action="{{ route('form.destroy', $form->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" style="margin-left: 15px"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
