
<?php


  global $session ;
  $username="";
  $password="";
  $user_type ="" ;
  if($session->is_logged_in()){
      $login_form = "" ;
      $logout = '<a href="logout.php" >log Out</a>' ;
      $user = User::find_by_id($session->user_id);
      $name = $user->fname . " " . $user->lname ;
      $login_form = '<div class="col login">'
              . $name
              . $logout
              . "</div>";
      $user_type = $user->type_id ;
      
  }else{
      $login_form = '<div class="col login">'
              . '<form action="" method="post">'
              . '<div class="input-group input-group-sm">'
              . '<input type="text" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3" name="username" value="'. $username. '">'
              . '<span class="input-group-addon" id="sizing-addon3">@</span>'
              . '</div>'
              . '<div class="input-group input-group-sm">'
              . ' <input type="password" class="form-control" placeholder="كلمة السر" aria-describedby="sizing-addon3" name="password" value="'. $password. '">'
              . '<span class="input-group-addon" id="sizing-addon3">@</span>'
              . '</div>'
              . '<div class="bu">'
              . '<input type="submit" name="login" class="btn btn-default" value="دخول">'
              . '</div>'
              . '<div class="wo">'
              . '<li><a href="forget_pass.php"> نسيت كلمة السر ؟؟</a></li>'
              . '<li><a href="signup.php">عمل حساااب</a></li>'
              . '</div>'
              . '</form>'
              . '</div>' ;
      $name = "" ;
      $logout = "" ;
  }
  
  
  $message = "" ;
  if(isset($_POST['login'])){
      $username = $_POST['username'] ;
      $password = $_POST['password'];
      $found_user = User::authenticate($username, $password);
                    if($found_user)
                    {
                         $session->login($found_user) ; 
                        log_action('login' ,"{$found_user->username} " );
                        redirect_to("index.php"); 
                    }  else {
                         $message = "Username/password combination incorrect." ;
                    }
      
//      $username = trim($_POST['username']);
  }  else {
      $username = "" ;
      $password = "" ;
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>CSS</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/Normalize.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
         <link rel="stylesheet" href="css/bootstrap.css">
         
    </head>
    <body>    <div class="logo">
            
            <!-- beginning of login div -->
            
            <?php echo $login_form;?>  
            
            <!-- ending of login div -->
            
                    <div class="col log">
                        <p><span>feed</span>  and Farm Supplies</p>
                    </div>
                    <div class="col li">
                        <a href=""><i class="fa fa-facebook fa-lg fa-fw fa-2x"></i></a>
                        <a href=""><i class="fa fa-google-plus fa-lg fa-fw fa-2x"></i></a>
                        <a href=""><i class="fa fa-twitter fa-lg fa-fw fa-2x"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
        
            <div class="navba">
                <div class="container">
                    <ul class="link">
                         <?php
                            if($user_type == 1 )
                                echo '<li><a href="control_panel.php">لوحه التحكم</a></li>';
                        ?>
                        <li><a href="about.php">عن الشركه</a></li>
                        <li><a href="products.php">المنتجات</a></li>
                        <li><a href="#">الاعمال السابقه</a></li>
                       <!-- <li><a href="#">Contact</a></li> -->
                        <li class="active"><a href="index.php">الرئيسيه</a></li>
                      
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        <!-- end header -->