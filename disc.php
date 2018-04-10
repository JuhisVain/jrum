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

$conn = connectToDB();
$sqlps = $conn->prepare("SELECT UserID, Nickname, Signature FROM fuser WHERE UserID=?");
$sqlps->bind_param("i",$uid);
	 
$discXMLfile = "topics/".$_GET["discussion"].".xml";
$discxml = simplexml_load_file($discXMLfile) or die ("Can't find ".$discXMLfile);

foreach($discxml->post as $posts){

    echo "<div class=\"post\">
	 <div class=\"postuser\">";

        //$sql = "SELECT UserID, Nickname, Signature FROM fuser WHERE UserID=".$posts->posterID;
        $uid = $posts->posterID;
        $sqlps->execute();
        //$result = $conn->query($sql);
        $result = $sqlps->get_result();
      $row = $result->fetch_assoc();
      echo $row["Nickname"];
      echo "<br>".$posts->postTimeDate->postTime."<br>".$posts->postTimeDate->postDate;
      echo "</div><div class=\"postdata\"><div class=\"postcontent\">";
      echo $posts->postContent;
      echo "</div><div class=\"postsignature\">".$row["Signature"];
      echo "</div></div><div style=\"clear:both;\"></div></div>";
}


	 
$conn->close();
?>
     </div>
<?php if (loggedIn()){ ?>       
     <div id="postwriter">
         <form name="writepost" id="writepost" action="" method="post">
             <input type="text" name="newpostcontent">
             <input type="submit" value="Post">
         </form>
     </div>
<?php } ?>
     <div id="footer">
       kopirait juho roductions
     </div>
	 
  </body>
  
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <script src="disc.js"/>
</html>

    
