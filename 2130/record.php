<?php
function write_record(){
  $Dong_Name= $_POST['dong_name'];
  $Nam_Name= $_POST['nam_name'];
  $Seo_Name= $_POST['seo_name'];
  $Buk_Name=$_POST['buk_name'];
  //이름 받아오는 구간
  $Dong_Score= $_POST['dong_score'];
  $Nam_Score= $_POST['nam_score'];
  $Seo_Score= $_POST['seo_score'];
  $Buk_Score=$_POST['buk_score'];
  //점수 받아오는 구간
  $Dong_Star= $_POST['dong_star'];
  $Nam_Star= $_POST['nam_star'];
  $Seo_Star= $_POST['seo_star'];
  $Buk_Star= $_POST['buk_star'];
  //별 받아오는 구간

  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  mysqli_query($conn, "
  INSERT INTO game_record (
    game_id,
    Dong_name,Nam_name,Seo_name,Buk_name,
    Dong_score,Nam_score,Seo_score,Buk_score,
    Dong_star,Nam_star,Seo_star,Buk_star,
    Date
  ) VALUES(
      NULL,
      $Dong_Name,$Nam_Name,$Seo_Name,$Buk_Name,
      $Dong_Score,$Nam_Score,$Seo_Score,$Buk_Score,
      $Dong_Star,$Nam_Star,$Seo_Star,$Buk_Star,
      NOW()
  )
  ");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>
    기록 등록중
  </title>
</head>
<body>
  <?php
    write_record();
   ?>
   <script>
    alert("등록되었습니다!");
    history.back();
   </script>
</body>
</html>
