<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="company_dashboard.php" class="logo"><?php echo $_SESSION['user_name']; ?></a>

      <form action="company_search.php" method="post" class="search-form">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>
      

      <div class="profile">
         
      </div>

   </section>

</header>



<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      </div>

   <nav class="navbar">
      <?php
      $company_id = $_SESSION['user_id'];
      $select_data = mysqli_query($conn, "SELECT * FROM `company` WHERE id='$company_id'") or die('query failed');
      $fetch_data = mysqli_fetch_assoc($select_data);
      ?>
      <p><img src="uploaded_img/profile_img/<?php echo $fetch_data['company_logo']; ?>" alt="Company Logo" style="width: 150px; height: 200px; display: block; margin: 0 auto;"></p>
      <a href="company_dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="company_post.php"><i class="fa-solid fa-plus"></i><span>Post a Job</span></a>
      <a href="company_applicant.php"><i class="fa-solid fa-users"></i><span>Applicants</span></a>
      <a href="company_message.php"><i class="fa-solid fa-message"></i><span>Messages</span></a>
      <a href="company_profile.php"><i class="fa-solid fa-square-poll-horizontal"></i><span>Company Profile</span></a>
      <a href="logout.php"><i class="fa fa-sign-out"></i><span>Log Out</span></a>

   </nav>

</div>

<!-- side bar section ends -->