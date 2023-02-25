<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RDI-KPRU</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body
    style="background-image: url({{ asset('img/blur-background05.jpg') }});
    position: fixed;
    width: 100vw;
    height: 100vh;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    -webkit-background-size: cover;
    background-size: cover;
    ">

    <div class="contact-form">
        <div class="d-grid d-md-flex justify-content-md-center">
            <img alt="" class="avatar" src="{{ asset('img/logo-kpru.png') }}">
            <h5>Research and Development Institute</h5>
        </div>
        @if ($message = Session::get('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    /* title: 'Oops...', */
                    text: 'Username or Password Incorrect!',
                    /*  footer: '<a href="">Why do I have this issue?</a>' */
                });
            </script>
        @endif
        @if (count($errors) > 0)
            {{-- <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>Username or Password Incorrect</li>
                @endforeach
            </ul>
        </div> --}}
        @endif

        <form id="form-validation" name="form-validation" method="POST" action="{{ route('login') }}">
            @csrf
            <label class="form-label">Username</label>
            <input
                style="border: none;border-bottom: 1px solid rgb(196, 196, 196);background: transparent;outline: none;height: 40px;color: #000;font-size: 16px;"
                placeholder="Enter Username" name="username" type="text">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-username"placeholder="Enter Password">
            <div class="d-grid d-md-flex justify-content-md-center">
                <button type="submit" value="Sign in" name="login">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
