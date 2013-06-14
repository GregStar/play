<?php
	// $db = mysql_connect('localhost','root','');
	// mysql_select_db('game_test', $db);
	
	$db = mysql_connect('mysqlsvr30.world4you.com','webcreativesat','6z77+my');
	mysql_select_db('webcreativesatdb2', $db);

	mysql_query ("INSERT INTO score (name) VALUES ('".$_POST['username']."')");
	
	

	$result = mysql_query ("SELECT id FROM score WHERE name = '".$_POST['username']."' ORDER BY date DESC LIMIT 1");
	
	$string = "id=".urlencode(utf8_encode($result));
	
	echo $string;
	
	
	mysql_close($db);



?>