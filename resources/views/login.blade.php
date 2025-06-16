@extends('layout')
@section('title', 'Login')
@section('main_container')
    <div class="login_container d-flex justify-content-center ">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-3">Login</h3>

            <form action="login.php" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="text-center mt-3">
                <small>Don't have an account? <a href="{{ route('register') }}">Register</a></small>
            </p>
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
        document.addEventListener('DOMContentLoaded', function () {
            grecaptcha.ready(function () {
                grecaptcha.execute('6LfXx2ArAAAAAFw9JczEdfdfaA-qd00V6_Nj7ZwJ', { action: 'login' })
                    .then(function (token) {
                        try {
                            if (!token || typeof token !== 'string') {
                                throw new Error('Invalid reCAPTCHA token');
                            }

                            const tokenInput = document.getElementById('recaptcha-token');
                            if (!tokenInput) {
                                throw new Error('Missing hidden input with id="recaptcha-token"');
                            }
                            tokenInput.value = token;
                        } catch (err) {
                            console.error('Token processing error:', err);
                        }
                    })
                    .catch(function (err) {
                        console.error('reCAPTCHA execute error:', err);
                    });
            });
        });
    </script>


@endsection