<?php 

function gettitle(){
    global $title;
    if(isset($title)){
        $title;
    }else{
        $title = 'Home';
    } 
    return $title;
}

function getinfo($select,$table,$where,$vaule,$column){
    
    global $con;
    
    $stmt = $con->prepare("SELECT $select FROM $table WHERE $where = $vaule");
    $stmt->execute();
    $info = $stmt->fetch();
    
    $getInfo =  $info[$column];
    
    return $getInfo;
}