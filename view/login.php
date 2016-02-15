    <body>
        <h2>Welcome! Welcome to Test-Life.<br>You have chosen, or been chosen, to visit one of our finest remaining web tests.<br>Whether you are here to stay, or passing through on your way to parts unknown - welcome to Test-Life. It's safer here. &copy;</h2>
        <form class="login" action="<?= URL_PROTOCOL . URL_DOMAIN . '/login/'?>" method="post">
            <label for="username">Username: </label>
            <input id="username" type="text" name="username" required>
            <label for="password">Password: </label>
            <input id="password" type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </body>