<?php
	$db = mysql_connect('mysqlsvr30.world4you.com','webcreativesat','6z77+my');
	$db_selected = mysql_select_db('webcreativesatdb2', $db);
        
        if(isset($_POST['username']) && isset($_POST['score'])){
                $sql = "INSERT INTO score (name, points) VALUES ('".$_POST['username']."', ".$_POST['score'].")";
		echo $sql;
                $result = mysql_query($sql, $db);   
	}
       
	mysql_close($db);



?>