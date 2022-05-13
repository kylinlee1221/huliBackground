<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $orderid=$_GET['orderid'];
    $refuseReason=$_GET['reason'];
    $result=array(
        'status' => '0',//0=error,1=success,2=sql error
        'msgs' => 'null',
    );
    if(!$conn){
        $result['status'] = '2';
        $result['msgs'] = 'sql connect error';
        echo json_encode($result);
    }else{
        $update_sql='UPDATE order_status_table SET orderstatus = 3, refuse_details = '."'{$refuseReason}'".'WHERE order_status_table.orderid = '."'{$orderid}'";
        if(mysqli_query($conn,$update_sql)){
            $result['status']='1';
            $result['msgs']='refuse success';
            echo json_encode($result);
        }else{
            $result['status']='2';
            $result['msgs']=mysqli_error($conn);
            echo json_encode($result);
        }
    }
?>