$(document).ready(function() {
	// Hintergrund bei ausgeblendeten tabs entfernen
	$('.contact').removeClass('container');
	
    // HTML5 EMAIL Felder ersetzten -> für Validierung
    $('input[type~="email"]').each(function(e){
        $name = $(this).attr('name');
        $(this).replaceWith('<input type="text" name="'+$name+'" id="'+$name+'"></input>'); 
    });
	
    //SLIDER MODELLE AUF HOME
    $('<li class="slider_link" id="back"><a class="slider_bt">zurück</a></li>').insertBefore('#slider li:first-child');
    $('<li class="slider_link" id="forward"><a class="slider_bt">weiter</a></li>').insertAfter('#slider li:last-child');
	
	// beim Laden das Main Modell in die Mitte rücken
	changeForward();
	
	$('#back').click(function(){
        fadeOutBack();
    });
    
    $('#forward').click(function(){  
        fadeOutForward();
    });
	//ende slider modelle auf home
	
	//MODELLE HIGHLIGHTEN AUF QUADS
	 var aktive = $('#modelle_slider .highlight ');
	 if(aktive.html() == $('#0').html()){ 
	 	aktive.css('width', '35%');
		$('.quad_mitte').css('margin-left', '-0.7%');
	 }else if(aktive.html() == $('#1').html()){
		aktive.css('width', '35%');
		$('.quad_mitte').css('margin', '0');
	 }else if(aktive.html() == $('#2').html()){
		aktive.css('width', '35%');
		$('.quad_mitte').css('margin-right', '-0.7%');
	 }
    

    //HÖHEN der Divs anpassen
    check_hoehen();
	
	//ABOUT News und Events Longtext ein-/ ausblenden
	if($('.longtext').length > 0 ){
		//Links hinzufuegen und alle Texte ausblenden
		$('<a class="einblenden">weiterlesen</a>').insertBefore('.longtext');
		$('.longtext').hide();	
		
		// wenn link geklickt
		$('.einblenden').click(function(){
			$('.einblenden').show('fast', 'linear');		//-->alle Links einblenden
			$(this).hide('fast', 'linear');					// außer den angeklickten
			
			$('.longtext').hide('fast', 'linear');			//alle Texte verstecken
			$(this).next().show('fast', 'linear');			//nur den angeklickten anzeigen
		});
	}//ende about news ein/ausblenden
	
	
    
    
    
});

//Höhen der Divs bei Veränderung des Browserfenster anpassen
$(window).resize(function() {
   $('.autoheight1, .autoheight2, .autoheight3').each(function(e){
		$(this).css('height','auto');	
	});
   check_hoehen();

});


function check_hoehen(){
        //HÖHEN VON DIVS AUSGLEICHEN
        /* Variable zum Merken der maximalen Höhe */
        var max_height = 0;

        /* alle Elemente mit der CSS-Klasse "autoheight" durchlaufen */
        $('.autoheight').each(function(e) {

            /* Höhe des aktuellen Elements */
            h = $(this).height();

            /* Wenn Höhe erfolgreich bestimmt werden konnte */
            if(typeof(h) != "undefined") {

                /* Wenn aktuelle Höhe gösser unserer maximalen, Höhe merken */
                if(h > max_height) {
                    max_height = h;
                }
            }
        });
        if(max_height > 0) {$('.autoheight').height(max_height);}
        
		var max_height = 0;
        $('.autoheight1').each(function(e) {
            h = $(this).height();
            if(typeof(h) != "undefined") {
                if(h > max_height) {max_height = h;}
            }
        });
        if(max_height > 0) {$('.autoheight1').height(max_height);}

		var max_height = 0;
        $('.autoheight2').each(function(e) {
            h = $(this).height();
            if(typeof(h) != "undefined") {
                if(h > max_height) {max_height = h;}
            }
        });
        if(max_height > 0) {$('.autoheight2').height(max_height);}
        
		var max_height = 0;
        $('.autoheight3').each(function(e) {
            h = $(this).height();
            if(typeof(h) != "undefined") {
                if(h > max_height) {max_height = h;}
            }
        });
        if(max_height > 0) {$('.autoheight3').height(max_height);}
    }//ende check_hoehen

 
 function fadeOutBack(){
	$('#slider').fadeOut('quick', 'linear', function(){
		var temp = $('.modell').eq(0).html();
			$('.modell').eq(0).html($('.modell').eq(1).html());
			$('.modell').eq(1).html($('.modell').eq(2).html());
			$('.modell').eq(2).html(temp);
		fadeIn();
	});
}
	
function fadeOutForward(){
	$('#slider').fadeOut('quick','linear', function(){
		changeForward();
		fadeIn();
	});
}

function changeForward(){
	var temp = $('.modell').eq(2).html();
	$('.modell').eq(2).html($('.modell').eq(1).html());
	$('.modell').eq(1).html($('.modell').eq(0).html());
	$('.modell').eq(0).html(temp);
}

function fadeIn(){     
	$('#slider').fadeIn('quick', function(){});
}