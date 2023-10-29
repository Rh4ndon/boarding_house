<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['approve_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `approve` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_request = $conn->prepare("DELETE FROM `approve` WHERE id = ?");
      $delete_request->execute([$delete_id]);
      $success_msg[] = 'renter was kicked!';
   }else{
      $warning_msg[] = 'renter was kicked already!';
   }

}

if(isset($_POST['receive'])){

   $pay_id = $_POST['pay_id'];
   $pay_id = filter_var($pay_id, FILTER_SANITIZE_STRING);

   $update_payment = $conn->prepare("UPDATE `renters_payment` SET remarks = ? WHERE id = ?");
   $update_payment->execute(['payment received', $pay_id]);
   $success_msg[] = 'payment received successfully!';

   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>requests</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="requests">

   <h1 class="heading">Approved Renters</h1>

   <div class="box-container">

   <?php
      $select_requests = $conn->prepare("SELECT * FROM `approve` WHERE owner = ?");
      $select_requests->execute([$user_id]);
      if($select_requests->rowCount() > 0){
         while($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)){

        $select_sender = $conn->prepare("SELECT * FROM `renters` WHERE id = ?");
        $select_sender->execute([$fetch_request['renter']]);
        $fetch_sender = $select_sender->fetch(PDO::FETCH_ASSOC);

        $select_property = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
        $select_property->execute([$fetch_request['property_id']]);
        $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="box">
      <p>name : <span><?= $fetch_sender['name']; ?></span></p>
      <p>number : <a href="tel:<?= $fetch_sender['number']; ?>"><?= $fetch_sender['number']; ?></a></p>
      <p>email : <a href="mailto:<?= $fetch_sender['email']; ?>"><?= $fetch_sender['email']; ?></a></p>
      <p>enquiry for : <span><?= $fetch_property['property_name']; ?></span></p>
      <p>renter's ratings : <span><?= $fetch_request['ratings']; ?> out of 5</span></p>
      <form action="" method="POST">
        
      <input type="hidden" name="approve_id" value="<?= $fetch_request['id']; ?>">
      <input type="submit" value="kick renter" class="btn" onclick="return confirm('kick this renter to house?');" name="delete">
     
   </div>
   </form>

   
   
   <?php
   $rent = $fetch_request['renter'];
   $own = $fetch_request['owner'];
   $pr_id = $fetch_request['property_id'];


    }
   }else{

            $rent = '';
            $own ='';
            $pr_id ='';
      echo '<p class="empty">you have no approved renters!</p>';
   }
   ?>
   

   <?php

$select_payment = $conn->prepare("SELECT * FROM `renters_payment` WHERE renter = ? and owner = ? and property_id = ?");
$select_payment->execute([$rent, $own, $pr_id ]);
if($select_payment->rowCount() > 0){?>

   <div class="box">
   <?php  while($fetch_rent = $select_payment->fetch(PDO::FETCH_ASSOC))  {?>
      <p>Proof : <img src="<?= $fetch_rent['proof']; ?>" alt=""></p>
      <p>Amount : Php <span><?= $fetch_rent['amount']; ?></span></p>
      <p>Date : <span><?= $fetch_rent['date_of']; ?></span></p>
      <p>Remarks : <span><?= $fetch_rent['remarks']; ?></span></p>
      
      <form action="" method="POST">
      <input type="hidden" name="pay_id" value="<?= $fetch_rent['id']; ?>">
      <input type="submit" value="Receive Payment" class="btn" onclick="return confirm('Confirm Receive?');" name="receive">
      </form>
   

   <?php }}?>

   </div>
   </div>
   

</section>






















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>