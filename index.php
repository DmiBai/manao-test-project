<!DOCTYPE HTML>
<html>
<head>
    <title>REGISTER</title>
    <meta charset="utf-8">
</head>

<body>
    <h1>WELCOME</h1>

    <form action="#" method="post" id="ajax_form">
        <p>Enter name <input type="text" name="name" required></p>
        <p id="name_error"></p>
        <p>Enter login <input type="text" name="login" required></p>
        <p id="login_error"></p>
        <p>Enter email <input type="email" name="email" required></p>
        <p id="email_error"></p>
        <p>Enter password <input type="password" name="password" required></p>
        <p id="password_error"></p>
        <p>Confirm password <input type="password" name="confirm_password" required></p>
        <p id="confirm_password_error"></p>
        <input type="button" value="SEND" id="btn">
    </form>

    <div id="result"></div>
<script src="scripts/jquery-min.js"></script>
<script src="scripts/reg_ajax.js"></script>
</body>
</html>