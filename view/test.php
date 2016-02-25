    <body>
        <form action="<?= URL . '/choice/' ?>" method="post">
            <div class="settings">
                <h3>Welcome to the dashboard!</h3>
                <p>This user panel was created to answer test questions as ordinary user</p>
                <input type="submit" name="logout" value="Logout" title="Exit">
            </div>
            <div class="msg">
                <?php if (isset($params['message'])): ?>
                    <?= $params['message'] ?>
                <?php endif ?>
            </div>
        <?php $i = 0; ?>
        <?php foreach ($params['list'] as $test): ?>
            <div class="test">
                
            <?php $data = unserialize($test->test_data) ?>
                <h2><?= $data['question'] ?></h2>
                
            <?php foreach ($data['answers'] as $answer): ?>
                
                <?php if (isset($params['rights'])): ?>
                
                    <?php in_array($test->test_id . "_$answer", $params['checked']) ? $checked = 'checked' : $checked = null ?>
                
                    <?php if ($params['rights'][$i] == $answer): ?>
                        <p class="correct"><input class="test-checkbox" type="checkbox" name="check[]" value="<?php echo $test->test_id . "_$answer" ?>" <?= $checked ?>><?= $answer ?></p>
                    <?php else: ?>
                        <p class="wrong"><input class="test-checkbox" type="checkbox" name="check[]" value="<?php echo $test->test_id . "_$answer" ?>" <?= $checked ?>><?= $answer ?></p>
                    <?php endif ?>
                        
                <?php else: ?>
                    <p><input class="test-checkbox" type="checkbox" name="check[]" value="<?php echo $test->test_id . "_$answer" ?>"><?= $answer ?></p>
                <?php endif ?>
                    
            <?php endforeach ?>
            <?php $i++; ?>
            </div>
            
        <?php endforeach ?>
            <input class="send-btn" type="submit" name="answer" value="Send answers">
        </form>
    </body>
