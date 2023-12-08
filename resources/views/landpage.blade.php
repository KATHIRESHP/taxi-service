<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>K Taxi</title>
    @vite(['resources/sass/app.scss'])
</head>
<body>
<div class="vh-100 vw-100 position-absolute bg-success d-flex justify-content-center align-items-center"
     style="
         background-image: url({{asset('/asset/utils/taxi-landpage.jpeg')}});
         background-position: center;
         background-repeat: no-repeat;
         background-origin: content-box;
         background-size: cover;
         ">
    <div class="w-75 gap-4">
        <span class="text-dark fs-3 bg-light px-4 py-1 rounded">Do the safe Ride!</span>
        <div class="d-flex flex-column flex-lg-row gap-4 w-75">
            <a class="btn btn-dark text-light px-5 py-1 fs-4" href="{{route('user.login')}}">Ride with K Taxi</a>
            <a class="btn btn-dark text-light px-5 py-1 fs-4" href="{{route('driver.login')}}">Drive with K Taxi</a>
            <a class="btn btn-primary text-light px-5 py-1 fs-4" href="{{route('admin.login')}}"><i class="bi bi-person-fill"></i> <span> Admin</span></a>
        </div>
    </div>
</div>
</body>
</html>
