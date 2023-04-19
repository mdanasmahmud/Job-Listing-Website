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
      <a href="company_dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="company_post.php"><i class="fa-solid fa-plus"></i><span>Post a Job</span></a>
      <a href="company_applicant.php"><i class="fa-solid fa-users"></i><span>Applicant</span></a>
      <a href="logout.php"><i class="fa fa-sign-out"></i><span>Log Out</span></a>

   </nav>

</div>

<!-- side bar section ends -->