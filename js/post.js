if($('.edit_no_valid').text() == 1){
    
    $("#form-edit").modal();
  
  }
    
    $('#comments-' + $('.pid_comment').text()).toggle();
  
    $(document).scroll(function (){
  
      var windwsSize = $(document).scrollTop();
      $('.data-windows-size').attr('value',windwsSize);
  
  
    });
  
  var addPid = $('.addPid').text();
  var insertExist = $('.insert-exist').text();
  
  if(insertExist == 1){
    $('#comments-' + addPid).toggle();  
  }else{  
  $('#comment-all-' + addPid).toggle();
  $('#row-add-comment-' + addPid).addClass('show');
  $('#comments-' + addPid).toggle();
  }
  
  var windowsSize = $('.div-windows-size').text();
  $(document).scrollTop(windowsSize);
  
  $('.like-yes').on('mouseenter', function (){
  
    $(this).removeClass('fas fa-thumbs-up')
    .addClass('far fa-thumbs-up');
  
  });
  
  $('.like-yes').on('mouseout', function (){
  
    $(this).removeClass('far fa-thumbs-up')
    .addClass('fas fa-thumbs-up');
  
  });
  
  $('.like-no').on('mouseenter', function (){
  
    $(this).removeClass('far fa-thumbs-up')
    .addClass('fas fa-thumbs-up');
  
  });
  
  $('.like-no').on('mouseout', function (){
  
    $(this).removeClass('fas fa-thumbs-up')
    .addClass('far fa-thumbs-up');
  
  });
  
  $('.icon-comments').on('click', function (){
    
    var id = $(this).data('id-comment');
  
    $('#comments-' + id).toggle();
  
  });
  
  $('.toggle-comment').on('click', function (){
    
    var id = $(this).data('id-comment');
  
    $('#comment-all-' + id).toggle();
  
  });
  
  $('.edit-comment').on('click', function (){
    
    var cid = $(this).data('cid'),
    pid = $(this).data('pid');
    
    $('#edit-comment-cid').attr('value', cid);
    $('#edit-pid-comment').attr('value', pid);
    $('#edit-comment-title').attr('value', $('#comment-title-' + cid).text());
    $('#edit-comment-article').text($('#comment-article-' + cid).text());
    $('.error-title-edit').text('');
    $('.error-article-edit').text('');
  
  
  });