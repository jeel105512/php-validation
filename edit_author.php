<?php
    require_once("./connect.php");

    $sql = "SELECT
        id, first_name, last_name, email, date_of_birth, profile
    FROM 
        authors
    WHERE id = :id";
    

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="./">Home</a></li>
            <li><a href="./new_author.php">New Author</a></li>
        </ul>
    </nav>

    <h1>Edit Authors</h1>

    <form action="./update_author.php" method="post">
        <input type="hidden" name="id" value="<?= $row->id ?>"> <!-- to update proper data using its id while making it hidden so that the user can not by mistake change it -->

        <div>
            <label for="first_name">First Name</label><br>
            <input type="text" name="first_name" value="<?= $row -> first_name ?>"> <!-- value="..." is to pre define (set the default data as) the data that we are editing so all the data do not changes -->
        </div>
        <div>
            <label for="last_name">Last Name</label><br>
            <input type="text" name="last_name" value="<?= $row -> last_name ?>">
        </div>
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" value="<?= $row -> email ?>">
        </div>
        <div>
            <label for="date_of_birth">Date Of Birth</label><br>
            <input type="date" name="date_of_birth" value="<?= $row -> date_of_birth ?>">
        </div>
        <div>
            <label for="profile">Profile</label><br>
            <input type="url" name="profile" value="<?= $row -> profile ?>">
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>