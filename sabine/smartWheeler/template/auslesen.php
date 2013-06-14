<?php
	$db = mysql_connect('mysqlsvr30.world4you.com','webcreativesat','6z77+my');
	$db_selected = mysql_select_db('webcreativesatdb2', $db);
	
	
	$sql = "SELECT style_number FROM style WHERE active = 1 LIMIT 1";
	$result = mysql_query ($sql, $db);
	
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
		$ausgabe="kampagne=".urlencode($row['style_number']);
	}
	$sql = "SELECT * FROM game";
	$result = mysql_query ($sql, $db);
	
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
		$ausgabe.= '&'.$row['variable']."=".urlencode($row['wert']);
	}
	
        echo $ausgabe;
        mysql_close($db);
        



?>