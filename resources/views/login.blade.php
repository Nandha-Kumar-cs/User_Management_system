@extends('layout')
@section('title', 'Login')
@section('main_container')
    <div class="login_container d-flex justify-content-center ">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-3">Login</h3>

            <form action="login.php" method="POST">
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
                <small>Don't have an account? <a href="#">Register</a></small>
            </p>
        </div>
    </div>
@endsection