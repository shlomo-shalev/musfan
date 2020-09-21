<?php

session_start();
session_regenerate_id();

require_once 'app/helpers.php';
$user_connected = user_connected();

if( !$user_connected ){

    header('location: signin.php');
  
  }


  $Accessories = Accesso('post profile', false, 'js/post.js');

  $uid = select_sess('user_id', -1);
  $live = mysqli_link('musfan');
  $pid = -1;
  $margin = 'm-0';
  
  $errors['title'] = $errors['article'] = $title_re_on = $article_re_on = '';
  $windows_size = $_POST['windows-size'] ?? 0;
  $header_post = '&header_post_profile=1';
  $pid_comment = filter_input(INPUT_POST, 'pid_comment', FILTER_SANITIZE_STRING);

if(isset($_POST['submit'])){
    
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $title = trim($title);

    $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $article = trim($article);

    $pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_STRING);

    $cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);

    $valid_exist = true;
    
        $errors['title'] = valid_size($title,$valid_exist,[3,255]);
        $errors['article'] = valid_size($article,$valid_exist,[3,5000]);

    if(!$valid_exist){

        $title_re_on = re_on('title');
        $article_re_on = re_on('article');

    }elseif(isset($_POST['add'])){

        comment_add($pid,$title,$article,$uid,$live);

    }elseif(isset($_POST['edit'])){

        comment_edit($cid,$title,$article,$uid,$live);

    }

}

if(isset($_POST['delete_comment'])){

    $windows_size = $_POST['windows-size'] ?? 0;
    $cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING) ?? 0;
    $cid = mysqli_real_escape_string($live,$cid);
    delete_comment($cid,$uid,$live);

}
  
like_toggle($_POST,$uid,$live);

$sql = "SELECT u.name,ip.name_file_img,ps.*,DATE_FORMAT(ps.date, '%d/%m/%Y %H:%i:%s') date_il, COUNT(DISTINCT l.id) count_likes, 
MAX(IF(l.user_id = $uid, 1, 0)) like_user_exist, COUNT(DISTINCT c.id) count_comments 
FROM img_profile ip JOIN posts ps ON ps.user_id = ip.user_id JOIN users u ON u.id = ps.user_id 
LEFT JOIN likes l ON ps.id = l.post_id LEFT JOIN comments c ON ps.id = c.post_id 
WHERE ps.user_id=$uid GROUP BY ps.id ORDER BY ps.date DESC";

$result_post = mysqli_query($live, $sql);

$result_post_date = [];
if($result_post && mysqli_num_rows($result_post)){

    while($row = mysqli_fetch_assoc($result_post)){

        $result_post_date[] = $row;
    
    }
    
}else{

    $sql = "SELECT name_file_img FROM img_profile WHERE user_id=$uid";
    $result_img_profile = mysqli_query($live, $sql);

    $row = mysqli_fetch_assoc($result_img_profile);

}


$data = import_comments($uid,$live);
$warning = select_sess('warning');


?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
        <div class="container-fluid mt-4">
        <div class="row justify-content-center">
        <div class="col-sm-8 mb-2 col-lg-3 pr-lg-0 mb-lg-0">
                <div class="bg-cs1 rounded-lg text-light mx-1 d-flex flex-column justify-content-center pt-3">
                    <img class="oj-f-center w-80p h-80p rounded-circle m-0a" src="images/profile/<?= htmlentities($result_post_date[0]['name_file_img'] ?? $row['name_file_img']); ?>" alt="img-profile">
                    <h1 class="text-center mt-2"><?= htmlentities(select_sess('user_name')); ?></h1>
                    <h6 class="text-center mt-2"><?= htmlentities(select_sess('user_email')); ?></h6>
                    <div class="row px-19 mt-2">
                        <a href="profile.php" class="col-6 h-50p btn bg-cs4 text-black rounded-0 border-bl pt-13p fz-15" >Edit Profile</button>
                        <a href="post_profile.php" class="col-6 h-50p btn bg-cs2 text-light rounded-0 border-br pt-13p fz-15">Editing posts</a>
                    </div>
                </div>
        </div>
        <div class="col-sm-8 col-lg-6">
        <?php include 'tpl/posts.php' ?>
        <?php if(!mysqli_num_rows($result_post)): ?>
            <div class="text-center mt-3">You have no posts, go to the blog to create a new post.</div>
        <?php endif; ?>
        </div>
        <?php include 'tpl/alert.php' ?>
</main>

<?php include 'tpl/footer.php'; ?>