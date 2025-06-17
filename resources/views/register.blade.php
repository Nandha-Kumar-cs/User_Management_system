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
        $(document).ready(function () {
            $('#register-form').on('submit', function (e) {
                e.preventDefault();

                grecaptcha.ready(function () {
                    grecaptcha.execute('6LfXx2ArAAAAAFw9JczEdfdfaA-qd00V6_Nj7ZwJ', { action: 'register' })
                        .then(function (token) {
                            $('#recaptcha-token').val(token);
                            const formData = new FormData($('#register-form')[0]);
                            fetch('{{ url("api/register") }}', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                },
                                body: formData
                            })
                                .then(async response => {
                                    const result = await response.json();
                                    if (response.ok) {
                                        localStorage.setItem('auth_token', result.token);
                                        window.location.href = '/profile';
                                    } else {
                                        $('.is-invalid').removeClass('is-invalid');
                                        $('.invalid-feedback').remove();
                                        const errors = result.error || result.errors || {};
                                        for (let field in errors) {
                                            let input = $(`[name="${field}"]`);
                                            input.addClass('is-invalid');
                                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                        }
                                    }
                                })
                                .catch(error => {
                                    alert('Registration error. Please try again.');
                                });
                        });
                });
            });
        });

    </script>


@endsection