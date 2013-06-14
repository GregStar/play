<div class="content_wrap">   
    <a id="formular"></a>
    <div id="contact_div" class="container clear autoheight3">
        <form action="javascript:void%200;<?php echo $_SERVER['PHP_SELF'].'?page=contact'; ?>" method="post" id="contact_form">
            <h2><span class="h2_ausrichten">Contact us</span></h2>
            <ul>
                <?php
                    if (isset($fehler['mail']) && $fehler['mail'] != '') {
                        echo '<li><span class="fehler">' . $fehler['mail'] . '</span></li>';
                    }  
                    if (isset($gesendet) && $gesendet != '') {
                        echo '<li><strong>' . $gesendet . '</strong></li>';
                    } ?>                
                <li>
                    <label for="user_vorname"><span class="label">Vorname:</span><input type="text" name="user_vorname" id="user_vorname" 
                        <?php if (isset($_POST['user_vorname'])) {
                            echo 'value="' . trim($_POST['user_vorname']) . '"';
                        } ?> /></label>
                    <?php
                    if (isset($fehler['user_vorname']) && $fehler['user_vorname'] != '') {
                        echo '<span class="fehler">' . $fehler['user_vorname'] . '</span>';
                    } ?>
                </li>
                <li>
                    <label for="user_nachname"><span class="label">Nachname:</span><input type="text" name="user_nachname" id="user_nachname"
                        <?php if (isset($_POST['user_nachname'])) {
                            echo 'value="' . trim($_POST['user_nachname']) . '"';
                        } ?> /></label>
                    <?php
                    if (isset($fehler['user_nachname']) && $fehler['user_nachname'] != '') {
                        echo '<span class="fehler">' . $fehler['user_nachname'] . '</span>';
                    } ?>      
                </li>
                <li>
                    <label for="user_email"><span class="label">Email:</span><input type="email" name="user_email" id="user_email" 
                        <?php if (isset($_POST['user_email'])) {
                            echo 'value="' . trim($_POST['user_email']) . '"';
                        } ?> /></label>
                    <?php
                    if (isset($fehler['user_email']) && $fehler['user_email'] != '') {
                        echo '<span class="fehler">' . $fehler['user_email'] . '</span>';
                    } ?>
                </li>
                <li>
                    <label for="nachricht"><span class="label">Ihre Nachricht:</span>
                        <textarea name="nachricht" id="nachricht" cols="50" rows="10" ><?php if (isset($_POST['nachricht']) 
                                && trim($_POST['nachricht']) != '') { echo trim($_POST['nachricht']); } else { echo "Schicke uns deine Anfrage...";
                        } ?></textarea></label>
                </li>
                <li>
                    <label for="news_anfordern"><input type="checkbox" id="news_anfordern" name="news_anfordern" 
                        <?php if (isset($_POST['news_anfordern'])) {
                            echo 'checked="checked"';
                        } ?> /><span class="after_checkbox">Newsletter bestellen</span></label>
                </li>
                <li>
                    <input type="submit" name="abschicken" value="Abschicken" class="abschicken_button"/>
                </li>
            </ul>
        </form>
    </div>
    
    <div id="daten_container">
        <div class="container autoheight1">
            <h2><span class="h2_ausrichten">Ge&ouml;ffnet</span></h2>
            <div class="text">
                <h3>Öffnungszeiten:</h3>
                <p> 
                    Mo-Fr: 9:00-19:00<br />
                    Sa: 10-19:00<br />
                </p>   
            </div>
        </div>
        
        <div class="container top autoheight2" id="daten">
            <h2><span class="h2_ausrichten">Daten</span></h2>
            <div class="text">
                <p>
                    smartWHEELER<br />
                    Tel.: 0650/ 36 14 224<br /> 
                    email: <a href="mailto:info@smartwheeler.at">info@smartwheeler.at</a><br />
                    home: <a href="">www.smartwheeler.at</a><br />
                    facebook: <a href="#">www.facebook.com/smartwheeler</a>
					<br />
                    Geschäftsführung: Sabine Döbrössy
                </p>    
            </div>
        </div>    
	</div>
    
    <div id="anfahrt_container" class="autoheight3">
        <div class="container autoheight1" id="adresse">
            <h2><span class="h2_ausrichten">Anreise</span></h2>
            <div class="text">
                <h3>Adresse:</h3>
                <p>
                    Geusaugasse 39 / 16<br /> 
                    A - 1030 Wien<br />
                   
                </p> 
       
            </div>
        </div>
        
        <div class="container top autoheight2" id="plan">
            <h2><span class="h2_ausrichten">Anfahrtplan</span></h2>
            <div class="text">
                <iframe width="340" height="340" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.at/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=Geusaugasse+39%2F16&amp;aq=&amp;sll=47.635784,13.590088&amp;sspn=11.730393,26.125488&amp;ie=UTF8&amp;hq=&amp;hnear=Geusaugasse+39,+Landstra%C3%9Fe+1030+Wien&amp;z=14&amp;ll=48.204048,16.394073&amp;output=embed"></iframe><br /><small><a href="http://maps.google.at/maps?f=q&amp;source=embed&amp;hl=de&amp;geocode=&amp;q=Geusaugasse+39%2F16&amp;aq=&amp;sll=47.635784,13.590088&amp;sspn=11.730393,26.125488&amp;ie=UTF8&amp;hq=&amp;hnear=Geusaugasse+39,+Landstra%C3%9Fe+1030+Wien&amp;z=14&amp;ll=48.204048,16.394073" style="color:#0000FF;text-align:left">Größere Kartenansicht</a></small>
       
            </div>
        </div>        
        
    </div>
</div>
