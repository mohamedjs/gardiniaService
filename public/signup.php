
                     
        <?php  include_once '../includes/initialize.php';
                include_layout_template("header.php");
                global $session;
                if($session->is_logged_in())
                {
                    redirect_to("index.php");
                }
                $message;
                if(isset($_POST['login'])){
                    $username = trim($_POST['username']);
                    $password = trim($_POST['password']);
                    $found_user = User::authenticate($username, $password);
                    if($found_user)
                    {
                         $session->login($found_user) ; 
                        log_action('login' ,"{$found_user->username} " );
                        redirect_to("index.php"); 
                    }  else {
                         $message = "Username/password combination incorrect." ;
                    }
                }  else {
                    $username = "" ;
                    $password = "" ;
                }
        ?>
                 <?php echo output_message($message);?>    
        <div class="si">
            <div class="col logg">
                <form action="signup.php" method="post">
                    <h1>اسم المستخدم</h1>
                     <div class="input-group input-group-sm">
                         <input type="text" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3" name="username" value="<?php echo htmlentities($username);?>">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                    <h1>كلمة السر</h1>
                     <div class="input-group input-group-sm">
                         <input type="password" class="form-control" placeholder="كلمة السر" aria-describedby="sizing-addon3" name="password" value="<?php echo htmlentities($password);?>">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                    <div class="bu">
                        <input type="submit" name="login" class="btn btn-default" value="دخول">
                    </div>
                </form>    
            </div>
            <div class="col signup">
                <div class="wor">
                    <h1>تسجيل حسااب</h1>
                </div>
                <div class="bi mi">
                     <h1>اسم العائلة</h1>
                     <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                </div>
                 <div class="bi">
                     <h1>الاسم الاول</h1>
                     <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                </div>
                 <div class="bi ci">
                     <h1>البريد الالكترونى</h1>
                     <div class="input-group input-group-sm">
                        <input type="email" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                </div>
                 <div class="bi ci">
                     <h1>تاريخ الميلاد</h1>
                     <div class="input-group input-group-sm">
                        <input type="date" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                </div>
                <input type="radio" id="GENDER_MALE" name="gender" value="male" checked="checked">                <label for="GENDER_MALE">ذكر</label>
                <input type="radio" id="GENDER_FEMALE" name="gender" value="female">                <label for="GENDER_FEMALE">أنثى</label>
                 <div class="bi ci">
                     <h1>بلد الاقااامة</h1>
                     <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                </div>
                 <div class="bi ci">
                     <h1>اكلمة السر</h1>
                     <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="اسم المستخدم" aria-describedby="sizing-addon3">
                        <span class="input-group-addon" id="sizing-addon3">@</span>
                    </div>
                </div>
                    <div class="bu">
                        <button type="submit" class="btn btn-default">تسجيل</button>
                    </div>
            </div>
        </div>
                     <?php include_layout_template("footer.php");?>