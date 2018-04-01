<?php

function createNewTopic($id,$name){

    //echo "<br>id and discname: ".$id." , ".$name."<br>";
    //echo getcwd()."<br>";
    //echo $_SERVER['DOCUMENT_ROOT']."<br>";
    $filename = "topics/".$id.".xml";

    //echo "owner of topics: ".posix_getpwuid(fileowner("topics")[0])."<br>";
    //echo "perms of topics/1: ".substr(sprintf("%o",fileperms("topics/1.xml")),-4)."<br>";
    //saatana
    //echo "topics/1.xml is dir: ".is_dir("topics/1.xml")."<br>";
    //echo "is readable and writebale: ".is_readable("topics/1.xml")." , ".is_writable("topics/1.xml")."<br>";
    
    if (!file_exists($filename)){
        $file = fopen($filename, "w");// or die ("File creation broken!");
        if (!file_exists($filename)) return false;
    } else return false;
    
    $initialText = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<topic>
\t<topicID>".$id."</topicID>
\t<nameOfTopic>".$name."</nameOfTopic>
</topic>
";

    fwrite($file, $initialText);
    fclose($file);
    return true;
}

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
