<?php				echo '<div>';
                    echo '<form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&amp;act=news" id="form_upload"  class="fileupload" onsubmit="return checkUpload();" >';
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
                        if(isset($_POST['img'])){ echo 'value='.$_POST['img'].'"'; }
                    echo ' /></label></li>';
                    
                    echo '<li id="datei_list_news"></li>';
                    echo '<li><label for="event"><span class="label">Event:</span><input type="checkbox" name="event" id="event" value="1" /></label></li>';
                    echo '<li><input type="submit" name="add_news" value="Eintrag speichern" /></li>';
                    echo '</ul>';
                    echo '</form>';
                    echo '</div>';
                    ?>