<!DOCTYPE HTML>
<html>
<head>
    <title>AUTH</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <form action="#" method="post" id="ajax_form">
        <p>Enter login <input type="text" name="login" required></p>
        <p>Enter password <input type="password" name="password" required></p>
        <p id="error"></p>
        <input type="button" value="SIGN IN" id="btn">
    </form>


    <p id="greeting" class="hide"></p>

    <button id="exit_button" class="hide">EXIT</button>

    <script src="scripts/jquery-min.js"></script>
    <script src="scripts/auth_ajax.js"></script>
</body>
</html>