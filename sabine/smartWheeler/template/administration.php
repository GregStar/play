<?php               
if (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] == 3) {
    include('template/edit_admin.php');
} ?>

<div class="content_wrap">

<?php
if (isset($_GET['act']) && $_GET['act'] == "admins" && $_SESSION['admin']['rights'] == 3) { ?>
    <div class="container">
        <h2><span class="h2_volle_breite">Admins verwalten</span></h2>
        <table class="text cms">
            <tr><th>Admin</th><th>Rights</th><th></th></tr>
    
    <?php        
            //ADMIN BEARBEITEN FORM
            if (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] == 3) {
                if (isset($_GET['change']) && substr($_GET['change'], 0, 2) == "id") {
					$result = $C->select('admin', array('id' => substr($_GET['change'], 2)), array('rights'), '', 1);
					while ($row = mysql_fetch_array($result)){
						if($row['rights'] >=3){
							$result = $C->select('admin', array('rights'=>3), array('id'));
							if(mysql_num_rows($result) > 1){
								$C->delete('admin', array('id'=> substr($_GET['change'], 2)) );
								break;
							}else{
								break;
							}
						}else{
							$C->delete('admin', array('id' =>substr($_GET['change'], 2)) );
						}
					}
                }
            }// ende admin löschen */
            
            // ALLE ADMINS ANZEIGEN
            $result = $C->select('admin', '', array('id', 'name', 'rights'), array('rights', 'DESC'));
            $table = '';
            while ($row = mysql_fetch_array($result)) {
                $table .= '<tr><td>' . $row['name'];
                $table .= '</td><td>' . $row['rights'];
                $table .= '</td><td><a href="?page=administration&amp;act=admins&amp;change=id' . $row['id'] . '">L&ouml;schen</a>';
                $table .= '</td></tr>';
            }
            echo $table;
            //ende alle admins anzeigen
            ?>
    
            <tr>
            <?php
            // ADMIN HINZUFUEGEN FORMULAR bzw LINK
            if (isset($_GET['change']) && $_GET['change'] == "newadmin") {
                ?>
                <form action="?page=administration&amp;act=admins&amp;change=newadmin" method="post">
                    <td><input id="newadmin_name" name="newadmin_name" type="text" /></td>
                    <td><input type="number" name="newadmin_rights" id="newadmin_rights" /></td>
                    <td><input type="password" name="newadmin_pw" id="newadmin_pw" /></td>
                    <td><input type="submit" name="newadmin_save" id="newadmin_save" value="save" class="abschicken_button"/>
                </form>
                <td>
        <?php
        if (isset($_POST['newadmin_save']) && isset($_SESSION['fehler']['newadmin_name'])) {
            echo $_SESSION['fehler']['newadmin_name'];
        }
        if (isset($_POST['newadmin_save']) && isset($_SESSION['fehler']['newadmin_rights'])) {
            echo $_SESSION['fehler']['newadmin_rights'];
        }
        if (isset($_POST['newadmin_save']) && isset($_SESSION['fehler']['newadmin_pw'])) {
            echo $_SESSION['fehler']['newadmin_pw'];
        }
        ?>
                </td>
                    <?php
                } else {
                    ?>
                <td colspan="4"><a href="?page=administration&amp;act=admins&amp;change=newadmin">admin hinzufuegen</a></td>
                <?php } // ende abmin hinzufuegen ?>
            </tr>
        </table>
    </div>
        <?php
    }

    
    
    
/* KAMPGANEN BEARBEITEN */
    if (isset($_GET['act']) && $_GET['act'] == "style" && $_SESSION['admin']['rights'] >= 2) { ?>
    <div class="container">
        <h2><span class="h2_volle_breite">Kampagnenwechsel</span></h2>
        <div class="text left">
			<?php
            $result = $C->select ('style', '', '', array('active', 'DESC'));
            while($row = mysql_fetch_array($result)){
                echo '<a href="?page=administration&amp;act=style&amp;style='.$row['id'].'" id="'.$row['name'].'"';
                  if($row['active']==1){ echo 'class="selected_link"'; } 
                echo ' >'.$row['name'].'-Design</a>';							   
            } ?> 
        </div> 
   </div>
   
   <div class="container top">
		<h2><span class="h2_volle_breite">Game anpassen</span></h2>
        <div class="text small">
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?page=administration&amp;act=style'; ?>" method="post">
                <ul>
                    <?php
                    $game = $C->select('game', '', array('variable', 'wert'));
                    while ($row = mysql_fetch_array($game)) {
                        echo '<li><label for="' . $row['variable'] . '"><span class="label">' . $row['variable'] . ':</span><input type="text" id="' . $row['variable'] . '" name="' . $row['variable'] . '" value="';
                            if(isset($_POST[$row['variable']]) && !isset($_POST['default'])) {echo $_POST[$row['variable']]; } else { echo $row['wert']; }
                        echo '" /></label>';
                            if(isset($fehler[$row['variable']])&& !isset($_POST['default'])){ echo '<span class="fehler">'.$fehler[$row['variable']].'</span>'; }
                        echo '</li>';
                    }
                    ?>
                    <li><input type="submit" value="Speichern" name="game_einstellung" class="abschicken_button" /></li>
                    <li><input type="submit" value="Default Einstellungen setzten" name="default" class="abschicken_button" /></li>
                </ul>
            </form>
        </div>    
	</div>
    <?php }// ende KAMPAGNEN bearbeiten


       
            
           
            
/* NEWSBEREICH EDITIEREN */
     if (isset($_GET['act']) && $_GET['act'] == "news" && $_SESSION['admin']['rights'] >= 1) { ?>
        <div class="container">
            <h2><span class="h2_volle_breite">NEWSBEREICH</span></h2>         
            <div class="text cms">
				<?php echo '<h4><a href="index.php?page=administration&amp;act=news&amp;news=add" id="add_newseintrag" class="button">Eintrag hinzuf&uuml;gen</a></h4>'; ?>
            </div>
            <div class="text cms">
			<?php 
			    // Formular neuer News-Eintrag
			    if ((isset($_GET['news']) && $_GET['news'] == 'add') || (isset($fehler) && $fehler != '')) {
                    echo '<div>';
                    echo '<form enctype="multipart/form-data" method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=administration&amp;act=news" id="form_upload"  class="fileupload" >';
                    echo '<ul>';
                    echo '<li><label for="titel" ><span class="label" >Titel:</span><input type="text" name="titel" id="titel" ';
                        if (isset($_POST['titel']) && trim($_POST['titel']) != '') { echo 'value="' . trim($_POST['titel']) . '"'; }
                    echo '/>';
                        if (isset($fehler['titel'])) { echo '<span class="fehler">' . $fehler['titel'] . '</span>'; }
                    echo '</label></li>';
                    
                    echo '<li><label for="shorttext"><span class="label">Einleitung:</span><textarea name="shorttext" id="shorttext" >';
                        if (isset($_POST['shorttext']) && trim($_POST['shorttext']) != '') { echo trim($_POST['shorttext']); }
                    echo '</textarea>';
                        if (isset($fehler['shorttext'])) { echo '<span class="fehler">' . $fehler['shorttext'] . '</span>'; }
                    echo '</label></li>';
                    
                    echo '<li><label for="longtext"><span class="label">Text:</span><textarea name="longtext" id="longtext" >';
                        if (isset($_POST['longtext']) && trim($_POST['longtext']) != '') { echo trim($_POST['longtext']); }
                    echo '</textarea>';
                        if (isset($fehler['longtext'])) { echo '<span class="fehler">' . $fehler['longtext'] . '</span>'; }
                    echo '</label></li>';
                    
                    echo '<li><label for="img"><span class="label">Bild:</span><input type="file" accept="image/*" name="img" id="img" ';
                        if(isset($_FILES)){ echo 'value='.$_FILES.'"'; }
					echo ' />';
					    if (isset($fehler['upload'])) { echo '<span class="fehler">' . $fehler['upload'] . '</span>'; }
                    echo '</label></li>';
                    
                    echo '<li id="datei_list_news"></li>';
                    echo '<li><label for="event"><span class="label">Event:</span><input type="checkbox" name="event" id="event" value="1"';
						if(isset($_POST['event'])){ echo ' checked = "checked" '; }
					echo ' /></label></li>';
                    echo '<li><input type="submit" name="add_news" value="Eintrag speichern" class="abschicken_button" /></li>';
                    echo '</ul>';
                    echo '</form>';
                    echo '</div>';
                }//ende Formular neuer Newseintrag
              
                // alle Artikel in Übersicht laden
				if(!isset($_GET['news'])){
					echo '<table>';
					echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&amp;act=news" id="edit_news" >';
					$aktuelles = $C->select('news', '', '', array('tsp', 'DESC'));
					while ($row = mysql_fetch_array($aktuelles)) {
						$time = explode(' ', $row['tsp']);
						echo '<tr>';
						echo '<td><input type="checkbox" name="delete[]" value="' . $row['id'] . '" /></td>';
					   	echo '<td><time>' . $time[0] . '</time></td>';

						echo '<td class="articel_td"><article>';
						echo '<h3>' .$row['titel'] . '</h3>';
						echo '<p class="bold">' . utf8_encode($row['short_text']) . '</p>';
						echo '</article></td>';
				
						$result = $C->select('pictures', array('news_id' => $row['id']), '', '', 1);
						if($result){
							while ($row = mysql_fetch_array($result)) {
								echo '<td><img src="' . $row['url_thumb'] . '" alt="' . $row['alt'] . '" /></td>';
							}
						}
					}
					echo '<tr><td  colspan="4"><input type="submit" name="news_loeschen" value="L&ouml;schen" class="abschicken_button" /></td></tr>';
					echo '</table>';
					echo '</form>';
				}
            } ?>
	
	
<?php
// ende newsbereich editieren
    
    
    
    



/* MODELLE BEARBEITEN */
    if (isset($_GET['act']) && $_GET['act'] == "models" && $_SESSION['admin']['rights'] >= 2) {
        ?>
        <div class="container">
            <h2><span class="h2_volle_breite">Modelle bearbeiten</span></h2>
            <div class="text left">
            <?php
				$result = $C->select('style', array('active' => 1), array('sort_models'), 'id', 1);     //Links für Modelle ausgeben
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$sort_models = explode(',', $row['sort_models']); 
						if(!isset($_GET['modell'])){ $_GET['modell'] = $sort_models[0]; }           // wenn noch kein Link geklickt wurde, erstes Modell anzeigen            
						foreach ($sort_models as $value) {
							$model = $C->select('modelle', array('id' => $value), array('name'), '', 1);
							while ($row = mysql_fetch_array($model)) {
									echo '<a href="?page=administration&amp;act=models&amp;modell=' . $value . '" id="' . $row['name'] . '"';
									   if(isset($_GET['modell']) && $_GET['modell']==$value){ echo 'class="selected_link"'; }  
									echo '>' . $row['name'] . '</a>';
							}
						}
					}
				}//ende modelle ausgebenm ?>
            </div>
            <div class="text left">
				<?php   //FILEUPLOAD
                echo '<form enctype="multipart/form-data" method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=administration&amp;act=models&amp;modell='.$_GET['modell'].'" id="form_upload"  class="fileupload" >';
                echo '<ul>';
                echo '<li><input type="hidden" name="modell" id="modell" value="' . $_GET['modell'] . '" /></li>';
                echo '<li><label for="datei" class="upload"><span class="label">Datei:</span><input type="file" accept="image/*" name="add[]" id="datei"/></label></li>';
                echo '<li id="datei_list"></li>';
                echo '<li><input type="submit" name="bilder_upload" value="Bilder hinzufuegen" class="abschicken_button" /></li>';
                echo '</ul>';
                echo '</form>';
                //ende fileupload
        ?></div>
          <div class="text left">
          <?php
        
                // Bilder in Formular anzeigen
        
                $result = $C->select('gallery', array('modell' => $_GET['modell']), '', array('tsp', 'ASC'));
                if($result){
                    echo '<table><tr><td></td><td></td><td></td></tr>';
					echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&amp;act=models&amp;modell='.$_GET['modell'].'" id="form_download" >';
                    while ($row = mysql_fetch_array($result)) {
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="delete[]" value="' . $row['id'] . '" /></td>';
                        echo '<td><img src="' . $row['url_thumb'] . '" alt="' . $row['alt'] . '" />';
                        if(isset($fehler['delete_file'][$row['id']]) && $fehler['delete_file'][$row['id']] != ''){ echo '<span class="fehler">'.$fehler['delete_file'][$row['id']].'</span>';}
                        echo '</td>';
                    }
                    echo '<tr><td colspan="3"><input type="submit" name="bilder_loeschen" value="L&ouml;schen" class="abschicken_button" /></td></tr>';
                    echo '</form>';
					echo '</table>';
                }
                //ende bilder in formular anzeigen ?>
			</div>
		</div>
<?php    }//ende modelle bearbeiten


/* NEWSLETTER */
     if (isset($_GET['act']) && $_GET['act'] == "newsletter" && $_SESSION['admin']['rights'] >= 1) { ?>
		<div class="container">
            <h2><span class="h2_volle_breite">NEWSLETTER VERSENDEN</span></h2>         
            <div class="text cms">
				<?php
                // Formular neuer News-Eintrag
                    echo '<div>';
					if(isset($gesendet) && $gesendet != '') { echo '<p class="bold">'.$gesendet.'</p>'; }
                    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&amp;act=newsletter" >';
                    echo '<ul>';
                    echo '<li><label for="betreff" ><span class="label" >Betreff:</span><input type="text" name="betreff" id="betreff" ';
                        if (isset($_POST['betreff']) && trim($_POST['betreff']) != '') { echo 'value="' . trim($_POST['betreff']) . '"'; }
                    echo '/>';
                        if (isset($fehler['betreff'])) { echo '<span class="fehler">' . $fehler['betreff'] . '</span>'; }
                    echo '</label></li>';
                    
                    echo '<li><label for="mitteilung"><span class="label">Mitteilung:</span><textarea name="mitteilung" id="mitteilung" >';
                        if (isset($_POST['mitteilung']) && trim($_POST['mitteilung']) != '') { echo trim($_POST['mitteilung']); }
                    echo '</textarea>';
                        if (isset($fehler['mitteilung'])) { echo '<span class="fehler">' . $fehler['mitteilung'] . '</span>'; }
                    echo '</label></li>';
                    echo '<li><input type="submit" name="senden" value="Newsletter verschicken" class="abschicken_button" /></li>';
                    echo '</ul>';
                    echo '</form>';
                    echo '</div>'; ?>
            </div>
       </div>       
<?php   }//ende Newsletter
	 ?>
         
                
    
<?php    
/* ADRESSEN VERWALTEN */
    if (isset($_GET['act']) && $_GET['act'] == "email" && $_SESSION['admin']['rights'] >= 2) {
        ?>
        <div class="container">
            <h2><span class="h2_volle_breite">Adressen verwalten</span></h2>
            <div class="text cms">
                <a href="index.php?page=administration&amp;act=email&amp;email=add" class="button">Neuer Kunde</a>
            </div>
            <div class="text cms">            
                <?php
                    if((isset($_GET['email']) && $_GET['email']=='add') || (isset($fehler) && $fehler != '')) {
                  // neuer Eintrag
                      echo '<h4>Email hinzuf&uuml;gen</h4>';
                      echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?page=administration&amp;act=email" id="add_email" >';
                      echo '<table>';
                      echo '<tr><th></th><th>Vorname</th><th>Nachname</th><th>Email</th><th>Newsletter</th></tr>';  
                      echo '<tr><td></td><td><input type="text" name="user_vorname" ';
                        if (isset($_POST['user_vorname'])) {  echo 'value="' . trim($_POST['user_vorname']) . '"'; }
                      echo ' /></td>';
                      echo '<td><input type="text" name="user_nachname" ';
                        if (isset($_POST['user_nachname'])) {  echo 'value="' . trim($_POST['user_nachname']) . '"'; }
                      echo '  /></td>';
                      echo '<td><input type="email" name="user_email" ';
                        if (isset($_POST['user_email'])) {  echo 'value="' . trim($_POST['user_email']) . '"'; }
                      echo ' /></td>';
                      echo '<td><input type="checkbox" name="news_anfordern" value="1" ';
                        if (!isset($_POST['abschicken']) || (isset($_POST['abschicken']) && isset($_POST['news_anfordern']) )) { echo 'checked="checked"'; }
                      echo ' /></td></tr>'; 
                      if(!isset($fehler) || $fehler != ''){
                          echo '<tr><td></td>';
                          echo '<td>';
                            if (isset($fehler['user_vorname']) && $fehler['user_vorname'] != '') { echo '<span class="fehler">'.$fehler['user_vorname'].'</span>'; }
                          echo '</td>';
                          echo '<td>';
                            if (isset($fehler['user_nachname']) && $fehler['user_nachname'] != '') { echo '<span class="fehler">'.$fehler['user_nachname'].'</span>'; }
                          echo '</td>';
                          echo '<td>';
                            if (isset($fehler['user_email']) && $fehler['user_email'] != '') { echo '<span class="fehler">'.$fehler['user_email'].'</span>'; }
                          echo '</td>';
                          echo '</tr>';
                      }
                      
                    echo '<tr><td><input type="submit" name="abschicken" value="Save" class="abschicken_button"/></td></tr>';
        
                    echo '</table>';
                    echo '</form>';
                  }
        
                 
                /* Formular für Emails Bearbeiten -> kann nur ein Eintrag gleichzeitig bearbeitet werden */
                if (isset($_POST['edit_adressen']) && isset($_POST['edit_newsletter'])) {     
                    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&amp;act=email" id="edit_news" >';
                    echo '<table>';
                    echo '<tr><th></th><th>Vorname</th><th>Nachname</th><th>Email</th><th>Newsletter</th></tr>';
                    $result = $C->select('newsletter', array('id' => $_POST['edit_newsletter'][0]), '', array('nachname', 'ASC'));
                    while ($row = mysql_fetch_array($result)) {
                        echo '<tr>';
                        echo '<td><input type="hidden" name="id" value="'. $row['id'] .'" /></td>';
                        echo '<td><input type="text" name="user_vorname" value="';
                            if (isset($_POST['user_vorname'])) { echo trim($_POST['user_vorname']); } else { echo $row['vorname']; }
                        echo  '" /></td>';
                        echo '<td><input type="text" name="user_nachname" value="';
                            if (isset($_POST['user_nachname'])) { echo trim($_POST['user_nachname']); } else { echo $row['nachname']; }
                        echo '" /></td>';
                        echo '<td><input type="text" name="user_email" value="';
                            if (isset($_POST['user_email'])) { echo trim($_POST['user_email']); } else { echo $row['email']; }
                        echo '" /></td>';
                        echo '<td><input type="checkbox" name="news_anfordern" value="1" ';
                            if( (!isset($_POST['abschicken']) && $row['newsletter'] == 1) || isset($_POST['abschicken'])) { echo 'checked="checked"'; }  
                        echo ' /></td>';
                        echo "</tr>";
                        if(!isset($fehler) || $fehler != ''){
                          echo '<tr><td></td>';
                          echo '<td>';
                            if (isset($fehler['user_vorname']) && $fehler['user_vorname'] != '') { echo '<span class="fehler">'.$fehler['user_vorname'].'</span>'; }
                          echo '</td>';
                          echo '<td>';
                            if (isset($fehler['user_nachname']) && $fehler['user_nachname'] != '') { echo '<span class="fehler">'.$fehler['user_nachname'].'</span>'; }
                          echo '</td>';
                          echo '<td>';
                            if (isset($fehler['user_email']) && $fehler['user_email'] != '') { echo '<span class="fehler">'.$fehler['user_email'].'</span>'; }
                          echo '</td>';
                          echo '</tr>';
                      }
                    }
                    echo '<tr><td><input type="submit" name="edit_email" value="Save" class="abschicken_button" /></td></tr>';
        
                    echo '</table>';
                    echo '</form>';
        
                    // Emails aus DB laden
                } else {
                    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&amp;act=email" id="edit_news" >';
                    echo '<table>';
                    echo '<tr><th></th><th>Vorname</th><th>Nachname</th><th>Email</th><th>Newsletter</th></tr>';
                    $result = $C->select('newsletter', '', '', array('nachname', 'ASC'));
                    while ($row = mysql_fetch_array($result)) {
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="edit_newsletter[]" value="' . $row['id'] . '" /></td>';
                        echo '<td>' . $row['vorname'] . '</td>';
                        echo '<td>' . $row['nachname'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td><input type="checkbox" name="check_news" ';
                        if ($row['newsletter'] == 1) {
                            echo 'checked="checked"';
                        }
                        echo ' /></td>';
                        echo "</tr>";
                    }
                    echo '<tr><td colspan="5"><input type="submit" name="edit_adressen" value="Bearbeiten" class="abschicken_button" /></td></tr>';
                    echo '<tr><td colspan="5"><input type="submit" name="delete_adressen" value="Loeschen" class="abschicken_button" /></td></tr>';
        
                    echo '</table>';
                    echo '</form>';
                }
            }
        ?>
		</div>
    </div>
</div>
