<?php
function delete_db_game_record(){
  $row = $_GET['rowcount'];
  $delete_game_id = $_GET['div_cell_'.$row];
  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  $sql_query_delete = "
  DELETE FROM game_record
  WHERE game_id = '$delete_game_id'
  ";
  mysqli_query($conn,$sql_query_delete);
}
 ?>

 <?php
 delete_db_game_record();
  ?>
<script>
  window.open('refresh_player_record.php','_self');//갱신 페이지로
</script>
