<?php

function strip_seros_from_date( $marked_string = "")
{
    //first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string) ;
    //then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros) ;
    return $cleaned_string ;
}

function redirect_to($location = null)
{
    if($location != null){
        header ("Location: {$location}") ;
        exit ;
    }
}

function output_message($message = "")
{
    if(!empty($message)){
        return "<p class=\"message\"> {$message} </p>" ;
    } else {
        return '' ; 
    }
}

function __autoload($class_name){
    $class_name = strtolower($class_name);
    $path = LIB_PATH.DS."{$class_name}.php" ;
    if(file_exists($path)){
        require_once($path);
    }else{
        die("the file {$class_name}.php could not be found.") ;
    }
}

function include_layout_template($template=""){
    include(SITE_ROOT.DS.'public'.DS.'layout'.DS.$template);
}

function log_action($action , $message=""){
    $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt' ;
    $new = file_exists($logfile)?false : true ;
    if($handle = fopen($logfile, 'a')){ // append
        $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
        $content = "{$timestamp} | {$action} | {$message}\n";
        fwrite($handle, $content);
        fclose($handle);
        if($new){ chmod($logfile, 0755); }
    }else{
        echo "Could not open log file for writing.";
    }
}