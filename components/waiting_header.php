<!-- header section starts  -->

<header class="header">

   <nav class="navbar nav-1">
      <section class="flex">
         <a href="" class="logo"><i class="fas fa-house"></i>Boarding House Mapping and Reservation System</a>

         
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               
               <li><a href="#">options<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="">dashboard</a></li>
                     <li><a href="">filter search</a></li>
                     <li><a href="">all listed boarding house</a></li>
                  </ul>
               </li>
               <li><a href="#">help<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="">about us</a></i></li>
                     <li><a href="">contact us</a></i></li>
                  </ul>
                  <li><a href="#">Listed Boarding House Map<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="">map and route</a></li>
                  </ul>
               </li>
               </li>
            </ul>
         </div>

         <ul>
            <li><a href="">saved <i class="far fa-heart"></i></a></li>
            <li><a href="#">account <i class="fas fa-angle-down"></i></a>
               <ul>
                  <li><a href="register.php">register new</a></li>
                  <?php if($user_id != ''){ ?>
                  <li><a href="update.php">update profile</a></li>
                  <li><a href="components/user_logout.php" onclick="return confirm('logout from this website?');">logout</a>
                  <?php }else {?>
                  <li><a href="login.php">login now</a></li>

                  <?php } ?></li>
               </ul>
            </li>
         </ul>
      </section>
   </nav>

</header>

<!-- header section ends -->