$(document).ready(function () {
    $(":button").on("click", function() {
        
        var func = $(this).attr("name");
        var id = $(this).value;
        console.log(id);
        
        $.ajax({
            url: "../controller/test.php",
            method: "post",
            dataType: "text",
            data: "func=" + func + "id=" + id,
            success: function (data) {
                $(".test").append(data);
            }
        });
    });
});