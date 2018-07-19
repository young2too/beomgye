<?php


function delete_db_game_record(){
  $row = $_GET['rowcount'];
  $delete_game_id = $_GET['div_cell_'.$row];
  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  $sql_query = "
  DELETE FROM game_record
  WHERE game_id = '$delete_game_id'
  ";
  mysqli_query($conn,$sql_query);
  echo "<script>alert('삭제되었습니다!');</script>";
  echo "<script>window.open('index.php','_self');</script>";
}
 ?>

 <?php
 delete_db_game_record()
  ?>
