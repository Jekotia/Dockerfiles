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
<div class="profile_title">How to Compose Entries</div>	
<div class="def_content">
<!-- ENTER YOUR CUSTOM CONTENT HERE -->

<center><h1>Authors: How to Compose</h1></center>
Firstly, the composition of entries should be handled by authors who already understand the language in question. Knowledge of linguistic terms, to whatever degree suffices for the language, is required. After registering and signing in, you will see your Profile page. Here, a big blue button will say "Create New Entry". Click it and the fun begins.<br>

<h2>1) The Basics</h2>

So <a href="add_new_entry.php" target="_blank">this page</a> lets you compose entries one word/morpheme at a time. Each row here is for translating one word from one language to another. You have the first few columns on the left representing the Foreign language (the language that is being translated) and after that you have the Native language columns (this is the language that the word is being translated into). Write both words down in their corresponding "Text" columns.<br><br>

You'll notice the "Order" columns next to each of these. Very often in language translations words will not be in the same orders. The order column will make sure you can rearrange the word order so that the final outcome has the proper sentence structure. What you wanna do is enter the words of the Foreign language in the proper order that they appear in the language, then <u>for the Native language, use the order columns to designate the right order, instead of entering the words in the right order going downward</u>. In other words, the Foreign language takes priority and the native language accomodates its order to it. Do this until you've composed your whole entry.

<h2>2) Adding Bold & Italics</h2>

To bold a word/morpheme, add # before it in the cell. To make a word italic, add @ before it instead. When you submit your post, the symbols will disappear and you'll just see your 
modified word. For example:<br><br>
#example = this will show up as = <b>example</b><br>
@example = this will show up as = <em>example</em><br><br>
And if your cell has more than one word it in and you only want to bold or italicize one of them, wrap that word around two of these symbols. For example:<br><br>
very #tall# man = this will show up as = very <b>tall</b> man<br><br>

The $ symbol has the effect of removing the spaces between one word and the word before it. This can be done across the whole site through the Admin Panel's Language settings, but this is an option for one-time scenarios such as hyphenated words of different roots.

<h2>3) Adding New Paragraphs</h2>

Click the "Add New Paragraph" button at the bottom of the page to start a new line. It will make a new line with <b>[br]</b> tags inserted, which will act as a paragraph divider when submitted. Now, the whole row is dedicated to the paragraph division, so don't put any other content into these cells, because then it won't show up on submit. If you change your mind about making it a paragraph, just remove the [br] tags and insert your content. You can also add the [br] tags to any line that you want to make into a paragraph breaker.

<h2>4) Adding Roots</h2>

Dictionary roots can be added from the admin panel, but also through the Add-Entry page. If, when you're entering your root word in the "Root" column, you don't see a green checkmark appear next to the word, that means that word does not exist as a root. Instead you'll see a blue "+" sign. Click on this "+" sign and it will let you create your root by using a popup box. After you create your root, close the popup box and re-enter your root into the cell. This time you should see a green checkmark and your root will show up properly when you submit your entry.<br><br>

<h2>5) Adding Alphabet Symbols</h2>

If your language has non-standard symbols (symbols not part of standard HTML) you can add each symbol as an image through the admin panel. Once you do this, the little purple icon in the Alphabetic column field will create a popup with your symbols. Each symbol will have a corresponding letter or set of letters. Click on one and you'll see it added to your text field. Please note that <u>letters must be divived with spaces</u> in this field. So if you are going to write "allen" you would do it as "a l l e n".<br><br>

Note: Spaces help the software differentiates the start of one letter from another, since sometimes in language we see double letters like "ch" or "th". If we had the word "athar", some languages may write it with four letters like: "a th a n", while others write it with five letters as: "a t h a n".<br><br>

<h2>6) Multiple Menu Items on one Word</h2>

The dropdown menus in the Morphology column of this page lets you refine your word through a series of branching menus until you get the precise word-attribute you want. But some languages require words to have more than one attribute, such as a word being positive/negative while also having a tense, a suffix/prefix, a person, or mutation.<br><br>

To add as many qualities as apply to a word, first follow the dropdown menus to the very bottom menu of your first attribute. Then, backtrack and change one of the  higher menus to something else that applies to the word, and another menu will pop up that can lead you through another end attribute. The previous attribute you entered will stay there. You can do this as many times as you'd like. There is a "Reset" button there too, in case you mess up and start a branch that you didn't want to include. Click it and you can start that word over.

<h2>7) Privacy Settings</h2>

<b>Public:</b> Pretty straightforward. The entry will appear in search results and in the library index listing.<br>
<b>Unlisted:</b> These entries will not show up through the Search function, nor in the library index. However, if you decide to add a tag to the entry, they will be searchable by that tag. In this case, the tag system can operate as a type of password. If you have a series of entries you only want your 3rd period Spanish class to view, you can tag each entry in that series with something like "SpX03" and if your students know to search for "SpX03" to get their lessons, then they'll have access to them and nobody else will. (Granted, you wanna use a  tag that isn't easily guessed, but this is just an example.)<Br>
<b>Private:</b> These entries will only be visible to you when you are logged in.<br><br>



<!-- CUSTOM CONTENT ENDS HERE -->

</div>
</div>
</div>	
<?php 
include('footer.php');
?>