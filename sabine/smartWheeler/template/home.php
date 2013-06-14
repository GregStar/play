<div class="content_wrap clear">
<div id="div_modelle">
    <ul id="slider" class="clear">
        <?php       // Modelle ausgeben
		$result = $C->select('style', array('active' => 1), array('sort_models'), 'id', 1);
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $sort_models = explode(',', $row['sort_models']);
                $zaehler = 0;
                foreach ($sort_models as $value) {
                    echo '<li class="container modell slide img container_3';
					if($zaehler == 1) {echo ' mitte'; }
					echo '" id="'.$zaehler.'">';
                    $zaehler++;
                    $model = $C->select('modelle', array('id' => $value), array('name', 'header_txt'), '', 1);
                    while ($row = mysql_fetch_array($model)) {
                        echo '<h2><span class="h2_ausrichten">'.$row['name'].'</span></h2>';
                        echo '<div class="container_content">';
						echo '<div class="text">';
                        echo '<p>'.utf8_encode($row['header_txt']).'</p>';
                        echo '<a href="index.php?page=quads&amp;modell=' . $value . '" class="button">N&auml;here Infos</a>';
                        $pic = $C->select('gallery', array('modell' => $value, 'need'=>'home_slider'), array('url_pic', 'alt'), '', 1);
                        echo "</div>";
						while ($row = mysql_fetch_array($pic)) {
                            echo '<div class="img_container"><img src="' . $row['url_pic'] . ' "width="200" height="150" alt="' . $row['alt'] . '" /></div>';
                        }
						echo '</div>';
                    }
                    echo "</li>";
                }
            }
        }//ende modelle ausgeben
        ?>
    </ul>
</div>


    <div id="container">
        <div id="about_us">
            <div id="about" class="container city_slider_hidden autoheight1 container_2 container_3">
                <h2><span class="h2_ausrichten">Whats that?</span></h2>
                <div class="text">
                    <p>
                        <strong>smartWHEELER</strong> ist ein Stundentenprojekt von mir - Sabine D&ouml;br&ouml;ssy - an der SAE Wien auf dem Weg zum Abschluss des 
                        Webdesign & Development Diploma. Das Unternehmen selbst ist natürlich rein fiktiv.
                    </p>
                    <a href="skin/trailer.swf" class="button" id="trailer" name="swf">Trailer</a>
                </div>
            </div>

            <div id="facebook" class="container top city_slider_active container_2 autoheight2">
                <h2><span class="h2_ausrichten">Take A Look</span></h2>
                <div class="text">
                    <p>
                        Besuche uns auf unserer Facebook-Seite! Lorem ipsum dolor sit amet, lorem ipsum dolor sit amet, lorem ipsum dolor sit amet,
                        lorem ipsum dolor sit amet, lorem ipsum dolor sit amet 
                        Wir freuen uns auf dich!
                    </p>
                    <a href="http://www.facebook.com/pages/smart-WHEELER/133451246749384?sk=app_188212464562339" class="button">Facebook</a>
                </div>
            </div>
        </div>

        <div id="game_div" class="autoheight3 container_3">
            <div id="game" class="container city_slider_hidden autoheight1 container_2 autoheight_3" >
                <h2><span class="h2_ausrichten">Game-play</span></h2>
                <div class="text">
                    <p>
                        Begib dich auf eine abenteuerliche Fahrt, sammle Punkte erreiche das Ziel so schnell du kannst!
                    </p>
                    <a href="skin/game/game.php" id="start" class="button">START GAME</a> 
                </div>
            </div>

            <div id="highscore" class="container top city_slider_hidden container_2 autoheight2">
                <h2><span class="h2_ausrichten">High-Score</span></h2>
                <div class="text"> 
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
                    <a href="template/highscore.php" id="score_suche" class="button">Suche deine Bestzeit</a>

                </div>
            </div>
        </div>
    </div>
    
    <div id="sae" class="container autoheight3 container_3">
		<div class="overlay">
            <div class="scroll">
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
        
                <h2><span class="pull_down"></span><span class="h2_ausrichten"><?php echo $rss->channel['title']; ?></span></h2>
                <div class="text">
                        <?php
                        echo "<ul id='feed'>";
                        foreach ($items as $item) {
                            echo '<li><article><h3><a href="' . utf8_encode($item['link']) . '">' . utf8_encode($item['title']) . '</a></h3>';
                            echo '<p>' . utf8_encode($item['description']) . '</p>';
                            echo '<a href="' . utf8_encode($item['link']) . '">weiter lesen ...</a></article></li>';
                        }
                        echo "</ul>";
                        ?>
                </div>
			</div>
        </div>
    </div>
</div>