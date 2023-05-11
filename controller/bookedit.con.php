<?php
include "../conn/connection.php";

$id = $_GET['id'];

$query = "SELECT * FROM create_book WHERE id='$id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];

if (isset($_POST['submit_save'])) {
    $author_name = mysqli_real_escape_string($con, $_POST['author_name']);
    $book_name = mysqli_real_escape_string($con, $_POST['book_name']);
    $description = mysqli_real_escape_string($con, $_POST['book_description']);

    if (isset($_FILES["uploadfile"]["name"]) && !empty($_FILES["uploadfile"]["name"])) {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "../upload_images/" . $filename;
        move_uploaded_file($tempname, $folder);
        $img_url = $folder;
    } else {
        $img_url = $row['img_url'];
    }

    $query = "UPDATE create_book SET book_name = '$book_name', author_name = '$author_name', book_description = '$description', img_url='$img_url' WHERE id='$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo '<script>alert("Book Details Edited successfully");</script>';
    } else {
        echo '<script>alert("Error updating book details");</script>';
    }
}

?>

<div class="wrapper">
    <div class="form-left">
        <img id="frame" src="<?php echo $row['img_url']; ?>" class="w-100 h-75" />
    </div>

    <form class="form-right ms-4" action="" method="POST" enctype="multipart/form-data">
        <h2 class="text-uppercase ms-4">EDIT BOOK DETAILS</h2>
        <div class="row">
            <div class="mb-3 ms-4">
                <label>EDIT AUTHOR NAME</label>
                <input type="text" id="author_name" value="<?php echo $row['author_name'] ?>" name="author_name" class="input-field w-75" required>
            </div>
        </div>
        <div class=" mb-3 ms-4" style="width: 100%;">
            <label>EDIT BOOK NAME</label>
            <input type="text" id="book_name" value="<?php echo $row['book_name'] ?>" name="book_name" class="input-field w-75" required>
        </div>
        <div class="row">
            <div class=" mb-3 ms-4">
                <label>EDIT DESCRIPTION/ABOUT</label>
                <textarea class="input-field w-75" id="description" name="book_description"><?php echo $row['book_description'] ?></textarea>
            </div>

            <div class="mb-3 ms-4">
                <label>Change book cover</label>
                <input type="file" class="input-field w-75" id="book_image" name="uploadfile" onchange="preview()">
            </div>
            <div class="form-field ms-4">
                <input type="submit" value="SAVE" class="register" name="submit_save">
            </div>
        </div>
    </form>
    <script>
        function preview() {
            var fileInput = document.getElementById('book_image');
            var frame = document.getElementById('frame');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    frame.src = e.target.result;
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>

</div>