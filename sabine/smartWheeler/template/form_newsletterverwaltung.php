
<h3>Adressen verwalten:</h3>

<a href="index.php?page=administration&act=email&email=add">Neuer Kunde</a>

<?php
    if(isset($_GET['email']) && $_GET['email']=='add'){
  // neuer Eintrag
      echo '<h4>Email hinzuf&uuml;gen</h4>';

      echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?page=administration&act=email" id="add_email" >';
      echo '<table>';
      echo '<tr><th></th><th>Vorname</th><th>Nachname</th><th>Email</th><th>Newsletter</th></tr>';  
      echo '<tr><td></td><td><input type="text" name="vorname" /></td>';
      echo '<td><input type="text" name="nachname" /></td>';
      echo '<td><input type="text" name="email" /></td>';
      echo '<td><input type="checkbox" name="check_news" value="1" /></td></tr>';         

    echo '<tr><td><input type="submit" name="add_adressen" value="Save" /></td></tr>';

    echo '</table>';
    echo '</form>';
  }


/* Formular für Emails Bearbeiten -> kann nur ein Eintrag glecihzeitig bearbeitet werden */
if (isset($_POST['edit_adressen']) && isset($_POST['edit_newsletter'])) {
    echo '<form accept-charset="utf-8" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&act=email" id="edit_news" >';
    echo '<table>';
    echo '<tr><th></th><th>Vorname</th><th>Nachname</th><th>Email</th><th>Newsletter</th></tr>';
    $result = $C->select('newsletter', array('id' => $_POST['edit_newsletter'][0]), '', array('nachname', 'ASC'));
    while ($row = mysql_fetch_array($result)) {
        echo '<tr>';
        echo '<td><input type="hidden" name="id" value="' . $row['id'] . '" /></td>';
        echo '<td><input type="text" name="vorname" value="' . $row['vorname'] . '" /></td>';
        echo '<td><input type="text" name="nachname" value="' . $row['nachname'] . '" /></td>';
        echo '<td><input type="text" name="email" value="' . $row['email'] . '" /></td>';
        echo '<td><input type="checkbox" name="check_news" value="1"';
        if ($row['newsletter'] == 1) {
            echo 'checked="checked"';
        }
        echo ' /></td>';
        echo "</tr>";
    }
    echo '<tr><td><input type="submit" name="save_adressen" value="Save" /></td></tr>';

    echo '</table>';
    echo '</form>';

    // Emails aus DB laden
} else {
    echo '<form accept-charset="utf-8" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=administration&act=email" id="edit_news" >';
    echo '<table>';
    echo '<tr><th></th><th>Vorname</th><th>Nachname</th><th>Email</th><th>Newsletter</th></tr>';
    $result = $C->select('newsletter', '', '', array('nachname', 'ASC'));
    echo "result: ";
    var_dump($result);
    while ($row = mysql_fetch_array($result)) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="edit_newsletter[]" value="' . $row['id'] . '" /></td>';
        echo '<td>' . $row['vorname'] . '</td>';
        echo '<td>' . $row['nachname'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td><input type="checkbox" name="check_news"';
        if ($row['newsletter'] == 1) {
            echo 'checked="checked"';
        }
        echo ' /></td>';
        echo "</tr>";
    }
    echo '<tr><td><input type="submit" name="edit_adressen" value="Bearbeiten" /></td></tr>';
    echo '<tr><td><input type="submit" name="delete_adressen" value="Loeschen" /></td></tr>';

    echo '</table>';
    echo '</form>';
}
?>
