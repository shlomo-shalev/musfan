<?php

session_start();
session_regenerate_id();

require_once 'app/helpers.php';
if( !user_connected() ){

    header('location: signin.php');
   
  }

$Accessories = Accesso('profile');

$errors['name'] = $errors['email'] = $errors['previous-password'] = $errors['new-password'] = 
$errors['new-password-again'] = $errors['img-profile'] = '';

$live = mysqli_link('musfan');
$uid = select_sess('user_id');
$name_info = re_on('name');
$email_info = re_on('email');

$sql = "SELECT name_file_img FROM img_profile 
WHERE user_id=$uid";
$result = mysqli_query($live, $sql);

if($result && mysqli_num_rows($result)){

    $row = mysqli_fetch_assoc($result);

}


if(isset($_POST['submit'])){


        $name_image = '';
        $name = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
        $name = mysqli_real_escape_string($live,$name);
        $name = trim($name);

        // 110 :)
        $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
        $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
        $email = mysqli_real_escape_string($live,$email);
        $email = trim($email);

        $previous_password = filter_input(INPUT_POST, 'previous-password',FILTER_SANITIZE_STRING);
        // I don't think the password should be secure but I left it because I don't know all the hacks you can do :)
        $previous_password = mysqli_real_escape_string($live,$previous_password);
        $previous_password = trim($previous_password);

        $new_password = filter_input(INPUT_POST, 'new-password',FILTER_SANITIZE_STRING);
        // I don't think the password should be secure but I left it because I don't know all the hacks you can do :)
        $new_password = mysqli_real_escape_string($live,$new_password);
        $new_password = trim($new_password);

        $new_password_again = filter_input(INPUT_POST, 'new-password-again',FILTER_SANITIZE_STRING);
        // I don't think the password should be secure but I left it because I don't know all the hacks you can do :)
        $new_password_again = mysqli_real_escape_string($live,$new_password_again);
        $new_password_again = trim($new_password_again);

        $form_valid_all = true;
        $form_valid_n_e_i = true;

        $errors['name'] = valid_size($name,$form_valid_all,[3,90]);
        $form_valid_n_e_i = $form_valid_all;

        if(!$email){

            $form_valid_all = false;
            $form_valid_n_e_i = false;
            $errors['email'] = 'Must write good email';

        } elseif(select_sess('user_email') != $email && email_exist($email, $live)){

            $form_valid_all = false;
            $form_valid_n_e_i = false;
            $errors['email'] = 'The email exists in the system';
        }

        if(!$previous_password){

            $form_valid_all = false;
            $errors['previous-password'] = 'Must write your previous password';

        }elseif(!password_exists($previous_password,select_sess('user_email'),$live)){

            $form_valid_all = false;
            $errors['previous-password'] = 'Wrong password';
        }

        if(!$new_password || strlen($new_password) < 7 || strlen($new_password) > 20){

            $form_valid_all = false;
            $errors['new-password'] = 'Must write a password with at least 7 characters and no more than 20 characters';

        }
        
        if(!$new_password_again){

            $form_valid_all = false;
            $errors['new-password-again'] = 'You must re-enter the password you wrote in the previous field';

        }elseif($new_password != $new_password_again){

            $form_valid_all = false;
            $errors['new-password-again'] = 'The password does not match the password you wrote before';

        }


        if(isset($_FILES['img-profile']) && isset($_FILES['img-profile']['error']) && $_FILES['img-profile']['error'] 
        == 0){
            
            if(image_proper($_FILES,'img-profile')){

                if($form_valid_n_e_i || $form_valid_all){

                $name_image = htmlentities($_FILES['img-profile']['name']);
                $name_image = date('Y.m.d.H.i.s') . '-' . $name_image;
                move_uploaded_file($_FILES['img-profile']['tmp_name'], 'images/profile/' . $name_image);
                if($row['name_file_img'] != 'default_profile.png'){
                $name_img = 'images/profile/' . $row['name_file_img'];
                unlink($name_img);
                }

                }
               
            }else{

                $form_valid_all = false;
                $form_valid_n_e_i = false;
                $errors['img-profile'] = 'Image is invalid, try uploading another image';

            }

        }

        if(!$previous_password && !$new_password && !$new_password_again){
            
            $errors['previous-password'] = $errors['new-password'] = $errors['new-password-again'] = '';

            if($form_valid_n_e_i){
            $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$uid";
            $result = mysqli_query($live, $sql);
            $user_affected = mysqli_affected_rows($live);

            if($result){

                Update_image_information($uid,$name_image,$live,$row['name_file_img']);

            }

            if($result && mysqli_affected_rows($live)){
                work_sess([
                    'user_name' => $name,
                    'user_email' => $email,
                ]);

                work_sess('warning','Details updated successfully !!!');

            }

            }

        }elseif($form_valid_all){
            
            $new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET name='$name', email='$email', password='$new_password' WHERE id=$uid";
            $result = mysqli_query($live, $sql);
            $user_num = mysqli_affected_rows($live);

            if($result){

                Update_image_information($uid,$name_image,$live,$row['name_file_img']);

            }

            if($result && $user_num){

                work_sess([
                    'user_name' => $name,
                    'user_email' => $email,
                ]);

                work_sess('warning','Details updated successfully !!!');

            }

        }

}else{

        $name_info = select_sess('user_name');
        $email_info = select_sess('user_email');
}

$warning = select_sess('warning');

?>

<?php include 'tpl/header.php'; ?>
<main>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
        <div class="col-sm-8 mb-2 col-lg-3 pr-lg-0 mb-lg-0">
                <div class="preview bg-cs1 rounded-lg text-light mx-1 d-flex flex-column justify-content-center pt-3">
                    <img class="oj-f-center w-80p h-80p rounded-circle m-0a" src="images/profile/<?= htmlentities($row['name_file_img']); ?>" alt="img-profile">
                    <h1 class="text-center mt-2"><?= htmlentities(select_sess('user_name')); ?></h1>
                    <h6 class="text-center mt-2"><?= htmlentities(select_sess('user_email')); ?></h6>
                    <div class="row px-19 mt-2">
                        <a href="profile.php" class="col-6 h-50p btn bg-cs4 text-black rounded-0 border-bl pt-13p fz-15" >Edit Profile</button>
                        <a href="post_profile.php" class="col-6 h-50p btn bg-cs2 text-light rounded-0 border-br pt-13p fz-15">Editing posts</a>
                    </div>
                </div>
        </div>
            <div class="col-sm-8 col-lg-6">
        <form action="" method="POST" enctype="multipart/form-data" class="p-3 mx-1 bg-cs1 px-4 rounded-lg text-light" autocomplete="off" novalidate="novalidate">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="form-group">
            <label for="name">* Name: </label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $name_info; ?>">
                <span class="text-danger"><?= $errors['name']; ?></span>
        </div>
        <div class="form-group">
            <label for="email">* Email: </label>
            <input type="email" name="email" id="email" class="form-control" value="<?= $email_info; ?>">
            <span class="text-danger"><?= $errors['email']; ?></span>
        </div>
        <div class="form-group">
            <label for="previous-password">** previous password: </label>
            <input type="password" name="previous-password" id="previous-password" class="form-control">
            <span class="text-danger"><?= $errors['previous-password']; ?></span>
        </div>
        <div class="form-group">
            <label for="new-password">** new password: </label>
            <input type="password" name="new-password" id="new-password" class="form-control">
            <span class="text-danger"><?= $errors['new-password']; ?></span>
        </div>
        <div class="form-group">
            <label for="new-password-again">** new password again: </label>
            <input type="password" name="new-password-again" id="new-password-again" class="form-control">
            <span class="text-danger"><?= $errors['new-password-again']; ?></span>
        </div>
        <span class="d-block mb-2">Change profile picture: </span>
        <div class="custom-file mb-3">
            <input type="file" name="img-profile" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
            <span class="text-danger"><?= $errors['img-profile']; ?></span>
        </div>
        <button class="btn text-light bg-cs2 border mb-2 border-dark mt-3" name="submit" type="submit">Update</button>
        <hr class="bg-light">
        <div class="comment">
            ** If you do not fill in these fields then the password will not be updated but only the email name and profile picture (if any)
        </div>
        </form>
        </div>
        </div>
    </div>
    <?php include 'tpl/alert.php' ?>
</main>

<?php include 'tpl/footer.php'; ?>