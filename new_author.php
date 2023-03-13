<?php

    /* Repopulate the fields */
    // 2. Start the session if you haven't already
    if(session_status() === PHP_SESSION_NONE) session_start();

    // 3. Assign the form fields
    $form_fields = $_SESSION["form_fields"];

    // 4. Unset the form field session variable (this way if they refresh, the values don't persist)
    unset($_SESSION["form_fields"]);

    // 5. Update the form with prefilled values if they exist

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Author</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="./">Home</a></li>
            <li><a href="./new_author.php">New Author</a></li>
        </ul>
    </nav>

    <h1>New Authors</h1>

    <form action="./create_author.php" method="post" novalidate> <!-- ./create_author.php is the logic or place where the new field will get created -->
        <div>
            <label for="first_name">First Name</label><br>
            <input type="text" name="first_name" value="<?= $form_fields["first_name"] ?? "" ?>">
        </div>
        <div>
            <label for="last_name">Last Name</label><br>
            <input type="text" name="last_name" value="<?= $form_fields["last_name"] ?? "" ?>">
        </div>
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" value="<?= $form_fields["email"] ?? "" ?>">
        </div>
        <div>
            <label for="date_of_birth">Date Of Birth</label><br>
            <input type="date" name="date_of_birth" value="<?= $form_fields["date_of_birth"] ?? "" ?>">
        </div>
        <div>
            <label for="profile">Profile</label><br>
            <input type="url" name="profile" value="<?= $form_fields["profile"] ?? "" ?>">
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>