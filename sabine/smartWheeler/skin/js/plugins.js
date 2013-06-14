$(document).ready(function() {

if($('#thumbs').length > 0 ){
	//GALLERIFFIC
	$('div.navigation').css({'width' : '300px', 'float' : 'left', 'margin-left' : '50px'});
	$('div.content').css('display', 'block');
					
	var gallery = $('#thumbs').galleriffic({
		delay:                     5000,
		numThumbs:                 12,
		preloadAhead:              10,
		enableTopPager:            true,
		enableBottomPager:         true,
		maxPagesToShow:            7,
		imageContainerSel:         '#slideshow',
		controlsContainerSel:      '#controls',
		captionContainerSel:       '#caption',
		loadingContainerSel:       '#loading',
		renderSSControls:          true,
		renderNavControls:         true,
		playLinkText:              'Play Slideshow',
		pauseLinkText:             'Pause Slideshow',
		prevLinkText:              '‹ Previous Photo',
		nextLinkText:              'Next Photo ›',
		nextPageLinkText:          'Next ›',
		prevPageLinkText:          '‹ Prev',
		enableHistory:             false,
		autoStart:                 false,
		syncTransitions:           true,
		defaultTransitionDuration: 0,
		onSlideChange:             function(prevIndex, nextIndex) {
			// 'this' refers to the gallery, which is an extension of $('#thumbs')
			this.find('ul.thumbs').children()
			.eq(prevIndex).fadeTo('fast', 1.0).end()
			.eq(nextIndex).fadeTo('fast', 1.0);
		},
		onPageTransitionOut:       function(callback) {
			this.fadeTo('fast', 0.0, callback);
		},
		onPageTransitionIn:        function() {
			this.fadeTo('fast', 1.0);
		}
	});
}
	// GALLERIFIC ENDE


if($('#featured').length > 0){
		// CONTENT_SLIDER
		$("#featured").tabs({fx:{opacity: "1"}}).tabs("rotate", 0, true);
		$("#featured").hover(function() {
			$("#featured").tabs("rotate",0,true);
			
		},
		function() {
		$("#featured").tabs("rotate",0,true);
		}
		);
}
//ende content slider#

/*		$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
*/

//FANCYBOX
if($("#trailer").length > 0){
    $("#trailer").fancybox({
	'transitionIn' : 'elastic',
		'transitionOut' : 'elastic',
		'cyclic' : 'true',
		'titleShow' : false,
		'hideOnOverlayClick' : false
    });
}

if($(".show_pic").length > 0){
    $(".show_pic").fancybox({
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic',
		'cyclic' : 'true',
		'titleShow' : false,
		'hideOnOverlayClick' : false
    });
}

if($("#start").length > 0){
    $("#start").fancybox({
		'width': '700',
		'height': '520',
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic',
        'autoScale': false
    });
}

if($("#score_suche").length > 0){
    $("#score_suche").fancybox({
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic',
        'autoScale': false
    });
}// ende Fancybox



//TINY MCE  

    if(rte >0) { 
        tinyMCE.init({
            mode : "textareas"
        });
    }
   

//FORMULARVALIDIERUNG
if(cms == 0 && $('#contact_form').length > 0){
    var vorname = new LiveValidation('user_vorname', {onValid: function(){this.addFieldClass();} , onlyOnBlur: true} );
        vorname.add( Validate.Presence ({failureMessage: "Vorname eingeben!"}) );
        vorname.add( Validate.Length, {tooShortMessage:"Mindestens 2 Buchstaben!", tooLongMessage:"Höchstens 25 Buchstaben!", minimum: 2, maximum: 25} );
        vorname.add( Validate.Custom, {against: function( value ){ if(check_name(value)){return true;}else{return false;} } , failureMessage: "Buchstaben eingeben!"} );

   
    var nachname = new LiveValidation('user_nachname' , {onValid: function(){this.addFieldClass();} , onlyOnBlur: true});   
        nachname.add( Validate.Presence ({failureMessage: "Nachname eingeben!"}) );
        nachname.add( Validate.Length, {tooShortMessage:"Mindestens 2 Buchstaben!", tooLongMessage:"Höchstens 25 Buchstaben!", minimum: 2, maximum: 25} );
        nachname.add( Validate.Custom, {against: function( value ){ if(check_name(value)){return true;}else{return false;} } , failureMessage: "Buchstaben eingeben!"} );

        
    var email = new LiveValidation('user_email' , {onValid: function(){this.addFieldClass();} , onlyOnBlur: true});
        email.add( Validate.Presence ({failureMessage: "Email eingeben!"}) );
        email.add( Validate.Length, {tooShortMessage:"Mindestens 2 Buchstaben!", tooLongMessage:"Höchstens 40 Buchstaben!", minimum: 2, maximum: 40} );   
        email.add( Validate.Email, {failureMessage: "Gültige Email eingeben!"} );

        
    }else if(cms == 1){
        
    }
});   
 //ende Formularvalidierung

function check_name( value ){ 
    var test = value.match(/^[a-zA-ZßöäüÄÖÜ \-\.]*$/g);
    if(test == null){
        return false;
    }else{
        return true;
    }
}