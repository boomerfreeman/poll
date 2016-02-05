$(document).ready(function () {
    
    $(".new-poll-btn").on("click", function() {
        $(".new-poll-menu").fadeIn("slow");
    });
    
    $(".new-answer-btn").on("click", function() {
        $(".new-answer").append('Answer: <input type="text" name="answer[]"> Is correct? <input type="checkbox" name="correct[]"><br>');
    });
    
//    $(".add-poll-btn").on("click", function(e) {
//        e.preventDefault();
//        
//        var question = $(".question").val();
//        console.log(question);
//    });
});