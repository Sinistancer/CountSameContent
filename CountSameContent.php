<?php
    class BigFile
    {
        protected $file;
    
        public function __construct($filename, $mode = "r")
        {
            if (!file_exists($filename)) {
                throw new Exception("File not found");
            }
    
            $this->file = new SplFileObject($filename, $mode);
        }
    
        protected function iterateText()
        {
            $count = 0;
    
            while (!$this->file->eof()) {
    
                yield $this->file->fgets();
    
                $count++;
            }
            return $count;
        }
    
        protected function iterateBinary($bytes)
        {
            $count = 0;
    
            while (!$this->file->eof()) {
    
                yield $this->file->fread($bytes);
    
                $count++;
            }
        }
    
        public function iterate($type = "Text", $bytes = NULL)
        {
            if ($type == "Text") {
                return new NoRewindIterator($this->iterateText());
            } else {
                return new NoRewindIterator($this->iterateBinary($bytes));
            }
        }
    }
     
    class GetContent
    {
        public $arrayContent = null;

        public function __construct($arrayContent) {
            $this->arrayContent = $arrayContent;
        }

        function RecursiveToGetArrayContent($dir){
            if (!file_exists($dir)){
                echo "File or directory is not exist check your path and setting path in config.json";
                return null;
            }

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
                $this->RecursiveToGetArrayContent($directory);
            }

            return $arrayContent;
        }

        function JoinAllContent($arrayContent){
            $arrayGetContent = array();
            foreach($arrayContent as $value){
                $largefile = new BigFile($value);
                $iterator = $largefile->iterate("Text");
                
                $text = "";
                foreach ($iterator as $line) {
                    $text .= $line;
                }

                $arrayGetContent[basename($value)] = $text;
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
    }

    if (file_exists("config.json")) {
        $jsonStr = file_get_contents("config.json");
        $config = json_decode($jsonStr);

        $dir = $config->path_directory;

        $arrayContent = array();
        $getContent = new GetContent($arrayContent);

        $getAllContent = $getContent->RecursiveToGetArrayContent($dir);
        if($getAllContent!=null){
            $dataContent = $getContent->JoinAllContent($getAllContent);
            echo $getContent->CountContent($dataContent);
        }
    } else {
        echo "config.json must exists for DYNAMICALLY path";
    }