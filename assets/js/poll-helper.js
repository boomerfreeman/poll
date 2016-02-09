$(document).ready(function () {
    
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
            $(".new-answer").append('Answer: <input type="text" name="answer[]"> Is correct? <select name="correct[]"><option value="1">Yes</option><option value="0">No</option></select><br>');
        } else {
            alert("Limit exceeded");
        }
    });
});