<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $userid=$_GET['userid'];
    $result=array(
        'status' => '9', //1=success,2=error,3=already checked,9=sql error
        'msgs' => 'null',
    );
    if(!$conn) {
        echo json_encode($result);
    }else{
        if($userid!=null){
            $sql_query='select * from user_status_table where userid='."'{$userid}'";
            $res_query=mysqli_query($conn,$sql_query);
            if($res_query->num_rows>0) {
                while ($row = $res_query->fetch_assoc()) {
                    if ($row['status'] == 1 || $row['status'] == 3) {
                        $update_sql='UPDATE user_status_table SET status = 2 WHERE user_status_table.userid ='. "'{$userid}'";
                        if(mysqli_query($conn,$update_sql)){
                            $result['status'] = '1';
                            $result['msgs'] = 'checked out';
                            echo json_encode($result);
                        }else{
                            echo mysqli_error($conn);
                            $result['status']='9';
                            $result['msgs']='sql error';
                            echo json_encode($result);
                        }

                        //echo json_encode($result);
                    }elseif ($row['status']==2){
                        $result['status'] = '2';
                        $result['msgs'] = 'you already checked out';
                        echo json_encode($result);
                    }
                }
            }
        }else{
            $result['status']='2';
            $result['status']='User never checked';
            echo json_encode($result);
        }
    }
?>