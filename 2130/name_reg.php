<?php
function write_db_name(){
  $NAME = $_POST['user_name'];
  #다른 주소라면 localhost 대신에 mysql 서버 컴퓨터의 ip를 적어넣'
  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  mysqli_query($conn, "
  INSERT INTO admin (
    NAME
  ) VALUES(
      '$NAME'
  )
  ");
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>이름 등록중</title>
  </head>
  <body>
    <?php
    write_db_name();
     ?>
  </body>
</html>
