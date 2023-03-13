<?php 

    try {
        // connection
        $dsn = "mysql:host=localhost;port=3308;dbname=comp_1006";

        $conn = new PDO($dsn, "root", ""); // new PDO($dsn, "userName", "password");
        // by default PDO does not have error handling turned on, to we will turn it on using attribute
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setAttribute(name of the attribute, value of the attribute), both are written as constants that are available on the PDO object
    } catch (PDOException $error) {
        echo $error->getMessage();
        $conn = false;
    }

?>