$( ".articleTitle" ).hover(
    function() {
        $( this ).css("opacity", "0");
        $( this).previous().css("opacity", "1");
    }, function() {
        $( this ).css("opacity", "0.6");
        $( this).previous().css("opacity", "0.8");
    }
);

$( "#messageSender" ).click(function(e){
    var message = $("#message").val();
    $.ajax({
        url: Routing.generate('message_create'),
        type: 'POST',
        data: 'message='+message,
        success: function (data) {
            console.log(data);
        },
        error: function(data){
            console.log(data);
        }
    });
});
