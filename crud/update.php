<?php

include '../connection.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";
    header('location: ../login.php');
}

$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $name, $email, $phone, $title, $created, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}

?>

<?php include '../CoolAdmin/layout/header.php'; ?>



<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="title-1 m-b-25">Update Contact #<?=$contact['id']?></h2>
                    <div class=" table--no-card ">
                        <table class="table table-borderless table-striped table-earning" action="update.php?id=<?=$contact['id']?>" method="post">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Update</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id"></td>
                                <td><input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name"></td>
                                <td>        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$contact['email']?>" id="email"></td>
                                <td><input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone"></td>
                                <td><input type="text" name="title" placeholder="Employee" value="<?=$contact['title']?>" id="title"></td>
                                <td>        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
                                </td>
                                <td>        <input type="submit" value="Update">
                                </td>

                            </tr>
                            </tbody>
                    </div>
                    <?php if ($msg): ?>
                        <p><?=$msg?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

