@extends('layout')

@section('title', 'Login')

@section('main_container')
    <div class="login_container d-flex justify-content-center ">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-3">Admin Login</h3>

            <form id="admin-form">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>

                <input type="hidden" name="recaptcha_token" id="recaptcha-token">

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p style="font-size: 12px;" class="text-muted text-center mt-3">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6LfXx2ArAAAAAFw9JczEdfdfaA-qd00V6_Nj7ZwJ"></script>
    <script>
        $(document).ready(function () {
            $('#admin-form').on('submit', function (e) {
                e.preventDefault();

                grecaptcha.ready(function () {
                    grecaptcha.execute('6LfXx2ArAAAAAFw9JczEdfdfaA-qd00V6_Nj7ZwJ', { action: 'adminlogin' })
                        .then(function (token) {
                            $('#recaptcha-token').val(token);
                            const formData = new FormData($('#admin-form')[0]);

                            fetch('{{ url("api/admin/login") }}', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                },
                                body: formData
                            })
                                .then(response => response.json())
                                .then(result => {
                                    if (result.token) {
                                        localStorage.setItem('admin_token' , result.token)
                                        window.location.href = '/admin/users';
                                    } else {
                                        alert(result.error || 'Login failed.');
                                    }
                                })
                                .catch(err => {
                                    console.error('Request failed:', err);
                                    alert('Login error. Please try again.');
                                });
                        });
                });
            });
        });
    </script>
@endsection