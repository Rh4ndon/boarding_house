<!-- header section starts  -->

<header class="header">

   <nav class="navbar nav-1">
      <section class="flex">
         <a href="dashboard.php" class="logo"><i class="fas fa-house"></i>Boarding House Owner Page</a>

         <ul>
            <li><a href="post_property.php">add boarding house<i class="fas fa-paper-plane"></i></a></li>
         </ul>
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               <li><a href="#">my listings<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="dashboard.php">dashboard</a></li>
                     <li><a href="post_property.php">add boarding house</a></li>
                     <li><a href="my_listings.php">my listings</a></li>
                  </ul>
               </li>
               
               
               <li><a href="#">Listed Boarding House Map<i class="fas fa-angle-down"></i></a>
                  <ul>
                  <li><a href="map_owner.php">map and route</a></li>
                  </ul>
               </li>
               </li>
            </ul>
         </div>

         <ul>
           
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