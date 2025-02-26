<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BIZ+UDPGothic:wght@400;700&display=swap" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Scripts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/kanri.css?v='.time()) }}" type="text/css">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @vite('resources/js/app.js')
</head>
<body>
    <a href="{{ url('/') }}">
        <header class="header">メディペット<h1>予約システム管理画面</h1>
        </header> 
        </a>
    
    <div class="openbtn1"><span></span><span></span>
        <div class="menu-text">Menu</div>
    </div>
    <nav id="g-nav">
        <div id="g-nav-list"><!--ナビの数が増えた場合縦スクロールするためのdiv※不要なら削除-->
        <ul>
            <li><a href="{{ route('kanri.yoyaku.dashboard') }}">
                <div>予約　（本日～2週間後）</div>
                <div class="jp"></div>
            </a></li>
            <li><a href="{{ route('kanri.60days') }}">
                <div>予約カレンダ　（本日～60日後）</div>
                <div class="jp"></div>
            </a></li>
            <li><a href="{{ route('kanri.user') }}">
                <div>ユーザー　（管理者）</div>
                <div class="jp"></div>
            </a></li>
            <li><a href="{{ route('kanri.profile.edit') }}">
                <div>{{ __('translation.Profile') }}　（{{ Auth::user()->name }}）</div>
                <div class="jp"></div>
            </a></li>
            <li><a href="{{ route('kanri.site-setting') }}">
                <div>{{ __('サイト設定') }}</div>
            </a></li>
            <li><a href="{{ route('kanri.yoyaku-setting') }}">
                <div>イベント予約設定</div>
            </a></li>
            {{-- <li><a href="{{ route('kanri.line-index') }}">
                <div>LINE ともだち</div>
            </a></li> --}}
            <li>
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <div>{{ __('translation.Logout') }}</div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a></li>
        </ul>
        </div>
    </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>
        <footer>
            Powered by <a href="https://dx.happyplace.pet/" target="_blank">メディペット</a>
        </footer>
</body>
@stack('scripts')
<script>
    $(".openbtn1").click(function () {//ボタンがクリックされたら
    $(this).toggleClass('active');//ボタン自身に activeクラスを付与し
        $("#g-nav").toggleClass('panelactive');//ナビゲーションにpanelactiveクラスを付与
    });

    $("#g-nav a").click(function () {//ナビゲーションのリンクがクリックされたら
        $(".openbtn1").removeClass('active');//ボタンの activeクラスを除去し
        $("#g-nav").removeClass('panelactive');//ナビゲーションのpanelactiveクラスも除去
    });
</script>

</html>
