<?php

/* KAMPAGNEN VERÄNDERN */
if (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] >= 2) {
    if (isset($_GET['style']) && $_GET['style'] > 0 && $_GET['style'] < 4) {  
        $C->update('style', array('active' => 0), null);
        $C->update('style', array('active' => 1), array('id' => $_GET['style']));
    }//ende kampagne in db speichern
}


/* Gültige Werte für $_GET['page'] */
$page = array('home', 'quads', 'about', 'contact', 'sitemap', 'impressum', 'agb');

#ADMIN LOGOUT
if (isset($_GET['logout'])) {
    $_SESSION['admin'] = 0;
    session_destroy();
}#ende admin-logout

#ADMIN LOGIN
if (isset($_POST['benutzer_name']) && isset($_POST['benutzer_pw'])) {
    $result = $C->select('admin', array('name' => $_POST['benutzer_name']), array('id', 'name', 'rights', 'password', 'timestamp', 'active'));
    $i = 0;
    $id = 0;
    $name = '';
    $rights = 0;
    $password = '';
    $tsp = 0;
    $active = null;
    while ($row = mysql_fetch_array($result)) {
        $i++;
        $id = $row['id'];
        $name = $row ['name'];
        $rights = $row['rights'];
        $password = $row['password'];
        $timestamp = $row['timestamp'];
        $active = $row['active'];
    }
    if ($i !== 1) {
        $fehler['admin_login'] = "Fehler! Bitte wenden Sie sich an den Systemadministrator!";
		$_GET['page'] = 'admin';
    } else {
        if ($active == 1 && $password == sha1(substr($timestamp, -10) . $_POST ['benutzer_pw'])) {
            $_SESSION['admin']['id'] = $id;
            $_SESSION['admin']['name'] = $name;
            $_SESSION['admin']['rights'] = $rights;
            $_SESSION['admin']['active'] = $active;
        } else {
            $_SESSION['fehler']['admin_login'] = "Zugangsdaten falsch!";
            header('Location: index.php?page=admin');
        }
    }
}#ende admin login
?>

<!DOCTYPE HTML>
<html><head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="keywords" content="Quads, Verkauf, Fahrzeug, Motorsport, 1030, Wien, &Ouml;sterreich, Austria, " />
        <meta name="description" content="smartWHEELER - Studentenprojekt SAE WIEN" />
		<link rel="shortcut icon" href="favicon.ico" />

        <link rel="stylesheet" type="text/css" href="skin/css/print.css" media="print"/>
        <?php
   
            ///Style einbinden
            $style = 'style';
			$plugins = 'plugins';
			$script = 'script';
			
            if (!isset($_SESSION['admin']['rights']) || $_SESSION['admin']['rights'] < 1) {
                $result = $C->select('style', array('active' => 1), array('css', 'plugins', 'script'), 'id', 1);
                if ($result) {
                    while ($row = mysql_fetch_array($result)) {
                        $style = $row['css'];
                        $plugins = $row['plugins'];
						$script = $row['script'];
					}
                } #ende style einbinden
            }
            ?>
            <link rel="stylesheet" type="text/css" href="skin/css/<?php echo $style; ?>.css" media="screen" />
            
            <script type="text/javascript">
			    var rte = <?php if ($_SESSION['admin']['rights'] > 0 && isset($_GET['act']) && ($_GET['act'] == 'news' /*|| $_GET['act'] == 'newsletter'*/)) {  echo 1; } else { echo 0; } ?>;
                var cms = <?php if(isset($_SESSION['rights']) && ($_SESSION['rights'] > 0)){ echo 1; }else{ echo 0; }?>;
            </script>

 
 
            
            <!-- JQUERY -->
            <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js" ></script>

			<!-- JQUERY UI - tabs -->           
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script> 

			<!-- AW-SHOWCASE-->
            <script type="text/javascript" src="plugins/circle.js"></script>
                     

            
            <!-- multible fileupload -->
            <script src="plugins/multifile_compressed.js"></script>
            
            
            <!-- QUICKSEARCH -->

            
            <!-- FANCYBOX -->
            <script type="text/javascript" src="plugins/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
            <script type="text/javascript" src="plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
            <link rel="stylesheet" type="text/css" href="plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />           
            <script type="text/javascript" src="plugins/fancybox/jquery.easing-1.3.pack.js"></script>
            
            <!-- Formularvalidierung -->
            <script type="text/javascript" src="http://livevalidation.com/javascripts/src/1.3/livevalidation_standalone.compressed.js" ></script>

            <!-- Tiny MCE -->
            <script type="text/javascript" src="plugins/tiny_mce/tiny_mce.js"></script>
            
               
               
               
        
            
            <script type="text/javascript" src="skin/js/<?php echo $script; ?>.js"></script>
            <script type="text/javascript" src="skin/js/<?php echo $plugins; ?>.js"></script>

        <title>smartWHEELER</title>
        
    </head>
    
    <body>
        <div id="header_style">
            <div id="footer_style">
                <div id="wrapper">
                    <header>   
                        <h1 id="logo"><a href="index.php?page=home">smartWHEELER</a></h1>

                        <div id="bg_style">
                        </div>
                        
                        <div id="nav_div">
                            <nav id="main_nav">
                                <ul>
                                    <li><a href="index.php?page=home" <?php if (isset($_GET['page']) && $_GET['page'] == 'home') {
                                        echo 'class="active_main_nav"'; } ?> >HOME</a></li>
                                    <li><a href="index.php?page=quads" <?php if (isset($_GET['page']) && $_GET['page'] == 'quads') {
                                        echo 'class="active_main_nav"'; } ?> >QUADS</a></li>
                                    <li><a href="index.php?page=about" <?php if (isset($_GET['page']) && $_GET['page'] == 'about') {
                                        echo 'class="active_main_nav"'; } ?> >ABOUT</a></li>
                                    <li><a href="index.php?page=contact" <?php if (isset($_GET['page']) && $_GET['page'] == 'contact') {
                                        echo 'class="active_main_nav"'; } ?> >CONTACT</a></li>
                                </ul>
                            </nav>
                            
                            <?php
							if (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] > 0) {  //Submenü wenn Admin eingelogged
								echo '<nav id="admin_nav"><ul>';
								if ($_SESSION['admin']['rights'] == 3) { ?>
									<li><a href="index.php?page=administration&amp;act=admins" <?php if (isset($_GET['act']) && $_GET['act'] == 'admins') {
                                        echo 'class="active_main_nav"'; } ?> >Admins</a></li>
								<?php }
								if ($_SESSION['admin']['rights'] >= 2) { ?>
									<li><a href="index.php?page=administration&amp;act=style" <?php if (isset($_GET['act']) && $_GET['act'] == 'style') {
                                        echo 'class="active_main_nav"'; } ?> >Kampagnen</a></li>
								<?php } ?>
								<li><a href="index.php?page=administration&amp;act=news" <?php if (isset($_GET['act']) && $_GET['act'] == 'news') {
                                        echo 'class="active_main_nav"'; } ?> >News</a></li>
								<li><a href="index.php?page=administration&amp;act=models" <?php if (isset($_GET['act']) && $_GET['act'] == 'models') {
                                        echo 'class="active_main_nav"'; } ?> >Quads</a></li>
								<li><a href="index.php?page=administration&amp;act=newsletter" <?php if (isset($_GET['act']) && $_GET['act'] == 'newsletter') {
                                        echo 'class="active_main_nav"'; } ?> >Newsletter</a></li>
								<?php if ($_SESSION['admin']['rights'] >= 2) { ?>
									<li><a href="index.php?page=administration&amp;act=email" <?php if (isset($_GET['act']) && $_GET['act'] == 'email') {
                                        echo 'class="active_main_nav"'; } ?> >Kundendaten</a></li>
								<?php } ?>
								<li><a href="index.php?logout" id="logout">Logout</a></li>	
							<?php 
								echo '</ul></nav>';
							} ?>             
						</div>
                        
                        <img src="skin/img/green/quad_header3.png" alt="quad" id="quad_pic" />
                    </header>
                     
                    <div id="content" class="clear">
                        <?php  #Templates entsprechend den menüpunkten laden
                        if (isset($_GET['page']) && ( (array_search($_GET['page'], $page))
                                || ($_GET['page'] == 'admin')
                                || (($_GET['page'] == 'administration') && (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] > 0)))
                           ) { include('template/' . $_GET['page'] . '.php');
                        } else { include ('template/home.php'); 
                        }#ende templates
                        ?>
                    </div>
                     
                    <footer class="clear">
                    	<div id="content_footer">
                            <div id="footer_div">
                                <div id="footer_style01">
                                </div>
                                <div id="footer_style02">
                                </div>
    
                            </div>                        
                            <p>&copy; Copyright smartWHEELER;  
                                Dies ist ein Studentenprojekt an der SAE WIEN. Die Inhalte und Texte sind erfunden. Der Autor &uuml;bernimmt keine Haftung.
                            </p>
                        </div>
                  </footer>
                </div>
            </div>
        </div>
        

    </body>
</html>
<script type="text/javascript" src="plugins/quicksearch/jquery.quicksearch.js"></script>
<script type="text/javascript">
	if($('.fileupload').length > 0){
		var multi_selector = new MultiSelector( document.getElementById( 'datei_list' ), 8 );       
		multi_selector.addElement( document.getElementById( 'datei' ) );
	}
	
	

</script>

