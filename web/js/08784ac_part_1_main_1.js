$( ".articleTitle" ).hover(
    function() {
        $( this ).css("opacity", "0");
        $( this).previous().css("opacity", "1");
    }, function() {
        $( this ).css("opacity", "0.6");
        $( this).previous().css("opacity", "0.8");
    }
);