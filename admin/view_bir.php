<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:index.php');
}

session_start();

$owner = $_SESSION['doc'];

if(isset($_POST['refuse'])){

   $owner = $_POST['owner_id'];
   $update_owner = $conn->prepare("UPDATE `users` SET remarks = ? WHERE id = ?");
   $update_owner->execute(['2', $owner]);


   $warning_msg[] = 'You refuse a boarding house owner application!';

}

if(isset($_POST['approve'])){

   $owner = $_POST['owner_id'];
   $update_owner = $conn->prepare("UPDATE `users` SET remarks = ? WHERE id = ?");
   $update_owner->execute(['1', $owner]);


   $success_msg[] = 'You successfully approve a boarding house owner!';

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">


</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- admins section starts  -->

<section class="grid">

   <h1 class="heading">users document</h1>

   

   <div class="box-container">
   <?php 
   
   $select_users = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select_users->execute([$owner]);
   $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)

   ?>
   
   <div class="box">
      <p>name : <span><?= $fetch_users['name']; ?></span></p>
      <p>number : <a href="tel:<?= $fetch_users['number']; ?>"><?= $fetch_users['number']; ?></a></p>
      <p>email : <a href="mailto:<?= $fetch_users['email']; ?>"><?= $fetch_users['email']; ?></a></p>
      
   </div>
   
   <div class="box" >
   <?php 
   
   $select_bir = $conn->prepare("SELECT * FROM `bir` WHERE owner = ?");
   $select_bir->execute([$owner]);

   while($fetch_bir = $select_bir->fetch(PDO::FETCH_ASSOC)){?>
    
      <img width="85%" src="../<?= $fetch_bir['img_src']; ?>">

   <?php }?>
   
      <form action="" method="POST">
         <input type="hidden" name="owner_id" value="<?= $fetch_users['id']; ?>">
         <input type="submit" value="Approve User" onclick="return confirm('approve this user?');" name="approve" class="btn">
         <input type="submit" value="Refuse User" onclick="return confirm('refuse approval for this user?');" name="refuse" class="delete-btn">
      </form>
   </div>

   </div>

</section>

<!-- users section ends -->
















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>