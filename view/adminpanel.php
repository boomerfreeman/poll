    <body>
        <form action="<?= URL . '/adminpanel/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This administration panel is created to manage test list</p>
                <input type="submit" name="logout" value="Logout">
            </div>
            <h2>All tests in the database for <?= $params['date'] ?></h2>
            <select class="test-list" name="test">
        <?php foreach ($params['list'] as $test): ?>
            <?php $data = unserialize($test->test_data) ?>
                <option value="<?= $test->test_id ?>"><?= $data['question'] ?></option>
        <?php endforeach ?>
            </select>
            <input type="submit" name="predit" value="Edit test" title="Edit this one">
            <input type="submit" name="delete" value="Delete test" title="Delete this one">
            <input class="new-test-btn" type="button" value="New test" title="Add a new one">
            <div class="new-test-menu"></div>
        <?php if (isset($params['editmenu'])): ?>
            <div class="edit-test-btns">
                <input class="send-btn" type="submit" name="edit" value="Edit this test">
                <input class="cancel-edit-btn" type="button" value="Cancel"><br>
                <div class="edit-test-menu">
            <?php foreach ($params['editdata'] as $row => $field): ?>
                <?php $testdata = unserialize($test->test_data) ?>
                Question: <input type="text" name="question" value="<?= $testdata['question'] ?>">
                <?php for ($i=0; $i < count($testdata['answers']); $i++): ?>
                    Answer: <input type="text" name="answer[]" value="<?= $testdata['answers'][$i] ?>">
                    Is correct? <select name="correct[]" value="<?= $testdata['correct'][$i] ?>"><option value="0">No</option><option value="1">Yes</option></select><br>
                <?php endfor ?>
            <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
            <div class="msg">
        <?php if (isset($params['message'])): ?>
            <?= $params['message'] ?>
        <?php endif ?>
            </div>
        </form>
        <script src="/assets/lib/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/admin-helper.js"></script>
    </body>
