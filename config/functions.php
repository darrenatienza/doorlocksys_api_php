<?php
    spl_autoload_register(function($className){
        $path = './test/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        $path = './Ahc/Jwt/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        $path = './src/logs/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        $path = './src/device/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        $path = './src/shared/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
       
        $path = './config/data/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
            
        }
        $path = './config/logic/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        $path = './config/model/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        $path = './config/'. strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        
        $path = strtolower($className) . ".php";
        if(file_exists($path)){
            require_once($path);
            return;
        }
        //if file not found from paths above
        echo "File $path is not found.";
            
        
        
        
    })
?>