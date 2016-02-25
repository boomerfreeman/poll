$(document).ready(function () {
    
    // New test menu counter
    var $new_test = 0;
    
    // Show new test adding form
    $(".new-test-btn").on("click", function() {
        
        if ($new_test >= 1) {
            alert('Finish with this test first');
            return;
        } else {
            
            $new_test++;
            
            $(".new-test-menu").append('<input class="send-btn" type="submit" name="add" value="Add new test" title="Complete adding the test"><input class="new-answer-btn" type="button" value="New answer" title="Close menu"><input class="cancel-new-btn" type="button" value="Cancel" title="Cancel adding new test">');
            $(".new-test-menu").append('<div class="new-test-main">Question: <input class="question" type="text" name="question"> Answer: <input class="answer" type="text" name="answer[]"> Is correct? <select name="correct[]"><option value="0">No</option><option value="1">Yes</option></select></div>');
            $(".new-test-menu").append('<div class="new-answer"></div>');
            
            // Create new answer block with limit of 5 rows
            $(".new-answer-btn").on("click", function() {
                $(".new-answer").append('Answer: <input type="text" name="answer[]"> ');
                $(".new-answer").append('Is correct? <select name="correct[]"><option value="0">No</option><option value="1">Yes</option></select><br>');
            });
            
            // Hide new test adding menu
            $(".cancel-new-btn").on("click", function() {
                $new_test--;
                $(".new-test-menu").empty();
            });
        }
    });
    
    // Hide editing test menu
    $(".cancel-edit-btn").on("click", function() {
        $(".edit-test-btns").empty();
        $(".edit-test-menu").empty();
    });
});
