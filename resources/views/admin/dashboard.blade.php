<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/kasir.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="/js/app.js"></script>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    @if (Auth::check())
    <div class="nav-left">
        <div class="col-md-12"><a href="/kasir"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a></div>
        <div class="col-md-12"><a href="/alltransaksi"><span class="glyphicon glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></div>
        <div class="col-md-12"><a href="/barang"><span class="glyphicon glyphicon glyphicon-equalizer" aria-hidden="true"></span></a></div>
        <div class="col-md-12"><a href="/kategori"><span class="glyphicon glyphicon glyphicon-tags" aria-hidden="true"></span></a></div>
        <div class="col-md-12"><a href="/grafik"><span class="glyphicon glyphicon glyphicon-signal" aria-hidden="true"></span></a></div>
        <div class="col-md-12"><a href="/laporan"><span class="glyphicon glyphicon glyphicon-folder-open" aria-hidden="true"></span></a></div>
    </div>
    @endif
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <ul class="nav navbar-nav">
            <a class="navbar-brand" href="#">CASH APP</a>
          </ul>
          @if (Auth::check())
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span><span class="badge">4</span><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
            </li>
            <li><a href="#">{{ Auth::user()->name }}</a></li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            @endif
          </ul>
        </div>
      </nav>
    <div class="container"><div class="row">@yield('content')</div></div>

    <div class="container">
      <div class="row"><footer style="padding: 40px 0">Laravel 8</footer></div>
    </div>
    <script type="text/javascript" src="/js/kasir.js"></script>
</body>
</html>