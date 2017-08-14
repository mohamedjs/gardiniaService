<?php
include_once '../includes/initialize.php';

if(isset($_POST['add_prod'])){
    if(!empty('prod_type')){
        $product_type = new Product_type();
        $product_type->type = $_POST['prod_type'];
        $product_type->create();
        $message = "تم اضافه نوع جديد" ;
        redirect_to("control_panel.php?page=add_product_type");
        
    }  else {
        $message = "من فضلك ادخل نوع المنتج" ;
    }
 
} else {
    $message = "";
}

?>

<form action="add_product_type.php" method="post">
    <?php output_message($message)?>
    <p><input type="text" name="prod_type" placeholder="ادخل نوع المنتج"/> </p>
    <p><input type="submit" name="add_prod" value="ADD"/> </p>
</form>

