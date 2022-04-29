<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $userid=$_GET['userid'];
    $result=array(
        'status' => '9', //1=success,2=error,3=already checked,9=sql error
        'msgs' => 'null',
    );
    if(!$conn){
        echo json_encode($result);
    }else{
        if($userid!=null){
            $sql_query='select * from user_status_table where userid='."'{$userid}'";
            $res_query=mysqli_query($conn,$sql_query);
            if($res_query->num_rows>0){
                while($row=$res_query->fetch_assoc()){
                    if($row['status']==1||$row['status']==3){
                        $result['status']='2';
                        $result['msgs']='you already checked in';
                        echo json_encode($result);
                    }
                }
            }else{
                $insert_sql="INSERT INTO `user_status_table` (`userid`, `status`) VALUES ('$userid', '1')";
                if(mysqli_query($conn,$insert_sql)){
                    $result['status']='1';
                    $result['msgs']='check in success';
                    echo json_encode($result);
                }
            }
            //echo json_encode($result);
        }
    }
?>
