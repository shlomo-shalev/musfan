<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

if( !user_connected() ){

    header('location: signin.php');

}

$uid = $_SESSION['user_id'] ?? -1;
$pid = $_GET['pid'] ?? '';


if(is_numeric($pid)){

    $live = mysqli_link('musfan');
    $pid = mysqli_real_escape_string($live, $_GET['pid']);

    $sql = "SELECT id FROM posts WHERE id= $pid AND user_id= $uid";
    $result = mysqli_query($live,$sql);

    if($result && mysqli_num_rows($result)){

        $sql = "DELETE FROM comments WHERE post_id = $pid";
        $result = mysqli_query($live, $sql);

        if($result){

        $sql = "DELETE FROM likes WHERE post_id = $pid";
        $result = mysqli_query($live, $sql);

        if($result){

        $sql = "DELETE FROM posts WHERE id = $pid";
        $result = mysqli_query($live, $sql);

        if($result && mysqli_affected_rows($live)){

        work_sess('warning', 'Successfully deleted post!!!');

        }

        }
    }
}else{

    header('location: logout.php');
    exit;

}
}


if(isset($_GET['header_post_profile'])){

    header('location: post_profile.php');
    exit;

}

header('location: blog.php');