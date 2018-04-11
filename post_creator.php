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

//Modifies existing xml-file.
//Truncate 9 chars ("\n</topic>"), Append new post.
//There might be a better way to do this
function createNewPost($content,$discussion){// :o
    $discXMLfile = "topics/".$discussion.".xml";

    $file = fopen($discXMLfile, "a");

    $filesize = filesize($discXMLfile);
    ftruncate($file,$filesize-9);//nyt menee lujaa
    
    fwrite($file, "\t<post>
\t\t<posterID>".$_SESSION["userid"]."</posterID>
\t\t<postTimeDate>\n\t\t\t<postTime>".date("H:i:s")."</postTime>
\t\t\t<postDate>".date("j.n.Y")."</postDate>\n\t\t</postTimeDate>
\t\t<postContent>".$content."</postContent>
\t</post>

</topic>");
    
    fclose($file);
}

?>
