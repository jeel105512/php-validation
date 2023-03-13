<?php 

    // 1. Start the session
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    $_SESSION["form_fields"] = $_POST; // $_SESSION[key] = $_POST -> This has taken all the values that are in the post (key value pairs from the form) and it has popped it in the session 
        

    require_once("./connect.php");
    require_once("./helper_functions.php");

    /* Sanitize Values => Sanitizing data = Remove any illegal character from the data. */
    // sanitization refers to the process of removing or neutralizing any potentially harmful or unwanted characters, data, or code from user input or other data sources.
    
    // 2. Cast all values to secure string (raw string)
    foreach($_POST as $key => $value){ // $key => $value to get the field and value both
        $_POST[$key] = htmlspecialchars($value); // $_POST[field] = htmlspecialchars(value);
        // The htmlspecialchars() function converts some predefined characters to HTML entities
    }

    // 3. Sanitize email (force email to be properly formatted)
    $_POST["email"] = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // filter_var(value to sanitize, algorithm you want to run against it);

    // 4. Sanitize date using helper functions
    $_POST["date_of_birth"] = sanitize_date($_POST["date_of_birth"]);

    // 4.extra Sanitize first and last name
    foreach(["first_name", "last_name"] as $field){
        $_POST[$field] = sanitize_name($_POST[$field]);
    }

    /* Validate Values */
    // setup an array to store errors in
    $errors = [];
    // create an array of all the fields that ypu have in your form
    $fields = ["first_name", "last_name", "email", "date_of_birth", "profile"];

    /* Validating required fields */
    // 6. Iterate over the fields and verify if it's empty
    foreach($fields as $field){
        // skip non required fields
        if($field === "profile") continue;

        // replacing any _ with "" in the field names and uppercase the first characters (first_name -> First Name)
        $humanized_field = str_replace("_", " ", $field);
        $humanized_field = ucfirst($humanized_field);

        // if any field is empty, add an error of it being empty
        if(empty($_POST[$field])){
            $errors[]= "{$humanized_field} is required"; // or array_push()
        }
    }

    /* Validate Formate */
    // 7. validate date
    if(!validate_date($_POST["date_of_birth"])){
        $errors[]= "Your date of birth must be in YYYY-MM-DD formate";
    }

    // 8. validate email
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $errors[]= "Your email must be a valid email";
    }

    // 8.extra validate first and last name
    if(!validate_name($_POST["first_name"])){
        $errors[]= "Your first name must contain at least 2 characters and no numbers";
    }
    if(!validate_name($_POST["last_name"])){
        $errors[]= "Your last name must contain at least 2 characters and no numbers";
    }

    /* Failing validation */
    // 9. If there are errors
    if(count($errors) > 0){
        // 9.1 Set the notifications session variable
        $_SESSION["notifications"]["errors"] = $errors;

        // 9.2 Redirect back to the index page and exit
        header("Location: ./index.php");
        exit();
    }

    /* Business validation */
    // .
    // .
    // .

    /* Normalize Values => so that the all the data in our database is relatively the same*/
    // 10. normalize the first and last name
    // foreach(["first_name", "last_name"] as $field){
    //     $_POST[$filed] = ucwords(strtolower($_POST[$field])); // we are actually doing it in the sanitization...
    // }

    /* Writing the authors to the database */
    var_dump($_POST);

    $sql = "INSERT INTO authors (
        first_name,
        last_name,
        email,
        date_of_birth,
        profile
    ) VALUES (
        :first_name, -- : means creating bound parameter -> it's like a place holder, it basically says I am not giving you the value now but I will give you the value later
        :last_name,
        :email,
        :date_of_birth,
        :profile
    )";

    // 11. try/catch to get the errors
    try{
        $stmt = $conn->prepare($sql); // stmt -> statement
        $stmt->bindParam(":first_name", $_POST["first_name"], PDO::PARAM_STR); // PDO::PARAM_STR to cast the data into string
        $stmt->bindParam(":last_name", $_POST["last_name"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
        $stmt->bindParam(":date_of_birth", $_POST["date_of_birth"], PDO::PARAM_STR);
        $stmt->bindParam(":profile", $_POST["profile"], PDO::PARAM_STR);
        $stmt->execute();
    } catch(PDOException $error){
        $_SESSION["notifications"]["errors"][]= "There was an issue with attempting to add a new author";
        $_SESSION["notifications"]["errors"][] = $error->getMessage();
        
        header("Location: ./index.php");
        exit();
    }

    // 12. Add a success to the notifications and redirect to the index page
    $_SESSION["notifications"]["success"][]= "Author added successfully!";
    header("Location: ./index.php");

?>