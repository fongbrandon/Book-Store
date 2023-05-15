<html>

<body>
    <form action="/sign_in" method="POST">
        @csrf
        <div>
            <label>Email</label>
            <input type="text" id="email" name="email">
        </div>
        <div>
            <label>Passowrd</label>
            <input type="password" id="password" name="password">
        </div>

        <input type="submit" value="Login">
    </form>
    <form action="/sign_up" method="get">
        <input type="submit" value="Sign Up">
    </form>
</body>
<style>
    form div {
        padding: 10px;
    }

    form label {
        display: inline-block;
        width: 100px;
        /* adjust as needed */
    }

    form input[type="text"] {
        display: inline-block;
        width: 200px;
        /* adjust as needed */
    }
</style>

</html>
