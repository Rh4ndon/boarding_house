<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

if(isset($_POST['delete'])){

   $delete_id = $_POST['payment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `payments` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_request = $conn->prepare("DELETE FROM `payments` WHERE id = ?");
      $delete_request->execute([$delete_id]);
      $success_msg[] = 'payment request deleted successfully!';
   }else{
      $warning_msg[] = 'payment request deleted already!';
   }

}

if(isset($_POST['send_payment'])){


   $payment_id = $_POST['payment_id'];
   


   

   $verify_payment = $conn->prepare("SELECT * FROM `payments` WHERE id = ?");
   $verify_payment->execute([$payment_id]);

   $fetch_payment = $verify_payment->fetch(PDO::FETCH_ASSOC);

   $img = $fetch_payment['img_src'];

   if($img == '0'){
      $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
      $image_name = addslashes($_FILES['image']['name']);
      $image_size = getimagesize($_FILES['image']['tmp_name']);

      move_uploaded_file($_FILES["image"]["tmp_name"], "./uploaded_files/" . $_FILES["image"]["name"]);
      $location = "uploaded_files/" . $_FILES["image"]["name"];

      $update_payment = $conn->prepare("UPDATE `payments` SET img_src = ? WHERE id = ?");
      $update_payment->execute([$location, $payment_id]);
      $success_msg[] = 'payment request sent successfully!';
   }else{
      $warning_msg[] = 'payment already sent!';
   }




   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Payment Requests</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/home_header.php'; ?>

<!-- listings section starts  -->      

<section class="listings">

   <h1 class="heading">Payment Requests</h1>

   <div class="box-container">


      <?php

         $sent_payment = $conn->prepare("SELECT * FROM `payments` WHERE renter = ?");
         $sent_payment->execute([$user_id]);
         if($sent_payment->rowCount() > 0){
            $fetch_payment = $sent_payment->fetch(PDO::FETCH_ASSOC);
            $property= $fetch_payment['property_id'];

            $total_images = 0;
            $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
            $select_properties->execute([$property]);
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){

               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$fetch_property['user_id']]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
   
               if(!empty($fetch_property['image_02'])){
                  $image_coutn_02 = 1;
               }else{
                  $image_coutn_02 = 0;
               }
               if(!empty($fetch_property['image_03'])){
                  $image_coutn_03 = 1;
               }else{
                  $image_coutn_03 = 0;
               }
               if(!empty($fetch_property['image_04'])){
                  $image_coutn_04 = 1;
               }else{
                  $image_coutn_04 = 0;
               }
               if(!empty($fetch_property['image_05'])){
                  $image_coutn_05 = 1;
               }else{
                  $image_coutn_05 = 0;
               }
   
               $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);
   
               $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
               $select_saved->execute([$fetch_property['id'], $user_id]);
   
         ?>
         <form action="" method="POST" enctype="multipart/form-data">
            <div class="box">
               <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
               <?php
                  if($select_saved->rowCount() > 0){
               ?>
               <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
               <?php
                  }else{ 
               ?>
               <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
               <?php
                  }
               ?>
               <div class="thumb">
                  <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
                  
                  <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
               </div>
               <div class="admin">
                  <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
                  <div>
                     <p><?= $fetch_user['name']; ?></p>
                     <span><?= $fetch_property['date']; ?></span>
                  </div>
               </div>
            </div>
            <div class="box">
               <div class="price"><i class="fa-solid fa-peso-sign"></i><span><?= $fetch_property['price']; ?> per room</span></div>
               <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
               <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
               <div class="flex">
                  <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
                  <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
                  <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               </div>

               <div class="flex-btn">
               <input type="file" name="image" class="input" accept="image/*">
               <input type="submit" value="send payment" class="btn" name="send_payment">
                  
               </div>

               <div class="flex-btn">
               <input type="hidden" name="payment_id" value="<?= $fetch_payment['id']; ?>">
               <input type="submit" value="delete request" class="btn" onclick="return confirm('remove this request?');" name="delete">
                  
               </div>
            </div>

            
         </form>

         
         <?php
            }
         }else{
            echo '<p class="empty">no payment request yet!</p>';
         }
         ?>
      
         


         


         
           
      
   </div>

</section>

<!-- listings section ends -->












<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>