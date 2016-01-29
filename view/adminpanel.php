    <body>
        <div class="settings">
            <h3>Welcome, admin!</h3>
            <p><a href="/controller/logout.php">Logout</a></p>
        </div>
        <form action="/controller/test.php" method="post">
            <div class="active-polls">
                <h2>Active polls:</h2>
                <select multiple name="poll[]">
                    <?php foreach ($poll['list'] as $poll): ?>
                    <option value="<?= $i ?>"><?= $poll->question ?></option>
                    <?php $i++ ?>
                    <?php endforeach ?>
                </select>
            </div>
            <input type="button" name="activate" value="Activate">
            <input type="button" name="disable" value="Disable">
            <input type="button" name="add" value="Add new poll">
            <input type="button" name="delete" value="Delete poll">
            <p class="test"></p>
        </form>
        <script src="/assets/lib/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/poll-helper.js"></script>
    </body>
