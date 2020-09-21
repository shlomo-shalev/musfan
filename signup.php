<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if(user_connected()){

  header('location: blog.php');

}

$Accessories = Accesso('sign up', 'css/signup-sigin.css');
$live = mysqli_link('musfan');

$errors['name'] = $errors['email'] = $errors['password'] = $errors['image'] = '';
$csrf_sess = select_sess('csrf_token', -1);
$csrf_form = $_POST['csrf_token'] ?? 0;

if(isset($_POST['submit'])){

  if($csrf_sess == $csrf_form){

    $image_name = 'default_profile.png';
  
    $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($live,$name);
    $name = trim($name);

    $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($live,$email);
    $email = trim($email);

    $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($live,$password);

    $valid_exist = true;

      $errors['name'] = valid_size($name,$valid_exist,[3,90]);

    if(!$email){

      $errors['email'] = 'Must write good email';
      $valid_exist = false;

    } elseif (email_exist($email,$live)){

      $errors['email'] = 'Email already exists in the system';
      $valid_exist = false;

    }

      $errors['password'] = valid_size($password,$valid_exist,[7,20]);


    

    if($valid_exist && isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0){

      
      if(image_proper($_FILES,'image')){

        $image_name = htmlentities($_FILES['image']['name']);
        $image_name = mysqli_real_escape_string($live,$image_name);
        $image_name = date('Y.m.d.H.i.s') . '-' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/profile/' . $image_name);

      }else {
        $valid_exist = false;
        $errors['image'] = 'The file is invalid, a file can only be an image and cannot exceed 5mb';
      }

    }

    if($valid_exist){

      $password = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO users VALUES(NULL,'$name','$email','$password')";
      $result = mysqli_query($live,$sql);

      if($result || mysqli_affected_rows($live)){
        $uid = mysqli_insert_id($live);
        $sql = "INSERT INTO img_profile VALUES(NULL, $uid, '$image_name')";
        $result = mysqli_query($live,$sql);

        if($result && mysqli_affected_rows($live)){

        work_sess([
          'user_id' => $uid,
          'user_name' => $name,
          'user_email' => $email,
          'user_ip' => $_SERVER['REMOTE_ADDR'],
          'user_agent' => $_SERVER['HTTP_USER_AGENT'],
          'warning' => 'You have successfully registered!!!',
        ]);

        header('location: blog.php');
        exit;

        }
      
      }

    }

  }

}

// Although in class you told me that if I put the variable that calls this function out of if then it won't work, even though it worked for me
$token = rand_str();

?>

<?php include 'tpl/header.php' ?>

<main class="min-h-900">

  <div class="container-fluid w-350 ov-h text-white mt-1 mt-sm-5 p-2 shadow">

    <div class="bg-cs1">

    <div class="row justify-content-center">

      <div class="col-8 mt-4 p-0">

        <h1 class="display-5 fz-20 mt-2">Subscribe to the musfan blog</h1>

      </div>

    </div>

    <div class="row justify-content-center">

    <form action="" method="POST" class="col-8 p-0" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">

      <input type="hidden" name="csrf_token" value="<?= $token; ?>">

      <div class="from-group">

      <label for="name">* name:</label>
      <input type="text" name="name" value="<?= re_on('name'); ?>" id="name" class="form-control">
      <span class="text-danger"><?= $errors['name']; ?></span>

      </div>

      <div class="form-group pt-3">

      <label for="email">* Email Address:</label>
      <input type="email" value="<?= re_on('email'); ?>" name="email" id="email" class="form-control">
      <span class="text-danger"><?= $errors['email']; ?></span>

      </div>

      <div class="from-group mb-3">

      <label for="password">* password:</label>
      <input type="password" name="password" id="password" class="form-control">
      <span class="text-danger"><?= $errors['password']; ?></span>

      </div>

      <label for="customFile">Upload a profile picture:</label>
      <div class="custom-file">
      <input type="file" name="image" class="custom-file-input" id="customFile">
      <span class="custom-file-label fz-15">Choose file</span>
      <span class="text-danger"><?= $errors['image']; ?></span>

      </div>

      <input type="submit" class="btn btn-primary mt-3" name="submit" value="submit">
      <br>

    </form>

    </div>

    <div class="row justify-content-center">

      <div class="col-8 mt-4">

        <p>Already signed up? <a href="signin.php" class="badge badge-primary bg-cs2">Sign in now</a></p>

      </div>
      
    </div>

    </div>

  </div>

</main>


<?php include 'tpl/footer.php' ?>