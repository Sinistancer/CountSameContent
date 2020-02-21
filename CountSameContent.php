<?php
    $dir    = 'C:\Users\Sinistancer\source\repos\DropsuiteTest';
    $scanned_directory = array_diff(scandir($dir), array('..', '.'));
    
    //NANTI DIBKIN FUNCTION CEK JEROAN DIRECTORY
    $arrayNextDir = array();
    $arrayContent = array();
    foreach($scanned_directory as $value){
       if(is_dir($dir."\\".$value)){
        array_push($arrayNextDir, $dir."\\".$value);
       } else {
        array_push($arrayContent, $dir."\\".$value);
       }
    }

    //JOIN ALL CONTENT
    $arrayGetContent = array('abcdef', 'abcdefghijk', 'abcd', 'abcd', 'abcdef', 'abcd');
    foreach($arrayContent as $value){
        array_push($arrayGetContent, file_get_contents($value));
    }
    

    //COUNT CONTENT
    $setCount = array_count_values($arrayGetContent);
    arsort($setCount);//Sort it from highest to lowest\

    $occurences = reset($setCount); //get the first value (rewinds internal pointer )
    $most_frequent = key($setCount); //get the key, as we are rewound it's the first key

    echo $most_frequent.' '. $occurences;
