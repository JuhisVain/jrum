<?php
//There's nothing but a signature modifying field here
require('site_setup.php');
setUp("settings");

if ('POST' == $_SERVER[ 'REQUEST_METHOD' ]) {
  if (isset($_POST['signature']) && loggedIn()) { //New signature

    $sanSig = filter_var($_POST['signature'], FILTER_SANITIZE_STRING);
    $sanSig = htmlspecialchars($sanSig);

    $conn = connectToDB();
    $sql = "UPDATE fuser SET Signature='".$sanSig."' WHERE UserID='".$_SESSION["userid"]."';";
    $conn->query($sql);
    $conn->close();
  }
}

?>

<!DOCTYPE html>
<meta charset="UTF-8"/>

  <html>
  <head>
  <title>User settings</title>
  </head>
  <body>
  <?php createPanel("settings");
  if (loggedIn()) { ?>
                    
                    <div id="settingsform">
                    <form name="settingschange" id="settingschange" action="" method="post">
                    Your signature: <input type="text" name="signature"
<?php
                    echo "value=\"";
                    $conn = connectToDB();
                    $sql = "SELECT * FROM fuser WHERE UserID=".$_SESSION["userid"];
                    $result = $conn->query($sql);
                    echo $result->fetch_assoc()["Signature"];
                    $conn->close();
                    echo "\">";
?>
                    <input type="submit" value="Apply changes">
                    </form>
                    </div>


<?php } else echo "You shouldn't be here.";
                    createFooter(); ?>
  
  </body>
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <script src="front.js"/>
</html>
