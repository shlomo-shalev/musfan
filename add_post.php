<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if( !user_connected() ){

    header('location: signin.php');

}

$Accessories = Accesso('add post');

$errors['title'] = $errors['article'] = '';

if( isset( $_POST['submit'] )){

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $title = trim($title);
    $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $article = trim($article);
    $valid_exist = true;
    
        $errors['title'] = valid_size($title,$valid_exist,[3,255]);
        $errors['article'] = valid_size($article,$valid_exist,[3,5000]);

    if($valid_exist){

    $user_id = select_sess('user_id');
    $live = mysqli_link('musfan');
    $title = mysqli_real_escape_string($live, $title);
    $article = mysqli_real_escape_string($live, $article);
    $sql = "INSERT INTO posts 
    VALUES(NULL, $user_id, '$title', '$article', NOW())";

    $result = mysqli_query($live,$sql);

    if($result && mysqli_affected_rows($live) > 0){

        work_sess('warning','The post was successfully added!!!');
        header('location: blog.php');
        exit;

    }

    }


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
                    <input class="form-control" type="text" name="title" id="title" value="<?= re_on('title'); ?>">
                    <span class="text-muted font-weight-bold"><?= $errors['title']; ?></span>
                </div>
                <div class="form-group">
                    <label for="article">* article:</label>
                    <textarea class="form-control" type="text" name="article" cols="30" rows="10" id="article"><?= re_on('article'); ?></textarea>
                    <span class="text-muted font-weight-bold"><?= $errors['article']; ?></span>
                </div>
                <button class="btn btn-primary bg-cs1 mt-2" type="submit" name="submit"><div class="bg-color-img">
                    sand</div></button>
                <a class="btn btn-info bg-cs3 mt-2" href="blog.php">cancel</a>
            </form>
        </div>
    </div>
</div>
</main>
<?php include 'tpl/footer.php'; ?>