<?php
$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");
$r = mysqli_query($conn,"SELECT id,day_id,hanzi,pinyin,nghia FROM tuvung ORDER BY day_id,id LIMIT 20");
header('Content-Type: text/html; charset=utf-8');
echo "<pre>";
while($row=mysqli_fetch_assoc($r)) echo implode(" | ",$row)."\n";
echo "</pre>";
