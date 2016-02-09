$(document).ready(function () {
    
    $(".new-poll-btn").on("click", function() {
        $(".new-poll-menu").fadeIn("slow");
    });
    
    $(".new-answer-btn").on("click", function() {
        $(".new-answer").append('Answer: <input type="text" name="answer[]"> Is correct? <select name="correct[]"><option value="1">Yes</option><option value="0">No</option></select><br>');
    });
    
//    $(".add-poll-btn").on("click", function(e) {
//        e.preventDefault();
//        
//        var question = $(".question").val();
//        console.log(question);
//    });
});