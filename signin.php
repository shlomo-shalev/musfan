<?php

session_start();
session_regenerate_id();

require_once 'app/helpers.php';
if( user_connected() ){

  header('location: blog.php');

}

$Accessories = Accesso('sign in', 'css/signup-sigin.css');
$error_text = '';
$csrf_sess = select_sess('csrf_token', -1);
$csrf_form = $_POST['csrf_token'] ?? 0;

if(isset($_POST['submit'])){

  if($csrf_sess == $csrf_form){
  
  // Although I do not think there is a reason to do filter_input for password and email I left this function because I do not know all types of loopholes
  $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
  // :) 110!!!
  $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_STRING); 
  $email = trim($email);

  $password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
  $password = trim($password);

  $valid_exist = true;

    $error_text = valid_size($email,$valid_exist);

  if($password){
    if(strlen($password) < 6 || strlen($password) > 70){
      $valid_exist = false;
      $error_text = 'The details you wrote are incorrect';
    }
  } else {
    $valid_exist = false;
      $error_text = 'The details you wrote are incorrect';
  }


  if($valid_exist){
    $live = mysqli_link('musfan');
    $email = mysqli_real_escape_string($live, $email);
    // I don't think the password should be secure but I left it because I don't know all the hacks you can do :)
    $password = mysqli_real_escape_string($live, $password);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($live,$sql);

    if($result && mysqli_num_rows($result) > 0){

      $rows = mysqli_fetch_assoc($result);

      if( password_verify($password, $rows['password']) ){

        work_sess([
          'user_id' => $rows['id'],
          'user_name' => $rows['name'],
          'user_email' => $rows['email'],
          'user_ip' => $_SERVER['REMOTE_ADDR'],
          'user_agent' => $_SERVER['HTTP_USER_AGENT'],
          'warning' => 'you have successfully connected!!!',
        ]);

        header('location: blog.php');
        exit;

      } else {
        $valid_exist = false;
        $error_text = 'The details you wrote are incorrect';
      }

    } else {
      $valid_exist = false;
      $error_text = 'The details you wrote are incorrect';
    }
  }

  }

}

// Although in class you told me that if I put the variable that calls this function out of if then it won't work, even though it worked for me
$token = rand_str();

$warning = select_sess('warning');


?>

<?php include 'tpl/header.php' ?>
<main class="min-h-900">
  <div class="container-fluid w-350 ov-h text-white mt-1 mt-sm-5 p-2 shadow">
    <div class="bg-cs1">
      <div class="row justify-content-center">
        <div class="col-8 mt-4">
          <h1 class="display-5 fz-20">Here you can signin with your account</h1>
        </div>
      </div>
      <div class="row justify-content-center">
        <form action="" method="POST" class="col-8" autocomplete="off" novalidate="novalidate">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" value="<?= re_on('email'); ?>" name="email" id="email" class="form-control">
          </div>
          <div class="from-group">
            <label for="password">password:</label>
            <input type="password" name="password" id="password" class="form-control">
          </div>
          <input type="submit" class="btn btn-primary mt-3" name="submit" value="submit">
          <br>
          <span class="text-danger font-weight-bolder"><?= $error_text; ?></span>
        </form>
      </div>
      <div class="row justify-content-center">
        <div class="col-8 mt-4">
          <p>No account? <a href="signup.php" class="badge badge-primary bg-cs2">Create New Account</a></p>
        </div>
      </div>
    </div>
  </div>
  <?php include 'tpl/alert.php' ?>
</main>

<?php include 'tpl/footer.php' ?>