<?php
	$db = mysql_connect('localhost','root','');
	mysql_select_db('game_test', $db);
	

	mysql_query ("INSERT INTO player (name) VALUES ('".$_POST['username']."')");
	
	

	$result = mysql_query ("SELECT id FROM player WHERE name = '".$_POST['username']."' ORDER BY date DESC LIMIT 1");
	
	$string = "id=".urlencode(utf8_encode($result));
	
	echo $string;
	
	
	mysql_close($db);



?>