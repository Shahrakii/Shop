<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد ادمین</title>
    <link rel="stylesheet" href="{{ asset('modules/auth/css/admin-dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <h1>خوش آمدید، {{ $user->name }}!</h1>
        <p>نقش شما: {{ implode(', ', $user->getRoleNames()->toArray()) }}</p>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">خروج</button>
        </form>
    </div>
</body>
</html>
