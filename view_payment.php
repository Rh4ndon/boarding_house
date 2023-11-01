<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}



if(isset($_POST['receive'])){

   $pay_id = $_POST['pay_id'];
   $pay_id = filter_var($pay_id, FILTER_SANITIZE_STRING);

   $update_payment = $conn->prepare("UPDATE `renters_payment` SET remarks = ? WHERE id = ?");
   $update_payment->execute(['payment received', $pay_id]);
   $success_msg[] = 'payment received successfully!';

   

}


session_start();

$renter = $_SESSION['rent'];
$property = $_SESSION['prop'];

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

   <h1 class="heading">Payments</h1>

   <div class="box-container"> 

   <?php

$select_payment = $conn->prepare("SELECT * FROM `renters_payment` WHERE renter = ? and owner = ? and property_id = ?");
$select_payment->execute([$renter, $user_id, $property ]);
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
   

   <?php }
}else{

   
echo '<p class="empty">no payment yet!</p>';
}?>

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