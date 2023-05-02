<?php include "../conn/session.php" ?>
<?php
if ($_SESSION['user_role'] != "Reader") {
    header('Location: ../view/403.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../conn/connection.php" ?>
    <?php include "../links/link.php" ?>
    <style>
        <?php include "../public/css/custom.css" ?>
    </style>

    <title>reader view</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid fw-bold">
            <a class="navbar-brand fw-bold" href="#">E-LIBRARY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="reader.view.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="wishlist.view.php">wishlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="mybook.view.php">my books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="">History</a>
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown me-lg-4">
                    <li class="text-align-center mt-2 align-items-center"><?php include "../controller/profile.con.php" ?></li>
                    <li><a class="dropdown-item " href="../controller/auth/logout.php"><button class="btn btn-primary text-align-center d-flex me-6">Logout</button></a></li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row justify-content-start mt-4">
            <div class="col-lg-10 col-md-10 mt-4 me-4">
                <div class="col-lg-10 col-md-8 mt-4">
                <?php
                include "../conn/connection.php";
                $user_email = $_SESSION['user_email'];
                $view = isset($_GET['view']) ? $_GET['view'] : 'month';

                if ($view == 'month') {
                    $sql = "SELECT COUNT(*) as count, MONTH(issue_date) as month, book_name,issue_date
                            FROM issue_book 
                            WHERE user_email = '$user_email' 
                            GROUP BY MONTH(issue_date), book_name";
                } else {
                    $sql = "SELECT COUNT(*) as count, WEEK(issue_date) as week, book_name,issue_date
                            FROM issue_book 
                            WHERE user_email = '$user_email' 
                            GROUP BY WEEK(issue_date), book_name";
                }

                $result = mysqli_query($con, $sql);
                $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                
            ?>
                    <div class="card text-white bg-primary mb-3 w-100 h-100 mx-4">
                        <div class="card-header text-center">
                            <i class="fa fa-sharp fa-light fa-book fa-flip fa-xl mt-3"></i> Book Count
                            <div class="btn-group float-end">
                                <a class="btn btn-secondary <?php echo $view == 'month' ? 'active' : ''; ?>" href="?view=month">Month</a>
                                <a class="btn btn-secondary <?php echo $view == 'week' ? 'active' : ''; ?>" href="?view=week">Week</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($view == 'month') : ?>
                                <h5 class="card-title text-center fw-bold">Month-wise Reading</h5>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Book Name</th>
                                            <th>Book Count</th>
                                            <th>Read Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $row) : ?>
                                            <tr>
                                                <td><?php echo date('F', mktime(0, 0, 0, $row['month'], 1)); ?></td>
                                                <td><?php echo $row['book_name']; ?></td>
                                                <td><?php echo $row['count']; ?></td>
                                                <td><?php echo $row['issue_date']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <h5 class="card-title text-center fw-bold">Week-wise Reading</h5>
                                <!-- <div style="height: 300px; overflow: scroll;"> -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Book Name</th>
                                            <th>Book Count</th>
                                            <th>Read Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $row) : ?>
                                            <tr>
                                                <td>Week <?php echo $row['week']; ?></td>
                                                <td><?php echo $row['book_name']; ?></td>
                                                <td><?php echo $row['count']; ?></td>
                                                <td><?php echo $row['issue_date']; ?></td>
                                            <?php endforeach; ?>
                                            </tr>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>








</body>

</html>