<?php
$user_name = $_GET['user_name'];
$query_str = "
SELECT *
FROM player_record
WHERE NAME= '$user_name'
";
//$conn = mysqli_connect("localhost", "id6538259_root", "12301230", "id6538259_lyg");
$conn = mysqli_connect("localhost", "root", "12301230", "lyg");
$result_set = mysqli_query($conn, $query_str) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result_set);
mysqli_close($conn);
if($row){
  echo "<script>parent.alert('이미 사용중인 이름입니다');</script>";
}
else{
  echo "<script>parent.alert('사용가능한 이름입니다');</script>";
  echo "<script>parent.is_check_dupe=true;</script>";
}
?>
