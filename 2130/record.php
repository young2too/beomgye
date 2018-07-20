<?php
$Rank_count = 4;
function compare($x, $y){
  if ($x[1] == $y[1] )//두번째 인자가 점수이다. 점수순 정렬
  return 0;
  else if ( $x[1] > $y[1] )//오름차순 정렬이다
  return -1;
  else
  return 1;
}

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

  $Records = array(
    array($Dong_Name, $Dong_Score, $Dong_Star),
    array($Nam_Name, $Nam_Score, $Nam_Star),
    array($Seo_Name, $Seo_Score, $Seo_Star),
    array($Buk_Name, $Buk_Score, $Buk_Star),
  );



  usort($Records, 'compare');
  //이차원 배열에서 점수순으로 정렬되어있음

  $first_score = (int)($Records[0][1]);
  $first_star = (int)($Records[0][2]);
  $first_name = $Records[0][0];

  $second_score = (int)($Records[1][1]);
  $second_star = (int)($Records[1][2]);
  $second_name = $Records[1][0];

  $third_score = (int)($Records[2][1]);
  $third_star = (int)($Records[2][2]);
  $third_name = $Records[2][0];

  $fourth_score = (int)($Records[3][1]);
  $fourth_star = (int)($Records[3][2]);
  $fourth_name = $Records[3][0];

  //$conn = mysqli_connect("localhost", "id6538259_root", "12301230", "id6538259_lyg");
  $conn = mysqli_connect("localhost", "root", "12301230", "lyg");
  $sql_query = "
  INSERT INTO game_record (
    game_id,
    1st_name,2nd_name,3rd_name,4th_name,
    1st_score,2nd_score,3rd_score,4th_score,
    1st_star,2nd_star,3rd_star,4th_star,
    Date
    ) VALUES(
      NULL,
      '$first_name','$second_name','$third_name','$fourth_name',
      '$first_score','$second_score','$third_score','$fourth_score',
      '$first_star','$second_star','$third_star','$fourth_star',
      NOW()
      )
      ";
      mysqli_query($conn, $sql_query);
      //플레이어를 등수대로 정렬해서 데이터베이스에 넣었음


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
      window.open('refresh_player_record.php','_self');//갱신 페이지로
      </script>
    </body>
    </html>


    <!--
    //       mysqli_query($conn, "
    //       UPDATE player_record
    //       SET 1st = 1st+1
    //       , Game_Count = Game_Count+1
    //       , Sum_Score = Sum_Score+'$first_score'
    //       , Ave_Score = Sum_Score/Game_Count
    //       , UMA = ('$first_score'-25000)/1000 + 30
    //       , Ave_UMA = UMA/Game_Count
    //       , Star = Star+'$first_star'
    //       WHERE NAME = '$first_name'
    //       "
    //     );
    //
    //     mysqli_query($conn, "
    //     UPDATE player_record
    //     SET 2nd = 2nd+1
    //     , Game_Count = Game_Count+1
    //     , Sum_Score = Sum_Score+'$second_score'
    //     , Ave_Score = Sum_Score/Game_Count
    //     , UMA = ('$second_score'-25000)/1000 + 10
    //     , Ave_UMA = UMA/Game_Count
    //     , Star = Star+'$second_star'
    //     WHERE NAME = '$second_name'
    //     "
    //   );
    //   mysqli_query($conn, "
    //   UPDATE player_record
    //   SET 3rd = 3rd+1
    //   , Game_Count = Game_Count+1
    //   , Sum_Score = Sum_Score+'$third_score'
    //   , Ave_Score = Sum_Score/Game_Count
    //   , UMA = ('$third_score'-25000)/1000 -10
    //   , Ave_UMA = UMA/Game_Count
    //   , Star = Star+'$third_star'
    //   WHERE NAME = '$third_name'
    //   "
    // );
    // mysqli_query($conn, "
    // UPDATE player_record
    // SET 4th = 4th+1
    // , Game_Count = Game_Count+1
    // , Sum_Score = Sum_Score+'$fourth_score'
    // , Ave_Score = Sum_Score/Game_Count
    // , UMA = ('$fourth_score'-25000)/1000 -30
    // , Ave_UMA = UMA/Game_Count
    // , Star = Star+'$fourth_star'
    // WHERE NAME = '$fourth_name'
    // "
    // );
  -->
