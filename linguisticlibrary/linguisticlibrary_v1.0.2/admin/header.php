<?php
header ('Content-type: text/html; charset=utf-8');
include("../includes/applicationTop.php");
	  $queryt = "select *from graphics where id=1";
	  $res	  = $db->select_data($queryt);
	  $fevicon= $res[0]['favicon'];
error_reporting(0);
ob_start(); 
session_start();
$session_admin	= $_SESSION["ADMIN_NAME"];

if($session_admin=="")
{ ?>
	<script>
	   window.location.href	= "admin_login.php";
   </script>
<?php }  

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <!-- <meta charset="utf-8" /> -->
   <title><?php echo $SITE; ?></title>
   
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="Mosaddek" name="author" />
   
   <link rel="shortcut icon" href="upload/<?php echo $fevicon;?>" type="image/x-icon">
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
   <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
   <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <!--BEGIN SIDEBAR TOGGLE-->
               <div class="sidebar-toggle-box hidden-phone">
                   <div class="icon-reorder"></div>
               </div>
               <!--END SIDEBAR TOGGLE-->
               
               <!-- BEGIN LOGO -->
               <a class="brand" href="index.php">
                 <h2><?php echo $SITE; ?></h2>
               </a>
               <!-- END LOGO -->
               
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
               <!-- END RESPONSIVE MENU TOGGLER -->
             
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >
                      
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <img src="img/avatar-mini.png" alt="">
                               
                               <span class="username">
                               	<?php 
                               
                               	  echo ucwords($session_admin);
								
								 ?>
                               	</span>
                              
                              
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu extended logout">
                               
                               <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
                           </ul>
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
           </div>
       </div>
       <!-- END TOP NAVIGATION BAR -->
   </div>
   <!-- END HEADER -->
      <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
       <!-- BEGIN SIDEBAR -->
      <div class="sidebar-scroll">
        <div id="sidebar" class="nav-collapse collapse">

         <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
         <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
               <input type="text" class="search-query" placeholder="Search" />
            </form>
         </div>
         <!-- END RESPONSIVE QUICK SEARCH FORM -->
         <!-- BEGIN SIDEBAR MENU -->
           <ul class="sidebar-menu">
              <li <?php if($page=="index") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="index.php">
                      <i class="icon-dashboard"></i>
                      <span>Dashboard</span>
                  </a>
              </li>
              <li <?php if($page=="admin_listing" || $page=="add_admin") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  	<a class="" href="admin_listing.php">
                      <i class="icon-user"></i>
                      <span>Admin Listing</span>
                   </a>
              </li>
              <li <?php if($page=="language_settings") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="language_settings.php">
                      <i class="icon-sort-by-alphabet"></i>
                      <span>Language</span>
                  </a>
              </li>
               
                  
               <li <?php if($page=="user_listing") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="user_list.php">
                      <i class="icon-group"></i>
                      <span>Accounts</span>
                  </a>
              </li>
                <li <?php if($page=="dictionary_list") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="dictionary_list.php">
                      <i class="icon-list"></i>
                      <span>Dictionary Listing</span>
                  </a>
              </li>
              <li <?php if($page=="website_form") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="website_form.php">
                      <i class="icon-map-marker"></i>
                      <span>Website</span>
                  </a>
              </li>
              <li <?php if($page=="charset_listing") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="charset_listing.php">
                      <i class="icon-tags"></i>
                      <span>Charset Manager</span>
                  </a>
              </li>
              <li <?php if($page=="alphabet_listing") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="alphabet_listing.php">
                      <i class="icon-font"></i>
                      <span>Alphabets</span>
                  </a>
              </li>
             <li <?php if($page=="dictionary_settings") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="dictionary_settings.php"> 
                      <i class="icon-file-text"></i>
                      <span>Dictionary Settings</span>
                  </a>
              </li>
           <!--   <li <?php if($page=="testimonials_listing" || $page=="add_testimnl") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="testimonials_listing.php"> 
                      <i class="icon-comments"></i>
                      <span>Testimonial Listing</span>
                  </a>
              </li> -->
           
              <!-- <li <?php if($page=="skill_category_listing" || $page=="add_skill_category") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="skill_category_listing.php"> 
                      <i class="icon-briefcase"></i>
                      <span>Skill Category</span>
                  </a>
              </li>
              <li <?php if($page=="post_assignment_listing") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="post_assignment_listing.php"> 
                      <i class="icon-file-text"></i>
                      <span>Post Assignment</span>
                  </a>
              </li>
              <li <?php if($page=="advertise_banner") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="advertise_banner_listing.php"> 
                      <i class="icon-picture"></i>
                      <span>Advertise Banner</span>
                  </a>
              </li>
              <li <?php if($page=="industry_listing") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="industry_listing.php"> 
                      <i class="icon-group"></i>
                      <span>New in industry</span>
                  </a>
              </li>
              <li <?php if($page=="add_contact_details") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                  <a class="" href="add_contact_details.php"> 
                      <i class="icon-book"></i>
                      <span>Contact details</span>
                  </a>
              </li>
               <li <?php if($page=="add_social_links") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                   <a class="" href="add_social_links.php">
                      <i class="icon-cloud"></i>
                      <span>Social Links</span>
                  </a>
              </li>
                <li <?php if($page=="bulck-upload") { ?> class="sub-menu active" <?php } else {?> class="sub-menu" <?php } ?>>
                   <a class="" href="bulck-upload.php">
                      <i class="icon-upload"></i>
                      <span>Bulck Upload Fundis</span>
                  </a>
              </li> -->
          </ul>
<a class="returning" href="..">Return to Site</a>
          
         <!-- END SIDEBAR MENU -->
      </div>
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                 