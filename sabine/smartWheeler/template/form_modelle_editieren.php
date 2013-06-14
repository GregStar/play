<h3>Modelle bearbeiten:</h3>
<p>Modell ausw&auml;hlen:</p>

<?php
    $modelle = $C->select('modelle', '', '', array('tsp', 'ASC'));
    while ($row = mysql_fetch_array($modelle)) {
        echo '<a href="?page=administration&act=models&modell=' . $row['id'] . '" id="' . $row['name'] . '">' . $row['name'] . '</a>';
    }

    if (isset($_GET['modell'])) {
        $_SESSION['modell'] = $_GET['modell'];
    }

    if (isset($_SESSION['modell'])) {
        echo '<h4>Gallery</h4>';

        echo '<form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&act=models" id="form_upload" onsubmit="return checkUpload(); >';
        echo '<ul>';
        echo '<li><input type="hidden" name="modell" id="modell" value="' . $_SESSION['modell'] . '" /></li>';
        echo '<li><label for="datei"><span class="label">Datei:</span><input type="file" name="add[]" id="add_datei" /></label></li>';
        echo '<div id="datei_list"></div>';
        echo '<li><input type="submit" name="bilder_upload" value="Bilder hinzufuegen" /></li>';
        echo '<ul>';
        echo '</form>';

        $bilder = $C->select('gallery', array('modell' => $_SESSION['modell']), '', array('tsp', 'ASC'));
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&act=models" id="form_download" onsubmit="return checkConfirm();">';
        echo '<ul>';
        while ($row = mysql_fetch_array($bilder)) {
            echo '<li>';
            echo '<input type="checkbox" name="delete[]" value="' . $row['id'] . '" />';
            echo '<img src="' . $row['url_thumb'] . '" alt="' . $row['alt'] . '" title="' . $row['title'] . '"/>';
            echo '</li>';
        }

        echo '<li><input type="submit" name="bilder_loeschen" value="L&ouml;schen" /></li>';
        echo '<ul>';
        echo '</form>';
    }
?>