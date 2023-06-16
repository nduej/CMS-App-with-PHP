<?php
include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');

if (isset($_POST['username'])) {

  //Run Statement copied from index.php
  if ($stmt = $connect->prepare("UPDATE users SET username = ?, email = ?, active = ? WHERE id = ?")) {

    $stmt->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
    $stmt->execute();

    
    

    // Close Statement
    $stmt->close();
    
    if(isset($_POST['password'])){
      if ($stmt = $connect->prepare("UPDATE users SET password = ? WHERE id = ?")) {
        $hashed = SHA1($_POST['password']);
        $stmt->bind_param('si', $hashed, $_GET['id']);
        $stmt->execute();

        $stmt->close();

    }
  
    else {
      echo 'Could not Prepare password update Statement';
    }
  }
    set_message("A user " . $_GET['id'] . " has been Updated");
    header('Location: users.php');
    die();

  } else {
    echo 'Could not Prepare user update Statement';
  }


 

}



if (isset($_GET['id'])) {


  if ($stmt = $connect->prepare("SELECT * FROM users WHERE id = ?")) {

    
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();


    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
      



  


?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h1 class="display-1">Edit User</h1>

      <form method="post">
        <!-- Username input -->
        <div class="form-outline mb-4">
          <input type="text" id="username" class="form-control active" name="username" value="<?php echo $user ['username']?>"/>
          <label class="form-label" for="email">Username</label>
        </div>

        <!-- Email input -->
        <div class="form-outline mb-4">
          <input type="email" id="email" class="form-control active" name="email" value="<?php echo $user ['email']?>"/>
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
            <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Active</option>
            <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Inactive</option>
          </select>
        </div>

        

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block">Update User</button>
      </form>
    </div>
  </div>
</div>

<?php

}
$stmt->close();
die();

} else {
echo 'Could not Prepare Statement';
}


} else {
echo 'No user selected';
die();
}

include('includes/footer.inc.php');
?>