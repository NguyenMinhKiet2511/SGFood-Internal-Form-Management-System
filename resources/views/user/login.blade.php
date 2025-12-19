<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login | SGF</title>

    <!-- Bootstrap 3 CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- Custom Styles -->
    <style>
        body {
            /* background-color: #f2f4f8; */
            background: url('/bg3.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Helvetica Neue', sans-serif;
        }

        .login-box {
            margin-top: 60px;
            padding: 40px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-height: 80px;
        }

        h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #003366;
        }

        .btn-block {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        small {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 login-box">
                <!-- Company Logo -->
                <img src="/sgflogo.png" alt="Company Logo" class="logo">

                

                <form method="POST" action="">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus>
                        @error('email')<small>{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="password" 
                            required>
                        @error('password')<small>{{ $message }}</small>@enderror
                    </div>

                    <div class="checkbox">
                        <a href="{{ route('password.request') }}" name="forgot">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>

                  
                </form>

            </div>
        </div>
    </div>

    <!-- jQuery CDN (required for Bootstrap 3) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap 3 JS CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
