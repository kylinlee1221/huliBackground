<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $sendby=$_GET['sendby'];
    $endtime=$_GET['endtime'];
    $announ=$_GET['announ'];
    $result=array(
        'status' => '0',//0=error,1=success,2=sqlerror
        'msgs' => 'null',
    );
    if(!$conn){
        $result['status']='2';
        $result['msgs']='sql not connected';
        echo json_encode($result);
    }else{
        $sql_insert="INSERT INTO `announcement_table` (`sendby`, `info`, `endtime`) VALUES ('$sendby', '$announ', '$endtime') ";
        if(mysqli_query($conn,$sql_insert)){
            $result['status']='1';
            $result['msgs']='add success';
            echo json_encode($result);
        }else{
            $result['status']='2';
            echo json_encode($result);
        }
    }