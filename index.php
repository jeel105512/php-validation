<?php

    $sql = "SELECT
        id, first_name, last_name, email, date_of_birth, profile
    FROM 
        authors";
    
    require_once("./connect.php");

    $rows = []; // to protect us, meaning if the connection fails we still at least have an empty variable of rows(empty array)
    if($conn){
        // $rows = $conn->query($sql)->fetchAll();
        //or
        $result = $conn->query($sql);
        $rows = $result->fetchAll(PDO::FETCH_OBJ); // PDO::FEtCH_OBJ to make sure that it returns the data as an object

    }

    // /* Repopulate the fields */
    // // 2. Start the session if you haven't already
    // if(session_status() === PHP_SESSION_NONE) session_start();

    // // 3. Assign the form fields
    // $form_fields = $_SESSION["form_fields"];

    // // 4. Unset the form field session variable (this way if they refresh, the values don't persist)
    // unset($_SESSION["form_fields"]);

    // // 5. Update the form with prefilled values if they exist

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD & Review(Authors)</title>
</head>
<body>
    <header>
        <!-- 1. Include your notification logic -->
        <?php require_once("./notification.php") ?>
    </header>
    <nav>
        <ul>
            <li><a href="./">Home</a></li>
            <li><a href="./new_author.php">New Author</a></li>
        </ul>
    </nav>

    <h1>Authors</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Date Of Birth</th>
                <th>Profile URL</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($rows as $row): ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->first_name ?></td>
                    <td><?= $row->last_name ?></td>
                    <td><?= $row->email ?></td>
                    <td><?= $row->date_of_birth ?></td>
                    <td><?= $row->profile ?></td>
                    <td>
                        <a href="./edit_author.php?id=<?= $row->id ?>">edit</a>
                        <a href="./delete_author.php?id=<?= $row->id ?>" onclick="return confirm('Are you absolutely sure you want to delete this  because that will be after the point of not return and you can never get this data back again.')">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>