<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sign In</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="assets/style.css">
        <link rel="shortcut icon" href="/front/img/logo.jpeg">
	</head>
    <body>
    <div class="container">
      <div class="login">
         <div class="container">
              <h1>Sign in</h1>
              @if (Session::has('errors'))
                <ul>
                    @foreach (Session::get('errors') as $error)
                        <li style="color: red">{{ $error[0] }}</li>
                    @endforeach
                </ul>
            @endif

            @if (Session::has('success'))
                <p style="color: green">{{ Session::get('success') }}</p>
            @endif

            @if (Session::has('failed'))
                <p style="color: red">{{ Session::get('failed') }}</p>
            @endif


              <form action="/login_member" method="POST">
                @csrf
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password"><br>
                <input type="checkbox"><span>Remember me</span>
                <a href="#">Forgot password?</a>
                <button>log in</button>
              </form>
              <span>Have an Account? <a href="/register_member" class="login-here">Create Here.</a></span>
         </div>
      </div>
      <div class="register">
        <div class="container">
            <i class="fas fa-user-plus fa-5x"></i>
            <h2>Hello, friend!</h2>
            <p>Ayo Belanja di Fresh Nugget.</p>
            <a href="/register_member" class="register-link">Register</a>
        </div>
    </div>

    </div>
		
	</body>
</html>