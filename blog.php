<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

$Accessories = Accesso('blog page' ,'css/blog.css', 'js/post.js');

$uid = select_sess('user_id', -1);
$live = mysqli_link('musfan');
$pid = -1;
$header_post = '';
$user_connected = user_connected();

$errors['title'] = $errors['article'] = $title_re_on = $article_re_on = '';
$windows_size = $_POST['windows-size'] ?? 0;
$pid_comment = filter_input(INPUT_POST, 'pid_comment', FILTER_SANITIZE_STRING);

if( $user_connected ){

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

    $cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING) ?? 0;
    $cid = mysqli_real_escape_string($live,$cid);
    delete_comment($cid,$uid,$live);

}

like_toggle($_POST,$uid,$live);

}

$sql = "SELECT u.name,p.*,
DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') date_il, ip.name_file_img,COUNT(DISTINCT l.id) count_likes,MAX(IF(l.user_id = $uid, 1, 0)) like_user_exist, COUNT(DISTINCT c.id) count_comments 
FROM posts p JOIN users u ON p.user_id = u.id
JOIN img_profile ip ON u.id = ip.user_id 
LEFT JOIN likes l ON p.id = l.post_id 
LEFT JOIN comments c ON p.id = c.post_id 
GROUP BY p.id 
ORDER BY p.date DESC";

$result_post = mysqli_query($live,$sql);

$result_post_date = [];
if($result_post && mysqli_num_rows($result_post)){

while($row = mysqli_fetch_assoc($result_post)){

    $result_post_date[] = $row;

}

}

$data = import_comments($uid,$live);
$warning = select_sess('warning');

?>

<?php include 'tpl/header.php'; ?>
<main>
<div class="container">
    <div class="row">
        <div class="col-12 mt-4">
            <h2 class="display-4">Recent posts</h2>
            <?php if( $user_connected ): ?>
            <a href="add_post.php" class="btn btn-primary bg-cs1 p-0 mt-2 fz-18">
                <div class="px-4 p-2">
                    + New post
                </div></a>
            <?php else: ?>
            <a href="signup.php" class="btn btn-primry text-light bg-cs1 bg-img p-0 fz-18">
            <div class="bg-img-color2 px-4 p-2">
               Sign up 
               <i class="fas fa-arrow-right ml-1" style="font-size: 13px"></i>
            </div></a>
            <?php endif; ?>
        </div>
    </div>
<?php include 'tpl/posts.php' ?>
<?php include 'tpl/alert.php' ?>
</div>
</main>

<?php include 'tpl/footer.php'; ?>