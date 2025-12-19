<!DOCTYPE html>
<html lang="en">
<head>
    <title>Công ty CP Sài Gòn Food</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/Routepage/favicon.ico" type="image/x-icon">
    <link href="http://fonts.googleapis.com/css?family=Terminal+Dosis" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('/bg5.jpg') no-repeat center center fixed;
            background-size: cover;
            
            min-height: 700px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            padding-top: 45px;
        }

        .header img {
            width: 90px;
            padding: 5px;
        }

        .header div {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 70px;
        }

        .ca-menu {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 40px;
        }

        .ca-menu li {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            width: 260px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .ca-menu li:hover {
            transform: translateY(-10px);
        }

        .ca-menu a {
            display: block;
            text-decoration: none;
            color: #333;
            padding: 30px 20px;
        }

        .ca-icon {
            font-size: 40px;
            margin-bottom: 15px;
            display: block;
        }

        .ca-main {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .ca-sub {
            font-size: 1rem;
            color: #555;
        }

        .productivity-text {
            position: absolute;
            bottom: 70px;
            left: 50px;
            color: #5a3e2b;
        }

        .productivity-text h3 {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <a href="https://sgfoods.com.vn"><img src="/sgflogo.png" alt="SG Food Logo"></a>
    <div>MANAGEMENT INFORMATION SYSTEMS</div>
</div>

<div  class="content">
    <ul class="ca-menu">
        <li>
            <a href="{{route('login')}}">
                {{-- <span class="ca-icon"></span> --}}
                <div class="ca-content">
                    <h2 class="ca-main">Proposal Form</h2>
                    <h3 class="ca-sub">Repair & Maintenance</h3>
                </div>
            </a>
        </li>
        
    </ul>
</div>

<div class="productivity-text">
    <h3>Productivity</h3>
    <em>pro·duc·tiv·i·ty</em><br>
    <small><i>noun</i></small>
    <p>
        &bull; The state or quality of being productive<br>
        &bull; Doing more with limited time.
    </p>
</div>

</body>
</html>
