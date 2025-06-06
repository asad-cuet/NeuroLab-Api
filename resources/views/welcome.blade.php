<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
    <title>Tork Self Coder</title>
    <style>
        body {
            text-align: center;
            font-family: "Poppins", sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .btn {
            border: none;
            border-radius: 30px;
            padding: 12px 35px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 500;
            transition: background-color 0.3s ease;
            margin: 10px;
            display: inline-block;
        }

        .btn-success {
            background-color: #23AE5B;
        }

        .btn-success:hover {
            background-color: #44ba74;
        }

        .btn-danger {
            background-color: #ee0970;
        }

        .btn-danger:hover {
            background-color: #cc085d;
        }

        .btn-primary {
            background-color: #6D71FA;
        }

        .btn-primary:hover {
            background-color: #8386fb;
        }

        .center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        p {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="center">
        <div class="container">

            @if (Auth::guard('web')->user())
                <p>Login With Web Guard as {{ Auth::guard('web')->user()->email }}</p>
            @endif
            <div>
                @if (!Auth::user())
                    <a class="btn btn-success" href="{{ url('/user/login') }}">Login to Frontend</a>
                @else
                    <a class="btn btn-danger" href="{{ url('/user/logout') }}">Logout from Frontend</a>
                @endif
            </div>

            @if (Auth::guard('admin')->user())
                <p>Login With Admin Guard as {{ Auth::guard('admin')->user()->email }}</p>
            @endif

            <a class="btn btn-primary" href="{{ route('admin') }}">Go to Admin Panel</a>
        </div>
    </div>
</body>

</html>
