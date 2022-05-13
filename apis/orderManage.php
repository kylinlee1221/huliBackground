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
        $result['status'] = '2';
        $result['msgs'] = 'sql connection error';
        echo json_encode($result);
    }else{
        switch ($type){
            case 'update':
                $orderId=$_GET['orderid'];
                $update_status_sql="UPDATE `order_status_table` SET `orderstatus` = '1' WHERE `order_status_table`.`orderid` = "."'{$orderId}'";
                $orderprice=$_GET['orderprice'];
                $orderpaid=$_GET['orderpaid'];
                $orderend=$_GET['orderend'];
                $orderplace=$_GET['orderplace'];
                $update_sql="UPDATE `order_table` SET `order_money` = '$orderprice', `order_paid` = '$orderpaid', `order_end` = '$orderend', `order_place` = '$orderplace' WHERE `order_table`.`id` = "."'{$orderId}'";
                if(mysqli_query($conn,$update_sql)){
                    if(mysqli_query($conn,$update_status_sql)){
                        $result['status']='1';
                        $result['msgs']='update success';
                        echo json_encode($result);
                    }else{
                        $result['status']='2';
                        $result['msgs']=mysqli_error($conn);
                        echo json_encode($result);
                    }
                }else{
                    $result['status']='2';
                    $result['msgs']=mysqli_error($conn);
                    echo json_encode($result);
                }
                break;
            case 'delete':
                $orderId=$_GET['orderid'];
                $delete_status_sql="DELETE FROM order_status_table WHERE `order_status_table`.`orderid` = "."'{$orderId}'";
                $delete_sql="DELETE FROM order_table WHERE `order_table`.`id` = "."'{$orderId}'";
                if(mysqli_query($conn,$delete_status_sql)){
                    if(mysqli_query($conn,$delete_sql)){
                        $result['status']='1';
                        $result['msgs']='delete success';
                        echo json_encode($result);
                    }else{
                        $result['status']='2';
                        $result['msgs']=mysqli_error($conn);
                        echo json_encode($result);
                    }
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