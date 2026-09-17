<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>
        Login
    </title>
</head>

<body>
    <form action="/login" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required />
        <br />
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required />
        <br />
        <br>
        <button type="submit">Login</button>
        <button type="button" onclick="window.location.href='/register'">Go to registery</button>
    </form>
</body>