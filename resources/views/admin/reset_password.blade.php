<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body class="container">

    <h1>Admin Reset Password</h1>

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

    <form action="{{ route('admin.reset_password_submit') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp">
        </div>
        <div class="mb-3 form-check">
          
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
