<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow rounded-4">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">🔒 Forgot Password</h3>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">📧 Email address</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary w-100">📨 Send Reset Link</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">← Back to Login</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
