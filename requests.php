<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['request_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `requests` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_request = $conn->prepare("DELETE FROM `requests` WHERE id = ?");
      $delete_request->execute([$delete_id]);
      $success_msg[] = 'request deleted successfully!';
   }else{
      $warning_msg[] = 'request deleted already!';
   }

}

if(isset($_POST['payment'])){

   $id = create_unique_id();
   $owner = $_POST['owner'];
   $owner = filter_var($owner, FILTER_SANITIZE_STRING);
   $renter = $_POST['renter'];
   $renter = filter_var($renter, FILTER_SANITIZE_STRING);
   $property = $_POST['property'];
   $property = filter_var($property, FILTER_SANITIZE_STRING);

   date_default_timezone_set('Asia/Manila');
	$date = date('m-d-y');

   $send_payment = $conn->prepare("SELECT * FROM `payments` WHERE property_id = ? AND renter = ? AND owner = ?");
   $send_payment->execute([$property, $renter, $owner]);

   if(($send_payment->rowCount() > 0)){
      $warning_msg[] = 'payment request already sent!';
   }else{
      $send_request = $conn->prepare("INSERT INTO `payments`(id, property_id, renter, owner, amount, img_src, date_request) VALUES(?,?,?,?,?,?,?)");
      $send_request->execute([$id, $property, $renter, $owner, '', '0', $date]);
      $success_msg[] = 'payment request sent successfully!';
   }



   

}

if(isset($_POST['approve'])){

   $id = create_unique_id();
   $owner = $_POST['owner'];
   $owner = filter_var($owner, FILTER_SANITIZE_STRING);
   $renter = $_POST['renter'];
   $renter = filter_var($renter, FILTER_SANITIZE_STRING);
   $property = $_POST['property'];
   $property = filter_var($property, FILTER_SANITIZE_STRING);

   $location = $_POST['src'];
   $amount = $_POST['amount'];

   $delete_id = $_POST['request_id'];
   $delete_pay_id = $_POST['pay'];

   $send_payment = $conn->prepare("SELECT * FROM `approve` WHERE property_id = ? AND renter = ? AND owner = ?");
   $send_payment->execute([$property, $renter, $owner]);

   date_default_timezone_set('Asia/Manila');
	$date = date('m-d-y');

   if(($send_payment->rowCount() > 0)){
      
      $warning_msg[] = 'renter is already approved!';
   }else{
      $send_request = $conn->prepare("INSERT INTO `approve`(id, property_id, renter, owner, ratings) VALUES(?,?,?,?,?)");
      $send_request->execute([$id, $property, $renter, $owner, 'none yet!']);

      $send_pay = $conn->prepare("INSERT INTO `renters_payment`(id, property_id, renter, owner, amount, proof, date_of, remarks) VALUES(?,?,?,?,?,?,?,?)");
      $send_pay->execute([$id, $property, $renter, $owner, $amount, $location, $date, 'payment received']);

      $delete_request = $conn->prepare("DELETE FROM `requests` WHERE id = ?");
      $delete_request->execute([$delete_id]);

      $delete_payment = $conn->prepare("DELETE FROM `payments` WHERE id = ?");
      $delete_payment->execute([$delete_pay_id]);

      $success_msg[] = 'renter was approved successfully!';
   }



   

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

   <h1 class="heading">all requests</h1>

   <div class="box-container">

   <?php
      $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
      $select_requests->execute([$user_id]);
      if($select_requests->rowCount() > 0){
         while($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)){

        $select_sender = $conn->prepare("SELECT * FROM `renters` WHERE id = ?");
        $select_sender->execute([$fetch_request['sender']]);
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
      <form action="" method="POST">
         <input type="hidden" name="request_id" value="<?= $fetch_request['id']; ?>">
         <input type="hidden" name="property" value="<?= $fetch_request['property_id']; ?>">
         <input type="hidden" name="renter" value="<?= $fetch_request['sender']; ?>">
         <input type="hidden" name="owner" value="<?= $fetch_request['receiver']; ?>">

         
         <input type="submit" value="request payment" name="payment" class="btn">
         <input type="submit" value="approve" name="approve" class="btn">
         <input type="submit" value="delete request" class="btn" onclick="return confirm('remove this request?');" name="delete">
         
 
   </div>
   
   
   <?php
   $p_id = $fetch_request['property_id'];
   $rent = $fetch_request['sender'];
   $own = $fetch_request['receiver'];

   $payment_requests = $conn->prepare("SELECT * FROM `payments` WHERE property_id = ? and renter= ? and owner = ?");
   $payment_requests->execute([$p_id, $rent, $own]);

   if($payment_requests->rowCount() > 0){
      $fetch_payment = $payment_requests->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="box">
   <p>Proof of Payment</p>
   <img src="<?= $fetch_payment['img_src']; ?>" alt="">
   <p>Amount: <?= $fetch_payment['amount']; ?></p>
   <input type="hidden" name="pay" value="<?= $fetch_payment['id']; ?>">
   <input type="hidden" name="amount" value="<?= $fetch_payment['amount']; ?>">
   <input type="hidden" name="src" value="<?= $fetch_payment['img_src']; ?>">
   </box>
   
   </form>
   <?php
   }
   
   
   
   ?>
   
   
   <?php
    }
   }else{
      echo '<p class="empty">you have no requests!</p>';
   }
   ?>

   </div>

</section>






















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>