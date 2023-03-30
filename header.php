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

<style>

.dropdown {
  position: relative;
  display: inline-block;
  text-align: center;
}

.dropdown-content {
  display: none;
  position: absolute;
  z-index: 1;
  background-color: white;
  border: 1px solid black;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  padding: 10px;
  width: 200px; /* change this value as needed */

  left: 50%;
  transform: translateX(-50%);
  
}

.dropdown-content a {
  display: block;
  padding: 5px 10px;
  border-bottom: 1px solid #ddd;
  font-size: 12px; /* change this value as needed */

  text-align: center;
  line-height: 1.5;
}

.dropdown-content a:last-child {
  border-bottom: none;
}

.dropdown:hover .dropdown-content {
  display: block;
}




</style>

<header class="header">


   <div class="header-2">
      <div class="flex">
      
         <a href="home.php" class="logo">Job Lister</a>

         <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="all_jobs.php">All Jobs</a>

            <div class="dropdown">
              <a href="all_job_categories.php" class="dropbtn">Job Category</a>
              <div class="dropdown-content">
                <a href="#">Category 1</a>
                <a href="#">Category 2</a>
                <a href="#">Category 3</a>
              </div>
            </div>

            <a href="applied_jobs.php">Applied Jobs</a>
            
            
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_jobs.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="user-box">
            <p>Username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="user_profile.php" class="option-btn">Profile</a>
            <a href="logout.php" class="delete-btn">Logout</a>
         </div>
      </div>
   </div>

</header>