<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

$Accessories = Accesso('about' ,'css/about.css');

?>

<?php include 'tpl/header.php'; ?>
<main>
<div class="container">
    <div class="row">
        <div class="col-12 mt-4">
            <h1 class="display-4">About musfan</h1>
            <p>
            The musfan site is a blog designed to be used by singers fan to create a community for that singer and a place to concentrate his content by fans.
            </p>
            <p>
            The site is designed to suit the
            simplest people so that anyone can use the site without getting involved and decide that the site is not suitable for him.
            </p>
            <p>
            Each user has to log in with the name and password he she has chosen subscribe and must keep the blog rules in order to create a good experience for all blog users.
            </p>
            <p>
            The musfan site was founded in 2020 by Shlomo shalev ben aderet and its use is free.
            </p>
            <p>
            Many singers can find a reason to use the blog as their fan site.
            </p>
        </div>
    </div>
</div>
</main>
<?php include 'tpl/footer.php'; ?>