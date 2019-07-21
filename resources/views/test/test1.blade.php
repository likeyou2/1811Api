<html>
<head>
    @section('head')
        <meta charset="UTF-8">
        <title>Mstore - Online Shop Mobile Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="HandheldFriendly" content="True">

        <link rel="stylesheet" href="/home/css/materialize.css">
        <link rel="stylesheet" href="/home/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/home/css/normalize.css">
        <link rel="stylesheet" href="/home/css/owl.carousel.css">
        <link rel="stylesheet" href="/home/css/owl.theme.css">
        <link rel="stylesheet" href="/home/css/owl.transitions.css">
        <link rel="stylesheet" href="/home/css/fakeLoader.css">
        <link rel="stylesheet" href="/home/css/animate.css">
        <link rel="stylesheet" href="/home/css/style.css">

        <link rel="shortcut icon" href="/home/img/favicon.png">
    @show

</head>
<body>
@section('sidebar')
    这里是侧边栏
@show

<div class="container">
    @yield('content')
</div>
</body>
</html>