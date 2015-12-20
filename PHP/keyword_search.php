<html>
<head>
  <meta HTTP-equiv="Context-Type" CONTENT="text/html;charset=UTF-8">
  <title>システムへのリンク</title>
  <link rel="stylesheet" type="text/css" href="top.css">
  <script type="text/javascript" src="draw.js"></script>
  <script type="text/javascript" src="reversi.js"></script>
  <script type="text/javascript" src="flip.js"></script>
<title>検索結果</title></head>
<body>
<?php
$host = "localhost";
if (!$conn = mysqli_connect($host, "s1513130", "s1513130")){
    die("データベース接続エラー.<br />");
}
mysqli_select_db($conn, "s1513130");
mysqli_set_charset($conn, "utf8");

$condition = "";


$level = $_REQUEST["level"];
if ($condition == ""){
  $condition = "WHERE book.level LIKE \"%".$level."%\"";
}
if($level == "1"){
  print "<h2>簡単";
}else if($level == "2"){
  print "<h2>ふつう";
}else if($level == "3"){
  print "<h2>難しい";
}else{
  print "<h2>レベル選択なし";
}

if(isset($_POST["sort"]) && ($_POST["sort"] != "")){
    $sort = mysqli_escape_string($conn, $_POST["sort"]);
    $sort = str_replace("%", "\%", $sort);
    if ($condition == ""){
      print $sort;
      $condition = "WHERE book.sort LIKE \"%".$sort."%\"";
    } else{
      print ",".$sort;
      $condition .= "AND book.sort LIKE \"%".$sort."%\"";
    }
}

if(isset($_POST["category"]) && ($_POST["category"] != "")){
  $category = mysqli_escape_string($conn, $_POST["category"]);
  $category = str_replace("%", "\%", $category);
  if ($condition == ""){
    print $category;
    $condition = "WHERE category.name LIKE \"%".$category."%\"";
  } else{
    print ",".$category;
    $condition .= "AND category.name LIKE \"%".$category."%\"";
  }
}

if(isset($_POST["book"]) && ($_POST["book"] != "")){
  $book = mysqli_escape_string($conn, $_POST["book"]);
  $book = str_replace("%", "\%", $book);
  if ($condition == ""){
    print $book;
    $condition = "WHERE book.name LIKE \"%".$book."%\"";
  } else{
    print ",".$book;
    $condition .= "AND book.name LIKE \"%".$book."%\"";
  }
}

if(isset($_POST["turn"]) && ($_POST["turn"] != "")){
  $turn = mysqli_escape_string($conn, $_POST["turn"]);
  $turn = str_replace("%", "\%", $turn);
  if ($condition == ""){
    print $turn;
    $condition = "WHERE move.turn = \"".$turn."\"";
  } else{
    print ",".$turn;
    $condition .= "AND move.turn = \"".$turn."\"";
  }
}

if(isset($_POST["map"]) && ($_POST["map"] != "")){
  $map = mysqli_escape_string($conn, $_POST["map"]);
  $map = str_replace("%", "\%", $map);
  if ($condition == ""){
    print $map;
    $condition = "WHERE move.map LIKE \"%".$map."%\"";
  } else{
    print ",".$map;
    $condition .= "AND move.map LIKE \"%".$map."%\"";
  }
}

print "の検索結果</h2>";

$sql = "SELECT DISTINCT book.sort,category.name as c_name,book.name as b_name,move.turn,move.map FROM book,category,move ".$condition." and book.category_id = category.category_id and book.book_id = move.book_id group by book.book_id";
$res = mysqli_query($conn, $sql);

print("<table class=\"table_01\">");
print("<tbody><tr><th>種類</th><th>カテゴリー</th><th>定石名</th><th>手順</th></tr>");
while($row = mysqli_fetch_array($res)) {
  $sort_name = $row["sort"];
  $category_name = $row["c_name"];
  $book_name = $row["b_name"];

    print("<tr>");
    print("<td>".$sort_name."</td>");
    print("<td>".$category_name."</td>");
    print("<td>".$book_name."</td>");
    print("<td><a href=\"http://turkey.slis.tsukuba.ac.jp/~s1513130/discription.php?s_name=$sort_name&c_name=$category_name&b_name=$book_name\">詳細</td>");
     print("</tr>");
}
print("</tbody></table>");
mysqli_free_result($res);
?>
</body>
</html>
