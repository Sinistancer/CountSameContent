<?php

    function RecursiveToGetArrayContent($dir){

        $scannedDirectory = array_diff(scandir($dir), array('..', '.'));
        $arrayNextDir = array();
        global $arrayContent;

        foreach($scannedDirectory as $value){
            if(is_dir($dir."\\".$value)){
                array_push($arrayNextDir, $dir."\\".$value);
            } else {
                array_push($arrayContent, $dir."\\".$value);
            }
        }

        foreach($arrayNextDir as $directory){
            RecursiveToGetArrayContent($directory);
        }

        return $arrayContent;
    }
    
    function CheckFileName($arrayContent){
        

        return $arrayGetContent;
    }

    function JoinAllContent($arrayContent){
        $arrayGetContent = array();
        foreach($arrayContent as $value){
            $arrayGetContent[basename($value)] = file_get_contents($value);
        }

        return $arrayGetContent;
    }
    
    function CountContent($arrayGetContent)
    {
        $setCount = array_count_values($arrayGetContent);
        arsort($setCount);

        $occurences = reset($setCount);
        $most_frequent = key($setCount);

        return $most_frequent.' '. $occurences;
    }
    
    
    $dir    = 'C:\Users\Sinistancer\source\repos\DropsuiteTest';

    $arrayContent = array();
    $getAllContent = RecursiveToGetArrayContent($dir);
    $dataContent = JoinAllContent($getAllContent);
    echo CountContent($dataContent);

    
