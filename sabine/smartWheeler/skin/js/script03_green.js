$(document).ready(function() {
    // HTML5 EMAIL Felder ersetzten -> für Validierung
    $('input[type~="email"]').each(function(e){
        $name = $(this).attr('name');
        $(this).replaceWith('<input type="text" name="'+$name+'" id="'+$name+'"></input>'); 
    });

	
    //SLIDER MODELLE AUF HOME


	//ende slider modelle auf home


	
	/*//MODELLE HIGHLIGHTEN AUF QUADS
	 var aktive = $('#modelle_slider .highlight ');
	 if(aktive.html() == $('#0').html()){ 
	 	aktive.css('width', '35%');
		$('.quad_mitte').css('margin-left', '-0.7%');
	 }else if(aktive.html() == $('#1').html()){
		aktive.css('width', '35%');
		$('.quad_mitte').css('margin', '0 1.25%');
	 }else if(aktive.html() == $('#2').html()){
		aktive.css('width', '35%');
		$('.quad_mitte').css('margin-right', '-0.7%');
	 }
    */

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
   $('.autoheight_3').each(function(e){
		$(this).css('height','auto');	
	});
   check_hoehen();

});


function check_hoehen(){
	  var max_height = 0;
	  $('.autoheight_3').each(function(e) {
		  h = $(this).height();
		  if(typeof(h) != "undefined") {
			  if(h > max_height) { max_height = h; }
		  }
	  });
	  if(max_height > 0) {$('.autoheight_3').height(max_height);}
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