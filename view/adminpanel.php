    <body>
        <div class="settings">
            <h3>Welcome, admin!</h3>
            <p><a href="/controller/logout.php">Logout</a></p>
        </div>
        <form action="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/adminpanel/' ?>" method="post">
            <div class="polls">
                <h2>All polls in database:</h2>
                <p>You can edit polls as you wish:</p>
                <select name="poll">
                <?php foreach ($params['list'] as $poll): ?>
                    
                    <option value="<?= $poll->question_id ?>"><?= $poll->question ?></option>
                    <?php $params['i']++ ?>
                    
                <?php endforeach ?>
                </select>
            </div>
            <input type="submit" name="activate" value="Activate poll">
            <input type="submit" name="disable" value="Disable poll">
            <input type="button" name="add" value="Add new poll">
            <input type="button" name="delete" value="Delete poll">
            <p class="test"></p>
        </form>
        <!--<script src="/assets/lib/jquery-1.11.3.min.js"></script>-->
        <!--<script src="/assets/js/poll-helper.js"></script>-->
    </body>
