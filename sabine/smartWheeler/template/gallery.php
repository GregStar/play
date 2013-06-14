 <div id="gallery" class="content">
        <?php

        //Bilder von DB ausgeben
        if(!isset($_GET['modell'])){
            $_GET['modell']=7;  //Zufallswert aus DB
        }
        $bilder = $C->select('gallery', array('modell'=>$_GET['modell']), '', array('tsp', 'ASC'));
        while($row = mysql_fetch_array($bilder)){
            echo '<a class="thumb" id="'.$row['alt'].'" href="'. $row['url_pic'].' " rel="group1">';
            echo '<img src="'.$row['url_thumb'].'" alt="'.$row['alt'].'" />';
            echo '</a>';
        }
	
        ?>
 </div>
<!--<div id="gallery" class="content">
    <div id="controls" class="controls"></div>
    <div class="slideshow-container">
        <div id="loading" class="loader"></div>
	<div id="slideshow" class="slideshow"></div>
    </div>
    <div id="caption" class="caption-container"></div>
</div>

<div id="thumbs" class="navigation clear_3">
    <ul class="thumbs noscript">
        <?php
/*
        //Bilder von DB ausgeben
        if(!isset($_GET['modell'])){
            $_GET['modell']=7;  //Zufallswert aus DB
        }
        $bilder = $C->select('gallery', array('modell'=>$_GET['modell']), '', array('tsp', 'ASC'));
        while($row = mysql_fetch_array($bilder)){
            echo '<li>';
            echo '<a class="thumb" id="'.$row['alt'].'" href="'. $row['url_pic'].'">';
            echo '<img src="'.$row['url_thumb'].'" alt="'.$row['alt'].'" />';
            echo '</a>';
            echo '</li>';
        }
		*/
        ?>
    </ul>
</div>-->

<script type="text/javascript">
if($(".thumb").length > 0){
    $(".thumb").fancybox({
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic',
		'cyclic' : 'true',
		'titleShow' : false,
		'hideOnOverlayClick' : false
    });
}

</script>