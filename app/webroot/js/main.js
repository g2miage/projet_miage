jQuery(function($) {
    // clignotement kikoo de l'enveloppe
    for (var i = 0; i<3; i++) {
        $(".blink").fadeOut("slow");
        $(".blink").fadeIn("slow");
    }
})
