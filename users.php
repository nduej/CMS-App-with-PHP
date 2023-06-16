<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');

if (isset($_GET['delete'])) {

  if ($stmt = $connect->prepare('DELETE FROM users WHERE id = ?')) {
    $stmt->bind_param('i', $_GET['delete']);
    $stmt->execute();

    set_message("User " . $_GET['delete'] . " has been deleted");
    header('Location: users.php');

    //Close Statement
    $stmt->close();
    die();

  } else {
    'Could not Prepare Statement';

  }

}

if ($stmt = $connect->prepare("SELECT * FROM users")) {
  $stmt->execute();
  $result = $stmt->get_result();




  if ($result->num_rows > 0) {
    ?>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h1 class="display-1">Users Management</h1>
          <table class="table table-striped table-hover">
            <tr>
              <th>Id</th>
              <th>Username</th>
              <th>Email</th>
              <th>Status</th>
              <th>Edit | Delete</th>

            </tr>

            <?php while ($record = mysqli_fetch_assoc($result)) { ?>

              <tr>

                <td>
                  <?php echo $record['id']; ?>
                </td>
                <td>
                  <?php echo $record['username']; ?>
                </td>
                <td>
                  <?php echo $record['email']; ?>
                </td>
                <td>
                  <?php echo $record['active']; ?>
                </td>
                <td><a href="users_edit.php?id=<?php echo $record['id']; ?>">Edit |</a>
                  <a href="users.php?delete=<?php echo $record['id']; ?>">Delete</a>
                </td>

                </td>


              <?php } ?>

          </table>

          <a href="users_add.php"> Add New User </a>

        </div>
      </div>
    </div>
    <?php
  } else {
    echo 'No users found';
  }
  $stmt->close();
} else {
  echo 'Could not prepare statement!';
}


include('includes/footer.inc.php');
?>