<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

$Accessories = Accesso('home' ,'css/content-home.css', 'js/post.js');

$uid = select_sess('user_id', -1);
$live = mysqli_link('musfan');
$windows_size = $_POST['windows-size'] ?? 0;

if( user_connected() ){

like_toggle($_POST,$uid,$live);

}

$sql = "SELECT u.name,p.*,
DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') date_il,COUNT(l.post_id) count_likes,
MAX(IF(l.user_id = $uid, 1, 0)) like_user_exist 
FROM posts p JOIN users u ON p.user_id = u.id 
LEFT JOIN likes l ON p.id = l.post_id 
GROUP BY p.id 
ORDER BY p.date DESC LIMIT 3";

$result = mysqli_query($live,$sql);
$warning = select_sess('warning');

?>

<?php include 'tpl/header.php'; ?>
    <main>
    <div class="d-none div-windows-size"><?= $windows_size ?></div>
        <div class="div-con">
            <div class="row">
                <div class="bgccc"></div>
                <div class="col-12 text-center mt-5">
                    <h1 class="welcome">Welcome to musfan!</h1>
                    <p class="mx-2">
                    Here you can share the music you love and find other fans who also admire your singer
                    </p>
                    <a href="signup.php" class="btn mt-2 btn-lg btn-but">Blogzzz signup!</a>
                </div>
            </div>
            </div>
        </div>
        <div class="container-fluid all-information mt-3">
            <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 ml-1 mr-1 information">
                <div class="box-information">
                <i class="fas fa-handshake fz-60"></i>
            <h3 class="text-center">A small community</h3>
            <p class="text-center fz-1">Here you can search for people who adore the same singer you admire, share posts about it and concentrate on the same singer's content in one place.</p>
            </div>
            </div>
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 ml-1 mr-1 information">
                <div class="box-information">
                <i class="fas fa-sitemap fz-60 mb-3"></i>
            <h3 class="text-center">Simple system</h3>
            <p class="text-center">This blog doesn't have too many special capabilities. All you have to do is simply flush your content by a simple page and manage it easily.</p>
        </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 ml-1 mr-1 information">
                <div class="box-information">
                    <span class="log-in-out">
                    <i class="fas fa-sign-in-alt fz-60 mr-3"></i>
                <i class="fas fa-sign-out-alt fz-60"></i>
                </span>
            <h3 class="text-center">Registration and login</h3>
            <p class="text-center">We don't need too much of your information, just an email and password you choose.</p>
        </div>
        </div>
        </div>
        </div>
        <h2 class="top-post mt-3">Recent Posts</h2>
        <div class="container-fluid mt-3">
        <div class="row mx-2 justify-content-center">
        <?php while( $row = mysqli_fetch_assoc($result) ): ?>
            <div class="col-xl-3 col-lg-4 mb-2 mx-1 card" id="posts">
                    <div class="card-title py-3 px-0 border-bottom">
                        <span><?= htmlentities($row['name']); ?></span>
                        <span class="float-right fz-10"><?= $row['date_il']; ?></span>
                    </div>
                    <div class="card-body dd pt-0">
                        <div class="card-title font-weight-bold"><?= htmlentities($row['title']); ?></div>
                        <div class="card-article"><?= htmlentities($row['article']); ?></div>
                        </div>
                          <div class="card-footer bg-white">
                          <div class="d-flex">
                                <?php if($uid != -1): ?>
                                     <?php if($row['like_user_exist']): ?>
                                        <form class="p-0 m-0" action="" method="POST">
                                            <input type="hidden" name="pid_like" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="pid_like_action" value="0">
                                            <input type="hidden" name="windows-size" class="data-windows-size" value="<?= $windows_size ?>">
                                            <button class="p-0 m-0 btn" type="submit" name="submit_like"><i class="fas fa-thumbs-up text-cs1 fz-20 like-yes"></i></button>
                                        </form>
                                     <?php else: ?>
                                        <form class="p-0 m-0" action="" method="POST">
                                            <input type="hidden" name="pid_like" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="pid_like_action" value="1">
                                            <input type="hidden" name="windows-size" class="data-windows-size" value="<?= $windows_size ?>">
                                            <button class="p-0 m-0 btn" type="submit" name="submit_like"><i class="far fa-thumbs-up text-cs1 fz-20 like-no"></i></button>
                                        </form>
                                     <?php endif; ?>
                                     <?php else: ?>
                                        <a class="p-0 m-0" href="signin.php">
                                        <i class="far fa-thumbs-up text-cs1 fz-20"></i>
                                        </a>
                                     <?php endif; ?>
                                <p class="pl-2 m-0"><?= $row['count_likes'] ?></p>
                                </div>
                          </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php if($uid != -1): ?>
        <p class="fz-10 mx-1 text-center">To edit and delete posts go to the blog page or profile page page In addition to see edit and delete comments you can only do this on the blog page</p>
        <?php else: ?>
            <p class="mx-1 text-center">Comments are only visible on the blog page and on the profile posts page</p>
        <?php endif; ?>
        </div>
<?php include 'tpl/alert.php' ?>
    </main>
    <?php include 'tpl/footer.php'; ?>