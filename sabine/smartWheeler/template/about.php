<div class="content_wrap"> 
	<div id="about_header">
        <div id="featured" class="about container" >
            <h2><span class="h2_volle_breite">About Us</span></h2>
           
            <ul class="ui-tabs-nav text">
                <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-wir"><a href="#wir" class="button"><img src="images/image1-small.jpg" alt="" /><span>Wir stellen uns vor</span></a></li>
                <li class="ui-tabs-nav-item" id="nav-support"><a href="#support" class="button"><img src="images/image2-small.jpg" alt="" /><span>Support</span></a></li>
                <li class="ui-tabs-nav-item" id="nav-news"><a href="#news" class="button"><img src="images/image3-small.jpg" alt="" /><span>News</span></a></li>
                <li class="ui-tabs-nav-item" id="nav-events"><a href="#events" class="button"><img src="images/image4-small.jpg" alt="" /><span>Events</span></a></li>
            </ul>
            
            
            <!-- First Content -->
            <div id="wir" class="ui-tabs-panel" style="">
                <div class="text info">
                    <h3>Wir stellen uns vor</h3>
                    <p>
                       Wir sind ein rein fiktives Unternehmen, das sich auf Quads spezialisiert hat. 
                    </p>
                    <p>
                        Wir m&ouml;chten unseren Kunden unsere Begeisterung mit auf 
                        den Weg geben. Uns ist die genaue Information wichtig, darum nehmen wir uns gerne Zeit f&uuml; dich.
                        Denn wir sind erst zufrieden, wenn du es bist.
                    </p>
                </div>
            </div>
            
            <!-- Second Content -->
            <div id="support" class="ui-tabs-panel ui-tabs-hide" style="">
                <div class="text info"> 
                    <h3>Support</h3>
                    <p>
                        Unser Team steht dir gerne mit mit Rat und Tat zur Seite. 
                        Bei Fragen oder Problemen kannst du dich jederzeit an unsere Mitarbeiter wenden. Am besten wendest du sich mit deiner Anfrage via <a href="index.php?page=contact#formular" class="inline">Email</a> an uns.
                    </p>
                </div>
            </div>
            
            <!-- Third Content -->
            <div id="news" class="ui-tabs-panel ui-tabs-hide" style="">
                <div class="text info breite">
                    <ul class="eintraege_liste">
                        <?php
                        $events = $C->select('news', array('event'=>0), '', array('tsp', 'DESC'));
                        while($row = mysql_fetch_array($events)){
                            $time = explode(' ', utf8_encode($row['tsp']));
                             echo '<li class="eintrag clear">';
                            echo '<article class="clear">';
                            echo '<h3>'.$row['titel'].'</h3>';
                            echo '<section class="artikel">';
                            echo utf8_encode($row['short_text']);
                            echo '<section class="longtext">'.utf8_encode($row['long_text']).'</section>';
                            echo '</section>';
                            echo '<section class="zu_artikel">';						
                            echo '<time>'.$time[0].'</time>';
                            $result = $C->select('pictures', array('news_id' => $row['id']), '', '', 1);
                            if($result){
                                while ($row2 = mysql_fetch_array($result)) {
                                    echo '<a href="'.$row2['url_pic'].'" class="show_pic"><img src="' . $row2['url_thumb'] . '" alt="' . $row2['alt'] . '" /></a>';
                                }
                            }
                            echo '</section>';
                            echo '</article>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            
            <!-- Fourth Content -->
            <div id="events" class="ui-tabs-panel ui-tabs-hide" style="">
                <div class="text info breite">
                    <ul class="eintraege_liste">
                         <?php
                        $events = $C->select('news', array('event'=>1), '', array('tsp', 'DESC'));
                        while($row = mysql_fetch_array($events)){
                            $time = explode(' ', utf8_encode($row['tsp']));
                            echo '<li class="eintrag clear">';
                            echo '<article class="clear">';
                            echo '<h3>'.$row['titel'].'</h3>';
                            echo '<section class="artikel">';
                            echo utf8_encode($row['short_text']);
                            echo '<section class="longtext">'.utf8_encode($row['long_text']).'</section>';
                            echo '</section>';
                            echo '<section class="zu_artikel">';						
                            echo '<time>'.$time[0].'</time>';
                            $result = $C->select('pictures', array('news_id' => $row['id']), '', '', 1);
                            if($result){
                                while ($row2 = mysql_fetch_array($result)) {
                                    echo '<a href="'.$row2['url_pic'].'" class="show_pic"><img src="' . $row2['url_thumb'] . '" alt="' . $row2['alt'] . '" /></a>';
                                }
                            }
                            echo '</section>';
                            echo '</article>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
		</div>
	</div>
</div>   