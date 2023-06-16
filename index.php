<?php

include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');

include('includes/header.inc.php');

if (isset($_SESSION['id'])) {
  header('Location: dashboard.php');
  die();
}


if (isset($_POST['email'])) {

  // Copy later into users_add.php
  if ($stmt = $connect->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND active = 1 ")) {


    $hashed = SHA1($_POST['password']);
    $stmt->bind_param('ss', $_POST['email'], $hashed);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['username'] = $user['username'];

      //To Do Give a Feedback / Welcome Message
      set_message("Login Successful" . $_SESSION['username']);
      header('Location: dashboard.php');
      die();
    }
    $stmt->close();
  } else {
    'Could not Prepare Statement';

  }
}

?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="post">
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

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">


          <div class="col">
            <!-- Simple link -->
            <a href="#!">Forgot password?</a>
          </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
      </form>


    </div>
  </div>
</div>

<?php
include('includes/footer.inc.php');