@extends('layout')
@section('title', 'Profile')
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
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Unauthorized');
                    }
                    return res.json();
                })
                .catch(err => {
                    console.error(err);
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                });
        }
    </script>
@endsection