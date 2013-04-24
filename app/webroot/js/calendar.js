jQuery(function($) {
    // affiche/cache la div pour l'enregistrement en tant que prestataire
    document.getElementById('UserScorpname').value ='Raison Sociale';
    document.getElementById('UserAddress').value ='Adresse';
    document.getElementById('UserZip').value ='Code postal';
    document.getElementById('UserCity').value ='Ville';
    document.getElementById('UserCountry').value ='pays';
    $("#prestabox").click(function(){
        // Si cochée
        if ($("#prestabox").is(":checked")){
            $("#presta").show("fast");
            document.getElementById('UserScorpname').value ='';
            document.getElementById('UserAddress').value ='';
            document.getElementById('UserZip').value ='';
            document.getElementById('UserCity').value ='';
            document.getElementById('UserCountry').value ='';
        } else {
            $("#presta").hide("fast");
            document.getElementById('UserScorpname').value ='Raison Sociale';
            document.getElementById('UserAddress').value ='Adresse';
            document.getElementById('UserZip').value ='Code postal';
            document.getElementById('UserCity').value ='Ville';
            document.getElementById('UserCountry').value ='pays';
        }
    });
    
    // Trad des noms pour le calendrier/l'heure
    $.datepicker.regional['fr'] = {
        closeText: 'Fermer',
        prevText: '<Pr�c',
        nextText: 'Suiv>',
        currentText: 'Courant',
        monthNames: ['Janvier', 'F�vrier', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Ao�t', 'Septembre', 'Octobre', 'Novembre', 'D�cembre'],
        monthNamesShort: ['Jan', 'F�v', 'Mar', 'Avr', 'Mai', 'Jun',
            'Jul', 'Ao�', 'Sep', 'Oct', 'Nov', 'D�c'],
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