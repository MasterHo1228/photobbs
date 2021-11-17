<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <title>@yield('title','Photo BBS') - 灰常低调的摄影生活杂志论坛</title>
</head>
<body>
  @include('layouts._header')
  <div class="container">
    @yield('content')
    @include('layouts._footer')
  </div>
</body>
</html>
