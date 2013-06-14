<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="keywords" content="Quads, Verkauf, Fahrzeug, Motorsport, 1030, Wien, &Ouml;sterreich, Austria, " />
        <meta name="description" content="smartWHEELER - Studentenprojekt SAE WIEN" />
        
        <link rel="stylesheet" type="text/css" href="skin/css/print.css" media="print"/>
        <?php
   
            ///Style einbinden
            $style = 'style';
            if (!isset($_SESSION['admin']['rights']) || $_SESSION['admin']['rights'] < 1) {
                $result = $C->select('style', array('active' => 1), array('css'), 'id', 1);
                if ($result) {
                    while ($row = mysql_fetch_array($result)) {
                        $style = $row['css'];
                    }
                } #ende style einbinden
            }
            ?>
            <link rel="stylesheet" type="text/css" href="skin/mobile/css/<?php echo $style; ?>.css" media="screen" />
 
  			<!-- JQUERY -->
            <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js" ></script>

			<!-- JQUERY UI - tabs -->           
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script> 
            
            
            <!-- FANCYBOX -->
            <script type="text/javascript" src="plugins/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
            <script type="text/javascript" src="plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
            <link rel="stylesheet" type="text/css" href="skin/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
            <script type="text/javascript" src="plugins/fancybox/jquery.easing-1.3.pack.js"></script>


            <!-- Formularvalidierung -->
            <script type="text/javascript" src="http://livevalidation.com/javascripts/src/1.3/livevalidation_standalone.compressed.js" ></script>

            

            <script type="text/javascript" src="skin/mobile/js/plugins.js"></script>
               
          

        <title>smartWHEELER</title>
        
    </head>
    
    <body>
        <a id="top"></a>
        <div id="wrapper">
            <header>        
                <h1 id="logo"><a href="index.php">smartWHEELER</a></h1>
                <nav id="main_nav">
                    <a href="#about" class="button<?php if (isset($_GET['page']) && $_GET['page'] == 'about') {
                                        echo ' active'; } ?>" >ABOUT</a>
                    <a href="#quads" class="button<?php if (isset($_GET['page']) && $_GET['page'] == 'quads') {
                                        echo ' active'; } ?>" >QUADS</a>
                    <a href="#news" class="button<?php if (isset($_GET['page']) && $_GET['page'] == 'news') {
                                        echo ' active'; } ?>" >NEWS</a>  
                    <a href="#game" class="button<?php if (isset($_GET['page']) && $_GET['page'] == 'game') {
                                        echo ' active'; } ?>" >GAME</a>                                                                              
                    <a href="#sae" class="button<?php if (isset($_GET['page']) && $_GET['page'] == 'sae') {
                                        echo ' active'; } ?>" >SAE</a>
                    <a href="#contact" class="button<?php if (isset($_GET['page']) && $_GET['page'] == 'contact') {
                                        echo ' active'; } ?>" >CONTACT</a>
                </nav>
            </header>
                     
            <div id="content">
				<!-- ABOUT -->
                <a id="about"></a>
                <div class="container">
                    <h2><a href="#about">ABOUT</a>
                    	<span><a href="#top">TOP</a></span>
                    </h2>
                    <div class="text">
                        <p class="em">smartWHEELER ist ein Stundentenprojekt von mir - Sabine Döbrössy - 
                            an der SAE Wien auf dem Weg zu Abschluss des Webdesign & Development 
                            Diploma. Das fiktive Unternehmen ist auf Quads spezialisiert.
                        </p>
                        <a href="#" class="link" >Sieh dir den Trailer zur Website an.</a>
                    </div>
                	<a href="#top" class="top">TOP</a>
                </div>
                
                <!-- QUADS -->
                <a id="quads"></a>
                <div class="container">                
                    <h2><a href="#quas">QUADS</a>
                    	<span><a href="#top">TOP</a></span>
                    </h2>
                    <div class="text">
                         <div id="gallery" class="content">
                                <?php
								$result = $C->select('style', array('active' => 1),'', 'sort_models', 1);
								if ($result) {
									while ($row = mysql_fetch_array($result)) {
                						$model = explode(',', $row['sort_models']);
										
										$bilder = $C->select('gallery', array('modell'=>$model[0]), '', array('tsp', 'ASC'));
										while($row = mysql_fetch_array($bilder)){
											echo '<a class="thumb" id="'.$row['alt'].'" href="'. $row['url_pic'].' " rel="group1">';
											echo '<img src="'.$row['url_thumb'].'" alt="'.$row['alt'].'" />';
											echo '</a>';
										}
									}
								} #ende style einbinden
                                //Bilder von DB ausgeben
      
                                
                            
                                ?>
                         </div>
                    </div>
                	<a href="#top" class="top">TOP</a>
				</div>
                
                <!-- NEWS -->
                <a id="news"></a>
                <div class="container">                
                    <h2><a href="#news">NEWS</a>
                    	<span><a href="#top">TOP</a></span>
                    </h2>
                    <div class="text info">
                        <ul>
                            <?php
                                $events = $C->select('news', array('event'=>0), '', array('tsp', 'DESC'), 3);
                                while($row = mysql_fetch_array($events)){
                                    $time = explode(' ', utf8_encode($row['tsp']));
                                    echo '<li><article>';
                                    echo '<h3>'.$row['titel'].'</h3>';
                                    echo '<p>'.utf8_encode($row['short_text']).'</p>';                    
                                    echo '</article></li>';
                                }
                            ?>
                        </ul>
                    </div>
                	<a href="#top" class="top">TOP</a>
                </div>    
                                
                <!-- GAME -->
                <a id="game"></a>
                <div class="container" id="game" >
                	<h2><a href="#game">GAME</a>
                    	<span><a href="#top">TOP</a></span>
                    </h2>
                    <div class="text">
                        <p class="em">Du liebst es dich um Highscores zu battel?! Dann haben wir genau das richtige für dich: Das neue smartWHEELER Game ist da! Besuche uns vom PC aus oder auf Facebook und los gehts!
                        </p>
     	
                        <?php
                            echo '<table><thead><tr><th><span class="table_span">Rang</span></th><th>Name</th><th>Score</th></tr></thead><tbody>';
        
                            $result = $C->select('score', '', array('name','points'), array('points','DESC'), 5);
                            if($result){
                              $rang = 1;
                              while($row = mysql_fetch_array($result)) {
                                    echo '<tr>';
                                      echo '<td><span class="table_span">'.$rang.'.</span></td>';
                                      echo '<th>'.$row['name'].'</th>';
                                      echo '<td><span class="punkte">'.$row['points'].'</span></td>';
                                      echo '</tr>';
                                      $rang ++;
                                }   
                            }
                            echo '</tbody></table>';
                        ?>                 
                    </div>
                	<a href="#top" class="top">TOP</a>                    
                </div>   
                
                <!--SAE -->  
                <div class="container" id="sae"> 
                    <?php
						define('MAGPIE_CACHE_DIR', 'cache');
						define('MAGPIE_CACHE_AGE', '21600');        // 4x am Tag abfragen 
						require_once('magpierss-0.72/rss_fetch.inc');
						$url = 'http://wien.sae.edu/de/news/rss';
			
						if ($url) {
							$num_items = 2;
							$rss = fetch_rss($url);
							$items = array_slice($rss->items, 0, $num_items);
						}
						?>
			                    
						<h2><a href="#sae"><?php echo $rss->channel['title']; ?></a>
                        	<span><a href="#top">TOP</a></span>
                        </h2>
                        <div class="text">
						<?php
                        echo "<ul id='feed'>";
                        foreach ($items as $item) {
                            echo '<li><article><h3><a href="' . utf8_encode($item['link']) . '" class="link">' . utf8_encode($item['title']) . '</a></h3>';
                            echo '<p>' . utf8_encode($item['description']) . '</p>';
                        }
                        echo "</ul>";
					?>
                    </div>   
                	<a href="#top" class="top">TOP</a>
                </div>

                
                <!-- CONTACT -->
                <a id="contact"></a>
                <div class="container" id="contact"> 
                	<h2><a href="#contact">CONTACT</a>
                    	<span><a href="#top">TOP</a></span>
                    </h2>
                    <form action="<?php echo $_SERVER['PHP_SELF'].'#contact'; ?>" method="post" id="contact_form" class="text">
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
                	<a href="#top" class="top">TOP</a>
                </div>
                
                

            </div>
                     
            <footer>
                <p>&copy; smartWHEELER; Dies ist ein Studentenprojekt, die Inhalte sind zum Teil erfunden. Der Autor übernimmt keine Haftung.</p>
            </footer>
        </div>
    </body>
</html>