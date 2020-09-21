<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <?php if(isset(  $Accessories['style'] )): ?>
    <link rel="stylesheet" href="<?= $Accessories['style'] ?>">
    <?php endif; ?>

    <title><?= $Accessories['title'] ?></title>
  </head>
  <body>
<header class="bg-lg-img">
  <nav class="navbar navbar-expand-lg navbar-light nav-con">
      <div class="container-fluid">
  <a class="navbar-brand text-white block-logo mr-4" href="./"><i class="fas fa-compact-disc fa-2x"></i>
  <span class="text-icon">mus<span>fan</span></span>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <i class="fas fa-bars icon-menu"></i>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link text-white" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="blog.php">Blog</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if( user_connected() ): ?>
        <li class="nav-item">
        <a class="nav-link text-white" href="profile.php"><?= htmlentities(select_sess('user_name')); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="logout.php">logout</a>
      </li>
      <?php else: ?>
        <li class="nav-item">
        <a class="nav-link text-white" href="signin.php">Sign in</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="signup.php">Sign up</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
  </div>
</nav>
</header>