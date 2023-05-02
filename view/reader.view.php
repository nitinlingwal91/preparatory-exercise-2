<?php include "../conn/session.php" ?>
<?php 
if($_SESSION['user_role'] != "Reader") {
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
    <script src="https://kit.fontawesome.com/2945ccc037.js" crossorigin="anonymous"></script>

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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="wishlist.view.php">wishlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="mybook.view.php">my books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="history.view.php">History</a>
                    </li>

                    <li class="d-flex align-items-center ms-lg-4">
                        <form class="d-flex" method="GET">
                            <input class="form-control me-2" name="search_query" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary" name="submit_search" type="submit">Search</button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown me-lg-4">
                    <li class="text-align-center mt-2 align-items-center"><?php include "../controller/profile.con.php"?></li>
                    <li><a class="dropdown-item " href="../controller/auth/logout.php"><button class="btn btn-primary text-align-center d-flex me-6">Logout</button></a></li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row align-items-center mb-4 mt-4">
            <div class="col-md-8 d-flex flex-column align-items-center align-items-md-start fw-bold">
                <h2>Welcome to E-Library</h2>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <?php
                $sql = "SELECT id, book_name, author_name, book_id FROM create_book ";
                $sql_run = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($sql_run);
                ?>

                <div class="col-md-8 d-flex justify-content-end">
                <button class="btn btn-primary  " onclick="location.href='../view/issuebookform.view.php';">Book Request</button>
                </div>
            </div>
        </div>
        <form action="" method="GET">
            <div class="input-group mb-3">
                <select name="sort_alphabet" class="input_group_text">
                    <option value="">--select option</option>
                    <option value="a-z" <?php if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == "a-z") {
                                            echo "selected";
                                        } ?>>A-Z (Ascending order)</option>
                    <option value="z-a" <?php if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == "z-a") {
                                            echo "selected";
                                        } ?>>Z-A (Descending order)</option>
                </select>
                <button type="submit" class="input-group-text" id="basic-addon2">Sort</button>
            </div>
        </form>
    </div>

    <main>

        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3" id="bookList">
              

                <?php include "../controller/reader.con.php" ?>
            </div>
        </div>

    </main>

    <ul class="pagination d-flex justify-content-center ">
        <?php

        if ($total_pages > 1) {
            $prev_page = ($page > 1) ? $page - 1 : 1;
            $next_page = ($page < $total_pages) ? $page + 1 : $total_pages;
            echo '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '"><a class="page-link" href="?page=' . $prev_page . '">Previous</a></li>';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
            echo '<li class="page-item ' . ($page == $total_pages ? 'disabled' : '') . '"><a class="page-link" href="?page=' . $next_page . '">Next</a></li>';
        }
        echo '</ul>';

        ?>
    </ul>

    
</body>

</html>