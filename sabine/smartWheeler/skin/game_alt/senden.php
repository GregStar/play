<?php
        $db = mysql_connect('localhost','root','');
	$db_selected = mysql_select_db('wheeler', $db);
        
        if(isset($_POST['username']) && isset($_POST['score'])){
                $sql = "INSERT INTO score (name, points) VALUES ('".$_POST['username']."', ".$_POST['score'].")";
		echo $sql;
                $result = mysql_query($sql, $db);   
	}
       
	mysql_close($db);



?>