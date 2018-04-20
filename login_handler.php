<?php
require('db_handling.php');

//Sign up button presssed:
function signup($un,$pw){

    $oldpw = $pw;
    $oldun = $un;
    
    $un = filter_var($un, FILTER_SANITIZE_STRING);
    $pw = filter_var($pw, FILTER_SANITIZE_STRING);

    if ($oldpw != $pw || $oldun != $un){
        echo "Don't use goofy characters!";
        return;
    }

    $hashedpw = password_hash($pw,PASSWORD_DEFAULT);
    
    $conn = connectToDB();
    $sql = "INSERT INTO fuser (Nickname, Password) VALUES (\"".$un."\", \"".$hashedpw."\");";
    $message = $conn->query($sql);
    if ($conn->error){
        echo "That nickname already exists!"; //Probably
        $conn->close();
        return;
    }
    $conn->close();
    login($un,$pw);
}

//login button pressed:
function login($un,$pw){
    $un = filter_var($un, FILTER_SANITIZE_STRING);
    $pw = filter_var($pw, FILTER_SANITIZE_STRING);
    $conn = connectToDB();
    $sql = "SELECT * FROM fuser WHERE Nickname=\"".$un."\";";
    $result = $conn->query($sql);
    $line = $result->fetch_assoc();

    if (password_verify($pw, $line["Password"])){
        $_SESSION["userid"] = $line["UserID"];
        $_SESSION["nickname"] = $line["Nickname"];
    } else {
        echo "Password or nickname wrong!<br>";
    }
    $conn->close();
}

function logout(){
    session_unset();
    session_destroy();
}

//Check if user is logged in:
function loggedIn(){
	return (isset($_SESSION["userid"]) &&  isset($_SESSION["nickname"]));
}

//Does a user have moderator rights?
function modRights() {
    if (isset($_SESSION["userid"])) {
        $conn = connectToDB();
        $sql = "SELECT Moderator FROM fuser WHERE UserID=".$_SESSION["userid"].";";
        $result = $conn->query($sql);
        $conn->close();
        return $result->fetch_assoc()["Moderator"];
    } else {
        return 0;
    }
}

//Translate id number to nickname string:
function idToNick($id){
    $conn = connectToDB();
    $sql = "SELECT UserID, Nickname FROM fuser WHERE UserID=".$id.";";
    $ret = $conn->query($sql)->fetch_assoc()["Nickname"];
    $conn->close();
    return $ret;
}


?>
