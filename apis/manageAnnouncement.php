<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $type=$_GET['type'];
    $result=array(
        'status' => '0',//0=error,1=success,2=sql error
        'msgs' => 'null',
    );
    if(!$conn){
        $result['status']='2';
        $result['msgs']='sql connection error';
        echo json_encode($result);
    }else{
        switch ($type){
            case 'delete':
                $anid=$_GET['anid'];
                $delete_sql="DELETE FROM announcement_table WHERE `announcement_table`.`id` = "."'{$anid}'";
                if(mysqli_query($conn,$delete_sql)){
                    $result['status']='1';
                    $result['msgs']='delete complete';
                    echo json_encode($result);
                }else{
                    $result['status']='2';
                    $result['msgs']=mysqli_error($conn);
                    echo json_encode($result);
                }
                break;
            case 'update':
                $anid=$_GET['anid'];
                $anin=$_GET['anin'];
                $update_sql="UPDATE `announcement_table` SET `info` = "."'{$anin}'"." WHERE `announcement_table`.`id` = "."'{$anid}'";
                if(mysqli_query($conn,$update_sql)){
                    $result['status']='1';
                    $result['msgs']='update complete';
                    echo json_encode($result);
                }else{
                    $result['status']='2';
                    $result['msgs']=mysqli_error($conn);
                    echo json_encode($result);
                }
                break;
            default:
                echo json_encode($result);
                break;
        }
    }
?>