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

    <link rel="icon" type="image/x-icon" href="{{ asset('img/LogoRDI.png') }}">
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

        <form id="form-validation" name="form-validation">
            @csrf
            <input type="hidden" name="id_user" id="id_user" />
            <label class="form-label">Username</label>
            <input
                style="border: none;border-bottom: 1px solid rgb(196, 196, 196);background: transparent;outline: none;height: 40px;color: #000;font-size: 16px;"
                placeholder="Enter Username" name="username" id="username" type="text">
            <label class="form-label">Password</label>
            <input name="password" id="password" type="password" class="form-username"placeholder="Enter Password">
            <div class="d-grid d-md-flex justify-content-md-center">
                <button type="button"
                    style="color: #fff;
                font-size: 15px;
                background: #F49D1A;
                cursor: pointer;
                border-radius: 5px;
                border: none;
                padding: 10px 60px;
                width: auto;
                outline: none;
                margin-top: 5%;
                text-transform: uppercase;"
                    value="Sign in" name="login" id="login">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        $('#login').click(function() {
            var frm = $('#form-validation').serialize();
            //console.log(frm);
            $.ajax({
                type: 'POST',
                url: "{{ route('login') }}",
                dataType: 'JSON',
                data: frm,
                success: function(res) {
                    console.log(res);
                    if (res.status == 'success') {
                        console.log(res.data);
                        var data = res.data;
                        $('#id_user').val()
                        var role = res.role;
                        if (role == 'admin' && res.roled == 'null') {
                            var roles = 1;
                            var id = data[0].employee_id;
                            console.log(id);
                            var url = '/admin/dashboard/' + id + '/' + roles;
                            window.location.href = url;
                        } else if (role == 'users') {
                            if (res.roled == 'director') {
                                var roles = 4;
                                var id = data[0].employee_id;
                                console.log(id);
                                var url = '/users-director/' + id + '/' + roles;
                                window.location.href = url;
                            } else {
                                var roles = 2;
                                var id = data[0].employee_id;
                                console.log(id);
                                var url = '/users/dashboard/' + id + '/' + roles;
                                window.location.href = url;
                            }
                        } else if (role == 'director' && res.roled == 'null') {
                            var roles = 3;
                            var id = data[0].employee_referees_id;
                            console.log(id);
                            var url = '/director/dashboard/' + id + '/' + roles;
                            window.location.href = url;
                        }
                    }
                }
            })
        })
    </script>
</body>

</html>
