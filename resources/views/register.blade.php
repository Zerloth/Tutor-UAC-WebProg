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
    <h1>Register</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <p>{{ session('success') }}</p>
            <a href="{{ route('login') }}" class="alert-link">Go to login</a>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" value="{{ old('name') }}" id="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email') }}" id="email">
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">DT Code</label>
            <input name="dating_code" type="text" class="form-control" value="{{ old('dating_code') }}"
                id="code">
        </div>
        <div class="mb-3">
            <label for="birthday" class="form-label">Birthday</label>
            <input name="birthday" type="date" class="form-control" value="{{ old('birthday') }}" id="birthday">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-select" id="gender">
                <option>Open this select menu</option>
                <option @if (old('gender') == 'male') selected @endif value="male">Male</option>
                <option @if (old('gender') == 'female') selected @endif value="female">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone number</label>
            <input name="phone_number" type="tel" class="form-control" value="{{ old('phone_number') }}"
                id="phone_number">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input name="image" type="file" class="form-control" id="image"
                accept="image/png, image/gif, image/jpeg">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Password Confirmation</label>
            <input name="password_confirmation" type="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>
