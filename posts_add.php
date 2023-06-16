<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');

if (isset($_POST['title'])) {

  //Run Statement copied from index.php
  if ($stmt = $connect->prepare("INSERT INTO posts (title, content, author, date) VALUES (?, ?, ?, ?)")) {

    $stmt->bind_param('ssis', $_POST['title'], $_POST['content'], $_SESSION['id'], $_POST['date']);
    $stmt->execute();

    set_message("A new post by " . $_SESSION['username'] . " has been added");
    header('Location: posts.php');

    // Close Statement
    $stmt->close();
    die();

  } else {
    echo 'Could not Prepare Statement';
  }

}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <h1 class="display-1">Add Post</h1>

      <form method="post">
        <!-- Title input -->
        <div class="form-outline mb-4">
          <input type="text" id="title" class="form-control" name="title" />
          <label class="form-label" for="title">Title</label>
        </div>

        <!-- Author input -->
        <div class="form-outline mb-4">
          <input type="number" id="author" class="form-control" name="author" />
          <label class="form-label" for="author">Author</label>
        </div>

        <!-- Content input -->
        <div class="form-outline mb-4">
          <textarea class="form-control" name="content" id="content"></textarea>
        </div>

        <!-- Date Select -->
        <div class="form-outline mb-4">
          <input type="date" id="date" class="form-control" name="date" />
          <label class="form-label" for="date">Date</label>
        </div>



        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block">Add Post</button>
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
include('includes/footer.inc.php');
?>