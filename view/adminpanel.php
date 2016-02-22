    <body>
        <form action="<?= URL . '/adminpanel/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This administration panel was created to manage test list</p>
                <input type="submit" name="logout" value="Logout">
            </div>
            <h2>All tests in the database for <?= $params['date'] ?></h2>
            <select class="test-list" name="test">
        <?php foreach ($params['list'] as $test): ?>
        <?php $data = unserialize($test->test_data) ?>
                <option value="<?= $test->test_id ?>"><?= $data['question'] ?></option>
        <?php endforeach ?>
            </select>
            <input class="edit-test-btn" type="button" value="Edit test" title="Edit this one">
            <input type="submit" name="delete" value="Delete test" title="Delete this one">
            <input class="new-test-btn" type="button" value="New test" title="Add a new one">
            <!-- Edit test menu -->
            <div class="edit-test-menu"></div>
            <!-- Add new test menu -->
            <div class="new-test-menu"></div>
            <div class="msg">
        <?php if (isset($params['message'])): ?>
            <?= $params['message'] ?>
        <?php endif ?>
            </div>
        </form>
        <script src="/assets/lib/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/admin-helper.js"></script>
    </body>
