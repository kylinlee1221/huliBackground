<?php
    header("Content-Type: text/html; charset=UTF-8");
    date_default_timezone_set('Asia/Shanghai');
    require('./include/server.php');
    $username=$_GET['username'];
    $password=$_GET['password'];
    $password=md5($password);
    $result=array(
        'status' => '0',//1=login success,2=password error
        'fullname' => 'null',
        'userid' => 'null',
        'telephone' => '0',
        'role' => '9', //0=user,1=admin
        'description' => 'null',
        'id' => '0',
    );
    if(!$conn){
        //echo "<script>alert('sql connect error')</script>";
        echo json_encode($result);
        //die("error:".mysqli_connect_error());
    }else{
        if($username!=null&&$password!=null){
            $sql='select * from user_table where username='."'{$username}'and password="."'$password';";
            $res=mysqli_query($conn,$sql);
            if($res->num_rows>0){
                while($row=$res->fetch_assoc()){
                    $result['status']='1';
                    $result['fullname']=urldecode($row['fullname']);
                    $result['userid']=$row['userid'];
                    $result['telephone']=$row['telephone'];
                    $result['role']=$row['role'];
                    $result['description']=$row['description'];
                    $result['userid']=$row['id'];
                }
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }else{
                $result['status']='2';
                echo json_encode($result);
            }
        }else{
            echo json_encode($result);
        }
    }
