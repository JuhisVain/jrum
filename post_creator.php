<?php

function createNewTopic($id,$name){

    $filename = "topics/".$id.".xml";
    echo "name of file: ".$filename;

    //If this fails: *something* needs permissions to write
    if (!file_exists($filename)){
        echo "File does not exist, attempting to create it!";
        $file = fopen($filename, "w");// or die ("File creation broken!");
        if (!file_exists($filename)){
            echo "File creation failed";
            return false;
        }
    } else return false;
    echo "File creation success!";
    $initialText = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<topic>
\t<topicID>".$id."</topicID>
\t<nameOfTopic>".$name."</nameOfTopic>

</topic>
";
    echo "Writing to file!";
    fwrite($file, $initialText);
    fclose($file);
    return true;
}

function destroyTopicXML($topicID){
    $discXMLfile = "topics/".$topicID.".xml";
    unlink($discXMLfile);
}

//Modifies existing xml-file.
//Truncate 9 chars ("\n</topic>"), Append new post.
//There might be a better way to do this
function createNewPost($content,$discussion){// :o
    $discXMLfile = "topics/".$discussion.".xml";

    $file = fopen($discXMLfile, "a");

    $filesize = filesize($discXMLfile);
    ftruncate($file,$filesize-9);//nyt menee lujaa. -update 18.4.: lujaa mentiin ja nyt ollaan ojassa

    //debug:
    echo "file: ".$discXMLfile." userid: ".$_SESSION["userid"]." content: ".$content."date and time: ".date("H:i:s j:n:Y")."<br>";
    //rewind($file);
    //fclose($file);
    //$file = fopen($discXMLfile, "a");
    /*
    if(!fwrite($file, "\t<post>
\t\t<posterID>".$_SESSION["userid"]."</posterID>
\t\t<postTimeDate>\n\t\t\t<postTime>".date("H:i:s")."</postTime>
\t\t\t<postDate>".date("j.n.Y")."</postDate>\n\t\t</postTimeDate>
\t\t<postContent>".$content."</postContent>
\t</post>

</topic>")){
      echo "Failure to write to file: ".fwrite($file,"\n</topic>");//try to recover
    };
*/

    fseek($file,0,SEEK_END);

    //echo "<br>1: ".fwrite($file, "<post>\n\t\t<posterID>".$_SESSION["userid"]."</posterID>");

    //wtf: try and try again until it works
    while (!fwrite($file, "<post>\n\t\t<posterID>".$_SESSION["userid"]."</posterID>"));
    
    while(!fwrite($file, "\n\t\t<postTimeDate>\n\t\t\t<postTime>".date("H:i:s")."</postTime>"));
    while(!fwrite($file, "\n\t\t\t<postDate>".date("j.n.Y")."</postDate>\n\t\t</postTimeDate>"));
    while(!fwrite($file, "\n\t\t<postContent>".$content."</postContent>"));
    while(!fwrite($file, "\n\t</post>\n\n</topic>"));
    
    fclose($file);
    
}

?>
