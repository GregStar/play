$(document).ready(function() {
	
    // HTML5 EMAIL Felder ersetzten -> für Validierung
    $('input[type~="email"]').each(function(e){
        $name = $(this).attr('name');
        $(this).replaceWith('<input type="text" name="'+$name+'" id="'+$name+'"></input>'); 
    });
	
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
});

function check_name( value ){ 
    var test = value.match(/^[a-zA-ZßöäüÄÖÜ \-\.]*$/g);
    if(test == null){
        return false;
    }else{
        return true;
    }
}