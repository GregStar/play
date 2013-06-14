<?php
if (isset($_GET['page']) && $_GET['page'] == 'about') {
    $title = 'about Elements';
    $content = 'content/c_about.php';
    $active2 = "active";
} elseif (isset($_GET['page']) && $_GET['page'] == 'credits') {
    $title = 'credits';
    $content = 'content/c_credits.php';
    $active4 = "active";
} else {
    $title = 'home';
    $content = 'content/c_home.php';
    $active1 = "active";
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="keywords" content="Elements, WebGL, Three.js, Feuer, Wasser, Erde, Metall, Luft, Projekt, Demo" />
        <meta name="description" content="Elements: an interactive Musicvideo with WebGL" />
        <title>Elements: an animated Musicvideo with WebGL</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="css/js-image-slider.css" media="screen" />
    </head>

    <body>

        <div id="enterMenu" class="show">
            <?php
            include ($content);
            ?>
        </div>
        <div id="loading" class="hide"><p>Loading</p></div>
        <nav id="infoMenu" class="show">
            <ul>
                <li><a href="index.php?page=home" class="<?php echo $active1; ?>">home</a></li>
                <li><a href="index.php?page=about" class="<?php echo $active2; ?>">about</a></li>
                <li><a href="index.php?page=credits" class="<?php echo $active4; ?>">credits</a></li>
            </ul>
        </nav>

        <ol id="soundMenu" class="hide">
            <li id="0">Track 1</li>
            <li id="1">Track 2</li>
            <li id="2">Track 3</li>
        </ol>

        <div id="trans">
            <nav id="worldMenu" class="hide">
                <ul id="menuUL">
                    <li class="0"><div id="home">Home</div></li>
                    <li class="1"><div id="feuer">Feuer</div></li>
                    <li class="2"><div id="wasser">Wasser</div></li>
                    <li class="3"><div id="erde">Erde</div></li>
                </ul>
            </nav>
        </div>
        <nav id="bridgeMenu" class="hide">
            <ul>
                <li id="bridgeLeft">
                    <div id="feuerBridge" class="1">Link1</div>
                </li>
                <li id="bridgeRight">
                    <div id="erdeBridge" class="3">Link2</div>
                </li> 
            </ul>

            <script type="text/javascript" src="js/Three.js"></script>

            <script type="text/javascript" src="js/ShaderExtras.js"></script>

            <script type="text/javascript" src="js/postprocessing/EffectComposer.js"></script>
            <script type="text/javascript" src="js/postprocessing/MaskPass.js"></script>
            <script type="text/javascript" src="js/postprocessing/RenderPass.js"></script>
            <script type="text/javascript" src="js/postprocessing/ShaderPass.js"></script>
            <script type="text/javascript" src="js/postprocessing/BloomPass.js"></script>
            <script type="text/javascript" src="js/Detector.js"></script>

            <?php if (!isset($_GET['page']) || $_GET['page'] == 'home') { ?>
                <script type="text/javascript" src="js/Elements.js"></script>
            <?php } ?>
            <script src="js/js-image-slider.js" type="text/javascript"></script>


        </nav>
    </body>
</html>
