<?php
function check_login(){
  $logined_id = $_POST['loginid'];
  $logined_pw = $_POST['loginpw'];
  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  $result_set = mysqli_query($conn, "
      SELECT *
      FROM 'admin'
      WHERE ID='{$logined_id}' and PW='{$logined_pw}'
  ") or die(mysqli_error($conn));
  // while ($row = mysqli_fetch_array($result_set)){
  //       echo $row['id'];
  //       echo '<br>';
  //
  //    }

  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>로그인 중</title>
</head>
<body>
  <?php
  $login_result = check_login();
  echo $login_result;
  if($login_result == true){
    echo "로그인 성공함";
    //원래 페이지에 이 정보를 전달하고 싶다!
  }
  else{
    echo "로그인 실패함";
    //원래 페이지에 이 정보를 전달하고 싶다!
  }
  ?>
</body>
</html>
