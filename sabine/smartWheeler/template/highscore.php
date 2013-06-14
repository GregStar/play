<!--        <script type="text/javascript" src="../plugins/quicksearch/jquery.quicksearch.js"></script>
        <script type="text/javascript" src="../skin/js/plugins.js"></script>
-->
<?php
require_once '../inc/mysqlDB.class.php';
$E = new mysqlDB('localhost', 'wdd909', 'student', 'doebroessy');
?>
<div class="box_content">
	
		<?php
        
        /* Spieler suchen */
        if(isset($_POST['spieler_suche']) && ($_POST['spieler_suche']) != '' ){                    
            $suche = $E->select('score', '', array('name', 'points'), array('points','DESC'));
            if($suche){
               $rang = 1;
               echo '<table id="table_example2"><thead><tr><th>Rang</th><th>Name</th><th>Score</th></tr></thead><tbody>';
               while($row = mysql_fetch_array($suche)) {
                   if($row['name'] == $_POST['spieler_suche']){
                      echo '<tr>';
                      echo '<td>'.$rang.'.</td>';
                      echo '<th>'.$row['name'].'</th>';
                      echo '<td><span class="punkte">'.$row['points'].'</span></td>';
                      echo '</tr>';
                   }
                      $rang ++;
                }  
                echo '</tbody></table>';
            }
        }
        ?>
        
        <a id="score"></a>
		<div class="text small">
            <form action="<?php //echo $_SERVER['PHP_SELF'].'?page=game#score'; ?>" method="post">
                <ul>
                   <li><label for="spieler_name"><span class="label">Suche:</span><input type="text" id="spieler_suche" name="spieler_suche" /></label></li>
            
                   <li><input type="submit" value="Suchen" class="abschicken_button" /></li>
                </ul>
            </form>
        </div>
        
        
        <?php
        echo '<div id="score_list">';
        echo '<table id="table_example2"><thead><tr><th><span class="table_span">Rang</span></th><th>Name</th><th>Score</th></tr></thead><tbody>';
        
        $result = $E->select('score', '', array('name','points'), array('points','DESC'));
        if($result){
          $rang = 1;
          while($row = mysql_fetch_array($result)) {
                  echo '<tr class="';
				  	if($rang%2 == 0){ echo 'even'; }else { echo 'odd'; }
				  echo '">';
                  echo '<td><span class="table_span">'.$rang.'.</span></td>';
                  echo '<th>'.$row['name'].'</th>';
                  echo '<td><span class="punkte">'.$row['points'].'</span></td>';
                  echo '</tr>';
                  $rang ++;
            }   
        }
        echo '</tbody></table>';
        echo '</div>';
        
        ?>
         <!--       <script type="text/javascript" src="plugins/quicksearch/jquery.quicksearch.js"></script> -->

 </div>
 <script>
 //Button verbergen
	$('.abschicken_button').hide();	
	
		
//QUICKSEARCH
    $('input#spieler_suche').quicksearch('table#table_example2 tbody tr', {
        'delay': 300,
        'selector': 'th',
        'stripeRows': ['odd', 'even'],
        'loader': 'span.loading',
        'bind': 'keyup click',
        'show': function () {
            this.style.color = '';
        },
        'hide': function () {
            this.style.color = '#ccc';
        },
        'prepareQuery': function (val) {
            return new RegExp(val, "i");
        },
        'testQuery': function (query, txt, _row) {
            return query.test(txt);
        }
    });    
</script>        