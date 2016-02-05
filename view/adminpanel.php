    <body>
        <form action="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/adminpanel/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This administration panel was created to manage poll list</p>
                <input type="submit" name="logout" value="Logout">
            </div>
            <div class="polls">
                <h2>All polls in the database for <?= $params['date'] ?>:</h2>
                <select name="poll">
                <?php foreach ($params['list'] as $poll): ?>
                    <option value="<?= $poll->question_id ?>"><?= $poll->question ?></option>
                <?php endforeach ?>
                </select>
                <input type="submit" name="activate" value="Activate poll">
                <input type="submit" name="disable" value="Disable poll">
                <input type="submit" name="delete" value="Delete poll">
                <input class="new-poll-btn" type="button" value="New poll">
                <div class="new-poll-menu">
                    <input class="add-poll-btn" type="submit" name="add" value="Add new poll">
                    <input class="new-answer-btn" type="button" value="New answer">
                    <div class="new-poll-main">
                        Question: <input class="question" type="text" name="question">
                        Answer: <input class="answer" type="text" name="answer[]">
                        Is correct? <input class="correct" type="checkbox" name="correct[]">
                    </div>
                    <div class="new-answer"></div>
                </div>
            </div>
        </form>
        <script src="/assets/lib/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/poll-helper.js"></script>
    </body>
