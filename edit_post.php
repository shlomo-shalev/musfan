<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if( !user_connected() ){

    header('location: signin.php');

}


$Accessories = Accesso('edit post');

$header = isset($_GET['header_post_profile']) ? 'post_profile.php' : 'blog.php';
$live = mysqli_link('musfan');
$errors['title'] = $errors['article'] = '';
if(isset($_GET['pid']) && is_numeric($_GET['pid'])){
    $pid = mysqli_real_escape_string($live, $_GET['pid']);
}else{
    header('location: logout.php');
}
$user_id = select_sess('user_id', '');

if( isset( $_POST['submit'] ) ){


    $post_title = re_on('title');
    $post_article = re_on('article');
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $title = trim($title);
    $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $article = trim($article);
    $valid_exist = true;
    

        $errors['title'] = valid_size($title,$valid_exist,[3,255]);
        $errors['article'] = valid_size($article,$valid_exist,[3,5000]);


    if($valid_exist){

    $title = mysqli_real_escape_string($live, $title);
    $article = mysqli_real_escape_string($live, $article);
    $sql = "UPDATE posts SET title = '$title', article = '$article' WHERE id = $pid AND user_id = $user_id";
    
    $result = mysqli_query($live,$sql);
    
    if($result && mysqli_affected_rows($live)){

        work_sess('warning', 'Post successfully updated!!!');
        
        header('location: ' . $header);
        exit;

    }else{
        $errors['article'] = 'In order to update the post you must update one of the data or the title or article';
    }

    }

}else {

    $sql = "SELECT title,article FROM posts WHERE id = $pid AND user_id = $user_id";
    $result = mysqli_query($live,$sql);
    $post = mysqli_fetch_assoc($result);
    $post_title = $post['title'];
    $post_article = $post['article'];
}

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mt-3 box-s">
            <h1 class="display-4 text-center">Add new post</h1>
            <p class="text-center">Add a new post to the musfan site.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="title">* title:</label>
                    <input class="form-control" type="text" name="title" id="title" value="<?= $post_title; ?>">
                    <span class="text-muted font-weight-bold"><?= $errors['title']; ?></span>
                </div>
                <div class="form-group">
                    <label for="article">* article:</label>
                    <textarea class="form-control" type="text" name="article" cols="30" rows="10" id="article"><?= $post_article; ?></textarea>
                    <span class="text-muted font-weight-bold"><?= $errors['article']; ?></span>
                </div>
                <button class="btn btn-primary bg-cs1 mt-2" type="submit" name="submit"><div class="bg-color-img">
                    sand</div></button>
                <a class="btn btn-info bg-cs3 mt-2" href="<?= $header; ?>">cancel</a>
            </form>
        </div>
    </div>
</div>
</main>
<?php include 'tpl/footer.php'; ?>