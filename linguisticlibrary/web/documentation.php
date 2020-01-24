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
<div class="profile_title">Software Documentation</div>	
<div class="def_content">
<!-- ENTER YOUR CUSTOM CONTENT HERE -->

<p id="tablecontents"><h1>Table of Contents</h1>

<ul>
<li><a href="#about">About this Software</a></li>
<li><a href="#installation">How to Install Software on a Website</a></li>
<li><a href="#morphology">How to Setup Language Morphology</a></li>
<li><a href="#themes">How to Change the Theme/Look</a></li>
<li><a href="#custom">How to Create Custom Pages</a></li>
</ul>

<hr>

<p id="about"><h2>About this Software</h2>

This software was created by the support of many linguists and fans through Kickstarter, and designed by <a href="http://adiondesigns.com/" target="_blank">adion designs</a>.
This software is version 1.0 (which was given to all backers of the project) and is an open-source platform. We give fans and enthusiasts the liberty to copy the software, experiment with and modify the functionality, and to create their own language endeavors.
 You can find a free copy of this software at: <a href="http://linguisticlibrary.org" target="_blank">Linguistic Library</a>, and there you can 
also find many useful dictionaries and morphology presets. If you have general questions not answered by this documentation, or if you've made a neat language, preset, or dictionary that you'd like to share with the world, you can contact us 
at team@adiondesigns.com and we'd be happy to help. Please keep this paragraph unchanged.

</p>
<p id="installation"><h2>How to Install the Software Online</h2>

Go to <a href="http://linguisticlibrary.org" target="_blank">http://linguisticlibrary.org</a> and download the zip file to your hard drive. Unzip the file using something like 
<a href="http://www.7-zip.org/download.html" target="_blank">7-zip</a>.<br><br>

<ul>
<li>
<b>If you're using a hosting service...</b><br>
Such as Bluehost, HostGator, GoDaddy, then login to your FTP client and you should see a list of folders. Find and click the "upload" button, then select all the files inside of the unzipped folder. Make sure you are in the folder that you want the software to be in. 
If you are in the root folder, doing this may replace your existing website. You can make a sub-folder, name it whatever you want, and expel the contents there instead.<br><br>
</li>
<li>
<b>If you have an FTP client...</b><br>
Like <a href="https://filezilla-project.org/download.php?type=client" target="_blank">Filezilla</a>, then login to your FTP account and drag-drop all of the contents of the unzipped folder into your desired directory.</li>
</ul>

When you first install the software, visit the url where the software was installed. This should initiate the installation wizard which will walk you through 
the steps needed to setup the software and your Admin account. After installation is complete, visiting your url should display the homepage of the software. 
If you want to use the software just on your computer, without needing to upload it to the internet, that can be done too but it's a bit more challenging. You will
need a third party program such as the free software <a href="https://www.apachefriends.org/index.html" target="_blank">XAMPP</a>. Follow the directions on 
their site to setup XAMPP (or WAMP for Mac users). After setup, treat the XAMPP interface as an online server and install Linguistic Library onto it by 
following the above steps the same way. </p>

<p id="morphology"><h2>How to Setup Language Morphology</h2>

This software gives the author the ability to insert grammar rule annotations to their text, so that readers can understand the author's intention and decisions for writing the 
entry as he or she did. These annotations will appear in the "Create Entry" page via dropdown menus, but to get them there first you have to create them via the "Language" tab of the Admin Panel.<br><br>

<b>Morphology Tree...</b><br>
In the Morphology section you will see an option to "create a new menu". <br>
You use these buttons to create a cascading grammar tree. So for example:
<ul>
<li>Part of Speech</li>
	<ul>
	<li>Noun</li>
	<li>Verb</li>
		<ul>
		<li>Past Tense Verb</li>
		<li>Present Tense Verb</li>
		<li>Future Tense Verb</li>
		</ul>
	<li>Preposition</li>
	<li>Adverb</li>
	</ul>
</ul>

Embed submenus inside your menus to help refine and account for all the types of words you or your community's authors will be using. 
There are a few important notes to make about these menus. 

<ul>
<li><b>Omitting Rungs of the Ladder</b><br>
Every menu and sub-menu with content in its "Abbreviation" or "Note" field will be displayed in the 
grammar column of an entry. However, if the abbreviation/note fields are left empty, then the grammar column will not display that sub-menu. This is beneficial 
if you don't want to clutter the grammar column with all of the "rungs of the ladder" of your word's designation. If you would only like to show the final outcome, 
for example "Present Tense Verb" then only enter descriptions for the last rungs of each morphology branch.<br><br></li>
<li><b>Selecting Multiple Options Within 1 Menu</b><br>
By default, all items inside of one menu are treated as options for that menu. You select one of the options and that cascades you down into whatever options exist 
inside of that one menu. But what if you want to designate multiple qualities to the same menu option? You can do that by switching the pre-checked "Child" option to the 
"root" option when creating or editing a menu item. This will treat each option within that menu as individual menus which can follow their own cascading directions.
</li>
</ul>
</p>

<p id="themes"><h2>How to Change the Theme/Look</h2>

You can change the site's theme by logging into the Admin Panel and going to the "Website" tab. There you have the options to:

<ul>
<li>Pick the name of your library/website.</li>
<li>Upload your own homepage image (1920x1080 is the size of the default)</li>
<li>Upload your own banner image, which spans across the top of any page except the homepage. (1920x500 is the size of the default)</li>
<li>Upload your own favicon (16x16 is preferred)</li>
</ul>

To make additional modifications, such as to the colors, the text types, and so forth, you can modify the "style_1.css" page that is found in the "css/" folder. Open it up either in your FTP client or on your own hard 
drive by right-clicking on it and selecting "Open With" then select "Notepad" or some other program like "Dreamweaver" if you have it.  Now, if you want to change a specific element of the page 
but don't know what CSS corresponds to it, open up that page in a web browser like Firefox or Chrome, and right click on that very element. Select "Inspect Element" and the bottom half of the browser will show you 
what that element is called. Find that element in the CSS sheet (maybe by using Ctrl+F or Command+F) and then make the appropriate changes.<br><br>

<b>Useful Links for Beginners:</b>
<ul>
<li>To learn how to change CSS elements, you can learn just about anything at: <a href="http://www.w3schools.com/css/" target="_blank">http://www.w3schools.com/css/</a></li>
<li>To select the colors that you want, you can get the hex code (for example: #47BF71) at: <a href="http://www.colorpicker.com/" target="_blank">http://www.colorpicker.com/</a></li>
</ul>


</p>
<p id="custom"><h2>How to Create Custom Pages</h2>

If you would like to create additional pages, whether informational or othewise, you can do so by copying the "default.php" page found in the root folder. Make a copy of it (right-click: copy) and paste it in the same folder 
(right-click on an empty area of the folder: paste). Right-click the copy and "rename" it to whatever you'd like the page to be called. Now, open up the page using either your FTP client's interface or a program such as 
Notepad or Dreamweaver (right-click: Open With), and there you'll be able to add your custom content. Add your custom HTML content in the space between where it says <b>"ENTER YOUR CUSTOM CONTENT HERE"</b> and <b>"CUSTOM CONTENT ENDS HERE"</b>. 
Save the page, and you're done!<br><br>

Now if you want to add that page to the top navigation menu of your site, you can do so by going into your Admin Panel, and in the Website tab input the URL (which is the name) of the page you just created. So for example, if you renamed your page to "about", then the full url will be 
"http://_______.com/about.php". Replace the long underscore with your website name. If you inserted the page in a place other than your website's root folder, then account for that, like so: "http://_______.com/____/about.php". Replace the second underscore with your path name. 
Or you could add a completely different external website link too.

</p>

<!-- CUSTOM CONTENT ENDS HERE -->

</div>
</div>
</div>	
<?php 
include('footer.php');
?>