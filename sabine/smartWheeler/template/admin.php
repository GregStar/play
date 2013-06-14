<div class="content_wrap">
    <div id="admin" class="container form_3">
        <h2><span class="h2_volle_breite">Login Administrationsbereich</span></h2>
        <div class="text small">
            <h3 class="left">Zutritt nur f&uuml;r berechtigte Administratoren</h3>
            <?php 
            if(isset($fehler['admin_login']) && strlen($fehler['admin_login']) != ''){
                echo '<p class="fehler">'.$fehler['admin_login'].'</p>';
            }
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                 <ul>
                     <li><label for="benutzer_name"><span class="label">Benutzername:</span><input type="text" id="benutzer_name" name="benutzer_name" /></label></li>
                     <li><label for="benutzer_pw"><span class="label">Passwort:</span><input type="password" id="benutzer_pw" name="benutzer_pw"/></label></li>
                     <li><input type="submit" value="Einloggen" class="abschicken_button" /></li>
                 </ul>
            </form>
        </div>
    </div>
</div>