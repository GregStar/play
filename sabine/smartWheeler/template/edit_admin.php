<?php
if (isset($_SESSION['admin']['rights']) && $_SESSION['admin']['rights'] == 3) {
    //ADMIN HINZUFUEGEN
    if (isset($_GET['change']) && $_GET['change'] == "newadmin") {
        if (isset($_POST['newadmin_save']) && $_POST['newadmin_save'] == "save") {
            $_SESSION['fehler']['newadmin_name'] = '';
            $_SESSION['fehler']['newadmin_rights'] = '';
            $_SESSION['fehler']['newadmin_pw'] = '';
            $fehler = 0;

            if (!isset($_POST['newadmin_name']) || (isset($_POST['newadmin_name']) && !check_name($_POST['newadmin_name']))) {
                $_SESSION['fehler']['newadmin_name'] = "Name ungültig";
                $fehler++;
            } else {
                $result = $C->select('admin', array('name' => $_POST['newadmin_name']), array('name'), '', 1);
                while ($row = mysql_fetch_array($result)) {
                    if ($row['name'] != '') {
                        $_SESSION['fehler']['newadmin_name'] = "Name bereits vergeben";
                        $fehler++;
                    }
                }
            }

            if (!isset($_POST['newadmin_rights']) || (isset($_POST['newadmin_rights']) && (!check_rights($_POST['newadmin_rights'])))) {
                $_SESSION['fehler']['newadmin_rights'] = "Rechte ungültig";
                $fehler++;
            }

            if (isset($_POST['newadmin_active'])) {
                $active = 1;
            } else {
                $active = 0;
            }




            if ($fehler == 0) {
                $C->insert('admin', array('name' => $_POST['newadmin_name'], 'rights' => $_POST['newadmin_rights'], 'active' => $active));
                $result = $C->select('admin', array('name' => $_POST['newadmin_name']), array('timestamp'), '', 1);
                while ($row = mysql_fetch_array($result)) {
                    $C->update('admin', array('password' => sha1(substr($row['timestamp'], -10) . $_POST ['newadmin_pw'])), array('name' => $_POST['newadmin_name']));
                }
            }
        }
    }
}
?>
