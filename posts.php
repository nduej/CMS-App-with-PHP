<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');

if (isset($_GET['delete'])) {

  if ($stmt = $connect->prepare('DELETE FROM posts WHERE id = ?')) {
    $stmt->bind_param('i', $_GET['delete']);
    $stmt->execute();

    set_message("A post " . $_GET['delete'] . " has been deleted");
    header('Location: posts.php');

    //Close Statement
    $stmt->close();
    die();

  } else {
    'Could not Prepare Statement';

  }

}

if ($stmt = $connect->prepare("SELECT * FROM posts")) {
  $stmt->execute();
  $result = $stmt->get_result();




  if ($result->num_rows > 0) {
    ?>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h1 class="display-1">Posts Management</h1>
          <table class="table table-striped table-hover">
            <tr>
              <th>Id</th>
              <th>Title</th>
              <th>Author's ID</th>
              <th>Content</th>
              <th>Edit | Delete</th>

            </tr>

            <?php while ($record = mysqli_fetch_assoc($result)) { ?>

              <tr>

                <td>
                  <?php echo $record['id']; ?>
                </td>
                <td>
                  <?php echo $record['title']; ?>
                </td>
                <td>
                  <?php echo $record['author']; ?>
                </td>
                <td>
                  <?php echo $record['content']; ?>
                </td>
                <td><a href="posts_edit.php?id=<?php echo $record['id']; ?>">Edit |</a>
                  <a href="posts.php?delete=<?php echo $record['id']; ?>">Delete</a>
                </td>

                </td>


              <?php } ?>

          </table>

          <a href="posts_add.php"> Add New Post </a>

        </div>
      </div>
    </div>
    <?php
  } else {
    echo 'No posts found';
  }
  $stmt->close();
} else {
  echo 'Could not prepare statement!';
}


include('includes/footer.inc.php');
?>