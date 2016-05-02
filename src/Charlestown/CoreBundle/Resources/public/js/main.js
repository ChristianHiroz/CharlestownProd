$('#formationModal').on('hidden.bs.modal', function (e) {
    player.stopVideo();
    player2.stopVideo();
    player3.stopVideo();
    player4.stopVideo();
});

$('#dLabel').hover(function() {
    $("#dDrop").toggle();
});

$('#eLabel').hover(function() {
    $("#eDrop").toggle();
});

$('#fLabel').hover(function() {
    $("#fDrop").toggle();
});

$('#gLabel').hover(function() {
    $("#gDrop").toggle();
});

$('#dDrop').hover(function() {
    $("#dDrop").toggle();
});

$('#eDrop').hover(function() {
    $("#eDrop").toggle();
});

$('#fDrop').hover(function() {
    $("#fDrop").toggle();
});

$('#gDrop').hover(function() {
    $("#gDrop").toggle();
});

$('.carousel').pause();


$('#myTabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show')
});


var open = 0;
var windows = 0;
$("#chat_open").click(function(e){
    e.preventDefault();
    alert("lala");
    if(open == 0){
        $("#chat_body").removeClass("hidden");
        open = 1;
    }
    else if(open == 1){
        $("#chat_body").addClass("hidden");
        open = 0;
    }
}); //open the chatrooms list

function sendMessage(){ //envoie de message
    var message = $("#message").val();
    $("#message").val("");
    $.ajax({
        url: Routing.generate('message_create'),
        type: 'POST',
        data: 'message='+message,
        success: function (data) {
            console.log(data);
            $("#message").before('<div class="chat_message"><p style="text-align:right;">'+message+'</p></div>');
        },
        error: function(data){
            console.log(data);
        }
    });
}
