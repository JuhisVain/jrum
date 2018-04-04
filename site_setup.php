<?php
require('login_handler.php');
require('post_creator.php');
session_start();

function setUp($mode){
    loginSignup();
    if ($mode == "disc"){
        echo "disc mode";
        if ('POST' == $_SERVER[ 'REQUEST_METHOD' ]){
            echo "post is set";
            if (isset($_POST['newtopic']) && loggedIn()){//new topic
                //Sanitize topicname:

                $sanetopic = filter_var($_POST['newtopic'], FILTER_SANITIZE_STRING);
                $sanetopic = htmlspecialchars($sanetopic);
                
                $conn = connectToDB();
                $sql = "INSERT INTO fdiscussion (UserID) VALUES (".$_SESSION["userid"].");";
                $conn->query($sql);
                $sql = "SELECT * FROM fdiscussion WHERE UserID=".$_SESSION["userid"]." ORDER BY DiscussionID DESC;";
                $result = $conn->query($sql);
                $discId = $result->fetch_assoc()["DiscussionID"];


                echo "Creating new topic with: ".$discId." and ".$sanetopic." !";
                $success = createNewTopic($discId, $sanetopic);

                if (!$success){
                    echo "Something's broken";
                    $sql = "DELETE FROM fdiscussion WHERE DiscussionID=".$discId.";";
                    $conn->query($sql);
                }

                $conn->close();
            }
            if (isset($_POST['newpostcontent']) && loggedIn()){//new post
                //sanitize post:
                $sanepost = filter_var($_POST['newpostcontent'], FILTER_SANITIZE_STRING);
                //more sanitizing:
                $sanepost = htmlspecialchars($sanepost);
                
                echo "newpost in disc: ".$_GET["discussion"]."xxx ";
                createNewPost($sanepost,$_GET["discussion"]);
                
            }
        }
    }
}
	 
function loginSignup(){
    if ('POST' == $_SERVER[ 'REQUEST_METHOD' ]){
        if (isset($_POST['signup'])){
            signup($_POST['username'],$_POST['password']);
      	}
      	if (isset($_POST['login'])){
            login($_POST['username'],$_POST['password']);
        }
        if (isset($_POST['logout'])){
            logout();
        }
    }
}


function createPanel($mode){ //ttu mitä skaa
?>
    <div id="header">
      <div id="control">
        <div id="navigation">
	      <a href="index.php">BACK</a>
	    </div>
<?php if ($mode == "index"){	//createtopic div for index.php
?>
        <div id="createtopic" class="controlcentre">
<?php   if ( loggedIn() ){ ?>
          <form name="topiccreator" id="topiccreator" action="disc.php" method="post">
      	    <input type="text" name="newtopic">
	        <input type="submit" value="Create new topic">
          </form>
<?php   } ?>
        </div>
<?php } else if ($mode == "discussion"){  //topictopic div for disc.php
?>
        <div id="topictopic" class="controlcentre">
          <div id="topicstarter">
<?php

$tsfilename = "topics/".$_GET["discussion"].".xml";
$tsfilexml = simplexml_load_file($tsfilename) or die ("sprölö");
if (isset($tsfilexml->post[0]->posterID)){
echo idToNick($tsfilexml->post[0]->posterID);
     	  
echo "<br>";

echo $tsfilexml->post[0]->postTimeDate[0]->postTime;

echo "<br>";

echo $tsfilexml->post[0]->postTimeDate[0]->postDate;
}
?>
     </div>
     <div id="topicstart">
<?php
echo $tsfilexml->nameOfTopic;
?>
     </div>
 </div>
 <?php
	 } else echo "tilt";


	 //login thing:
?>
<div id="user">

	   <?php
	     if ( loggedIn() ){ ?>
	   <form name="logout" id="logout" action="" method="post">
	     <?php echo $_SESSION["nickname"]."<br>" ?>
	     <input type="submit" name="logout" value="Log out">
	   </form>
	   <?php } else { ?>
	   <form name="login" id="login" action="" method="post">
	     <input type="text" name="username"><br>
	     <input type="password" name="password"><br>
	     <input type="submit" name="login" value="Log in">
	     <input type="submit" name="signup" value="Sign up">
	   </form>

	   <?php } ?>

	 </div>
	 <div style="clear:both;"></div>
       </div>
     </div>
<?php

}

?>
