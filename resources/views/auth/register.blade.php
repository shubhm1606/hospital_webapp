@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-vh-100 d-flex align-items-center bg-light">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-8 col-lg-5">
				<div class="text-center mb-4">
					<h3 class="fw-bold text-primary">Civil Hospital</h3>
					<p class="text-muted">Create a user account</p>
				</div>

				<div class="card shadow-lg border-0 rounded-4">
					<div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
						<h4 class="mb-0 fw-bold">Register</h4>
					</div>

					<div class="card-body p-4 p-md-5">
						<form method="POST" action="{{ route('register') }}">
							@csrf

							<div class="mb-3">
								<label for="name" class="form-label">Name</label>
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="email" class="form-label">Email Address</label>
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
								@error('email')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="password" class="form-label">Password</label>
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
								@error('password')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-4">
								<label for="password-confirm" class="form-label">Confirm Password</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							</div>

							<div class="d-grid">
								<button type="submit" class="btn btn-primary btn-lg">Create Account</button>
							</div>
						</form>

						<div class="text-center mt-4">
							<a href="{{ route('login') }}">Already have an account? Login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
