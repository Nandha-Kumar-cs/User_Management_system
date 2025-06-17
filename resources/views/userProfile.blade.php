@extends('layout')
@section('title', 'Profile')
@section('header')
    <nav class="container d-flex justify-content-between">
        <h4>DashBoard</h4>
        <article class="d-flex">
            <section>Logout</section>
            <section title="logout"><i class="bi bi-power ps-1" id="logout-btn"></i></section>
        </article>
    </nav>
@endsection
@section('main_container')

    <div class="container mt-5">
        <div class="card shadow-sm" style="max-width: 400px; margin: auto;">
            <div class="card-body">
                <form id="update-form">
                    <h5 class="card-title">User Info</h5>
                    <p class="card-text mb-1"><strong>Name:</strong> <input id="user_name" name="name" disabled></input></p>
                    <p class="card-text"><strong>Email:</strong> <input id="user_email" name="email" disabled></input></p>
                    <button class="btn btn-primary w-100 mt-3" id="update" type="button">Update</button>
                    <button class="btn btn-primary w-100 mt-3" id="save" style="display: none;">save</button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        var token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '/login';
        } else {
            fetch('/api/user/profile', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
                .then(async res => {
                    if (!res.ok) {
                        throw new Error('Unauthorized');
                    }
                    var result = await res.json();
                    $('#user_name').val(result.name);
                    $('#user_email').val(result.email);


                })
                .catch(err => {
                    console.error(err);
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                });
        }

        $('#logout-btn').on('click', async function () {
            fetch('api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            }).then(async res => {
                if (res.ok) {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                }
            })
        });

        $('#update').on('click', function () {
            $(this).hide();
            $('#user_name , #user_email').removeAttr('disabled');
            $('#save').show();
        });


        $('#save').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('#update-form')[0]);
            var token = localStorage.getItem('auth_token');
            fetch('api/user/profile', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'PUT' 
                },
                body: formData
            }).then(res => {
                if (res.ok) {
                    alert('updated SucessFully');
                    location.reload();
                }
            })
        });
    </script>
@endsection