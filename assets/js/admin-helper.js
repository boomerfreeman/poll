$(document).ready(function () {
    
    // Edit test menu counter
    var edit_test = 0;
    
    // Show editing test form
    $(".edit-test-btn").on("click", function() {
        
        if (edit_test >= 1) {
            alert('Only one test can be edited at the same time');
            return;
        } else {
            
            edit_test++;
            
            var test_id = $(".test-list").val();
            
            $.ajax({
                url: $(location).attr("protocol") + "//" + $(location).attr("hostname") + "/ajax/",
                method: "post",
                dataType: "json",
                data: "test_id=" + test_id,

                success: function (data) {
                    $(".edit-test-menu").append('<div class="edit-test-btns"><input class="send-btn" type="submit" name="edit" value="Edit this test"><input class="cancel-edit-btn" type="button" value="Cancel"></div><br>');
                    $(".edit-test-menu").append('Question: <input type="text" name="question" value="' + data[0]["question"] + '"> ');

                    $.each(data, function(key, value) {
                        $(".edit-test-menu").append('Answer: <input type="text" name="answer[]" value="' + value["answer"] + '"> ');
                        $(".edit-test-menu").append('Is correct? <select class="test-list-edit_' + key + '" name="correct[]"><option value="0">No</option><option value="1">Yes</option></select><br>');
                        
                        $(".test-list-edit_" + key).val(value["correct"]);
                    });
                    
                    // Hide editing test form
                    $(".cancel-edit-btn").on("click", function() {
                        edit_test--;
                        $(".edit-test-menu").empty();
                    });
                }
            });
        }
    });
    
    // New test menu counter
    var new_test = 0;
    
    // Show new test adding form
    $(".new-test-btn").on("click", function() {
        
        if (new_test >= 1) {
            alert('Finish with this test first');
            return;
        } else {
            
            new_test++;
            
            $(".new-test-menu").append('<input class="send-btn" type="submit" name="add" value="Add new test" title="Complete adding the test"><input class="new-answer-btn" type="button" value="New answer" title="Close menu"><input class="cancel-new-btn" type="button" value="Cancel" title="Cancel adding new test">');
            $(".new-test-menu").append('<div class="new-test-main">Question: <input class="question" type="text" name="question"> Answer: <input class="answer" type="text" name="answer[]"> Is correct? <select name="correct[]"><option value="0">No</option><option value="1">Yes</option></select></div>');
            $(".new-test-menu").append('<div class="new-answer"></div>');
            
            // Create new answer block with limit of 5 rows
            $(".new-answer-btn").on("click", function() {
                $(".new-answer").append('Answer: <input type="text" name="answer[]"> ');
                $(".new-answer").append('Is correct? <select name="correct[]"><option value="0">No</option><option value="1">Yes</option></select><br>');
            });
            
            // Hide new test adding form
            $(".cancel-new-btn").on("click", function() {
                new_test--;
                $(".new-test-menu").empty();
            });
        }
    });
    
    // Hide message in 2 seconds
    $(".msg").fadeOut(2000);
});
