$(document).ready(function() {     
	


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


//function check_name(value, args){
//    if(value == 'name'){
//        return true;
//    }else{
//        return false;
//    }
//}


// RATING
//$(document).ready(function() {
//   // generate markup
//   $("#rating").append("Please rate: ");
//   
//   for ( var i = 1; i <= 5; i++ )
//     $("#rating").append("<a href='#'>" + i + "</a> ");
//   
//   // add markup to container and apply click handlers to anchors
//   $("#rating a").click(function(e){
//     // stop normal link click
//     e.preventDefault();
//     
//     // send request
//     $.post("rate.php", {rating: $(this).html()}, function(xml) {
//       // format and output result
//       $("#rating").html(
//         "Thanks for rating, current average: " +
//         $("average", xml).text() +
//         ", number of votes: " +
//         $("count", xml).text()
//       );
//     });
//   });
// });
