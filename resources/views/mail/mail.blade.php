<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SGFood Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 30px;
        }

        .email-container {
            background-color: #fff;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
        }

        .content {
            line-height: 1.6;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #999;
        }

        .btn {

        }
    </style>
</head>
<body>
    <div class="email-container">


        <div class="content">
            <h2>📋 New Form Assigned</h2>

            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>You have been assigned a new maintenance request form.</p>

            <ul>
                <li><strong>Form Number:</strong> {{ $form->form_number }}</li>
                <li><strong>Department:</strong> {{ $form->department }}</li>
                <li><strong>Requested By:</strong> {{ $form->name }}</li>
                <li><strong>Content:</strong> {{ $form->content }}</li>
            </ul>

            <p>
                <a href="{{ $url }}">View Form Details</a>
            </p>
        </div>

        <div class="footer">
            © {{ date('Y') }} SGFood System. All rights reserved.
        </div>
    </div>
</body>
</html>
