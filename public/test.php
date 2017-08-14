<?php
require_once('../includes/initialize.php');
//if (!$session->is_logged_in()) { redirect_to("login.php"); }
include_layout_template("header.php");
?>


  

<?php
/*
$product_type = new Product_type();
$product_type->type = 'الاشجار' ;
$product_type->create();

*/
$product_types = Product_type::find_all();
?>

<form action="test.php" method="get">
    <select>
        <?php 
            foreach ($product_types as $product_type):
        ?>
        <option value="<?php echo $product_type->id;?>"><?php echo $product_type->type;?></option>
        <?php endforeach;?>
    </select>
</form>


<?php

/*$product = new Product();
$product->
/*
$user = new User();
$user->gender = "ذكر" ;
$user->addres = "حلوان" ;
$user->type_id = 1;
$user->username = "يحى";
$user->password = "123" ;
$user->fname = "يحى" ;
$user->lname = "عبدالله" ;
$user->email = "yahiafcih201411@gmail.com" ;
$user->create();
//$user->full_name();
/*
 $user = User::find_by_id(2);
 $user->password ="Aa*12345";
 $user->save();*/
/*
$user = User::find_by_id(3);
$user->delete();
echo $user->first_name;
?>*/?>
<?php include_layout_template('footer.php'); ?>