@extends('layout')
@section('title', 'Profile')
@section('header')
    <nav class="container d-flex justify-content-between">
        <h4>DashBoard</h4>
        <article class="d-flex">
            <section id="user_name" class="pe-2"></section>
            <section title="logout"><i class="bi bi-power" id="logout-btn"></i></section>
        </article>
    </nav>
@endsection
@section('main_container')


@endsection
@section('scripts')
    <script>
        var token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '/login';
        } else {
            fetch('/api/profile', {
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
                    $('#user_name').text(result.name);
                })
                .catch(err => {
                    console.error(err);
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                });
        }

        $('#logout-btn').on('click', async function () {
            fetch('api/logout', {
                method : 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            }).then( async res => {
                if(res.ok)
                {
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                }
            })
        });
    </script>
@endsection