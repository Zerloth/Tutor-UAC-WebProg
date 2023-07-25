<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/app.js'])
</head>

<body class="container">
    <h1>Login</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-danger" role="alert">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="login" class="form-label">Id or Email address</label>
            <input name="login" type="text" class="form-control" value="{{ old('login') }}" id="login">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>
