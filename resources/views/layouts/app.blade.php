<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .side-bar
        {
            background: black;
            padding: 15px;
        }
        .side-bar a 
        {
            color: white !important;
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <ul class="nav flex-column side-bar">
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('home') }}">管理用戶</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('cuserpage') }}">創建用戶</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('hno3') }}">HNO3</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('hf') }}">HF</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('brushrollerelectricity') }}">刷輥電流</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('concentration') }}">濃度預測</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a></li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
                <div class="col-sm-9">
                    @yield('content')
                </div>
            </div>
        </div>

        
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
