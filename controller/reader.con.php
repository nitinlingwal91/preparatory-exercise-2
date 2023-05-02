<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<?php
include "../conn/connection.php";
$sort_option = "";
if (isset($_GET['sort_alphabet'])) {
    if ($_GET['sort_alphabet'] == "a-z") {
        $sort_option = "ASC";
    } elseif ($_GET['sort_alphabet'] == "z-a") {
        $sort_option = "DESC";
    }
}

$search_query = "";
if (isset($_GET['submit_search'])) {
    $search_query = $_GET['search_query'];
}

$results_per_page = 6;
$sql = "SELECT COUNT(*) as count FROM create_book";
if (!empty($search_query)) {
    $sql .= " WHERE book_name LIKE '%$search_query%' OR author_name LIKE '%$search_query%'";
}
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$total_results = $row['count'];
$total_pages = ceil($total_results / $results_per_page);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$starting_limit = ($page - 1) * $results_per_page;
$ending_limit = $starting_limit + $results_per_page;

$sql = "SELECT * FROM create_book";
if (!empty($search_query)) {
    $sql .= " WHERE book_name LIKE '%$search_query%' OR author_name LIKE '%$search_query%'";
}
if (!empty($sort_option)) {
    $sql .= " ORDER BY book_name $sort_option";
}
$sql .= " LIMIT $starting_limit, $results_per_page";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $read_status = $row['read_status'];
        $copies_available = $row['copies_available'];
    
?>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <img src="<?php echo $row['img_url']; ?>"  class="card-img-top" alt="image" style="max-width: 100%; max-height: 300px;">
                <p class="float-right mb-2"><strong>Copies Available: </strong><?php echo $copies_available; ?></p>
                <div class="card-body bg-light book-card mb-2" style="height: 200px;">
                    <div class="d-flex flex-column justify-content-between ">
                        <div class=" text-center mb-4 ">
                            <a href="../view/wishlist.view.php?id=<?php echo $row['id'] ?>" class="btn btn-primary add-wishlist btn-sm float-left" id="left" style="color:white" name="action"><i class="fas fa-heart"></i> Add to Wishlist</a>
                            <form class="mb-2 mark-as-read-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="book_id" value="<?php echo $id; ?>" />
                                <?php
                                if ($read_status == 'read') {
                                    $btn_text = 'Mark as Unread';
                                } else {
                                    $btn_text = 'Mark as Read';
                                }
                                ?>
                                <button type="submit" name="mark_as_read" class="btn btn-success btn-sm float-right" id="right" style="color: white">
                                    <i class="fas fa-check"></i> <?php echo $btn_text; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    <h5 class="card-title text-center"><?php echo $row['book_name']; ?></h5>
                    <p class="card-text text-center"><?php echo $row['author_name']; ?></p>
                    <p class="card-text text-center">Book Id--<?php echo $row['book_id']; ?></p>

                </div>
            </div>
        </div>

<?php
    }
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_as_read'])) {
    $book_id = $_POST['book_id'];
    $query = "SELECT read_status, book_name FROM create_book WHERE id='$book_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $read_status = $row['read_status'];
    
    if ($read_status == 'read') {
        $new_read_status = 'unread';
    } else {
        $new_read_status = 'read';
        $user_email = $_SESSION['user_email'];
        $book_name = $row['book_name'];
        $query = "INSERT INTO read_book (user_email, book_name, read_status, book_id) VALUES ('$user_email', '$book_name', '$new_read_status', '$book_id')";
        $result = mysqli_query($con, $query);
        if (!$result) {
            echo '<script>alert("Error marking book as ' . $new_read_status . '!");</script>';
        }
    }

    $query = "UPDATE create_book SET read_status='$new_read_status' WHERE id='$book_id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo '<script>alert("Book marked as ' . $new_read_status . '!"); window.location.href = window.location.href;</script>';
    } else {
        echo '<script>alert("Error marking book as ' . $new_read_status . '!");</script>';
    }
}
?>
