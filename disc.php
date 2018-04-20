<?php
  require('site_setup.php');
  setUp("disc");
  ?>

<!DOCTYPE html>
<meta charset="UTF-8"/>

<html>
  <head>
    <title>
      <?php
      //title should be the name given to the topic

	$filename = "topics/".$_GET["discussion"].".xml";
	$filexml = simplexml_load_file($filename) or die ("Cannot open file ".$filename);
	echo $filexml->nameOfTopic;

	?>
    </title>
  </head>
<body>
<?php createPanel("discussion"); ?>

     <div id="topiclist">

<?php

//the xml files only have users' id numbers.
//Translate numbers to nicknames and fetch the signatures
$conn = connectToDB();
$sqlps = $conn->prepare("SELECT UserID, Nickname, Signature FROM fuser WHERE UserID=?");
$sqlps->bind_param("i",$uid);

//Get the [id].xml file with posts
$discXMLfile = "topics/".$_GET["discussion"].".xml";
$discxml = simplexml_load_file($discXMLfile) or die ("Can't find ".$discXMLfile);

//get the <post>s from xml
foreach($discxml->post as $posts){

    echo "<div class=\"post\">
	 <div class=\"postuser\">";
        //Get the nickname from mysql database:
        $uid = $posts->posterID;
        $sqlps->execute();

        $result = $sqlps->get_result();
        $row = $result->fetch_assoc();
        echo $row["Nickname"];
        //Get the time from xml:
        echo "<br>".$posts->postTimeDate->postTime."<br>".$posts->postTimeDate->postDate;
        echo "</div><div class=\"postdata\"><div class=\"postcontent\">";
        //get the post's text content from xml:
        echo $posts->postContent;
        //get the signature from mysql database
        echo "</div><div class=\"postsignature\">".$row["Signature"];
        echo "</div></div><div style=\"clear:both;\"></div></div>";
}

$conn->close();
?>
</div>
<?php if (loggedIn()){ /*if logged in show form to add new post */  ?>       
<div id="postwriter">
   <form name="writepost" id="writepost" action="" method="post">
     <input type="text" name="newpostcontent">
     <input type="submit" value="Post">
   </form>
</div>
<?php }
createFooter();
?>

  </body>

  <link rel="stylesheet" type="text/css" href="style.css"/>
  <script src="disc.js"/>
</html>

    
