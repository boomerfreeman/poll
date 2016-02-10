    <body>
        <form action="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/choice/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This user panel was created to answer prefered polls</p>
                <input type="submit" name="logout" value="Logout">
            </div>
            <div class="polls">
                <h2>Active polls in the database for <?= $params['date'] ?></h2>
                <select class="poll-list" name="poll">
                <?php foreach ($params['list'] as $poll): ?>
                    <option value="<?= $poll->question_id ?>"><?= $poll->question ?></option>
                <?php endforeach ?>
                    <input type="button" name="start" value="Start answering">
                </select>
            </div>
        </form>
    </body>
