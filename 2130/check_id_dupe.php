<?php
function check_dupe(){
  $admin_id = $_GET['admin_id'];
  $query_str = " SELECT * FROM admin WHERE ID= '$admin_id'";
  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  $result_set = mysqli_query($conn, $query_str) or die(mysqli_error($conn));
  while ($row = mysqli_fetch_array($result_set)){
    if( $row['ID'] == $admin_id){
      mysqli_close($conn);
      return true;
    }
  }
  mysqli_close($conn);
  return false;
}
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>아이디 중복 검사중</title>
</head>
<body>
  <?php
  if(check_dupe()==true){
    //중복결과 검사가 참
    parent.alert("이미 사용중인 아이디입니다.");
  }
  else {

    parent.alert("사용 가능합니다.");
  }
   ?>
</body>
</html>
