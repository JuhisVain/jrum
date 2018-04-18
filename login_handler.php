<?php
require('db_handling.php');

function signup($un,$pw){
    $un = filter_var($un, FILTER_SANITIZE_STRING);
    $pw = filter_var($pw, FILTER_SANITIZE_STRING);

    $hashedpw = password_hash($pw,PASSWORD_DEFAULT);
    
    $conn = connectToDB();
    $sql = "INSERT INTO fuser (Nickname, Password) VALUES (\"".$un."\", \"".$hashedpw."\");";
    $message = $conn->query($sql);
    if ($conn->error){
        //There's only one way this can go wrong:
        echo "That nickname already exists!";
        $conn->close();
        return;
    }
    $conn->close();
    login($un,$pw);
}

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

function loggedIn(){
	return (isset($_SESSION["userid"]) &&  isset($_SESSION["nickname"]));
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
