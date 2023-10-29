<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

if(isset($_POST['delete'])){

   $delete_id = $_POST['approve_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `approve` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_request = $conn->prepare("DELETE FROM `approve` WHERE id = ?");
      $delete_request->execute([$delete_id]);
      $success_msg[] = 'payment request deleted successfully!';
   }else{
      $warning_msg[] = 'payment request deleted already!';
   }

}

if(isset($_POST['submit_rate'])){

   $approve_id = $_POST['approve_id'];
   $rating = $_POST['rate'];

   $update_payment = $conn->prepare("UPDATE `approve` SET ratings = ? WHERE id = ?");
   $update_payment->execute([$rating, $approve_id]);
   $success_msg[] = 'ratings sent successfully!';
   

}

if(isset($_POST['send_payment'])){
   $id = create_unique_id();
   
   $prop_id = $_POST['prop_id'];
   $prop_id= filter_var($prop_id, FILTER_SANITIZE_STRING);
   $amount = $_POST['amount'];
   $amount= filter_var($amount, FILTER_SANITIZE_STRING);
   $owner = $_POST['owner'];
   $owner= filter_var($owner, FILTER_SANITIZE_STRING);
   $renter = $_POST['renter'];
   $renter= filter_var($renter, FILTER_SANITIZE_STRING);

   date_default_timezone_set('Asia/Manila');
	$date = date('m-d-y');
   

   $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
   $image_name = addslashes($_FILES['image']['name']);
   $image_size = getimagesize($_FILES['image']['tmp_name']);

   move_uploaded_file($_FILES["image"]["tmp_name"], "./uploaded_files/" . $_FILES["image"]["name"]);
   $location = "uploaded_files/" . $_FILES["image"]["name"];

   $send_pay = $conn->prepare("INSERT INTO `renters_payment`(id, property_id, renter, owner, amount, proof, date_of, remarks) VALUES(?,?,?,?,?,?,?,?)");
   $send_pay->execute([$id, $prop_id, $renter, $owner, $amount, $location, $date, 'not yet receive']);
   
   $success_msg[] = 'payment sent successfully!';
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Approved Boarding House</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/home_header.php'; ?>

<!-- listings section starts  -->      

<section class="listings">

   <h1 class="heading">Approved Boarding House</h1>

   <div class="box-container">


      <?php

         $approve_rent = $conn->prepare("SELECT * FROM `approve` WHERE renter = ?");
         $approve_rent->execute([$user_id]);
         if($approve_rent->rowCount() > 0){
            $fetch_rent = $approve_rent->fetch(PDO::FETCH_ASSOC);
            $property= $fetch_rent['property_id'];

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
               <input type="hidden" name="approve_id" value="<?= $fetch_rent['id']; ?>">
               <input type="submit" value="quit rent" class="btn" onclick="return confirm('quit to rent this house?');" name="delete">
                  
               </div>

               <div class="flex-btn">
               <br>
               <h3 class="name">You rate <?= $fetch_rent['ratings']; ?> out of 5</h3>
               </div>
               <div class="flex-btn">
               
               <input type="number" maxlength="11" step="1" placeholder="enter ratings in scale of 1 - 5" class="box" name="rate" max="5" min="1">
               <input type="submit" value="submit ratings" class="btn" name="submit_rate">
                  
               </div>
               <br><br>
               <div class="flex-btn">
               <input type="file" name="image" class="input" accept="image/*">
               <input type="number" name="amount" maxlength="11" step="1" placeholder="enter Php amount" class="box" max="99999" min="1">
               </div>
               <div class="flex-btn">
               <input type="hidden" name="prop_id" value="<?= $fetch_rent['property_id']; ?>">
               <input type="hidden" name="renter" value="<?= $fetch_rent['renter']; ?>">
               <input type="hidden" name="owner" value="<?= $fetch_rent['owner']; ?>">
               
               <input type="submit" value="send payment" class="btn" name="send_payment">
                  
               </div>

               
            </div>

     

            
         </form>

         
         <?php

         $rent = $fetch_rent['renter'];
         $own = $fetch_rent['owner'];
         $pr_id = $fetch_rent['property_id'];
         
         
         }
         }else{
            $rent = '';
            $own ='';
            $pr_id ='';
            echo '<p class="empty">no approve boarding house yet!</p>';
         }
         ?>
      
         
    

      <?php

$select_payment = $conn->prepare("SELECT * FROM `renters_payment` WHERE renter = ? and owner = ? and property_id = ?");
$select_payment->execute([$rent, $own, $pr_id ]);
if($select_payment->rowCount() > 0){?>

            <form method="POST">
            <div class="box-container">
            
            

            
            <h3 class="name">Proof of Payments</h3>
            
            <div class="flex-btn"> 
               <h1 class="heading">Proof</h1>
               <br><br><br><br><br><br>
               <h1 class="heading">Amount</h1>
               <br><br> 
               <h1 class="heading">Date send</h1>
               <br><br>
               <h1 class="heading">Remarks</h1>
            </div>
            
            <?php  while($fetch_rent = $select_payment->fetch(PDO::FETCH_ASSOC))  {?>
            <div class="flex-btn"> 
               <img src="<?= $fetch_rent['proof']; ?>" alt="">
               <br>  
               <h1 class="heading"><?= $fetch_rent['amount']; ?></h1>
               <br>  
               <h1 class="heading"><?= $fetch_rent['date_of']; ?></h1>
               <br><br>
               <h1 class="heading"><?= $fetch_rent['remarks']; ?></h1>
            </div>
         
         
              <?php }}?>
              </div> 
              </form>
            
           
            

          

         
           
      
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