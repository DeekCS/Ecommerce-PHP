<?php
include '../connection.php';

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <div>
        <h1>Website Title</h1>
        <a href="../index.php"><i class="fas fa-home"></i>Home</a>
        <a href="../crud/read.php"><i class="fas fa-address-book"></i>Contacts</a>
        <a href="../register.php"><i class="fas fa-register"></i>Register</a>
    </div>
</nav>
<div class="content delete">
    <h2>Delete Contact #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Are you sure you want to delete contact #<?=$contact['id']?>?</p>
        <div class="yesno">
            <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Yes</a>
            <a href="delete.php?id=<?=$contact['id']?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
