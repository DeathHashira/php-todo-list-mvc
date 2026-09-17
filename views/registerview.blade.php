<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>
        Register
    </title>
</head>

<body>

    <form action="/register" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required />
        <br />
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required />
        <br />
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required />
        <br />
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required />
        <br />
        <br>
        <button type="submit">Register</button>
        <button type="button" onclick="window.location.href='/login'">Go to login</button>
    </form>

</body>

</html>