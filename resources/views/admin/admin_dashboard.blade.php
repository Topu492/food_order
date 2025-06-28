<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body class="container">

    <h1>Admin dashboard</h1>

    @if ($errors->any())

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    @endif

    @if (Session::has('error'))
        <li>{{ Session::get('error') }}</li>
    @endif
    @if (Session::has('success'))
        <li>{{ Session::get('success') }}</li>
    @endif

    


 <a href="{{ route('admin.logout') }}">Logout</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
