<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

include 'components/save_send.php';


if(isset($_POST['upload'])){

   $id = create_unique_id();
   $owner = $_POST['owner'];

   $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
   $image_name = addslashes($_FILES['image']['name']);
   $image_size = getimagesize($_FILES['image']['tmp_name']);

   move_uploaded_file($_FILES["image"]["tmp_name"], "./uploaded_files/" . $_FILES["image"]["name"]);
   $location = "uploaded_files/" . $_FILES["image"]["name"];

   $insert_bir = $conn->prepare("INSERT INTO `bir`(id, owner, img_src) VALUES(?,?,?)");
   $insert_bir->execute([$id, $owner, $location]);
   $success_msg[] = 'document uploaded successfully!';
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/waiting_header.php'; ?>


<!-- home section starts  -->

<div class="home">

   <section class="center">
   <form action="" method="post" enctype="multipart/form-data">
   <?php 
         $user = $conn->prepare("SELECT * FROM `users` WHERE id = ? ");
         $user->execute([$user_id]);
         $fetch_user = $user->fetch(PDO::FETCH_ASSOC);
         ?>
   <?php if($fetch_user['remarks']==0){?>
   <input type="hidden" name="owner" value="<?= $fetch_user['id']; ?>">
   <input type="file" name="image" class="input" accept="image/*">
   <input type="submit" value="send bir document" class="btn" name="upload">
   <?php }else if ($fetch_user['remarks']==2) {?>
      <h3 font-size="2em">Your Application was refuse. Contact <br>
      <a href="tel:1234567890"><i class="fas fa-phone"></i><span>09654726596</span></a>, 
      <a href="tel:1112223333"><i class="fas fa-phone"></i><span>09616156123</span></a> OR <a href="mailto:shaikhanas@gmail.com"><i class="fas fa-envelope"></i><span>jericomanuel35@gmail.com</span></a>
      <br>to clarify what document is needed then send another BIR document.</h3><br><br>
      <input type="hidden" name="owner" value="<?= $fetch_user['id']; ?>">
      <input type="file" name="image" class="input" accept="image/*">
      <input type="submit" value="send bir document" class="btn" name="upload">
   <?php }else {?>
      <h3>You are successfully approved to upload your property!</h3><br>
      <h3><a href="dashboard.php">Click this to be directed to dashboard</a></h3>
   <?php }?>
      

  
   
   
   </form>
      
   </section>

</div>

<!-- home section ends -->

<!-- services section starts  -->











<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

   let range = document.querySelector("#range");
   range.oninput = () =>{
      document.querySelector('#output').innerHTML = range.value;
   }

</script>

</body>
</html>