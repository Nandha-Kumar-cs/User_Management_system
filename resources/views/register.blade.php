@extends('layout')
@section('title', 'register')

@section('main_container')
    <div class="register_container d-flex justify-content-center">
        <div class="card shadow p-4" style="width: 100%; max-width: 450px;">
            <h3 class="text-center mb-3">Create Account</h3>

            <form id="register-form">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
                <div class="mb-3">
                    <label for="confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm" name="confirm" required />
                </div>
                <input type="hidden" name="recaptcha_token" id="recaptcha-token">
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>

            <p class="text-center mt-3">
                <small>Already have an account? <a href="{{ route('login') }}">Login</a></small>
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

        });


        // for registering the input
        $('#register-form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            new Promise((resolve, reject) => {
                grecaptcha.ready(function () {
                    grecaptcha.execute('6LfXx2ArAAAAAFw9JczEdfdfaA-qd00V6_Nj7ZwJ', { action: 'register' })
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
                                
                                resolve();
                            } catch (err) {
                                console.error('Token processing error:', err);
                                reject();
                            }
                        })
                        .catch(function (err) {
                            console.error('reCAPTCHA execute error:', err);
                            reject();
                        });
                });
            });

            var formData = new FormData(this);
            fetch('api/register', {
                method: 'POST',
                body: formData
            }).then(async response => {
                const result = await response.json();
                if (response.ok) {
                    window.location.href = '/profile';
                }
                else if (response.status != 200) {
                    let errors = result.error;
                    for (let field in errors) {
                        let input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                    }

                }
            }).catch(error => { alert(error); })
        });

    </script>


@endsection