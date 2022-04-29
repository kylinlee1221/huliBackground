<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $username=$_GET['username'];
    $password=$_GET['password'];
    $fullname=$_GET['fullname'];
    $telephone=$_GET['telephone'];
    $role=$_GET['role'];
    $description=$_GET['des'];
    $userid='';
    //$key=$_GET['key'];
    $result=array(
        'status' => '0', //1=success,2=exist,3=error
        'msgs' => 'null',
    );
    if(!$conn){
        $result['status']='3';
        $result['msgs']='connection error';
        echo json_encode($result);
    }else{
        if($username!=null&&$password!=null){
            $password=md5($password);
            $sql_query='select * from user_table where username='."'{$username}'";
            $res_query=mysqli_query($conn,$sql_query);
            if($res_query->num_rows>0){
                $result['status']='2';
                $result['msgs']='user already exists';
                echo json_encode($result);
            }else{
                $sql_query_last='select * from user_table order by id desc limit 1';
                $res_query2=mysqli_query($conn,$sql_query_last);
                if($res_query2->num_rows>0){
                    while($row=$res_query2->fetch_assoc()){
                        $userid=$row['userid'];
                    }
                    $userid_number=(int)$userid;
                    $userid_number++;
                    $userid=strval($userid_number);
                    if(strlen($userid)<7){
                        for($i=1;$i<=7-strlen($userid);$i++){
                            $userid='0'+$userid;
                        }
                    }
                    $sql_insert="INSERT INTO user_table (`username`, `password`, `fullname`, `userid`, `telephone`, `role`, `description`) VALUES ('$username', '$password', '$fullname', '$userid' , '$telephone', '$role', '$description') ";
                    if(mysqli_query($conn,$sql_insert)){
                        $result['status']='1';
                        $result['msgs']='success';
                        echo json_encode($result);
                    }else{
                        $result['status']='3';
                        echo json_encode($result);
                    }
                }else{
                    $userid='0000001';
                    $sql_insert="INSERT INTO user_table (`username`, `password`, `fullname`, `userid`, `telephone`, `role`, `description`) VALUES ('$username', '$password', '$fullname', '$userid' , '$telephone', '$role', '$description') ";
                    if(mysqli_query($conn,$sql_insert)){
                        $result['status']='1';
                        $result['msgs']='success';
                        echo json_encode($result);
                    }else{
                        $result['status']='3';
                        echo json_encode($result);
                    }
                }
            }
        }
    }
?>