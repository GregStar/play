<div class="content_wrap">
    <ul id="modelle_slider" class="container_3">
        <?php
		$modell_name='';
        $result = $C->select('style', array('active' => 1), array('sort_models'), 'id', 1);
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $sort_models = explode(',', $row['sort_models']);
				if(!isset($_GET['modell'])){ $_GET['modell'] = $sort_models[0]; }
                $zaehler = 0;
				foreach ($sort_models as $value) {
                    echo '<li class="container';
					if($zaehler == 1) {echo ' quad_mitte'; }
					if(isset($_GET['modell']) && $_GET['modell']== $value){ echo ' highlight'; }
					echo '" id="'.$zaehler.'">';
                    $zaehler++;
					$model = $C->select('modelle', array('id' => $value), array('name'), '', 1);
                    while ($row = mysql_fetch_array($model)) {
						if($value == $_GET['modell']){ $modell_name = $row['name']; }
                        echo '<h2><a href="index.php?page=quads&amp;modell=' . $value . '">' . $row['name'] . '</a></h2>';
                    }

                        $pic = $C->select('gallery', array('modell' => $value, 'need'=>'home_slider'), array('url_pic', 'alt'), '', 1);
                  	while ($row = mysql_fetch_array($pic)) {
                            echo '<div class="img_container"><img src="' . $row['url_thumb'] . '" alt="' . $row['alt'] . '" /></div>';
                        }

                    echo "</li>";
                }
            }
        }
        ?>
    </ul>


    <div id="featured" class="quads container container_3" >
        <h2><span class="h2_volle_breite">
        <?php echo $modell_name; ?>
        </span></h2>
       
        <ul class="ui-tabs-nav text">
            <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-info"><a href="#info" class="button"><img src="images/image1-small.jpg" alt="" /><span>Produktinfos</span></a></li>
            <li class="ui-tabs-nav-item" id="nav-details"><a href="#details" class="button"><img src="images/image2-small.jpg" alt="" /><span>Details</span></a></li>
            <li class="ui-tabs-nav-item" id="nav-pics"><a href="#pics" class="button"><img src="images/image3-small.jpg" alt="" /><span>Gallery</span></a></li>
        </ul>
        
        
        <!-- First Content -->
        <div id="info" class="ui-tabs-panel">
                <?php 
				echo '<div class="text info" >';
				$result = $C->select('beschreibung', array('modell' => $_GET['modell']));
				while($row = mysql_fetch_array($result)){
					if($row['tag']!= 'li'){
						echo '<'.$row['tag'].'>'.utf8_encode($row['text']).'</'.$row['tag'].'>';
					}
				}
				echo '</div>';
				?>
        </div>
        <!-- Second Content -->
        <div id="details" class="ui-tabs-panel ui-tabs-hide">
                <?php 
				echo '<div class="text info" >';
				echo '<h3>Technische Highlights</h3>';
				$result = $C->select('beschreibung', array('modell' => $_GET['modell'], 'tag' => 'li'));
				echo '<ul class="liste">';
				while($row = mysql_fetch_array($result)){
					echo '<'.$row['tag'].'>'.utf8_encode($row['text']).'</'.$row['tag'].'>';
				}
				echo '</ul>';
				echo '</div>';
				?>
        </div>
        <!-- Third Content -->
        <div id="pics" class="ui-tabs-panel ui-tabs-hide">
            <div id="gallery_container" class="text info" >
            	<?php include ('template/gallery.php'); ?>
            </div>
        </div>
    </div>
</div>