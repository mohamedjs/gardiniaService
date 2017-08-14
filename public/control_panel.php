

<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
include_once ('../includes/initialize.php');
if($session->is_logged_in()){
    $user = User::find_by_id($session->user_id);
    if($user->type_id !=1){
        redirect_to("index.php");
    }
}  else {
    redirect_to("index.php");
}
$products = Product::find_all();

include_layout_template("header.php"); 
error_reporting( error_reporting() & ~E_NOTICE );

?>
    

            
        <div class="prof">
                <div class="col link">
                    <ul class="links">
                        <li class="active"><a href="?page=our_product">اضاافة منتج</a></li>
                        <li><a href="?page=previous_work">اضافة عمل سابق</a></li>
                        <li><a href="#">االمستخدمين</a></li>
                        <li><a href="?page=add_product_type">اضافه نوع جديد</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div> 
            
            <section>
                <?php
                if($_GET['page']){
                    $url = $_GET['page'].'.php' ;
                    
                    if(is_file($url)){
                        include_once $url;
                    }  else {
                        output_message("file not Exirt".$url);
                    }
                }  else {
                    include_once 'our_product.php';
                }
                ?>
            </section>
                
            
            <?php include_layout_template("footer.php");