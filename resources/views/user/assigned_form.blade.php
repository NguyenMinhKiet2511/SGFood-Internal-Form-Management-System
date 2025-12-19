@extends('layout.main')

@section('content')
<style>
    body {
        background: url('/bg15.jpg') no-repeat center center fixed;
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
        color: #fff;
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
    <a href="{{route('user.index')}}" class="btn btn-success mb-3">
        <i class="bi bi-person-fill"></i>
        My Form
    </a>
    <table class="table table-bordered" id="assigned_table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Form ID</th>

                <th>Department</th>
                <th>Content</th>
                <th>Completion Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($forms as $pf)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ route('user.assigned.show', $pf->form->id) }}">{{ $pf->form->form_number }}</a></td>
                <td>{{ $pf->form->department }}</td>
                <td>{{ $pf->form->content }}</td>
                <td>{{ $pf->form->completion_date }}</td>
                <td>
                    @if($pf->status == 'pending')
                    <form method="POST" action="{{ route('form.accept', $pf->id) }}" style="display:inline-block;">
                        @csrf
                        <button class="btn btn-sm btn-success">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('form.reject', $pf->id) }}" style="display:inline-block;">
                        @csrf
                        <button class="btn btn-sm btn-danger">Reject</button>
                        <input name="note" placeholder="Reason" required class="form-control d-inline-block mt-2" style="width: 160px;">
                    </form>
                    @elseif($pf->status == 'accepted')
                    <form method="POST" action="{{ route('form.done', $pf->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-primary">Mark Done</button>
                    </form>
                    @else
                    <span>{{ ucfirst($pf->status) }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
