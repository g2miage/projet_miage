jQuery(function($) {
    $.datepicker.regional['fr'] = {
        closeText: 'Fermer',
        prevText: '<Préc',
        nextText: 'Suiv>',
        currentText: 'Courant',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun',
            'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        weekHeader: 'Sm',
        //dateFormat: 'dd/mm/yy',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        timeOnlyTitle: 'Choix de l\'heure',
	timeText: 'Heure',
	hourText: 'Heure',
	minuteText: 'Minute'};
    $.datepicker.setDefaults($.datepicker.regional['fr']);

    $("#EventEndday").datepicker($.datepicker.regional[ "fr" ]);
    $("#EventStartday").datepicker($.datepicker.regional[ "fr" ]);
    $('#EventStarttime').timepicker($.datepicker.regional[ "fr" ]);
    $('#EventEndtime').timepicker($.datepicker.regional[ "fr" ]);
});
