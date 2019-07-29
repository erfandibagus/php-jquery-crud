<?php

include('config.php');

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'insert') {
        $query = "INSERT INTO users (first_name, last_name) VALUES ('" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "')";
        $statement = $connect->prepare($query);
        $statement->execute();
    }
    
    if ($_POST['action'] == 'user') {
        if (isset($_POST['id'])) {
            $query = "SELECT * FROM users WHERE id = '" . $_POST['id'] . "'";
            $statement = $connect->prepare($query);
            $statement->execute();
            $results = $statement->fetchObject();
            echo json_encode($results);
        }
    }

    if ($_POST['action'] == 'update') {
        $query = "UPDATE users SET  first_name = '" . $_POST['first_name'] . "', last_name = '" . $_POST['last_name'] . "' WHERE id = '" . $_POST['id'] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
    }

    if ($_POST['action'] == 'delete') {
        $query = "DELETE FROM users WHERE id = '" . $_POST['id'] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
    }
}
