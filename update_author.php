<?php

    require_once("./connect.php");

    $sql = "UPDATE authors SET
        first_name = :first_name,
        last_name = :last_name,
        email = :email,
        date_of_birth = :date_of_birth,
        profile = :profile
    WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":first_name", $_POST["first_name"], PDO::PARAM_STR); // PDO::PARAM_STR to cast the data into string
    $stmt->bindParam(":last_name", $_POST["last_name"], PDO::PARAM_STR);
    $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
    $stmt->bindParam(":date_of_birth", $_POST["date_of_birth"], PDO::PARAM_STR);
    $stmt->bindParam(":profile", $_POST["profile"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
    $stmt->execute();

    header("Location: ./index.php");

?>