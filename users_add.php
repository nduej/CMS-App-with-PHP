<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');

if (isset($_POST['username'])) {

  //Run Statement copied from index.php
  if ($stmt = $connect->prepare("INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, ?)")) {

    $hashed = SHA1($_POST['password']);
    $stmt->bind_param('ssss', $_POST['username'], $_POST['email'], $hashed, $_POST['active']);
    $stmt->execute();

    set_message("A new user " . $_SESSION['username'] . " has been added");
    header('Location: users.php');

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
    <div class="col-md-6">
      <h1 class="display-1">Add User</h1>

      <form method="post">
        <!-- Username input -->
        <div class="form-outline mb-4">
          <input type="text" id="username" class="form-control" name="username" />
          <label class="form-label" for="email">Username</label>
        </div>

        <!-- Email input -->
        <div class="form-outline mb-4">
          <input type="email" id="email" class="form-control" name="email" />
          <label class="form-label" for="email">Email address</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
          <input type="password" id="password" class="form-control" name="password" />
          <label class="form-label" for="email">Password</label>
        </div>

        <!-- Active Select -->
        <div class="form-outline mb-4">
          <select name="active" id="active" class="form-select">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
          <div class="col">
            <!-- Simple link -->
            <a href="#!">Forgot password?</a>
          </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block">Add User</button>
      </form>
    </div>
  </div>
</div>

<?php
include('includes/footer.inc.php');
?>