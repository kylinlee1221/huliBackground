<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $result=array();
    $result_user=array(
        'fullname' => 'null',
        'telephone' => '0',
        'userid' => 'null',
        'id' => '0',
    );
    if($conn){
        $sql_query="SELECT * FROM `user_table` WHERE role = 0 ORDER BY id DESC; ";
        $res=mysqli_query($conn,$sql_query);
        if($res->num_rows>0){
            while($row=$res->fetch_assoc()){
                $result_user['fullname']=$row['fullname'];
                $result_user['telephone']=$row['telephone'];
                $result_user['userid']=$row['userid'];
                $result_user['id']=$row['id'];
                array_push($result,$result_user);
            }
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($result,$result_user);
            echo json_encode($result);
        }
    }
?>