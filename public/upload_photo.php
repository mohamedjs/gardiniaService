<?php
require_once('../includes/initialize.php');
//if (!$session->is_logged_in()) { redirect_to("login.php"); }
$product_types = Product_type::find_all();
?>


<?php
    $max_file_size = 1048576;  // expressed in bytes
	                            //     10240 =  10 KB
	                            //    102400 = 100 KB
	                            //   1048576 =   1 MB
	                            //  10485760 =  10 MB
    //$message = "" ;
    if(isset($_POST['submit'])){
        $photo = new Product();
        $photo->name = $_POST['product_name'];
        $photo->description = $_POST['description'];
        $photo->price = $_POST['price'];
        $photo->type = $_POST['type'];
        $photo->attach_file($_FILES['file_upload']);
        if ($photo->save()){
            //Success
           $session->message("photo Uploaded successfully.") ;
            redirect_to('control_panel.php?page=our_product');
        }  else {
            //Failure
            $message = join("<br />", $photo->errors);
        }
    }
    // public $id ;    public $name ;    public $filename ;    public $description ;    public $price ;    public $type ;
?>
<?php include_layout_template('header.php');?>
    <h2>Photo Upload</h2>
    <?php echo output_message($message)?>
    <form action="upload_photo.php" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
    <p><input type="file" name="file_upload" /></p>
    <p>اسم المنتج: <input type="text" name="product_name" value="" /></p>
    <p>الوصف: <input type="text" name="description" value="" /></p>
    <p>السعر: <input type="text" name="price" value="" /></p>
    <p>نوع المنتج :</p>
    <select name="type">
        <?php 
            foreach ($product_types as $product_type):
        ?>
        <option value="<?php echo $product_type->id;?>"><?php echo $product_type->type;?></option>
        <?php endforeach;?>
    </select>
    <input type="submit" name="submit" value="Upload" />
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