<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $name=$_GET['name'];
    $price=$_GET['price'];
    $paid=$_GET['paid'];
    $sendby=$_GET['sendby'];
    $sendto=$_GET['sendto'];
    $orderdate=$_GET['orderdate'];
    $place=$_GET['place'];
    $placedetails=$_GET['details'];
    $result=array(
        'status' => '0', //0=error,1=success,2=sql error
        'msgs' => 'null',
    );
    if(!$conn){
        $result['status'] ='2';
        $result['msgs'] = 'sql error';
        echo json_encode($result);
    }else{
        $orderdate=strtotime($orderdate);
        $sql_insert="INSERT INTO `order_table` (`order_name`, `orderby`, `orderfrom`, `order_money`, `order_paid`, `order_start`, `order_end`, `order_place`, `order_place_details`, `order_create`) VALUES ('$name', '$sendto', '$sendby', '$price', '$paid', current_timestamp(), '$orderdate', '$place', '$placedetails', current_timestamp()) ";
        if(mysqli_query($conn,$sql_insert)){
            $id=mysqli_insert_id($conn);
            $sql_insert2="INSERT INTO `order_status_table` (`orderid`, `orderstatus`, `refuse_details`) VALUES ('$id', '1', '') ";
            if(mysqli_query($conn,$sql_insert2)){
                $result['status']='1';
                $result['msgs']='success';
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
    }
?>

