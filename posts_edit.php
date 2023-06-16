<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');

if (isset($_POST['title'])) {

  //Run Statement copied from index.php
  if ($stmt = $connect->prepare('UPDATE posts SET title = ?, content = ?, date = ? WHERE id = ?')) {

    $stmt->bind_param('sssi', $_POST['title'], $_POST['content'], $_POST['date'], $_GET['id']);
    $stmt->execute();


    //To Do: Give feedback / welcome message


    $stmt->close();



    set_message("A Post " . $_SESSION['id'] . " has been updated!");
    header('Location: posts.php');
    die();

  } else {
    echo 'Could not prepare post update statement!';
  }

}


if (isset($_GET['id'])) {

  if ($stmt = $connect->prepare('SELECT * FROM posts WHERE id = ?')) {
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
      ?>
      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <h1 class="display-1">Edit Post</h1>
            <form method="post">
              <!-- Title input -->
              <div class="form-outline mb-4">
                <input type="text" id="title" class="form-control" name="title" value="<?php echo $post['title'] ?>" />
                <label class="form-label" for="title">Title</label>
              </div>

              <!-- Author input -->
              <div class="form-outline mb-4">
                <input type="number" id="author" class="form-control" name="author" value="<?php echo $post['content'] ?>" />
                <label class="form-label" for="author">Author</label>
              </div>

              <!-- Content input -->
              <div class="form-outline mb-4">
                <textarea class="form-control" name="content" id="content" ><?php echo $post['content'] ?></textarea>
              </div>

              <!-- Date Select -->
              <div class="form-outline mb-4">
                <input type="date" id="date" class="form-control" name="date" value="<?php echo $user['date'] ?>" />
                <label class="form-label" for="date">Date</label>
              </div>



              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block">Edit Post</button>
            </form>
          </div>
        </div>
      </div>

      <script src="bootstrap/js/tinymce/tinymce.min.js"></script>
      <script>
        tinymce.init({
          selector: '#content'
        });
      </script>

      <?php
    }

    // Close Statement
    $stmt->close();
    die();

  } else {
    echo 'Could not prepare statement!';
  }
} else {
  echo "No post selected";
  die();
}


include('includes/footer.inc.php');
?>