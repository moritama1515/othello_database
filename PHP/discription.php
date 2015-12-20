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

$s_name = $_GET['s_name'];
$c_name = $_GET['c_name'];
$b_name = $_GET['b_name'];

print "<h2>". $s_name."定石".$c_name." ".$b_name."</h2>";
print "<p>詳細ページです．ブラウザを二つ開いてTOPページの盤を横に並べてお使いください.</p>";


$sql = "SELECT move.turn,move.map FROM book,category,move where book.sort like \"%".$s_name."%\" and category.name like \"%".$c_name."%\" and book.name like \"%".$b_name."%\" and book.category_id = category.category_id and book.book_id = move.book_id";
$res = mysqli_query($conn, $sql);

print("<table class=\"table_02\">");
print("<tbody><tr><th>手数</th><th>座標</th></tr>");
while($row = mysqli_fetch_array($res)) {
    print("<tr>");
    print("<td>".$row["turn"]."</td>");
    print("<td>".$row["map"]."</td>");
     print("</tr>");
}
print("</tbody></table>");
mysqli_free_result($res);
?>
</body>
</html>
