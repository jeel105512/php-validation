<?php

    // 1. Start the session if its isn't running
    if(session_status() === PHP_SESSION_NONE) session_start();

    // 2. Set an empty array to store the notifications
    $notifications = [];

    // 3. Assign the notifications if there are any to the notifications array
    if(isset($_SESSION["notifications"])){
        $notifications = $_SESSION["notifications"];
        // 4. Clear the session notifications by unsetting the notifications session variable (not the one you created in step 2)
        unset($_SESSION["notifications"]);
    }

?>

<!-- 5. Loop over the notifications extracting the Type and the block of Messages -->
<?php foreach($notifications as $type => $messages): ?> <!-- in this case $type -> errors and $messages -> array of errors -->
    <!-- 5.2 Output each messages -->
    <div class="notification <?= $type ?>">
        <?php foreach($messages as $message): ?>
            <p><?= $message ?></p>
        <?php endforeach ?>
    </div>
<?php endforeach ?>