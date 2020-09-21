<?php

if(!function_exists('mysqli_link')){

   /**
  *
  * Database connection
  *
  * @param    string $name_db Database name
  * @return   object
  */
  function mysqli_link($name_db){

    return mysqli_connect('localhost','root','',$name_db);

  }

}

if(!function_exists('work_sess')){

  /**
 *
 * Create session
 *
 * @param    array/string $data_or_kay IDs and values or ID only
 * @param    string $val Value only
 */
 function work_sess($data_or_kay,$val = false){

  if(is_array($data_or_kay)){

   foreach($data_or_kay as $kay => $val){
     
     $_SESSION[$kay] = $val;

   }

  }

  if(is_string($data_or_kay) && is_string($val)){

    $_SESSION[$data_or_kay] = $val;

  }

 }

}

if(!function_exists('select_sess')){

   /**
  *
  * Using the session
  *
  * @param    string $name_sess The session name
  * @param    scalar/composite/null $difult Value if the session does not exist
  * @return   string/bool
  */
  function select_sess($name_sess,$difult = false){

    return $_SESSION[$name_sess] ?? $difult;

  }

}

if(!function_exists('re_on')){

    /**
   *
   * Data recovery from a field
   *
   * @param    string  $value The field name
   * @return   string
   *
   */
   function re_on($value)
   {
     return $_REQUEST[$value] ?? '';
   }

}

if(!function_exists('rand_str')){

  /**
 *
 * Create a random string
 *
 * @return   string
 *
 */
 function rand_str()
 {
   
  $token = sha1(rand(1,1000) . date('Y.m.d.h.i.s') . 'fddfds!%');

  work_sess('csrf_token', $token);
  return $token;
 
 }

}


if(!function_exists('email_exist')){

  /**
 *
 * Does the email sent exist in the user table
 *
 * @param    string $email The email we want to check
 * @param    object $live Database connection
 * @return   boolean
 *
 */
 function email_exist($email, $live)
 {

  $sql = "SELECT email FROM users WHERE email = '$email'";
  $result = mysqli_query($live, $sql);

  if($result && mysqli_num_rows($result)){

    return true;

  } else {

    return false;

  }
 
 }

}

if(!function_exists('user_connected')){

  /**
 *
 * Does the email sent exist in the user table
 *
 * @return   boolean
 *
 */
 function user_connected()
 {

  $user_connected = false;
  if(select_sess('user_id')){

    $user_ip = select_sess('user_ip', -1);
    $remote_addr =  $_SERVER['REMOTE_ADDR'] ?? 0;

    if($user_ip == $remote_addr){ 
    
    $user_agent = select_sess('user_agent', -1);
    $http_user_agent = select_sess('HTTP_USER_AGENT', 0);

    if($user_agent == $http_user_agent){

      $user_connected = true;

    }
 
    }

 }

 return $user_connected;

}

}


if(!function_exists('image_proper')){

   /**
  *
  * Checking image upload limits
  *
  * @param    array $file Details of uploaded files
  * @param    string $name_element Field name of the image
  * @return   boolean
  *
  */
  function image_proper($file, $name_element){

    $valid = false;
    $limitations = [
      'size' => 1024 * 1024 * 5,
      'finish_file' => ['jpg', 'jpeg', 'gif', 'png', 'bmp'],
      'mimes' => ['image/jpeg', 'image/gif', 'image/png', 'image/bmp']
    ];

    $file_size = $file[$name_element]['size'] ?? ++$limitations['size'];

      if($file_size <= $limitations['size']){

        $file_mime = strtolower($file[$name_element]['type']) ?? false;

        if (in_array($file_mime, $limitations['mimes'])) {

        if( isset($file[$name_element]['name']) ){
          $interpret_file = pathinfo($file[$name_element]['name']);

          if( in_array(strtolower( $interpret_file['extension'] ), $limitations['finish_file'] ) ){

            if( is_uploaded_file( $file[$name_element]['tmp_name'] ) ){

              $valid = true;

            }

          }

        }

      }

      }

      return $valid;

    }


  }

if(!function_exists('password_exists')){

   /**
  *
  * Checks that the password is correct
  *
  * @param    string $password The password the user wrote
  * @param    string $email Connected user's email
  * @param    object $live Database connection
  * @return   boolean
  *
  */
  function password_exists($password,$email,$live){

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($live,$sql);

    if($result && mysqli_num_rows($result)){

      $row = mysqli_fetch_assoc($result);
      
      if(password_verify($password, $row['password'])){

        return true;

      }

    }

    return false;

  }

}

if( !function_exists('Update_image_information') ){

   /**
  *
  * Update profile image data in a database
  *
  * @param    integer $uid User ID whose profile photo
  * @param    string $name_image The name given to the file
  * @param    object $live Database connection
  * @param    string $row_nfi Name of the previous profile photo
  */
  function Update_image_information($uid,$name_image,$live,&$row_nfi){

    $file_error = $_FILES['img-profile']['error'] ?? -1;

    if(isset($_FILES['img-profile']) && $file_error == 0){

        $sql = "UPDATE img_profile SET name_file_img = '$name_image' WHERE user_id=$uid";
        $result = mysqli_query($live,$sql);

        if($result && mysqli_affected_rows($live)){

          $row_nfi = $name_image;
          work_sess('warning','Profile picture successfully updated !!!');

        }
        
    }

}

}

if( !function_exists('import_comments') ){

   /**
  *
  * Imports all posts comments
  *
  * @param    string $uid Connected user ID
  * @param    object $live Database connection
  * @return   array
  */
  function import_comments($uid,$live){

    $data = [];
    $sql = "SELECT u.name,i.name_file_img,c.*,DATE_FORMAT(c.date, '%d/%m/%Y %H:%i:%s') date_il,IF(c.user_id = $uid, 1, 0) my_comment FROM comments c 
    JOIN users u ON c.user_id = u.id 
    JOIN img_profile i ON i.user_id = u.id 
    ORDER BY c.date DESC";

    $result_comments = mysqli_query($live,$sql);

    if($result_comments && mysqli_num_rows($result_comments)){

      while($row = mysqli_fetch_assoc($result_comments)){

        $data[$row['post_id']][] = $row;

      }

    }

    return $data;

  }

}

if(!function_exists('comment_add')){
  
   /**
  *
  * Add a comment to the post
  *
  * @param    integer $pid The post ID to which the response belongs
  * @param    string $title The title of the comment
  * @param    string $article Article of the response
  * @param    integer $uid The user ID that generated the response
  * @param    object $live Database connection
  */
  function comment_add($pid,$title,$article,$uid,$live){

    $pid = mysqli_real_escape_string($live,$pid);
    $title = mysqli_real_escape_string($live,$title);
    $article = mysqli_real_escape_string($live,$article);
    $sql = "INSERT INTO comments VALUES(NULL, $pid, $uid, '$title', '$article', NOW())";
    $result_add_comment = mysqli_query($live,$sql);

    if($result_add_comment && mysqli_affected_rows($live)){

      work_sess('warning','Comment added successfully!');

    }

  }

}

if(!function_exists('like_toggle')){

   /**
  *
  * Add or delete Like
  *
  * @param    array $post All data that comes with the post method
  * @param    integer $uid User ID whose likeness
  * @param    object $live Database connection
  */
  function like_toggle($post,$uid,$live){

    $post_pid_like = $post['pid_like'] ?? 'hii';
    $pid_like_action = $post['pid_like_action'] ?? 'hii';

      if(is_numeric($post_pid_like) && is_numeric($pid_like_action)){

      $windows_size = $post['windows-size'] ?? 0;
      $pid_like = mysqli_real_escape_string($live,$post['pid_like']);
      $sql = "SELECT * FROM likes WHERE post_id = $pid_like AND user_id = $uid";
      $result_like = mysqli_query($live,$sql);
  
      if($result_like && mysqli_num_rows($result_like) && $pid_like_action == 0){
  
          $sql = "DELETE FROM likes WHERE user_id = $uid AND post_id = $pid_like";
          $result = mysqli_query($live,$sql);
  
          if($result && mysqli_affected_rows($live)){

            work_sess('warning','The like was successfully deleted');
  
          }
  
      }elseif($result_like && mysqli_num_rows($result_like) == 0 && $pid_like_action == 1){
  
          $sql = "INSERT INTO likes VALUES(NULL,$uid, $pid_like)";
          $result = mysqli_query($live,$sql);
          
          if($result && mysqli_affected_rows($live)){
  
            work_sess('warning','the like was successfully added');

          }
  
      }
  
  }

  }

}

if(! function_exists('delete_comment')){

   /**
  *
  * Delete comment
  *
  * @param    integer $cid Response ID
  * @param    integer $uid User ID
  * @param    object $live Database connection
  */
  function delete_comment($cid,$uid,$live){

    $sql = "DELETE FROM comments WHERE id = $cid AND user_id = $uid";
    $return = mysqli_query($live,$sql);

    if($return && mysqli_affected_rows($live)){

      work_sess('warning','comment deleted successfully');      

    }

  }

}

if(!function_exists('comment_edit')){
  
  /**
 *
 * Update comment
 *
 * @param    integer $cid comment ID
 * @param    string $title The title of the comment
 * @param    string $article Article of the response
 * @param    integer $uid The user ID that generated the response
 * @param    object $live Database connection
 */
 function comment_edit($cid,$title,$article,$uid,$live){
   $cid = mysqli_real_escape_string($live,$cid);
   $title = mysqli_real_escape_string($live,$title);
   $article = mysqli_real_escape_string($live,$article);
   $sql = "UPDATE comments SET title = '$title', article = '$article' WHERE id = $cid AND user_id = $uid";
   $result_edit_comment = mysqli_query($live,$sql);

   if($result_edit_comment && mysqli_affected_rows($live)){

    work_sess('warning','comment updated!');

   }

 }

}

if(! function_exists('Accesso')){

   /**
  *
  * Starter accessories: title, style, script
  *
  * @param    string $title The title of the title
  * @param    string $style Style file location
  * @param    string $script script file location
  * @return   array
  */
  function Accesso($title,$style = '',$script = ''){

    $array = [];

    $array['title'] = $title;
    $array['style'] = $style;
    $array['script'] = $script;

    return $array;

  }

}

if(!function_exists('valid_size')){
  
   /**
  *
  * Basic Validation Tests
  *
  * @param    string $val The tested value
  * @param    bool $var_valid Variable to include proper validation
  * @param    array $min_max Character editor min and max
  * @return   string
  */
  function valid_size($val,&$var_valid,$min_max = [0,0]){

    $min_exist = !empty($min_max[0]);
    $max_exist = !empty($min_max[1]);
    if(!$val){

      $var_valid = false;
      return 'The details you wrote are incorrect';

    }elseif($min_exist && $max_exist){

      $val = mb_strlen($val);
      if($val < $min_max[0] || $val > $min_max[1]){

        $var_valid = false;
        return "Must write a minimum of $min_max[0] characters and no more than $min_max[1] characters";

      }

    }elseif($min_exist){

      $val = mb_strlen($val);
      if($val < $min_max[0]){

        $var_valid = false;
        return "Must write a minimum of $min_max[0]";

      }

    }elseif($max_exist){

      $val = mb_strlen($val);
      if($val > $min_max[1]){

        $var_valid = false;
        return "Must write a max of $min_max[0]";

      }

    }

    return '';
  }

}

