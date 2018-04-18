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

  //Topic IDs are incremental -> Place larger IDs on top.
  //no sense to make this a prepared statement
  $conn = connectToDB();
  $sql = "SELECT fdiscussion.DiscussionID, fuser.Nickname FROM fdiscussion LEFT JOIN fuser ON fdiscussion.UserID = fuser.UserID ORDER BY DiscussionID DESC";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()){
    echo "<div class=\"topic\">
           <div class=\"topicdata\">
	         <div class=\"topicuser\">".
    $row["Nickname"];//topic starter... or at least first poster

    //Get the times and topicnames + handle no files errors
    $filename = "topics/".$row["DiscussionID"].".xml";
    
    if (file_exists($filename)){
        $filexml = simplexml_load_file($filename);// or die ("Cannot open file ".$filename);

        if (isset($filexml->post[0]->postTimeDate[0]->postTime)){//if first post has been made
            echo "<br>".$filexml->post[0]->postTimeDate[0]->postTime."<br>";
            echo $filexml->post[0]->postTimeDate[0]->postDate;
        }
        echo "</div><div class=\"topicname\"><a class=\"discussionLink\" href=\"disc.php?discussion=".$row["DiscussionID"]."\">";
        echo $filexml->nameOfTopic."</a>";
    } else {
        ?>

        </div><div class="topicname" style="color: RED;">Error in opening topicfile!
        
        <?php
    }
		
	echo "</div>
	      <div style=\"clear:both;\"></div>
	    </div>
      </div>";
  }

  $conn->close();

?>
       
     </div>

     <?php createFooter();?>
  </body>
  
  
  
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <script src="front.js"/>
</html>

