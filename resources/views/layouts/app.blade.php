<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{asset('css/search_result.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Gắn Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
</head>

<body>
<<<<<<< HEAD
    @yield('content')
    <script src="{{asset('js/search_result.js')}}"></script>
=======
    <!-- content page home -->
    <div class="content">
        @yield('content')
    </div>

    <!-- footer -->
    @yield('footer')
>>>>>>> UI-Home-NguyenSon
</body>

</html>