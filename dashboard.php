<?php

include('includes/config.inc.php');
include('includes/database.inc.php');
include('includes/functions.inc.php');
secure();
include('includes/header.inc.php');



?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
    <h1 class="dispaly-1">Dashboard</h1>

      <a href="users.php">Users Management</a> |
      <a href="posts.php">Posts Management</a>
    </div>
  </div>
</div>

<?php
include('includes/footer.inc.php');