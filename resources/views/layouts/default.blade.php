<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/app.css">
  <title>@yield('title','Photo BBS') - 灰常低调的摄影生活杂志论坛</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/">Photo BBS</a>
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
        <li class="nav-item" ><a class="nav-link" href="#">登录</a></li>
      </ul>
    </div>
  </nav>
  <div class="container">
    @yield('content')
  </div>
</body>
</html>
