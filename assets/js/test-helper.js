$(document).ready(function () {
    
    // Test quantity counter
    var start = 0;
    
    // Show chosen test form
    $(".start-test-btn").on("click", function() {
        
        if (start >= 1) {
            alert('No more');
            return;
        } else {
            
            start++;
            
            var test_id = $(".test-list").val();
            
            $.ajax({
                url: $(location).attr("protocol") + "//" + $(location).attr("hostname") + "/ajax/",
                method: "post",
                dataType: "json",
                data: "test=" + test_id,

                success: function (data) {
                    $(".answer-test-menu").append('<h3>Test question:</h3><p>' + data[0]["question"] + '</p></div>');
                    $(".answer-test-menu").append('<input type="hidden" name="question_id" value="' + data[0]["question_id"] + '"</p></div>');

                    $.each(data, function(key, value) {
                        $(".answer-test-menu").append('<input type="checkbox" name="check[]" value="' + value["answer"] + '">' + value["answer"] + '<br>');
                    });
                    
                    $(".answer-test-menu").append('<input class="answer-test-btn" type="submit" name="answer" value="Answer">');
                }
            });

            $(".answer-test-menu").fadeIn("slow");
        }
    });
    
    // Hide editing test form
    $(".cancel-test-btn").on("click", function() {
        start--;
        $(".answer-test-menu").fadeOut("slow").empty();
    });
    
    // Hide message in 2 seconds
    $(".msg").fadeOut(2000);
});
