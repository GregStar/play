<?php
// EINTRAG NEWS löschen
    if (isset($_POST['news_loeschen'])) {
        //für alle ausgewählten Bilder
        foreach ($_POST['delete'] as $value) {
            $C->delete('news', array('id' => $value));
            //URL aus DB wählen und aus dem Verzeichnis löschen
            $result = $C->select('pictures', array('news_id' => $value), array('url_thumb', 'url_pic'));
            while ($row = mysql_fetch_array($result)) {
                unlink($row['url_thumb']);
                unlink($row['url_pic']);
            }
            //Eintrag aus DB löschen
            $result = $C->delete('pictures', array('news_id' => $value));
        }
    }//ende eintrag löschen
    //EINTRAG HINZUFUEGEN
    if (isset($_POST['add_news'])) {
        $fehler = null;
        $eingabe = null;
        // eintrag speichern
        if (count($_POST) > 1) {
            // Fehler setzten
            if (isset($_POST['titel']) && $_POST['titel'] != '') {
                $eingabe['titel'] = $_POST['titel'];
            } else {
                $fehler['titel'] = 'Titel eingeben!';
            }
            if (isset($_POST['shorttext']) && $_POST['shorttext'] != '') {
                $eingabe['shorttext'] = $_POST['shorttext'];
            } else {
                $fehler['shorttext'] = 'Einleitung eingeben!';
            }
            if (isset($_POST['longtext']) && $_POST['longtext'] != '') {
                $eingabe['longtext'] = $_POST['longtext'];
            } else {
                $fehler['longtext'] = 'Text eingeben!';
            }

            if (isset($_POST['event'])) {
                $event = 1;
            } else {
                $event = 0;
            }

            // keine Fehler -> speichern    
            if (!isset($fehler) || count($fehler) <= 0) {
                $C->insert('news', array('titel' => ($_POST['titel']), 'short_text' => $_POST['shorttext'], 'long_text' => $_POST['longtext'], 'event' => $event));

                // Fileupload news

                foreach ($_FILES as $key => $value) {
                    if ($_FILES[$key]['error'] == 0) {
                        $filename = explode('.', $_FILES[$key]['name']);

                        move_uploaded_file($_FILES[$key]['tmp_name'], 'news_pics/pics/' . $_FILES[$key]['name']);
                        copy('news_pics/pics/' . $_FILES[$key]['name'], 'news_pics/thumbs/' . $_FILES[$key]['name']);

                        //id aus db auslesen
                        $result = $C->select('news', '', array('id'), array('tsp', 'DESC'), 1);
                        while ($row = mysql_fetch_array($result)) {
                            //in DB eintragen
                            echo '<br />ID: ' . $row['id'];
                            $C->insert('pictures', array('news_id' => $row['id'], 'url_thumb' => 'news_pics/thumbs/' . $_FILES[$key]['name'], 'url_pic' => 'news_pics/pics/' . $_FILES[$key]['name'], 'alt' => $filename[0], 'title' => $filename[0]));
                        }
                    }
                }//ende fileupload news

                $fehler = null;
                $eingabe = null;
            }
        }
    }//ende eintag hinzufuegen
?>
<h3>NEWSBEREICH</h3>         
    <?php
    // neuer Eintrag
    echo '<h4><a href="index.php?page=administration&act=news&news=add">Eintrag hinzuf&uuml;gen</a></h4>';

    if (isset($_GET['news']) && $_GET['news'] == 'add') {
        echo '<div>';
        echo '<form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&act=news" id="form_upload" onsubmit="return checkUpload(); >';
        echo '<ul>';
        //echo '<input type="hidden" name="modell" id="modell" value="'.$_SESSION['modell'].'" /></li>';
        echo '<li><label for="titel"><span class="label">Titel:</span><input type="text" name="titel" ';
        if (isset($eingabe['titel']) && $eingabe['titel'] != '') {
            echo 'value="' . $eingabe['titel'] . '"';
        }
        echo '/>';
        if (isset($fehler['titel']) && $fehler['titel'] != '') {
            echo '<span class="fehler">' . $fehler['titel'] . '</span>';
        }
        echo '</label></li>';
        echo '<li><label for="shorttext"><span class="label">Einleitung:</span><textarea name="shorttext" >';
        if (isset($eingabe['shorttext']) && $eingabe['shorttext'] != '') {
            echo $eingabe['shorttext'];
        }
        echo '</textarea>';
        if (isset($fehler['shorttext']) && $fehler['shorttext'] != '') {
            echo '<span class="fehler">' . $fehler['shorttext'] . '</span>';
        }
        echo '</label></li>';
        echo '<li><label for="longtext"><span class="label">Text:</span><textarea name="longtext">';
        if (isset($eingabe['longtext']) && $eingabe['longtext'] != '') {
            echo $eingabe['longtext'];
        }
        echo '</textarea>';
        if (isset($fehler['longtext']) && $fehler['longtext'] != '') {
            echo '<span class="fehler">' . $fehler['longtext'] . '</span>';
        }
        echo '</label></li>';
        echo '<li><label for="img"><span class="label">Bild:</span><input type="file" name="img" id="add_img" /></label></li>';
        echo '<div id="datei_list_news"></div>';
        echo '<li><label for="event"><span class="label">Event:<input type="checkbox" name="event" value="1" /></span></li>';
        echo '<li><label for="newsletter"><span class="label">Als Newsletter verschicken:<input type="checkbox" name="newsletter" value="1" /></span></li>';
        echo '<li><input type="submit" name="add_news" value="Eintrag speichern" /></li>';
        echo '<ul>';
        echo '</form>';
        echo '</div>';
    }


    // Artikel in Formular laden
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&act=news" id="edit_news" >';
    echo '<ul>';
    $aktuelles = $C->select('news', '', '', array('tsp', 'DESC'));
    while ($row = mysql_fetch_array($aktuelles)) {
        $time = explode(' ', $row['tsp']);
        echo '<li>';
        echo '<input type="checkbox" name="delete[]" value="' . $row['id'] . '" />';
        echo '<article>';
        echo '<h3>' . $row['titel'] . '</h3>';
        echo '<time>' . $time[0] . '</time>';
        echo '<p class="bold">' . $row['short_text'] . '</p>';
        echo '</article>';
        echo '<input type="submit" name="edit' . $row['id'] . '" value="Editieren" />';
        echo '</li>';
    }
    echo '<li><input type="submit" name="news_loeschen" value="L&ouml;schen" /></li>';
    echo '</ul>';
    echo '</form>';
?>