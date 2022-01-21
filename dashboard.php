<?php
include '../connection.php';

if (($_SESSION['isAdmin']) != 1) {
    $_SESSION['msg'] = "You must log in first";
    echo "<script>alert('You must log in first');</script>";

    header('location: ../login.php');
}

// Connect to MySQL database

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
//get all users from database
$sql = $pdo->prepare('SELECT * FROM users ORDER BY id');
$sql->execute();
$users = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ../../login.php");
}
?>
<?php include './layout/header.php'; ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">overview</h2>
                                    <a href="../crud/create.php" class="au-btn au-btn-icon au-btn--blue">
                                        <i class="zmdi zmdi-plus"></i>add member</a>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2> <?php
                                                    $stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id DESC');
                                                    $num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
                                                    $stmt->execute();
                                                    $num_contacts = $stmt->rowCount();
                                                    echo $num_contacts;
                                                    ?></h2>
                                                <span>Number Of Contacts</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2> <?php
                                                    $stmt = $pdo->prepare('SELECT * FROM users ORDER BY id DESC');
                                                    $num_contacts = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
                                                    $stmt->execute();
                                                    $num_contacts = $stmt->rowCount();
                                                    echo $num_contacts;
                                                    ?></h2>
                                                <span>Number Of Members</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart2"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-calendar-note"></i>
                                            </div>
                                            <div class="text">
                                                <h2>1,086</h2>
                                                <span>this week</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$1,060,386</h2>
                                                <span>total earnings</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="widgetChart4"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">Read Contacts</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th class="text-right">Title</th>
                                                <th class="text-right">Created</th>
                                                <th class="text-right">Edit/Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($contacts as $contact): ?>
                                            <tr>
                                                <td><?=$contact['id']?></td>
                                                <td><?=$contact['name']?></td>
                                                <td><?=$contact['email']?></td>
                                                <td><?=$contact['title']?></td>
                                                <td><?=$contact['created']?></td>
                                                <td class="actions">
                                                    <a href="../crud/update.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="../crud/delete.php?id=<?=$contact['id']?>" class="trash text-danger"><i class="fas fa-trash "></i></a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a href="../crud/read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
                                <?php endif; ?>
                                <?php if ($page*$records_per_page < $num_contacts): ?>
                                    <a href="../crud/read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
                                <?php endif; ?>
                            </div>

                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">All Users</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">

                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th class="text-right">Date Of Birth</th>
                                            <th class="text-right">Age</th>"
                                            <th class="text-right">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($users as $user): ?>
                                            <tr>
                                                <td><?=$user['id']?></td>
                                                <td><?=$user['username']?></td>
                                                <td><?=$user['email']?></td>
                                                <td><?=$user['date_of_birth']?></td>
                                                <td><?=$user['age']?></td>
                                                <td class="text-right"><?php if ($user['isAdmin'] == 1): ?>
                                                        <span class="badge badge-success">Admin</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">User</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>



<!-- end document-->
<?php include './layout/footer.php'; ?>

