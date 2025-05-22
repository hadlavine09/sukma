<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets_backend/css/main.css')}}"> --}}
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        .material-half-bg {
            height: 100vh;
            background-color: #e7e7e7;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }

        .material-half-bg .cover {
            background-color: #00695C;
            height: 50vh;
        }

        * {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            /* background: linear-gradient(135deg, #4caf50, #a5d6a7); Green gradient */
            font-family: 'Poppins', sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-content {
            width: 100%;
            max-width: 100%;
            padding: 40px 32px 48px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-content h3 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 12px;
            color: #5a34ff;
            letter-spacing: 1.3px;
        }

        .login-content p.subtitle {
            margin: 0 0 36px;
            color: #666;
            font-weight: 500;
            font-size: 1rem;
            text-align: center;
        }

        form {
            width: 100%;
        }

        .form-group {
            position: relative;
            margin-bottom: 34px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px 12px 16px 12px;
            font-size: 1rem;
            border: 2px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
            background: transparent;
            font-weight: 600;
            color: #222;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #00695C;
            box-shadow: 0 0 8px #00695C;
        }

        label {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            background: transparent;
            padding: 0 6px;
            color: #999;
            font-size: 1rem;
            pointer-events: none;
            font-weight: 500;
            transition: all 0.25s ease;
            user-select: none;
        }

        input:focus+label,
        input:not(:placeholder-shown)+label {
            top: -10px;
            font-size: 0.8rem;
            color: #00695C;
            ;
            font-weight: 700;
            letter-spacing: 0.7px;
        }

        button.login-btn {
            width: 100%;
            padding: 15px 0;
            background-color: #00695C;
            ;
            color: white;
            font-weight: 700;
            font-size: 1.15rem;
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 18px #028f7f;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button.login-btn:hover,
        button.login-btn:focus {
            background-color: #00695C;
            box-shadow: 0 12px 30px #00695C;
            outline: none;
        }

        .error-message {
            color: #d9534f;
            background-color: #f9d6d5;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 24px;
            font-weight: 600;
            display: none;
            user-select: none;
        }

        @media (max-width: 480px) {
            .login-content {
                padding: 32px 24px 40px;
                width: 90%;
            }

            .login-content h3 {
                font-size: 2rem;
            }
        }
    </style>

</head>

<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <img class="login-head" src="{{ asset('logo/logo2.png') }}" style="padding-bottom: 22px;" alt="Login Icon">
        <div id="error-message" class="error-message" role="alert" aria-live="assertive"></div>
        <form class="login-form" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder=" " name="email" value="{{ old('email') }}" required autofocus>
                <label for="email">EMAIL</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder=" " name="password" required>
                <label for="password">PASSWORD</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 btn-container d-grid">
                <button type="submit" class="login-btn">
                    <i class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN IN
                </button>
            </div>
        </form>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets_backend/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets_backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets_backend/js/main.js') }}"></script>
    <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function() {
            $('.login-box').toggleClass('flipped');
            return false;
        });
    </script>
</body>

</html>
