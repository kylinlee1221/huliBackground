<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $type=$_GET['type'];
    $userid=$_GET['userid'];
    $result=array();
    $row_result=array(
      'id' => '0',
        'ordername' => 'null',
        'orderplace' => 'null',
        'orderprice' => '0.0',
        'orderpaid' => '0.0',
        'orderend' => 'null',
        'status' => '0',// 	0=unavailable,1=available,2=on work,3=refuse,4=done
    );
    if(!$conn){
        echo "empty";
    }else{
        switch ($type){
            case 'all':
                $query_sql= "select * from order_table";
                $res=mysqli_query($conn,$query_sql);
                if($res->num_rows>0){
                    while($row=$res->fetch_assoc()){
                        $row_result['id']=$row['id'];
                        $row_result['ordername']=$row['order_name'];
                        $row_result['orderplace']=$row['order_place'];
                        $row_result['orderprice']=$row['order_money'];
                        $row_result['orderpaid']=$row['order_paid'];
                        $row_result['orderend']=$row['order_end'];
                        $sql_query2="SELECT * FROM `order_status_table` WHERE `orderid` = $orderid ";
                        //echo $sql_query2;
                        $res2=mysqli_query($conn,$sql_query2);
                        //echo mysqli_error($conn);
                        if($res2->num_rows>0){
                            while($row2=$res2->fetch_assoc()){
                                $row_result['status']=$row2['orderstatus'];
                                array_push($result,$row_result);
                            }
                        }
                    }
                }
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                break;
            case 'byid':
                $query_sql= "select * from order_table where orderby ="."'{$userid}'";
                $res=mysqli_query($conn,$query_sql);
                if($res->num_rows>0){
                    while($row=$res->fetch_assoc()){
                        $row_result['id']=$row['id'];
                        $row_result['ordername']=$row['order_name'];
                        $row_result['orderprice']=$row['order_money'];
                        $row_result['orderplace']=$row['order_place'];
                        $row_result['orderpaid']=$row['order_paid'];
                        $row_result['orderend']=$row['order_end'];
                        array_push($result,$row_result);
                    }
                }
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                break;
            default:
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                break;
        }
    }