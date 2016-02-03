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
                <input type="button" name="add" value="Add new poll">
                <input type="button" name="delete" value="Delete poll">
            </div>
            <!--<p class="test"></p>-->
        </form>
        <!--<script src="/assets/lib/jquery-1.11.3.min.js"></script>-->
        <!--<script src="/assets/js/poll-helper.js"></script>-->
    </body>
