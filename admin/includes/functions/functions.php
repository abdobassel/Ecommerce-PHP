<?php


// func getTilte => make $pagetitle is global variable and chech on it exist or no in pages to echo title 
function getTitle(){
    // global pagetitle ==> to access from any where
    global $pageTitle ;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo 'Default';
    }
}