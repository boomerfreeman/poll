$(document).ready(function () {
    
    // Edit poll menu counter
    var edit_poll = 0;
    
    // Show editing poll form
    $(".edit-poll-btn").on("click", function() {
        
        if (edit_poll >= 1) {
            alert('Only one poll can be edited at the same time');
            return false;
        } else {
            
            edit_poll++;
            
            var poll_id = $(".poll-list").val();

            $.ajax({
                url: $(location).attr("protocol") + "//" + $(location).attr("hostname") + "/ajax/",
                method: "post",
                dataType: "json",
                data: "poll=" + poll_id,

                success: function (data) {
                    $(".edit-poll-menu").append('<div class="edit-poll-btns"><input class="send-btn" type="submit" name="edit" value="Edit this poll"><input class="cancel-edit-btn" type="button" value="Cancel"></div><br>');
                    $(".edit-poll-menu").append('Question: <input type="text" name="question" value="' + data[0]["question"] + '"> ');

                    $.each(data, function(key, value) {
                        $(".edit-poll-menu").append('Answer: <input type="text" name="answer[]" value="' + value["answer"] + '"> ');
                        $(".edit-poll-menu").append('Is correct? <select class="poll-list-edit_' + key + '" name="correct[]"><option value="1">Yes</option><option value="0">No</option></select><br>');
                        
                        $(".poll-list-edit_" + key).val(value["correct"]);
                    });
                    
                    // Hide editing poll form
                    $(".cancel-edit-btn").on("click", function() {
                        $(".edit-poll-menu").fadeOut("slow").empty();
                        edit_poll--;
                    });
                }
            });

            $(".edit-poll-menu").fadeIn("slow");
        }
    });
    
    // Answer block default value
    var new_answer = 1;
    
    // Show new poll adding form
    $(".new-poll-btn").on("click", function() {
        $(".new-poll-menu").fadeIn("slow");
    });
    
    // Create new answer block with limit of 5 rows
    $(".new-answer-btn").on("click", function() {
        
        if (new_answer < 5) {
            
            new_answer++;
            
            $(".new-answer").append('Answer: <input type="text" name="answer[]"> ');
            $(".new-answer").append('Is correct? <select name="correct[]"><option value="1">Yes</option><option value="0">No</option></select><br>');
        } else {
            alert("Maximum 5 rows allowed");
        }
    });
    
    // Hide new poll adding form
    $(".cancel-new-btn").on("click", function() {
        $(".new-poll-menu").fadeOut("slow").empty();
    });
});