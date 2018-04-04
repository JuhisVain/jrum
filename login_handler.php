<?php
require('db_handling.php');

//TODO: hashing
//done: validation(?)

function signup($un,$pw){
    $un = filter_var($un, FILTER_SANITIZE_STRING);
    $pw = filter_var($pw, FILTER_SANITIZE_STRING);
    $conn = connectToDB();
    $sql = "INSERT INTO fuser (Nickname, Password) VALUES (\"".$un."\", \"".$pw."\");";
    $conn->query($sql);
    $conn->close();
    login($un,$pw);
}

function login($un,$pw){
    $un = filter_var($un, FILTER_SANITIZE_STRING);
    $pw = filter_var($pw, FILTER_SANITIZE_STRING);
    $conn = connectToDB();
    $sql = "SELECT * FROM fuser WHERE Nickname=\"".$un."\" AND Password=\"".$pw."\";";
    $result = $conn->query($sql);
    $line = $result->fetch_assoc();
    $_SESSION["userid"] = $line["UserID"];
    $_SESSION["password"] = $line["Password"];
    $_SESSION["nickname"] = $line["Nickname"];
    $conn->close();
}

function logout(){
    session_unset();
    session_destroy();
}

function loggedIn(){
	return (isset($_SESSION["userid"]) && isset($_SESSION["password"]) && isset($_SESSION["nickname"]));
}

function idToNick($id){
    $conn = connectToDB();
    $sql = "SELECT UserID, Nickname FROM fuser WHERE UserID=".$id.";";
    $ret = $conn->query($sql)->fetch_assoc()["Nickname"];
    $conn->close();
    return $ret;
}


?>
