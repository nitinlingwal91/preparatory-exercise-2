<?php include "../conn/session.php" ?>
<?php
if ($_SESSION['user_role'] != "Admin" && $_SESSION['user_role'] != "SuperAdmin") {
  header('Location: ../view/403.php');
  exit();
}
?>
<?php
include "../conn/connection.php";


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../links/link.php" ?>
  <style>
    <?php include "../public/css/admin.css" ?>
  </style>
  <title>user list</title>
</head>

<body>

  <!-- delete Modal -->
  <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="../controller/delete.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="delete_id" class="delete_user_id">
            <p>Are you sure you want to delete this data?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="deleteuserbtn" class="btn btn-primary ">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- update modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="../controller/update.con.php" method="POST">
          <?php
          if (isset($_GET['id'])) {
            $sql = "SELECT * FROM user_registration WHERE id= '$id'";
            $sql_run = mysqli_query($con, $sql);

            $row = mysqli_fetch_assoc($sql_run);
            $id = $_row['id'];
          }
          ?>
          <div class="modal-body">
            <input type="text" name="id" value="id=<?= $row['id']; ?>" id="id">
            <div class="mb-3">
              <label for="edit_fname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="edit_fname" name="user_fname">
            </div>
            <div class="mb-3">
              <label for="edit_lname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="edit_lname" name="user_lname">
            </div>
            <div class="mb-3">
              <label for="edit_email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="edit_email" name="user_email">
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="saveuserdetails" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- update modal end -->


  <!-- nav bar start -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid fw-bold">
      <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="admin">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="booklist">Book List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="issuebook">Issue Book Management</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="">Admin List</a>
          </li>

          <li class="nav-item">
            <a class="nav-link " href="userdata">User List</a>
          </li>
          <!-- <li class="d-flex align-items-center ms-lg-4">
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-primary" type="submit">Search</button>
            </form>
          </li> -->
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown me-lg-4">
          <li class="text-align-center mt-2 align-items-center"><?php include "../controller/profile.con.php" ?></li>
          <li><a class="dropdown-item " href="../controller/auth/logout.php"><button class="btn btn-primary text-align-center d-flex me-6">Logout</button></a></li>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  

  <div class="row mt-3 mx-4">
    <div class="col-md-6 col-lg-4">
      <form action="" method="POST">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search by name and email" name="search">
          <div class="input-group-append">
            <button class="btn btn-success" type="submit">Search</button>
          </div>
        </div>
      </form>
    </div>

    
    <form action="" method="POST">
      <section>
        <div class="input-group mt-3 mx-4">
          <select name="sort_alphabet" class=" input_group_text mx-4">
            <option value="">--select option</option>
            <option value="a-z" <?php if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == "a-z") {
                                  echo "selected";
                                } ?>>A-Z (Ascending order)</option>
            <option value="z-a" <?php if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] == "z-a") {
                                  echo "selected";
                                } ?>>Z-A (Descending order)</option>
          </select>
          <button type="submit" name="sort" class="input-group-text " id="basic-addon2">sort</button>
        </div>
      </section>
    </form>
    


    <div class="table-responsive">
      <table class="table table-bordered mt-4 text-center ">
        <thead>
          <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Email Verification Status</th>
            <th>Registration time</th>
            <th>DELETE</th>
          </tr>
        </thead>
        <tbody>
          <?php include "../controller/adminlist.con.php" ?>
        </tbody>
      </table>
    </div>

    <?php

    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination justify-content-center mt-4">';

    if ($current_page > 1) {
      $prev_page = $current_page - 1;
      echo '<li class="page-item"><a class="page-link" href="?search=' . $search . '&page=' . $prev_page . '">Previous</a></li>';
    } else {
      echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>';
    }

    for ($i = 1; $i <= $total_pages; $i++) {
      if ($i == $current_page) {
        echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
      } else {
        echo '<li class="page-item"><a class="page-link" href="?search=' . $search . '&page=' . $i . '">' . $i . '</a></li>';
      }
    }

    if ($current_page < $total_pages) {
      $next_page = $current_page + 1;
      echo '<li class="page-item"><a class="page-link" href="?search=' . $search . '&page=' . $next_page . '">Next</a></li>';
    } else {
      echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Next</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
    ?>
  </div>  


    <?php include "footer.php"?>
    <script src="../public/js/update.js"></script>
    <script src="../public/js/delete.js"></script>
    <script src="../public/js/adminedit.js"></script>


</body>

</html>