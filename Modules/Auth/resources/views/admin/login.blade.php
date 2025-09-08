<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود ادمین</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Vazirmatn', sans-serif; }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            width: 400px;
            max-width: 90%;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
        }

        .login-container form div { margin-bottom: 20px; text-align: right; }

        .login-container label { display: block; margin-bottom: 5px; font-weight: 600; }

        .login-container input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 16px;
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .login-container input::placeholder { color: rgba(255,255,255,0.7); }

        .login-container button {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-size: 18px;
            font-weight: 700;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .error-message {
            background: rgba(255,0,0,0.2);
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            color: #ffdddd;
        }

        @media (max-width: 500px) {
            .login-container { padding: 25px; }
            .login-container h2 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>ورود ادمین</h2>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div>
                <label>ایمیل یا شماره موبایل</label>
                <input type="text" name="email" placeholder="ایمیل یا شماره موبایل خود را وارد کنید" required>
            </div>
            <div>
                <label>رمز عبور</label>
                <input type="password" name="password" placeholder="رمز عبور" required>
            </div>
            <button type="submit">ورود</button>
        </form>

        <br>

        @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</body>
</html>
