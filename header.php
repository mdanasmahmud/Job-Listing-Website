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

if (isset($_GET['value'])) {
   // Set the session variable
   $_SESSION['value'] = $_GET['value'];
   header('Location: /cse471_job_listing/all_jobs.php');

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
            <a href="all_jobs.php" class="dropbtn" style="color: gray; pointer-events: none;">Job Category</a>
              <div class="dropdown-content">
                <a href="all_jobs.php?value=Accounting">Accounting</a>
                <a href="all_jobs.php?value=Bank">Bank</a>
                <a href="all_jobs.php?value=Customer Service">Customer Service</a>
                <a href="all_jobs.php?value=Data Entry">Data Entry</a>
                <a href="all_jobs.php?value=Engineer">Engineer</a>
                <a href="all_jobs.php?value=IT">IT</a>
                <a href="all_jobs.php?value=Manager">Manager</a>
                <a href="all_jobs.php?value=Marketing">Marketing</a>
                <a href="all_jobs.php?value=Medical">Medical</a>
                <a href="all_jobs.php?value=NGO">NGO</a>
                <a href="all_jobs.php?value=Teacher">Teacher</a>
                <a href="all_jobs.php?value=Others">Others</a>
                
                
              </div>
            </div>
            <a href="tutorials.php">Tutorials</a>
            
            
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_jobs.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="user-box">
            <p>Username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="user_dashboard.php" class="option-btn">Dashboard</a>
            <br>
            <br>
            <a href="logout.php" class="delete-btn">Logout</a>
         </div>
      </div>
   </div>

</header>