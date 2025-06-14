<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?render=6Le0yGArAAAAAK_KOX8uRdq0F4IGzubtqwJZfpwt"></script>
</head>
<style>
    body{
        height: 100vh;
        width: 100%;
    }
    header{
        height: 10%;
        width: 100%;
    }
    .main_container{
        height: 80%;
        width: 100%;
    }
</style>
<body>
    <header>
        @yield('header')
    </header>
    <div class="main-container">
        @yield('main_container')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>