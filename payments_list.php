<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
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
   <style>
       table {
            font-size: 20px;
            border-collapse: collapse;
            max-width: 100%;
            text-align:center;
            display: block;
        }
        thead {
            width:220px;
            background-color: #EFEFEF;
        }
        tbody {
            display: block;
        }
        tbody {
         
            
        }
        td, th {
            min-width: 220px;
            height: 25px;
            border: dashed 1px lightblue;
        }
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="requests">

   <h1 class="heading">Payments Summary</h1>

<table>
<thead>
    <tr>
        <th>Renters Name</th>
        <th>Date</th>
        <th>Remarks</th>
        <th>Proof</th>
        <th>Amount</th>
    </tr>
</thead>
<tbody>
   <?php 
      $payments = $conn->prepare("SELECT * FROM `renters_payment` WHERE owner = ? ORDER BY date_of DESC");
      $payments->execute([$user_id]);
      while($fetch_payments = $payments->fetch(PDO::FETCH_ASSOC)){
      ?>
   
    <tr>
        <td>
         <?php 
         $renters = $conn->prepare("SELECT * FROM `renters` WHERE id = ? ");
         $renters->execute([$fetch_payments['renter']]);
         $fetch_renters = $renters->fetch(PDO::FETCH_ASSOC);
         ?>
         
        <?= $fetch_renters['name']; ?></td>
        <td><?= $fetch_payments['date_of']; ?></td>
        <td><?= $fetch_payments['remarks']; ?></td>
        <td><img src="<?= $fetch_payments['proof']; ?>" width="220px" ></td>
        <td><?= $fetch_payments['amount']; ?></td>
    </tr>

    <?php }?>
    <tr>
      <td>Total Earnings</td>
      <td></td>
      <td></td>
      <td></td>
      <td>
      <?php 

      $total_payments = $conn->prepare("SELECT sum(amount) FROM `renters_payment` WHERE owner = ? ORDER BY date_of DESC");
      $total_payments->execute([$user_id]);

      while($fetch_total = $total_payments->fetch(PDO::FETCH_ASSOC)){?>
             <br>
      <h1 class='name'><?= $fetch_total['sum(amount)']; ?></h1>
            <br>
      <?php  }?>
      </td>
    </tr>
</tbody>
</table>
   



   

</section>






















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>