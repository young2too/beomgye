<?php
include_once('update_player_record.php');
function delete_db_game_record(){
  $row = $_GET['rowcount'];
  $delete_game_id = $_GET['div_cell_'.$row];
  //$conn = mysqli_connect("localhost", "root", "12301230", "lyg");
  $conn = mysqli_connect("localhost", "id6538259_root", "12301230", "id6538259_lyg");
  $sql_query_delete = "
  DELETE FROM game_record
  WHERE game_id = '$delete_game_id'
  ";
  mysqli_query($conn,$sql_query_delete);
}
 ?>

 <?php
 delete_db_game_record();
 update_player_DB()
  ?>
<script>
  alert('삭제되었습니다!');
  window.open('index.php','_self');
</script>
