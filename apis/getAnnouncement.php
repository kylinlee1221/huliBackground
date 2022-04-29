<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $result=array();
    $result1=array(
        'id' => '0',
        'sendby' => '0',
        'info' => 'null',
        'endtime' => 'null',
    );
    if($conn){
        $sql='select * from announcement_table';
        $res=mysqli_query($conn,$sql);
        if($res->num_rows>0){
            while($row=$res->fetch_assoc()){
                $count=count($row);
                for($i=0;$i<$count;$i++){
                    unset($row[$i]);
                }
                $result1['id']=$row['id'];
                $result1['sendby']=$row['sendby'];
                $result1['info']=$row['info'];
                $result1['endtime']=$row['endtime'];
                array_push($result,$result1);
            }
        }
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }