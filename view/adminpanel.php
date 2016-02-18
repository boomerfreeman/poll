    <body>
        <form action="<?= URL_PROTOCOL . URL_DOMAIN . '/adminpanel/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This administration panel was created to manage test list</p>
                <input type="submit" name="logout" value="Logout">
            </div>
            <div class="tests">
                <h2>All tests in the database for <?= $params['date'] ?></h2>
                <select class="test-list" name="test">
                <?php foreach ($params['list'] as $test): ?>
                    <option value="<?= $test->id ?>"><?= $test->question ?></option>
                <?php endforeach ?>
                </select>
                <input class="edit-test-btn" type="button" value="Edit test">
                <input type="submit" name="delete" value="Delete test">
                <input class="new-test-btn" type="button" value="New test">
                <!-- Edit test menu -->
                <div class="edit-test-menu"></div>
                <!-- Add new test menu -->
                <div class="new-test-menu"></div>
                <div class="msg">
                    <?php if (isset($params['message'])) {
                        echo $params['message'];
                    } ?>
                </div>
            </div>
        </form>
        <script src="/assets/lib/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/admin-helper.js"></script>
    </body>
