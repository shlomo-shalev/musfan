    <div class="d-none div-windows-size"><?= $windows_size ?></div>
    <div class="d-none addPid"><?= $_POST['pid'] ?? 0 ?></div>
    <div class="d-none insert-exist"><?= $valid_exist ?? 1 ?></div>
    <div class="d-none pid_comment"><?= $pid_comment ?? 0 ?></div>
    <div class="d-none edit_no_valid"><?= isset($cid) && isset($valid_exist) && !$valid_exist ? 1 : 0 ?></div>
    <?php if($result_post && mysqli_num_rows($result_post)): ?>
    <div class="row <?= $margin ?? 'mx-2 mt-2' ?>"> 
            <?php foreach( $result_post_date as $row ): ?>
                <div class="col-12 mt-3 card" id="<?= $row['id'] ?>">
                    <div class="card-title p-3 border-bottom">
                    <img class="oj-f-center h-30p w-30p rounded-circle mr-2" src="images/profile/<?= htmlentities($row['name_file_img']) ?>" alt="profile">
                        <span><?= htmlentities($row['name']); ?></span>
                        <span class="float-right fz-15"><?= $row['date_il']; ?></span>
                    </div>
                    <div class="card-body pt-0 pb-3">
                        <div class="card-title font-weight-bold"><?= htmlentities($row['title']); ?></div>
                        <div class="card-article"><?= str_replace("\n",'<br>', htmlentities($row['article'])); ?></div>
                        <div class="row justify-content-between pt-2">
                            <div class="pl-3 d-flex">
                            <div class="p-0 m-0 d-flex">
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
                            <div class="p-0 m-0 icon-comments d-flex" data-id-comment="<?= $row['id'] ?>">
                            <i class="fas fa-comments text-cs1 fz-20 pl-3 pt-2p"></i>
                            <p class="pl-2 m-0"><?= $row['count_comments'] ?></p>
                            </div>
                        </div>
                        <?php if($uid == $row['user_id']): ?>
                            <div class="btn-group float-right">
                        <a type="button" class="dropdown-toggle dropdown-toggle-split buttom-toggle-ju" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-h fz-20 text-cs1 pt-1"></i>
                        </a>
                              <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="edit_post.php?pid=<?= $row['id'] . $header_post ?>">
                              <i class="far fa-edit"></i>
                                  Edit
                              </a>
                              <a class="dropdown-item delete-post-btn" data-toggle="modal" data-target="#myModal<?= $row['id'] ?>">
                              <i class="fas fa-eraser"></i>
                              Delete
                              </a>
                            </div>
                            </div>

                            <div class="modal" id="myModal<?= $row['id'] ?>">
                              <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">delete</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                              Are you sure?
                              </div>
                        
                              <div class="modal-footer">
                                <button type="button" class="btn bg-cs5" data-dismiss="modal">cansel</button>

                                <button type="button" class="btn btn-danger">
                                <a class="dropdown-item delete-post-btn p-0 bg-tran text-light" href="delete_post.php?pid=<?= $row['id'] . $header_post ?>">delete</a>
                                </button>
                              </div>
                              </div>
                              </div>
                              </div>

                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-none-no-inport comments" id="comments-<?= $row['id'] ?>">

                    <div class="row justify-content-between">
                        <h3 class="p-0 m-0 mt-1 fz-15">comments</h3>
                        <?php if($user_connected): ?>
                        <button class="btn btn-primary bg-cs1 py-1 fz-13 toggle-comment" data-toggle="collapse" data-target="#row-add-comment-<?= $row['id'] ?>" data-id-comment="<?= $row['id'] ?>">
                        + New comment
                        </button>
                        </div>
                        <div class="row collapse" id="row-add-comment-<?= $row['id'] ?>">
                            <form action="" method="post" class="col-12">
                            <input type="hidden" name="windows-size" class="data-windows-size" value="<?= $windows_size ?>">
                            <label for="comment-title-<?= $row['id'] ?>">title:</label>
                            <?php if($pid == $row['id']): ?>
                            <input class="form-control" type="text" name="title" id="comment-title-<?= $row['id'] ?>" placeholder="title" value="<?=  $title_re_on ?? '' ?>">
                            <span class="text-muted font-weight-bold"><?= $errors['title'] ?? '' ?></span>
                            <label class="pt-1" for="comment-article-<?= $row['id'] ?>">article:</label>
                            <textarea class="form-control h-80p" type="text" name="article" id="comment-article-<?= $row['id'] ?>" placeholder="article"><?= $article_re_on ?? '' ?></textarea>
                            <span class="text-muted font-weight-bold d-block"><?= $errors['article'] ?? '' ?></span>
                            <?php else: ?>
                            <input class="form-control" type="text" name="title" id="comment-title-<?= $row['id'] ?>" placeholder="title">
                            <span class="text-muted font-weight-bold"></span>
                            <label class="pt-1" for="comment-article-<?= $row['id'] ?>">article:</label>
                            <textarea class="form-control h-80p" type="text" name="article" id="comment-article-<?= $row['id'] ?>" placeholder="article"></textarea>
                            <span class="text-muted font-weight-bold"></span>
                            <?php endif; ?>
                                <input type="hidden" name="add" value="add">
                                <input type="hidden" name="offset-card" id="hidden-<?= $row['id'] ?>">
                            <input type="hidden" name="pid" value="<?= $row['id'] ?>">
                            <a class="btn bg-info text-light mt-2 toggle-comment" data-id-comment="<?= $row['id'] ?>" data-toggle="collapse" data-target="#row-add-comment-<?= $row['id'] ?>">cansel</a>
                            <button type="submit" name="submit" class="btn bg-cs5 mt-2"> submit</button>
                            </form>
                        </div>
                        <?php else: ?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($data[$row['id']])): ?>
                        <div class="row mt-3 ov-auto h-200p" id="comment-all-<?= $row['id'] ?>">
                            <?php foreach($data[$row['id']] as $array): ?>
                                <div class="col-12 mb-2">
                                <div class="card">
                                <div class="card-title p-3 border-bottom">
                                    <img class="oj-f-center h-30p w-30p rounded-circle mr-2" src="images/profile/<?= htmlentities($array['name_file_img']) ?>" alt="profile">
                                    <span><?= htmlentities($array['name']); ?></span>
                                    <span class="float-right fz-10"><?= $array['date_il']; ?></span>
                                </div>
                                <div class="card-body pt-0 pb-3">
                                <div class="card-title font-weight-bold" id="comment-title-<?= $array['id'] ?>"><?= htmlentities($array['title']); ?></div>
                                <div class="card-article" id="comment-article-<?= $array['id'] ?>"><?= str_replace("\n",'<br>', htmlentities($array['article'])); ?></div>
                                <?php if($uid == $array['user_id']): ?>
                            <div class="btn-group float-right">
                        <a type="button" class="dropdown-toggle dropdown-toggle-split buttom-toggle-ju" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-h fz-20 text-cs1 pt-1"></i>
                        </a>
                              <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item edit-comment"  data-toggle="modal" data-target="#form-edit" data-cid="<?= $array['id'] ?>" data-pid="<?= $array['post_id'] ?>">
                              <i class="far fa-edit"></i>
                                  Edit
                              </a>
                              <a class="dropdown-item delete-post-btn" data-toggle="modal" data-target="#myModalcomment<?= $row['id'] ?>">
                              <i class="fas fa-eraser"></i>
                              Delete
                              </a>
                            </div>
                            </div>

                            <div class="modal" id="myModalcomment<?= $row['id'] ?>">
                              <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">delete comment</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                              Are you sure?
                              </div>
                        
                              <div class="modal-footer">
                                <button type="button" class="btn bg-cs5" data-dismiss="modal">cansel</button>

                                <form action="" method="POST" class="p-0 m-0">
                                <input type="hidden" name="windows-size" class="data-windows-size" value="<?= $windows_size ?>">
                                <input type="hidden" name="pid_comment" value="<?= $array['post_id'] ?>">
                                <input type="hidden" name="cid" value="<?= $array['id'] ?>">
                                <button type="submit" name="delete_comment" class="btn btn-danger">
                                <a class="dropdown-item delete-post-btn p-0 bg-tran text-light">delete</a>
                                </button>
                                </form>
                              </div>
                              </div>
                              </div>
                              </div>

                        <?php endif; ?>
                                </div>
                                </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                                <?php else: ?>
                                    <div class="row mt-3 justify-content-center" id="comment-all-<?= $row['id'] ?>">
                                    <p>There are no comments for this post.</p>
                                    </div>
                                <?php endif; ?>
                    </div>
                </div>
                        <?php endforeach; ?>
            <?php endif; ?>

<div class="modal" id="form-edit">
  <div class="modal-dialog">
    <div class="modal-content">

    <form action="" class="p-0 m-0" method="POST">
      <div class="modal-header">
        <h4 class="modal-title">edit comment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
      <input type="hidden" name="windows-size" class="data-windows-size" value="<?= $windows_size ?>">
      <label for="edit-comment-title">title:</label>
      <?php if(isset($cid)): ?>
      <input class="form-control" type="text" name="title" id="edit-comment-title" placeholder="title" value="<?= $title_re_on ?>">
      <span class="text-muted font-weight-bold error-title-edit"><?= $errors['title'] ?></span>
      <label class="pt-1 d-block" for="edit-comment-article">article:</label>
      <textarea class="form-control h-80p" type="text" name="article" id="edit-comment-article" placeholder="article"><?= $article_re_on ?></textarea>
      <span class="text-muted font-weight-bold d-block error-article-edit"><?= $errors['article'] ?></span>
      <input type="hidden" id="edit-comment-cid" name="cid" value="<?= $cid ?>">
      <input type="hidden" id="edit-pid-comment" name="pid_comment" value="<?= $pid_comment ?>">
      <?php  else: ?>
      <input class="form-control" type="text" name="title" id="edit-comment-title" placeholder="title">
      <label class="pt-1" for="edit-comment-article">article:</label>
      <textarea class="form-control h-80p" type="text" name="article" id="edit-comment-article" placeholder="article"></textarea>
      <input type="hidden" id="edit-comment-cid" name="cid" value="">
      <input type="hidden" id="edit-pid-comment" name="pid_comment" value="">
      <?php endif; ?>
      <input type="hidden" name="edit" value="edit">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger mt-2" data-dismiss="modal">cancel</button>
        <button type="submit" name="submit" class="btn bg-cs5 mt-2"> submit</button>
      </div>
      </form>

    </div>
  </div>
</div>