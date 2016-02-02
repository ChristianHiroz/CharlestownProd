$('#formationModal').on('hidden.bs.modal', function (e) {
    player.stopVideo();
    player2.stopVideo();
    player3.stopVideo();
    player4.stopVideo();
});

$('#dLabel').hover(function() {
    $("#dDrop").toggle();
});

$('#dDrop').hover(function() {
    $("#dDrop").toggle();
});

