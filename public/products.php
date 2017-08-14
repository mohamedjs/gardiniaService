<?php

include_once '../includes/initialize.php';

include_layout_template("header.php");
$products = Product::find_all();
?>


        <div class="produ">
            <div class="container">
                <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="image">
                        <img src="<?php echo $product->image_path();?>" alt="">
                    </div>
                    <div class="contant">
                        <p>
                            <?php echo $product->description;?>
                        </p>
                        <span><?php echo $product->price;?></span>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
           

<?php include_layout_template("footer.php");