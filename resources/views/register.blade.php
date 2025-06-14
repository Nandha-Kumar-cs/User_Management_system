@extends('layout')
@section('title', 'register')
@section('main_container')
    <div class="register_container d-flex justify-content-center ">
        <div class="card shadow p-4" style="width: 100%; max-width: 450px;">
            <h3 class="text-center mb-3">Create Account</h3>
            <form action="register.php" method="POST">
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
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey=""></div>
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            <p class="text-center mt-3">
                <small>Already have an account? <a href="login.html">Login</a></small>
            </p>
        </div>
@endsection