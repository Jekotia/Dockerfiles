<?php
include('header.php');
include_once('includes/applicationTop.php');
?>
<!--- DEFAULT PAGE --->
<link rel="stylesheet" type="text/css" href="css/style_homepage.css">
<style>
.main_wrap {background-color: #fff;}
a:link {color: #907ed1;}
a:visited {color: #907ed1;}
a:hover {color: blue;}
a.menubtn:link {color: #eee;}
a.menubtn:visited {color: #eee;}
a.menubtn:hover {color: #eee;}
ul.navbar-nav li a:link {color: #eee;}
ul.navbar-nav li a:visited {color: #eee;}
ul.navbar-nav li a:hover {color: #999;}
</style>
</head>
<div class="container">
<div class="main_wrap" style="height:auto; min-height: 469px;">
<div class="profile_title">Page Name</div>	
<div class="def_content">
<!-- ENTER YOUR CUSTOM CONTENT HERE -->


<form name="contactform" method="post" action="report.php">
<table width="450px" style="color: black;">
<tr>
 <td valign="top">
  <label for="first_name">First Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top"">
  <label for="last_name">Last Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="last_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="email">Email Address *</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="telephone">Telephone Number</label>
 </td>
 <td valign="top">
  <input  type="text" name="telephone" maxlength="30" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="comments">Message *</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="1000" cols="25" rows="6">Copy & Paste the URL in question here: </textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Submit">
 </td>
</tr>
</table>
</form>


<br><br><br>



<!-- CUSTOM CONTENT ENDS HERE -->

</div>
</div>
</div>	
<?php 
include('footer.php');
?>