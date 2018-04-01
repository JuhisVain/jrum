<?php
  require('site_setup.php');
  setUp("index");
  ?>

<!DOCTYPE html>
<meta charset="UTF-8"/>

<html>
  <head>
    <title>Juho Foorumi</title>
  </head>
  <body>
  <?php createPanel("index"); ?>

  <div id="topiclist">

<?php

  $conn = connectToDB();
  
  $sql = "SELECT fdiscussion.DiscussionID, fuser.Nickname FROM fdiscussion LEFT JOIN fuser ON fdiscussion.UserID = fuser.UserID";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()){
    echo "<div class=\"topic\">
           <div class=\"topicdata\">
	         <div class=\"topicuser\">".
		     $row["Nickname"];

    $filename = "topics/".$row["DiscussionID"].".xml";
    $filexml = simplexml_load_file($filename) or die ("Cannot open file ".$filename);

    if (isset($filexml->post[0]->postTimeDate[0]->postTime)){//if first post has been made
        echo "<br>".$filexml->post[0]->postTimeDate[0]->postTime."<br>";
        echo $filexml->post[0]->postTimeDate[0]->postDate;
    }
    echo "</div><div class=\"topicname\"><a class=\"discussionLink\" href=\"disc.php?discussion=".$row["DiscussionID"]."\">";
    echo $filexml->nameOfTopic."</a>";

		
	echo "</div>
	      <div style=\"clear:both;\"></div>
	    </div>
      </div>";
  }

  $conn->close();

?>
       
     </div>

     <div id="footer">
       kopirait juho roductions
     </div>
  </body>
  
  
  
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <script src="front.js"/>
</html>

