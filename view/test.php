    <body>
        <form action="<?= URL_PROTOCOL . URL_DOMAIN . '/choice/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This user panel was created to answer prefered tests</p>
                <input type="submit" name="logout" value="Logout">
            </div>
            <div class="tests">
                <h2>Active tests in the database for <?= $params['date'] ?></h2>
                <select class="test-list">
                <?php foreach ($params['list'] as $test): ?>
                    <option value="<?= $test->question_id ?>"><?= $test->question ?></option>
                <?php endforeach ?>
                </select>
                <input class="start-test-btn" type="button" value="Start answering">
                <input class="cancel-test-btn" type="button" value="Cancel">
            </div>
            <div class="answer-test-menu"></div>
        </form>
        <script src="/assets/lib/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/test-helper.js"></script>
    </body>
