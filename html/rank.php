<?php
$conn = mysqli_connect("mysql", "root", "1234", "game_db");
$result = mysqli_query($conn, "SELECT * FROM scores ORDER BY time DESC LIMIT 50");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>랭킹 (Top 50)</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');

body{
margin:0;
font-family:'Orbitron';
background:#02030a;
color:#fff;
}

.game-title{
text-align:center;
font-size:42px;
margin:20px 0;
color:#00fff7;
text-shadow:0 0 20px #00fff7;
}

.wrap{
max-width:720px;
margin:auto;
padding:10px;
}

.card{
background:rgba(255,255,255,.05);
border-radius:18px;
border:1px solid rgba(255,255,255,.12);
overflow:hidden;
}

.toolbar{
display:flex;
justify-content:space-between;
padding:12px;
}

.btn{
border:1px solid #00fff7;
color:#00fff7;
padding:8px 14px;
border-radius:10px;
cursor:pointer;
background:none;
}

.btn:hover{
background:#00fff7;
color:#000;
}

table{
width:100%;
border-collapse:collapse;
}

thead th{
padding:10px;
background:#111;
}

tbody td{
padding:10px;
text-align:center;
}

.top1{color:gold;}
.top2{color:silver;}
.top3{color:#cd7f32;}
</style>
</head>

<body>

<div class="game-title">👽Galaxy Survivor🤖</div>

<div class="wrap">
<div class="card">

<div class="toolbar">
<button class="btn" onclick="location.reload()">새로고침</button>
<button class="btn" onclick="location.replace('index.php')">게임으로 돌아가기</button>
</div>

<table>
<thead>
<tr>
<th>순위</th>
<th>아이디</th>
<th>기록</th>
<th>시간</th>
</tr>
</thead>

<tbody>

<?php
$rank = 1;
while($row = mysqli_fetch_assoc($result)){
    $class = "";
    if($rank == 1) $class = "top1";
    else if($rank == 2) $class = "top2";
    else if($rank == 3) $class = "top3";

    echo "<tr>";
    echo "<td class='$class'>".$rank."</td>";
    echo "<td>".$row['userId']."</td>";
    echo "<td>".$row['time']."</td>";
    echo "<td>".$row['createdAt']."</td>";
    echo "</tr>";
    $rank++;
}
?>

</tbody>
</table>

</div>
</div>

</body>
</html>