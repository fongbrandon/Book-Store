<html>
    <head>
    </head>
    <body>
        <h1>Sign Up</h1>
        <form method="post" action="/sign_up">
            @csrf
            <p>
                <label>Account Type</label>
                <input required type="radio" value="customer" name="user_type">
                <span>Customer</span>
                <input required type="radio" value="staff" name="user_type">
                <span>Staff</span>
            </p>
            <p>
                <label>Full Name</label>
                <input required type="text" name="full_name"/>
            </p>
            <p>
                <label>Email</label>
                <input required type="email" name="email">
            </p>
            <p>
                <label>Password</label>
                <input required type="password" name="password">
            </p>
            <input type="submit" value="Sign Up"/>
        </form>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </body>
</html>
