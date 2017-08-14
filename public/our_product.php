
                <div class="col contant"> 
                     <div class="pro">
                        <h1>المنتجات</h1>
                        <li><a href="upload_photo.php">اضافة منتج</a></li>
                     </div> 
                   <div class="table">
                      <table>
                        <caption>جدول المنتاجات</caption>
                         <thead>
                            <tr>
                              <td>حذف</td>
                               <td>تعديل</td>
                               <td>السعر</td>
                               <td>نوع المنتج</td>
                               
                               <td>اسم المنتج</td>
                               <td>صورة المنتج</td>
                            </tr>
                         </thead>
                         <?php foreach ($products as $product):?>
                           <tr>
                               <td><a href=""><button type="submit" class="btn btn-default bt">حذف</button></a></td>
                               <td><a href=""><button type="submit" class="btn btn-default bo">تعديل</button></a></td>
                              <td><?php echo $product->price; ?></td>
                              <td><?php echo $product->productCategory() ?></td>
                               <td><?php echo $product->name;?></td>
                               <td><img src="<?php echo $product->image_path();?>" alt="ig" width="50px" height="50px"></td>
                           </tr>
                           <?php endforeach;?>
                      </table>
                   </div>
                </div>
       </div>
        

