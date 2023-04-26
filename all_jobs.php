<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'job_seeker'){
   header('location:login.php');
}

if(isset($_GET['company_id'])){
   $user_id = $_SESSION['user_id'];
   $company_id = $_GET['company_id'];
   $insert_message = mysqli_query($conn, "INSERT INTO bookmark (bookmark_company, bookmark_job_seeker) VALUES ('$company_id', '$user_id')") or die('query failed');
   $message[] = 'Bookmarked';
   
   header('location:user_bookmarked.php');

}

$_SESSION['job_category'] = 'All';
$_SESSION['job_sort'] = 'Date Ascending';

$_SESSION['job_type'] = 'Both Time';

$_SESSION['min_job_salary'] = 0;
$_SESSION['max_job_salary'] = 999999;


if(isset($_POST['job_sort_button'])){
   $_SESSION['job_sort'] = mysqli_real_escape_string($conn, $_POST['job_sort']);
   $_SESSION['job_category'] = mysqli_real_escape_string($conn, $_POST['category_buttons']);

   $_SESSION['job_type'] = mysqli_real_escape_string($conn, $_POST['job_type_select']);

   $_SESSION['min_job_salary'] = mysqli_real_escape_string($conn, $_POST['min_job_salary']);
   $_SESSION['max_job_salary'] = mysqli_real_escape_string($conn, $_POST['max_job_salary']);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Jobs List</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>


<div class="heading">
   <h3 style="color: white;">Available Jobs</h3>
   <p style="color: #ccc;"> <a href="home.php">Home</a> / All Available Jobs </p>
</div>


<section class="products">

   <h1 class="title">Latest Jobs</h1>
   

   <section class="search-form">
      
      <form action="" method="post">
            <select name="category_buttons" class="box">
               <option value="All">All</option>
               <option value="Teacher">Teacher</option>
               <option value="Engineer">Engineer</option>
               <option value="IT">IT</option>
               <option value="Marketing">Marketing</option>
               <option value="Customer">Customer Service</option>
               <option value="Medical">Medical</option>
               <option value="Manager">Manager</option>
               <option value="Data Entry">Data Entry</option>
               <option value="Accounting">Accounting</option>
               <option value="Bank">Bank</option>
               <option value="NGO">NGO</option>
               <option value="Others">Others</option>
            </select>

            <select name="job_type_select" class="box">
               <option value="Both Time">Both Time</option>
               <option value="Full Time">Full Time</option>
               <option value="Part Time">Part Time</option>
            </select>
            <!-- This is for sort dropdown menu -->
            <select name="job_sort" class="box"> 
            
               <option value="Date Ascending">Date Ascending</option>
               <option value="Date Descending">Date Descending</option>
               <option value="Salary Ascending">Salary Ascending</option>
               <option value="Salary Descending">Salary Descending</option>
               
            </select>

            <input type="text" name="min_job_salary" placeholder="Min Salary" value=0 class="box">
            <input type="text" name="max_job_salary" placeholder="Max Salary" value=999999 class="box">

            
               <!-- Main Button -->
               <input type="submit" value="Select" name="job_sort_button" class="btn"> 
         </form>
         
   </section>


<!-- This is for search, category, dropdown dropdown menu ENDS -->

<section class="show-products">
   <div class="box-container">

      <?php
         $job_category = $_SESSION['job_category'];
         $job_sort = $_SESSION['job_sort'];

         $job_type = $_SESSION['job_type'];

         $min_job_salary = $_SESSION['min_job_salary'];
         $max_job_salary = $_SESSION['max_job_salary'];

         

         
         if (isset($_SESSION['value'])) {
            // Use the value
            $job_header_category = $_SESSION['value'];
            
         }
        
         if(isset($_POST['job_sort_button'])){ // If the category button was not pressed
            unset($_SESSION['value']);
            
         }


         if (isset($_SESSION['value'])) {
            // Use the value
            $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` ON jobs_posted.job_company_id = company.id WHERE job_category='$job_header_category' AND job_post_status='Approved'") or die('query failed');
            // echo "<script>console.log('" . $_SESSION['value'] . "');</script>";
            
            
         }

         else if(($job_category == 'All') and ($job_sort == 'Date Ascending') and (!isset($_POST['job_sort_button']))){ // This posts everything
            $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` ON jobs_posted.job_company_id = company.id WHERE job_post_status='Approved'") or die('query failed');
            
         }



         else if(($job_category == 'All') and ($job_sort == 'Date Ascending') and ($job_type == 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` ON jobs_posted.job_company_id = company.id WHERE job_post_status='Approved'") or die('query failed');
            
         }
         else if(($job_category == 'All') and ($job_sort == 'Date Ascending') and ($job_type != 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` ON jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_post_status='Approved'") or die('query failed');
         
         }



         
         else if(($job_category != 'All') and ($job_sort == 'Date Ascending') and ($job_type == 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            
            $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_category='$job_category' AND job_salary AND job_post_status='Approved' BETWEEN '$min_job_salary' AND '$max_job_salary'") or die('query failed');
            
            
         }
         else if(($job_category != 'All') and ($job_sort == 'Date Ascending') and ($job_type != 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            
            $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_category='$job_category' AND job_type='$job_type' AND job_post_status='Approved' AND job_salary BETWEEN '$min_job_salary' AND '$max_job_salary'") or die('query failed');                  
           

         }



         
         else if(($job_category == 'All') and ($job_sort != 'Date Ascending') and ($job_type == 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            
            if($job_sort == 'Salary Ascending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_post_status='Approved' ORDER BY job_salary asc") or die('query failed');
            }
            else if($job_sort == 'Salary Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE AND job_post_status='Approved' ORDER BY job_salary desc") or die('query failed');
            }
            else if($job_sort == 'Date Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE AND job_post_status='Approved' ORDER BY job_creation_date asc") or die('query failed');
            }
            
         }
         else if(($job_category == 'All') and ($job_sort != 'Date Ascending') and ($job_type != 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            
            if($job_sort == 'Salary Ascending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_post_status='Approved' ORDER BY job_salary asc") or die('query failed');
            }
            else if($job_sort == 'Salary Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_post_status='Approved' ORDER BY job_salary desc") or die('query failed');
            }
            else if($job_sort == 'Date Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_post_status='Approved' ORDER BY job_creation_date asc") or die('query failed');
            }
            
         }




         else if(($job_category != 'All') and ($job_sort != 'Date Ascending') and ($job_type == 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            echo "<script>console.log('" . $job_sort . "');</script>";
            if($job_sort == 'Salary Ascending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_category='$job_category' AND job_post_status='Approved' ORDER BY job_salary asc") or die('query failed');
            }
            else if($job_sort == 'Salary Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_category='$job_category' AND job_post_status='Approved' ORDER BY job_salary desc") or die('query failed');
            }
            else if($job_sort == 'Date Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_category='$job_category' AND job_post_status='Approved' ORDER BY job_creation_date asc") or die('query failed');
            }
            
         }
         else if(($job_category != 'All') and ($job_sort != 'Date Ascending') and ($job_type != 'Both Time') and (isset($_POST['job_sort_button']))){ // If the category button was pressed
            echo "<script>console.log('" . $job_sort . "');</script>";
            if($job_sort == 'Salary Ascending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_category='$job_category' AND job_post_status='Approved' ORDER BY job_salary asc") or die('query failed');
            }
            else if($job_sort == 'Salary Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_category='$job_category' AND job_post_status='Approved' ORDER BY job_salary desc") or die('query failed');
            }
            else if($job_sort == 'Date Descending'){
               $select_job = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_type='$job_type' AND job_category='$job_category' AND job_post_status='Approved' ORDER BY job_creation_date asc") or die('query failed');
            }
            
         }
         
         
         
         if(mysqli_num_rows($select_job) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_job)){
            ?>
         <form action="" method="post" class="box">
         <p> <span class="details" style="font-size: 19px; color: green;"><span><?php echo $fetch_products['job_creation_date']; ?></span> </p>
            <div class="job_title"><a href="all_jobs.php?update=<?php echo $fetch_products['job_id']; ?>"><?php echo $fetch_products['job_title']; ?></a></div>
            <div class="company_name"><?php echo $fetch_products['name']; ?></div>
            <br>

            <div class="box">
               <div class="job_details"><?php echo (strlen($fetch_products['job_details']) > 70) ? substr($fetch_products['job_details'],0,30).'...' : $fetch_products['job_details']; ?></div>
            </div>
         
            
            
            
         </form>
            <?php
               }
         }else{
            echo '<p class="empty">Could not find any job posts</p>';
         }
      ?>
   </div>
<!-- To make the time stay at top right corner -->
<style>
.box p { position: relative; }
.box .details { position: absolute; top: 0; right: 0; }
</style>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $job_detail_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_id = '{$job_detail_id}'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
      <form action="" method="post" enctype="multipart/form-data">

            <img src="uploaded_img/<?php echo $fetch_update['company_logo']; ?>" alt="">
            <p type="text" name="show_job_title" class="box" style="font-size: 24px; color: purple;"><?php echo $fetch_update['job_title']; ?></p>
            <p type="text" name="show_job_title" class="box" style="font-size: 24px; color: red;"><?php echo $fetch_update['name']; ?></p>
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;"><?php echo $fetch_update['job_type']; ?></p>
            <textarea type="text" name="show_job_description" cols="50" rows="15" class="box" disabled><?php echo $fetch_update['job_details']; ?></textarea>
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;">Job Category: <?php echo $fetch_update['job_category']; ?></p>
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;">Job Post Expiration: <?php echo $fetch_update['job_expiration_date']; ?></p>

            <a href="user_job_apply.php?job_apply_id=<?php echo $fetch_update['job_id']; ?>" class="btn" style="background-color: green;">Apply Job</a>
            <a class="btn" href="search_jobs.php?company_id=<?php echo $fetch_update['id']; ?>&job_title=<?php echo urlencode($fetch_update['job_title']); ?>">Bookmark</a>
         <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'all_jobs.php'">
      </form>

         <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>