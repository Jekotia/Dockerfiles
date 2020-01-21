<?php include("header.php");
$user_role = $_SESSION['USER_ROLE'];
$user_id   = $_SESSION['ADMIN_ID'];

 ?>
            <!-- END PAGE HEADER-->
                   <h3 class="page-title">
                     Dashboard
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="index.php">Home</a>
                           <span class="divider">/</span>
                       </li>
                      
                       <li class="active">
                           Dashboard
                       </li>
                      
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
		<p class="dashboard_msg">Welcome to your Dashboard! You can customize your language settings using the options below. If you need help, please visit the <a href="/documentation.php" target="_blank">documentation</a> page, or visit our support forum <a href="http://linguisticlibrary.org" target="_blank">here</a>. We hope you enjoy this free software. Current Version: 1.0</p>
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="index.php">
                            <i class="icon-dashboard"></i>
                            <div class="status">Dashboard</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="admin_listing.php">
                            <i class="icon-user"></i>
                            <div class="status">Admin Accounts</div>
                        </a>
                    </div>
                    <?php 
                    $query="select *from visibility";
					$res=$db->select_data($query);
					$cnt=count($res);
					 
                    ?>
                     <div class="metro-nav-block nav-block-grey">
                        <a data-original-title="" href="language_settings.php">
                            <i class="icon-sort-by-alphabet"></i>
                            <div class="status">Language</div>
                        </a>
                    </div>
                    
                     <div class="metro-nav-block nav-block-purple">
                        <a data-original-title="" href="user_list.php">
                           <i class="icon-group"></i>
                            <div class="status">User Accounts</div>
                        </a>
                    </div>
                     <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="dictionary_list.php">
                            <i class="icon-list"></i>
                            <div class="status">Dictionary Listing</div>
                        </a>
                    </div>
                  </div>
                   <div class="metro-nav">                   
                    
                    <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="website_form.php">
                            <i class="icon-map-marker"></i>
                            <div class="status">Website</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-blue">
                        <a data-original-title="" href="add_charset.php">
                            <i class="icon-tags"></i>
                            <div class="status">Charset Management</div>
                        </a>
                    </div>
                      <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="alphabet_listing.php">
                            <i class="icon-font"></i>
                            <div class="status">Alphabet Listing</div>
                        </a>
                    </div>
                <!-- </div> -->
                
                 <!-------- 2nd row ----------------->
                 <div class="metro-nav">
                    <div class="metro-nav-block nav-block-grey">
                        <a data-original-title="" href="dictionary_settings.php">
                           <i class="icon-file-text"></i>
                            <div class="status">Dictionary Settings</div>
                        </a>
                    </div>  
                 <div class="metro-nav">
                    <div class="metro-nav-block nav-block-blue">
                        <a data-original-title="" href="/index.php">
                           <i class="icon-home"></i>
                            <div class="status">Return to Site</div>
                        </a>
                    </div>  
                    <!--<div class="metro-nav-block nav-block-green double">
                        <a data-original-title="" href="provider_listing.php">
                           <i class="icon-male"></i>
                            <div class="status">Provider Listing</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="testimonials_listing.php">
                           <i class=" icon-comments"></i>
                            <div class="status">Testimonial Listing</div>
                        </a>
                    </div> -->
                    
                     <!-- <div class="metro-nav-block nav-block-grey">
                        <a data-original-title="" href="skill_category_listing.php">
                           <i class="icon-briefcase"></i>
                            <div class="status">Skill Category</div>
                        </a>
                    </div> -->
                </div>
                <!----------------3rd Row ----------->
                <!-- <div class="metro-nav">
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="post_assignment_listing.php">
                            <i class="icon-file-text"></i>
                            <div class="status">Post Assignment</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="advertise_banner_listing.php">
                            <i class="icon-picture"></i>
                            <div class="status">Advertise Banner</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-grey">
                        <a data-original-title="" href="industry_listing.php">
                            <i class="icon-group"></i>
                            <div class="status">industry Listing</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-blue double">
                        <a data-original-title="" href="add_contact_details.php">
                            <i class="icon-book"></i>
                            <div class="status">Contact Details</div>
                        </a>
                    </div>
                     <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="add_social_links.php">
                            <i class="icon-cloud"></i>
                            <div class="status">Social Links</div>
                        </a>
                    </div>
                </div> -->
                <!----------End 3rd row --------->
                <!----------Start 4th row ------->
                <!-- <div class="metro-nav">
	                 <div class="metro-nav-block nav-block-blue">
	                        <a data-original-title="" href="bulck-upload.php">
	                           <i class="icon-upload"></i>
	                            <div class="status">Bulck Upload Fundis</div>
	                        </a>
	                 </div>
	             </div>     -->
                <!----------End 4th row ------->
                <div class="space10"></div>
                <!--END METRO STATES-->
            </div>
		 </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
 <?php include("footer.php") ?>