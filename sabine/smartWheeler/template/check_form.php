<?php
$D = new mysqlDB('localhost', 'wdd909', 'student', 'doebroessy');
$fehler = '';
$gesendet = '';
$inDB = 0;
$empfaengerSELF = 'sabine_d@aon.at'; 
//ADRESSVERWALTUNG
    // HOME KONTAKTFORMULAR UND BACKEND EMAIL HINZUFUEGEN ODER BEARBEITEN
    if(isset($_POST['abschicken']) || isset($_POST['edit_email'])){
        if (count($_POST) > 1) {
            // Fehler setzten
            if (!isset($_POST['user_vorname']) || trim($_POST['user_vorname']) == '' || !check_name($_POST['user_vorname'])) {
                $fehler['user_vorname'] = 'Vorname korrigieren!';
            }
            if (!isset($_POST['user_nachname']) || trim($_POST['user_nachname']) == '' || !check_name($_POST['user_nachname'])) {
                $fehler['user_nachname'] = 'Nachname korrigieren!';
            }
            if (!isset($_POST['user_email']) || trim($_POST['user_email']) == '' || !check_email($_POST['user_email'])) {
                $fehler['user_email'] = 'Gültige Email eingeben!';
            }

            $newsletter = 0;
            if(isset($_POST['news_anfordern'])){ $newsletter = 1; }
            
            $kommentar = '';
            if(isset($_POST['nachricht']) && trim($_POST['nachricht']) != '' && trim($_POST['nachricht']) != 'Schicke uns deine Anfrage...'){ $kommentar = $_POST['nachricht']; }
                        
            if($fehler == ''){
				//EMAIL VERSENDEN: NEWSLETTER ANMELDUNG
				if($kommentar != ''){
				//AN EIGENE EMAIL SCHICKEN
					$betreffSELF =  'Kundenanfrage';
					$fromSELF = "From:".$_POST['user_vorname']." ".$_POST['user_nachname']."<".$_POST['user_email'].">\n"
						. "Content-Type: text/plain; charset=iso-8859-15\n"
						. "MIME-Version: 1.0\n"
						. "Content-Transfer-Encoding: quoted-printable\n";
					$textSELF = "Anfrage von: ".ucwords(trim($_POST['user_vorname']))." ".ucwords(trim($_POST['user_nachname'])).", \n";
					$textSELF .= $kommentar;
	
					$sendenSELF = mail($empfaengerSELF, $betreffSELF, utf8_decode($textSELF), $fromSELF);
				}
				
                //Email bereits in DB?
                $result = $D->select('newsletter', array('email' => $_POST['user_email']), '', '', 1);
                if(mysql_num_rows($result) == 0){
                //Email noch nicht vorhanden
                    $D->insert('newsletter', array('vorname' => trim($_POST['user_vorname']), 'nachname' => trim($_POST['user_nachname']), 'email' => trim($_POST['user_email']), 'newsletter' => $newsletter));
                    //Newsletter oder Kommentar
					if($newsletter == 1 || $kommentar != ''){ 
						// AN USER SCHICKEN
                        $empfaenger = trim($_POST['user_email']);
                        if($newsletter == 1){ $betreff =  'Newsletteranmeldung'; }
                        if($kommentar != ''){ $betreff =  'Anfrage wird bearbeitet'; }
                        if($newsletter == 1 && $kommentar != ''){ $betreff =  'Newsletteranmeldung und Anfrage'; }
                        
                        $from = "From:smartWHEELER<smartwheeler@office.at>\n"
                            . "Content-Type: text/plain; charset=iso-8859-15\n"
                            . "MIME-Version: 1.0\n"
                            . "Content-Transfer-Encoding: quoted-printable\n";
                        $text = "Hallo ".ucwords(trim($_POST['user_vorname']))." ".ucwords(trim($_POST['user_nachname'])).", \n";
                            if($kommentar != ''){ $text .= 'Vielen Dank für deine Anfrage, wir bemühen uns um schnellst mögliche Bearbeitung!'."\n"; }
                            if($newsletter == 1){ $text .= 'Du wurdest für den Newsletter angemeldet!'."\n"; }
                            $text .= "\n\n\n dein smartWHEELER Team";
                        $senden = mail($empfaenger, $betreff, utf8_decode($text), $from);
                        
                        if($senden){ $gesendet = "Anmeldung erfolgreich, du erh&auml;lst in K&uuml;rze ein Mail als Best&auml;tigung.";
                        }else{ $fehler['mail'] = "Fehler bei der Anmeldung, bitte versuche es nochmal oder wende dich an unseren Support"; }
                    } 
                }else{ 
                    //bereits vorhanden
                    $result = $D->select('newsletter', array('email' => $_POST['user_email']), array('newsletter'), '', 1);
					while($row = mysql_fetch_array($result)){
                        if($row['newsletter'] == 1) {       //Bereits angemeldet
                            //EMAIL VERSENDEN: BEREITS ANGEMELDET
                            $empfaenger = trim($_POST['user_email']);
                            $betreff =  'Newsletter Info';
                            $from = "From:smartWHEELER<smartwheeler@office.at>\n"
                                . "Content-Type: text/plain; charset=iso-8859-15\n"
                                . "MIME-Version: 1.0\n"
                                . "Content-Transfer-Encoding: quoted-printable\n";
                            $text = "Hallo ".ucwords(trim($_POST['user_vorname']))." ".ucwords(trim($_POST['user_nachname'])).", \n";

                            $text .= 'Du bist bereits für den Newsletter angemeldet!'."\n";
                            $text .= "\n\n\n dein smartWHEELER Team";
                            $senden = mail($empfaenger, $betreff, utf8_decode($text), $from);

                            if($senden){
                                $gesendet = "Anmeldung erfolgreich, du erh&auml;lst in K&uuml;rze ein Mail als Best&auml;tigung.";
                            }else{
                                $fehler['mail'] = "Fehler bei der Anmeldung, bitte versuche es nochmal oder wende dich an unseren Support";
                            }
                        }
                    }
                }
                    
                if($newsletter == 1){
                    $result = $D->select('newsletter', array('email' => $_POST['user_email']), array('newsletter'), '', 1);
				    while($row = mysql_fetch_array($result)){
                        if($row['newsletter'] != 1){        // wenn email zwar vorhanden, aber abgemeldet
							$D->update('newsletter', array('newsletter' => $newsletter), array('email' => trim($_POST['user_email'])));
							// AN USER SCHICKEN: WIEDER ANGEMELDET
							$empfaenger = trim($_POST['user_email']);
							if($newsletter == 1){ $betreff =  'Newsletteranmeldung'; }
							if($kommentar != ''){ $betreff =  'Anfrage wird bearbeitet'; }
							if($newsletter == 1 && $kommentar != ''){ $betreff =  'Newsletteranmeldung und Anfrage'; }
							
							$from = "From:smartWHEELER<smartwheeler@office.at>\n"
								. "Content-Type: text/plain; charset=iso-8859-15\n"
								. "MIME-Version: 1.0\n"
								. "Content-Transfer-Encoding: quoted-printable\n";
							$text = "Hallo ".ucwords(trim($_POST['user_vorname']))." ".ucwords(trim($_POST['user_nachname'])).", \n";
								if($kommentar != ''){ $text .= 'Vielen Dank für deine Anfrage, wir bemühen uns um schnellst mögliche Bearbeitung!'."\n"; }
								if($newsletter == 1){ $text .= 'Du wurdest für den Newsletter angemeldet!'."\n"; }
								$text .= "\n\n\n dein smartWHEELER Team";
							$senden = mail($empfaenger, $betreff, utf8_decode($text), $from);
	
							
							if($senden){ $gesendet = "Anmeldung erfolgreich, du erh&auml;lst in K&uuml;rze ein Mail als Best&auml;tigung.";
							}else{ $fehler['mail'] = "Fehler bei der Anmeldung, bitte versuche es nochmal oder wende dich an unseren Support"; }
							}
                    }
                }
            }
                   
                        
//                if(isset($_POST['news_anfordern']) && $_POST['news_anfordern'] == 1){   
////                    $empfaenger = trim($_POST['user_email']);
////                    $betreff =  'NEWSLETTERANMELDUNG';
////                    $from = "From:smartWHEELER<smartwheeler@office.at>\n"
////                        . "Content-Type: text/plain; charset=iso-8859-15\n"
////                        . "MIME-Version: 1.0\n"
////                        . "Content-Transfer-Encoding: quoted-printable\n";
////                    $text = "Hallo ".ucwords(trim($_POST['user_vorname']))." ".ucwords(trim($_POST['user_nachname'])).", \n";
////                    $text .= "Vielen Dank für deine Nachricht.\n";
////
////                    $text .= 'Du wurdest für den Newsletter angemeldet!'."\n";
////
////
////                    $senden = mail($empfaenger, $betreff, utf8_decode($text), $from);
////
////                    if($senden){
////                        $gesendet = "Anmeldung erfolgreich, du erh&auml;lst in K&uuml;rze ein Mail als Best&auml;tigung.";
////                    }else{
////                        $fehler['mail'] = "Fehler bei der Anmeldung, bitte versuche es nochmal oder wende dich an unseren Support";
////                    }
////                    unset($_POST);
//                //}
//            }else{
//                $fehler['mail'] = "Bitte überprüfe deine Eingaben!";
//            }
 
        }
        
        /* Newsletter speichern */
        if ($fehler == '') {
//            $newsletter = 0;
//            if(isset($_POST['news_anfordern'])){ $newsletter = 1; }
//            if(isset($_POST['abschicken'])){
//                $D->insert('newsletter', array('vorname' => ($_POST['user_vorname']), 'nachname' => $_POST['user_nachname'], 'email' => $_POST['user_email'], 'newsletter' => $newsletter));
//            }
            if (isset($_POST['edit_email'])){
                $D->update('newsletter', array('vorname' => $_POST['user_vorname'], 'nachname' => $_POST['user_nachname'], 'email' => $_POST['user_email'], 'newsletter' => $newsletter), array('id' => $_POST['id']));
            }
            
            $ausgabe['mail']='Du hast dich erfolgreich für den Newsletter angemeldet und erhälst ein Email als Bestätigung.';
                
        }
    }// ende home kontaktformular
    
    /* EMAIL LÖSCHEN */
    if (isset($_GET['act']) && $_GET['act'] == "email" && $_SESSION['admin']['rights'] >= 1) {

        if(isset($_POST['delete_adressen']) && isset($_POST['edit_newsletter'])){
            foreach ($_POST['edit_newsletter'] as $value) {
                $C->delete('newsletter', array('id'=>$value));
            }
        }
    }

    
//GAME-EINSTELLUNGEN SPEICHERN
    if (isset($_GET['act']) && $_GET['act'] == 'style' && isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] >= 2) {
        if(isset($_POST['default'])){
            $result = $C->select('game', '', array('variable', 'default'));
                while ($row = mysql_fetch_array($result)) {
                    $C->update('game', array('wert' => $row['default']), array('variable'=>$row['variable']));
                }
        }
        if (isset($_POST['game_einstellung'])) {
            if (count($_POST) > 1) {
                if (!isset($_POST['leben']) || trim($_POST['leben']) == '' || !check_zahl(trim($_POST['leben'])) || (trim($_POST['leben'])) > 19 || (trim($_POST['leben'])) < 1) {
                    $fehler['leben'] = '1 bis 19 Leben möglich!';
                }
                if (!isset($_POST['interval']) || trim($_POST['interval']) == '' || !check_zahl(trim($_POST['interval']))|| (trim($_POST['interval'])) > 1200 || (trim($_POST['interval'])) < 500) {
                    $fehler['interval'] = 'Interval von 500 bis 1200 möglich!';
                }
                if (!isset($_POST['levelTime']) || trim($_POST['levelTime']) == '' || !check_zahl(trim($_POST['levelTime']))|| (trim($_POST['levelTime'])) > 180000 || (trim($_POST['levelTime'])) < 5000) {
                    $fehler['levelTime'] = 'Leveldauer von 5000 bis 180000!';
                }
                if (!isset($_POST['sideSpeed']) || trim($_POST['sideSpeed']) == '' || !check_zahl(trim($_POST['sideSpeed']))|| (trim($_POST['sideSpeed'])) > 45 || (trim($_POST['sideSpeed'])) < 10) {
                    $fehler['sideSpeed'] = 'Schnelligkeit der Steuerung zwischen 10 und 45!';
                }               
                
                if ($fehler == '') {
                    array_pop($_POST);                  //letzten Eintrag entfernen (button)
                    foreach ($_POST as $variable => $wert) {
                        $C->update('game', array('wert' => $wert), array('variable' => $variable));
                    }
                }
            }
        }
        
    }//ende game-einstellungen speichern
    
    

//NEWS 
    if (isset($_GET['act']) && $_GET['act'] == 'news' && isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] >= 1) {
        // NEWS EINTRAG HINZUFUEGEN ODER BEARBEITEN
        if (isset($_POST['add_news']) /*|| isset($_POST['edit_news'])*/) {
            if (count($_POST) > 1) {
                // Fehler setzten
                if (!isset($_POST['titel']) || trim($_POST['titel']) == '') { $fehler['titel'] = 'Titel eingeben!'; }
                if (!isset($_POST['shorttext']) || trim($_POST['shorttext']) == '') { $fehler['shorttext'] = 'Einleitung eingeben!'; }
                if (!isset($_POST['longtext']) || trim($_POST['longtext']) == '') { $fehler['longtext'] = 'Text eingeben!'; }

                // keine Fehler -> speichern
                if ($fehler == '') {
                    $event = 0;
                    if (isset($_POST['event'])) { $event = 1; }
                    if(isset($_POST['add_news'])){          //neuer Eintrag speichern
                        $C->insert('news', array('titel' => $_POST['titel'], 'short_text' => $_POST['shorttext'], 'long_text' => $_POST['longtext'], 'event' => $event));
                    }
					
					// FILE SPEICHERN
					 foreach ($_FILES as $key => $value) {
						if ($_FILES[$key]['error'] == 0) {
							$filename = explode('.', $_FILES[$key]['name']);
							
							//Thumb erstellen
							$imagesize = getimagesize($_FILES[$key]['tmp_name']);
							$imagewidth = $imagesize[0];
							$imageheight = $imagesize[1];
							$imagetype = $imagesize[2];
							if($imagetype == 2){
								 $image = imagecreatefromjpeg($_FILES[$key]['tmp_name']);
							}else {
								$fehler['upload'] = "Bitte nur Bilder im jpg-Format.";
							}
							$maxthumbwidth = 150;
							$maxthumbheight = 150;
							$thumbwidth = $imagewidth;
							$thumbheight = $imageheight;
							if($thumbwidth > $maxthumbwidth){
								$factor = $maxthumbwidth/$thumbwidth;
								$thumbwidth *= $factor;
								$thumbheight *= $factor;
							}
							if($thumbheight > $maxthumbheight){
								$factor = $maxthumbheight/$thumbheight;
								$thumbwidth *= $factor;
								$thumbheight *= $factor;
							}
							$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
							
							imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbwidth, $thumbheight, $imagewidth, $imageheight);
							header('Content-Type: image/jpeg');
							imagejpeg($thumb, 'news_pics/thumbs/'.$_FILES[$key]['name']);
							imagedestroy($thumb);
							//ende Thumb erstellen
							
							
							// Maximale Abmessungen
							$maxthumbwidth = 700;
							$maxthumbheight = 700;
							$thumbwidth = $imagewidth;
							$thumbheight = $imageheight;
							if($thumbwidth > $maxthumbwidth || $thumbheight > $maxthumbheight){
								if($thumbwidth > $maxthumbwidth){
									$factor = $maxthumbwidth/$thumbwidth;
									$thumbwidth *= $factor;
									$thumbheight *= $factor;
								}
								if($thumbheight > $maxthumbheight){
									$factor = $maxthumbheight/$thumbheight;
									$thumbwidth *= $factor;
									$thumbheight *= $factor;
								}
								$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
								
								imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbwidth, $thumbheight, $imagewidth, $imageheight);
								header('Content-Type: image/jpeg');
								imagejpeg($thumb, 'news_pics/pics/'.$_FILES[$key]['name']);
								imagedestroy($thumb);
							}else{
							//ende maximale abmessungen erstellen
							
							//file als Thumb und Original speichern
								move_uploaded_file($_FILES[$key]['tmp_name'], 'news_pics/pics/' . $_FILES[$key]['name']);
							}
							//in DB eintragen
							$result = $C->select('news', array('titel' => $_POST['titel']), array('id'), array('tsp', 'DESC'), 1 );
							while($row = mysql_fetch_array($result)){
								$C->insert('pictures', array('news_id' => $row['id'], 'url_thumb' => 'news_pics/thumbs/' . $_FILES[$key]['name'], 'url_pic' => 'news_pics/pics/' . $_FILES[$key]['name'], 'alt' => $filename[0]));
							}
							
							
						}
					}//ende file speichern

                    $inDB = 1;
					unset($_GET['news']);
					header("Location: index.php?page=administration&act=news");

                }
            }
        }//ende eintag hinzufuegen
   
    
        /* NEWS EINTRÄGE LÖSCHEN */
        if (isset($_POST['news_loeschen'])) {
            foreach ($_POST['delete'] as $value) {                 //für alle ausgewählten Bilder
                $C->delete('news', array('id' => $value));
                //URL aus DB wählen und aus dem Verzeichnis löschen
                $result = $C->select('pictures', array('news_id' => $value), array('url_thumb', 'url_pic'));
                while ($row = mysql_fetch_array($result)) {
                    unlink($row['url_thumb']);
                    unlink($row['url_pic']);
                }
                $result = $C->delete('pictures', array('news_id' => $value));
            }
        }//ende news löschen
        
    }
    

    

/* MODELLE EDITIEREN */
    if (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] >= 2) {
        //MODELLE GALLERY löschen
        if (isset($_POST['bilder_loeschen'])) {
            //für alle ausgewählten Bilder
            foreach ($_POST['delete'] as $value) {
                //URL aus DB wählen und aus dem Verzeichnis löschen
                $result = $C->select('gallery', array('id' => $value), array('need', 'url_thumb', 'url_pic'));
                while ($row = mysql_fetch_array($result)) {
                    // wenn pic nicht für design benötigt wird
					if($row['need'] == NULL){
						//prüfen ob bild nicht nochmal vorkommt
						$check= $C->select('gallery', array('url_pic' => $row['url_pic']), array('id'));
						if(mysql_num_rows($check) < 1){
							unlink($row['url_thumb']);
							unlink($row['url_pic']);
						}
						//Eintrag aus DB löschen
						$C->delete('gallery', array('id' => $value));
					}else{
						$fehler['delete_file'][$value] = 'Bild wird benötigt und kann nicht gelöscht werden';
					}
                }
            }
        }//ende modelle gallery löschen
        // MODELLE FILEUPLOAD
        if (isset($_POST['bilder_upload'])) {
			if(isset($_GET['modell'])){
			// FILE SPEICHERN
			   foreach ($_FILES as $key => $value) {
				  if ($_FILES[$key]['error'] == 0) {
					  $filename = explode('.', $_FILES[$key]['name']);
					  
					  //Thumb erstellen
					  $imagesize = getimagesize($_FILES[$key]['tmp_name']);
					  $imagewidth = $imagesize[0];
					  $imageheight = $imagesize[1];
					  $imagetype = $imagesize[2];
					  if($imagetype == 2){
						   $image = imagecreatefromjpeg($_FILES[$key]['tmp_name']);
					  }else {
						  $fehler['upload'] = "Bitte nur Bilder im jpg-Format.";
					  }
					  $maxthumbwidth = 150;
					  $maxthumbheight = 150;
					  $thumbwidth = $imagewidth;
					  $thumbheight = $imageheight;
					  if($thumbwidth > $maxthumbwidth){
						  $factor = $maxthumbwidth/$thumbwidth;
						  $thumbwidth *= $factor;
						  $thumbheight *= $factor;
					  }
					  if($thumbheight > $maxthumbheight){
						  $factor = $maxthumbheight/$thumbheight;
						  $thumbwidth *= $factor;
						  $thumbheight *= $factor;
					  }
					  $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
					  
					  imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbwidth, $thumbheight, $imagewidth, $imageheight);
					  header('Content-Type: image/jpeg');
					  imagejpeg($thumb, 'gallery/thumbs/'.$_FILES[$key]['name']);
					  imagedestroy($thumb);
					  //ende Thumb erstellen
					  
					  
					  
					  
					  // Maximale Abmessungen
							$maxthumbwidth = 700;
							$maxthumbheight = 700;
							$thumbwidth = $imagewidth;
							$thumbheight = $imageheight;
							if($thumbwidth > $maxthumbwidth || $thumbheight > $maxthumbheight){
								if($thumbwidth > $maxthumbwidth){
									$factor = $maxthumbwidth/$thumbwidth;
									$thumbwidth *= $factor;
									$thumbheight *= $factor;
								}
								if($thumbheight > $maxthumbheight){
									$factor = $maxthumbheight/$thumbheight;
									$thumbwidth *= $factor;
									$thumbheight *= $factor;
								}
								$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
								
								imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbwidth, $thumbheight, $imagewidth, $imageheight);
								header('Content-Type: image/jpeg');
								imagejpeg($thumb, 'gallery/pics/'.$_FILES[$key]['name']);
								imagedestroy($thumb);
							}else{
							//ende maximale abmessungen erstellen
							
							//file als Thumb und Original speichern
					  			move_uploaded_file($_FILES[$key]['tmp_name'], 'gallery/pics/' . $_FILES[$key]['name']);
							}

					  //in DB eintragen
					  
					  $C->insert('gallery', array( 'modell' => $_GET['modell'], 'url_thumb' => 'gallery/thumbs/' . $_FILES[$key]['name'], 'url_pic' => 'gallery/pics/' . $_FILES[$key]['name'], 'url_mobile' => 'gallery/mobile/' . $_FILES[$key]['name'] ,'alt' => $filename[0]));
				  }  
			   }
			   $inDB = 1;
			   header("Location: index.php?page=administration&act=models");
		    }	
        }//ende modelle fileupload           
    }//ende modelle editieren    
    
    
/* NEWSLETTER VERSCHICKEN */    
  if (isset($_GET['act']) && $_GET['act'] == 'newsletter' && isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] >= 1) {
        if (isset($_POST['senden'])) {
            if (count($_POST) > 1) {
                // Fehler setzten
                if (!isset($_POST['betreff']) || trim($_POST['betreff']) == '') { $fehler['betreff'] = 'Betreff eingeben!'; }
                if (!isset($_POST['mitteilung']) || trim($_POST['mitteilung']) == '') { $fehler['mitteilung'] = 'Mitteilung eingeben!'; }

                // keine Fehler -> senden
                if ($fehler == '') {
					$result = $D->select('newsletter', array('newsletter' => 1), array('email') );
	
					$betreff =  'Aktuell: '.trim($_POST['betreff']);
					$from = "From:smartWHEELER<smartwheeler@office.at>\n"
						. "Content-Type: text/plain; charset=iso-8859-15\n"
						. "MIME-Version: 1.0\n"
						. "Content-Transfer-Encoding: quoted-printable\n";
					$text = trim($_POST['mitteilung']);
					
					while($row = mysql_fetch_array($result)){
						$empfaenger =  $row['email'];
						$senden = mail($empfaenger, $betreff, utf8_decode($text), $from);
					}
					
					$gesendet = "Newsletter erfolgreich versendet.";		
					
					
					
                }
            }
        }
  }//ende eintag hinzufuegen
       

    
?>

