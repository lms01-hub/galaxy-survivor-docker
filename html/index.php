<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title> 스퀘어 타임런(Square Time Run)[1단원-12]</title>
<style>
 body {
  margin: 0;
  min-height: 100vh;
  background:
    radial-gradient(circle at 20% 20%, #1a237e, #000),
    radial-gradient(circle at 80% 80%, #311b92, #000);
  overflow-x: hidden;
}

  #canvas {
  background: radial-gradient(circle at center, #050b2c, #000);
  display: block;
  margin: 0 auto;
  border-radius: 14px;
  box-shadow: 0 0 35px rgba(0,200,255,.5);
}

  .sound-toggle-wrap{
    position: sticky;
    top: 0;
    z-index: 50;
    display: flex;
    justify-content: center;
    background: rgba(255,255,255,0.9);
    border-bottom: 1px solid #e5e5e5;
    padding: 6px 8px;
  }

  .sound-toggle{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    color: #222;
    user-select: none;
  }
  .switch{
    position: relative;
    display: inline-block;
    width: 54px;
    height: 28px;
  }
  .switch input{
    display: none;
  }
  .slider{
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .2s;
    border-radius: 28px;
  }
  .slider:before{
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    top: 3px;
    background: white;
    transition: .2s;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
  }
  input:checked+.slider{
    background-color: #4caf50;
  }
  input:checked+.slider:before{
    transform: translateX(26px);
  }

  .pc-guide{
    display:none;
    margin-top:10px;
    font-size:16px;
    font-weight:bold;
    color:white;
    text-shadow:
      0 0 5px #7c4dff,
      0 0 10px #651fff;
}

  @media (min-width:769px) { #canvas { width:600px; height:600px; } .pc-guide{ display:block;} }
  .controls { display:none; margin-top:10px; flex-direction:column; align-items:center; }
  .controls .row{ display:flex; justify-content:center; }
  .controls button {
    font-size:24px; padding:15px 20px; margin:5px; min-width:60px;
    border-radius:10px; background-color:#333; color:white;
    touch-action:none; user-select:none; -webkit-user-select:none;
  }
  .controls button:active{ background-color:#555; }
  #startBtn{
  position:relative;
  isolation:isolate;  
  background: #2d6cdf;   /* ⭐ 기본 배경 필수 */
  color: white;
  border-radius: 16px;
  transform-origin: center center; 
  pointer-events: auto;
  will-change: transform;

  position: relative;   /* 중요 */
  z-index: 20;          /* QR보다 높게 */

  flex-shrink: 0;              /* ⭐ 절대 찌부 안 됨 */
  width: 280px;                /* 고정 폭 */
  min-height: 200px;

  display: flex;               /* 내부 정렬 고정 */
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;

  padding: 24px 18px;
  line-height: 1.5;
}
#startBtn::before{
  content:"";
  position:absolute;
  inset:0;
  background:#45a049;
  border-radius:16px;
  z-index:-1;

  transform: scale(1);
  transition: transform .15s ease, opacity .15s ease;
  opacity:0;
}

#startBtn:hover::before{
  opacity:1;
  transform: scale(1.05);
}


#startBtn:active{
  transform: scale(0.95);
}
  .messageBox{
    display:none;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    z-index:50;

    background:rgba(5,10,40,0.95);
    border:2px solid #00e5ff;
    border-radius:16px;

    padding:30px 40px;
    text-align:center;
    min-width:300px;

    box-shadow:
        0 0 10px #00e5ff,
        0 0 30px #00e5ff;

    font-family:'Orbitron','Noto Sans KR',sans-serif;
}

  @media (max-width:768px) {
    #canvas { width:100vw; height:100vw; }
    .controls{ display:block; }
    .pc-guide{ display:none; }
  }
  .rank-btn{
    margin: 15px auto 30px;
    padding: 10px 20px;
    background: #2d6cdf;
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.rank-btn:active{
    transform: translateY(2px);
}

.game-title{
    text-align:center;
    font-size:42px;
    font-weight:900;
    margin-top:16px;
    margin-bottom:12px;
    letter-spacing:3px;

    color:white;

    font-family:'Orbitron','Arial Black','Noto Sans KR',sans-serif;

    text-shadow:
        0 0 5px #00e5ff,
        0 0 10px #00e5ff,
        0 0 20px #00bcd4,
        0 0 40px #00acc1;
}


@media(max-width: 768px){
    .game-title{
        font-size: 28px;
    }
}
  #restartBtn {
    display:none;
    font-size:20px;
    margin-top:10px;
    padding:10px 20px;
  }
  .star{
  position:absolute;
  width:2px;
  height:2px;
  background:white;
  border-radius:50%;
  opacity:.8;
}
.rank-btn,
.pc-guide{
    display:block;
    margin-left:auto;
    margin-right:auto;
    text-align:center;
}

.pc-guide{
    color:white;
}
#timeDisplay{
    text-align:center;
    font-size:26px;
    font-weight:800;
    margin-bottom:10px;

    color:white;

    font-family:'Orbitron','Arial Black','Noto Sans KR',sans-serif;

    text-shadow:
        0 0 5px #ff1744,
        0 0 10px #ff1744,
        0 0 20px #ff5252;

    letter-spacing:2px;
}
#msgText{
    color:#ff1744;
    font-size:26px;
    font-weight:900;
    margin-bottom:20px;
    white-space:pre-line;

    text-shadow:
        0 0 5px #ff1744,
        0 0 15px #ff1744,
        0 0 30px #ff5252;
}
#userId{
    width:220px;
    padding:10px;
    font-size:16px;
    border-radius:8px;
    border:1px solid #00e5ff;
    background:#02051f;
    color:white;
    outline:none;
    margin-bottom:15px;

    box-shadow:0 0 10px #00e5ff inset;
}
#saveBtn{
    margin:8px;
    padding:10px 20px;
    font-size:16px;
    font-weight:700;
    border:none;
    border-radius:8px;
    cursor:pointer;
    color:white;
    background:#00bcd4;

    box-shadow:0 0 10px #00e5ff;
}



#saveBtn:hover{
    transform:scale(1.05);
}

#cancelBtn:hover{
    transform:scale(1.05);
}
/* === QR SHARE === */

/* START 영역 전체 */
#startArea{
  position:absolute;
  top:45%;
  left:50%;
  transform:translate(-50%, -50%);
  display:flex;
  align-items:center;
  gap:80px;
  z-index:10;
}

/* QR 공통 */
.qr-share{
  pointer-events: none; 
  position: relative;
  z-index: 5;
  flex-shrink: 1;
  text-align:center;
  background:rgba(0,0,0,.45);
  border:2px solid #00ff88;
  border-radius:16px;
  padding:14px;

  box-shadow:0 0 30px rgba(0,255,136,.8);
}

/* QR 크기 크게 */
.qr-share img{
  width:160px;
  height:160px;
}

/* QR 아래 텍스트 */
.qr-text{
  margin-top:8px;
  font-size:14px;
  font-weight:700;
  color:#00ff88;
  text-shadow:0 0 10px #00ff88;
}

/* 모바일 대응 */
@media (max-width: 768px){
  #startArea{
    flex-direction:column;
    gap:20px;
  }

  .qr-share img{
    width:130px;
    height:130px;
  }
}
/* 📱 모바일에서는 QR 숨김 */
@media (max-width: 768px){
  .qr-share{
    display: none;
  }
}
@media (max-width: 768px){

  #startArea{
    top: 50%;
    gap: 0;
  }

  #startBtn{
    width: 90vw;          /* 화면 거의 꽉 */
    max-width: 360px;
    min-height: 220px;

    font-size: 32px;
    line-height: 1.4;
  }

  #startBtn span{
    font-size: 16px;
  }
}
</style>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-app.js";
  import { getFirestore } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-firestore.js";

  const firebaseConfig = {
    apiKey: "AIzaSyDdjYf_8gLtqSnCtfgj_sZ4w1Bh2JVQTHM",
    authDomain: "my-webgame-project1-f4e1b.firebaseapp.com",
    projectId: "my-webgame-project1-f4e1b",
    storageBucket: "my-webgame-project1-f4e1b.firebasestorage.app",
    messagingSenderId: "143089634435",
    appId: "1:143089634435:web:e5ee71a77d74a071a99fb6"
  };

  const app = initializeApp(firebaseConfig);
  const db = getFirestore(app);
  window._db = db;
</script>
</head>
<body>
<div class="sound-toggle-wrap">
    <div class="sound-toggle">
        <span id="soundStateEmoji">🔊</span>
        사운드
        <label class="switch" title="사운드 On/Off">
            <input type="checkbox" id="soundToggle" checked />
            <span class="slider"></span>
        </label>
        <span id="soundStateText">ON</span>
    </div>
</div>
<div class="game-title">👽Galaxy Survivor🤖</div>
<div id="timeDisplay">SURVIVE : 0.00s</div>
<canvas id="canvas"></canvas>


<div id="startArea">
  
  <!-- 왼쪽 QR -->
  <div class="qr-share left">
    <img src="qr.png" alt="QR Left">
    <div class="qr-text">SCAN<br>PLAY</div>
  </div>

  <!-- START 버튼 -->
  <div id="startBtn">
    Start<br><br>
    <span style="font-size:14px; font-weight:normal; line-height:1.4">
      이 게임은 외계인으로부터<br>
      오래 살아남는 게임입니다.<br><br>
      HP가 다 닳기 전까지 살아남으세요!
    </span>
  </div>

  <!-- 오른쪽 QR -->
  <div class="qr-share right">
    <img src="qr.png" alt="QR Right">
    <div class="qr-text">SCAN<br>PLAY</div>
  </div>

</div>
<div class="messageBox" id="msgBox">
  <div id="msgText"></div>
  <input type="text" id="userId" placeholder="(영어+숫자) 5~15자이내">
  <br>
  <button id="saveBtn">저장</button>
 
</div>

<div class="controls">
  <div class="row">
    <button id="upBtn">↑</button>
  </div>
  <div class="row">
    <button id="leftBtn">←</button>

    <!-- 🔥 여기 추가 -->
    <button id="fireBtn">🔥</button>

    <button id="rightBtn">→</button>
  </div>
  <div class="row">
    <button id="downBtn">↓</button>
  </div>
</div>

<div class="pc-guide">
  PC에서 접속했습니다. 방향키로 이동하세요<br>
  스마트폰은 버튼으로 이동하세요.
</div>
<button class="rank-btn" id="btnRank">랭킹보기</button>
<button id="restartBtn" onclick="location.reload()">다시 시작</button>

<script type="module">
  import { containsSwearWord } from "https://cdn.jsdelivr.net/gh/bc-develop2000/swear_words@main/swear_words.js";
  window.containsSwearWord = containsSwearWord;
</script>

<script>

let userInteracted=false;
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
canvas.width = 600;
canvas.height = 600;

// 주인공 위치/속도
let x = (canvas.width - 10) / 2;
let y = (canvas.height - 10) / 2;
const heroSize = 24;
const enemySize = 32;
const moveAmount = 3;

// 목적지 박스


// 게임 상태
let startTime;
let gameStarted = false;
let elapsedTime = 0;
let stopTime = null;




let soundEnabled=true;
const soundToggle=document.getElementById('soundToggle');
const soundStateEmoji=document.getElementById('soundStateEmoji');
const soundStateText=document.getElementById('soundStateText');



function applySoundState(){
    bgm.muted =
    enemyDieSound.muted =
    pickupSound.muted =
    shootSound.muted = !soundEnabled;

    soundStateEmoji.textContent=soundEnabled?'🔊':'🔈';
    soundStateText.textContent=soundEnabled?'ON':'OFF';
    if(!soundEnabled){bgm.pause();}
    else if(gameStarted && stopTime===null){
        try{ bgm.play();}catch(e){}
    }
}
soundToggle.addEventListener('change',()=>{
    soundEnabled = soundToggle.checked;
    applySoundState();   // ⭐ 이 줄 추가
});

const bgm = new Audio("background.mp3");
bgm.loop = true;
bgm.volume = 0.4;

const enemyDieSound = new Audio("enemydie.mp3");
enemyDieSound.volume = 0.6;

const pickupSound = new Audio("pickup.mp3");
pickupSound.volume = 0.6;

const shootSound = new Audio("shoot.mp3");
shootSound.volume = 0.3;
applySoundState();


function safePlay(audio){
    if (!soundEnabled) return;
    if (!userInteracted) return;   // 🔥 핵심
    try {
        audio.currentTime = 0;
        audio.play();
    } catch(e) {}
}

// 요소
const msgBox = document.getElementById('msgBox');
const msgText = document.getElementById('msgText');
const userIdInput = document.getElementById('userId');
const saveBtn = document.getElementById('saveBtn');
const cancelBtn = document.getElementById('cancelBtn');
const startBtn = document.getElementById('startBtn');

// 함수들

const isMobile =
  window.matchMedia("(pointer: coarse)").matches ||
  window.innerWidth <= 768;


if (isMobile) {
  startBtn.style.width = "80vw";
  startBtn.style.fontSize = "6vw";
  startBtn.style.padding = "20px 0";
}
const timeDisplay = document.getElementById("timeDisplay");

function drawTimer() {
  if (gameStarted) {
    const t = (Date.now() - startTime) / 1000;
    timeDisplay.innerText = `SURVIVE : ${t.toFixed(2)}s`;
  } else if (stopTime !== null) {
    timeDisplay.innerText = `SURVIVE : ${stopTime.toFixed(2)}s`;
  } else {
    timeDisplay.innerText = "SURVIVE : 0.00s";
  }
}





function showMessage(text) {
  msgText.innerText = text;
  msgBox.style.display = 'block';
  userIdInput.value = '';
  userIdInput.focus();
}

saveBtn.addEventListener('click', async () => {
  const val = userIdInput.value.trim();
  const re = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z0-9]{5,15}$/;

  if (typeof window.containsSwearWord !== 'function') {
    alert('욕설 필터 모듈을 불러오지 못했습니다. (ESM import 확인)');
    console.error('[swear] containsSwearWord not ready')
    return;
  }

  if (containsSwearWord(val, 'eng')) {
    alert('사용할 수 없는 단어가 포함되어 있습니다.');
    userIdInput.focus();
    return;
  }

  if (!re.test(val)) {
    alert('아이디는 영어와 숫자를 반드시 포함한 5~15자여야 합니다.');
    userIdInput.focus();
    return;
  }

  alert(`입력한 아이디는: ${val}입니다.`);

  const record = Number.isFinite(stopTime) ? Number(stopTime.toFixed(2)) :0;
  try{
    const db = window._db;

    if(!db){
      alert("DB 초기화 실패: Firebase 설정을 확인하세요.");
      return;
    }

    const{collection,addDoc,serverTimestamp} = await import(
      "https://www.gstatic.com/firebasejs/12.3.0/firebase-firestore.js"
    );

   fetch("save.php", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify({
    userId: val,
    time: record
  })
})
.then(res => res.text())
.then(data => {
  alert("저장 완료!");
  location.href = "rank.php";
});

    alert(`저장되었습니다!\nID: ${val}\n기록: ${record}초`);
    msgBox.style.display='none';
    location.href="canvas_js_exam_1_15_exam_rankpage.html";

    // alert("저장성공 : 다음 단원에서는 성공시 rankpage.html 페이지로 이동을 학습합니다.");
  }catch(err){
    console.error(err);
    alert("저장 중 오류가 발생했습니다. 콘솔을 확인하세요.");
  }
  msgBox.style.display='none';
  resetGame();
});



startBtn.addEventListener('click', async () => {
  document.getElementById('startArea').style.display = 'none';
  userInteracted = true;

  // ✅ 오디오 unlock (모든 사운드)
   const audios = [bgm, enemyDieSound, pickupSound, shootSound];

  for (const a of audios) {
    try {
      await a.play();
      a.pause();
      a.currentTime = 0;
    } catch (e) {}
  }

  // ✅ 게임 시작 처리 (기존 로직 유지)
  gameStarted = true;
  startTime = Date.now();
  startBtn.style.display = 'none';
  playerLife = maxLife;   // 🔥 시작할 때 무조건 풀피

  if (soundEnabled) {
    bgm.play();
  }
});


// 리셋 함수
function resetGame() {
  spawnInterval = 2000;
  lastSpawn = 0;
  gameStarted = false;
  stopTime = null;
  startBtn.style.display = 'block';
  respawnPlayer();
  initEnemies();
  playerLife = maxLife;

  time = 0;
  ammo = maxAmmo;     // ✅ 추가
  reloading = false; // ✅ 추가
  bgm.pause();
 
}

// 적 관련
const positions = [];
for (let i = 0; i < 30; i++) {
  for (let j = 0; j < 30; j++) {
    positions.push({ x: i * 20, y: j * 20 });
  }
}

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
}

let enemyX = [], enemyY = [], enemyColor = [];
let enemySpeed = [];
let enemyAngle = [];
let enemyWaveSpeed = [];
let spawnInterval = 2000; // 처음엔 2초마다
let lastSpawn = 0;

function initEnemies() {
  shuffle(positions);
  enemyX = [];
  enemyY = [];
  enemyColor = [];
  enemySpeed = [];

  for (let i = 0; i < 10; i++) {
    enemyX.push(positions[i].x);
    
    enemyY.push(-Math.random() * 300 - enemySize);
    enemyColor.push('red');
    enemySpeed.push(2);   // 🔴 빨강 빠름
    enemyAngle.push(Math.random() * Math.PI * 2);
    enemyWaveSpeed.push(0.05 + Math.random() * 0.05);
  }

  for (let i = 10; i < 15; i++) {
    enemyX.push(positions[i].x);
    enemyY.push(-Math.random() * 300 - enemySize);
    enemyColor.push('blue');
    enemySpeed.push(0.8); // 🔵 블루 느림
    enemyAngle.push(Math.random() * Math.PI * 2);
    enemyWaveSpeed.push(0.03 + Math.random() * 0.03);
  }
}

function spawnEnemy() {
  const px = Math.random() * (canvas.width - enemySize);
  const py = -Math.random() * 200 - enemySize;

  const surviveTime = (Date.now() - startTime) / 1000;

  // 30초 이후 블루 증가
  let blueChance = surviveTime > 30 ? 0.4 : 0.2;

  const color = Math.random() < blueChance ? "blue" : "red";

  enemyX.push(px);
  enemyY.push(py);
  enemyColor.push(color);

  // ⭐ 이게 빠져있었음
  enemySpeed.push(color === "red" ? 2 : 0.8);
  enemyAngle.push(Math.random() * Math.PI * 2);
  enemyWaveSpeed.push(0.03 + Math.random() * 0.05);
}



initEnemies();

const maxLife = 5;
let playerLife = maxLife;

let time = 0;
let timerId = null;
function startTimer() {
  if (timerId) clearInterval(timerId);
  timerId = setInterval(() => {
    if (playerLife > 0 && gameStarted) time++;
  }, 1000);
}
startTimer();

function formatTime(sec) {
  const m = Math.floor(sec / 60);
  const s = sec % 60;
  return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
}

function move_limit() {
  if (x < 0) x = 0;
  if (y < 0) y = 0;
  if (x > canvas.width - heroSize) x = canvas.width - heroSize;
  if (y > canvas.height - heroSize) y = canvas.height - heroSize;
}

function drawHero() {
   ctx.font = `${heroSize}px "Segoe UI Emoji","Apple Color Emoji","Noto Color Emoji", serif`;
  ctx.textAlign = 'left';
  ctx.textBaseline = 'top';
  ctx.fillText('🚀', x, y);
}

function drawEnemies() {
  ctx.font = `${enemySize}px "Segoe UI Emoji","Apple Color Emoji","Noto Color Emoji", serif`;
  ctx.textAlign = 'left';
  ctx.textBaseline = 'top';

  for (let i = 0; i < enemyX.length; i++) {

    // ⬇ 내려오기
    if(gameStarted){
    enemyY[i] += enemySpeed[i];
    enemyAngle[i] += enemyWaveSpeed[i];
    enemyX[i] += Math.sin(enemyAngle[i]) * 1.5;
    }
    if (enemyColor[i] === 'red') {
      ctx.fillText('👾', enemyX[i], enemyY[i]);
    } else {
      ctx.fillText('👹', enemyX[i], enemyY[i]);
    }

    // 화면 밑으로 가면 다시 위로
    if (gameStarted && enemyY[i] > canvas.height) {
      enemyY[i] = -enemySize;
      enemyX[i] = Math.random() * (canvas.width - enemySize);
    }
  }
}

function drawInfo() {
  const redLeft = enemyColor.filter(c => c === 'red').length;

  ctx.shadowBlur = 0;
  ctx.font = '16px sans-serif';

  ctx.fillStyle = 'red';
  ctx.fillText(`RED: ${redLeft}`, canvas.width - 100, 20);

  

  ctx.fillStyle = 'white';
  ctx.fillText(`AMMO: ${ammo}/${maxAmmo}`, 10, 20);

  if (reloading) {
    ctx.fillText("장전중...", 10, 45);
  }
}

function drawEnergyBar() {
  const barWidth = 120;
  const barHeight = 14;

  const xBar = canvas.width - barWidth - 15;
  const yBar = 15;

  // 테두리
  ctx.strokeStyle = "white";
  ctx.strokeRect(xBar, yBar, barWidth, barHeight);

  // 현재 체력 비율
  const ratio = playerLife / maxLife;

  // 색상 (체력 줄수록 빨개짐)
  ctx.fillStyle = ratio > 0.5 ? "lime" : ratio > 0.25 ? "orange" : "red";

  ctx.fillRect(xBar, yBar, barWidth * ratio, barHeight);

  ctx.font = "12px sans-serif";
  ctx.fillStyle = "white";
  ctx.fillText("ENERGY", xBar, yBar - 3);
}


function resetRedEnemies() {
  for (let i = enemyColor.length - 1; i >= 0; i--) {
    if (enemyColor[i] === 'red') {
      enemyX.splice(i, 1);
      enemyY.splice(i, 1);
      enemyColor.splice(i, 1);
    }
  }
  shuffle(positions);
  for (let i = 0; i < 10; i++) {
    enemyX.push(positions[i].x);
    enemyY.push(positions[i].y);
    enemyColor.push('red');
  }
}

function collisionEnemies() {
  for (let i = 0; i < enemyX.length; i++) {
    if (
      x < enemyX[i] + enemySize &&
      x + heroSize > enemyX[i] &&
      y < enemyY[i] + enemySize &&
      y + heroSize > enemyY[i]
    ) {

      safePlay(enemyDieSound);

      playerLife--;
      respawnPlayer();

      enemyX.splice(i, 1);
      enemyY.splice(i, 1);
      enemyColor.splice(i, 1);
      i--;
    }
  }
}


function bulletHitEnemies() {
  for (let b = bullets.length - 1; b >= 0; b--) {
    for (let i = enemyX.length - 1; i >= 0; i--) {

      if (
        bullets[b].x < enemyX[i] + enemySize &&
        bullets[b].x + 20 > enemyX[i] &&
        bullets[b].y < enemyY[i] + enemySize &&
        bullets[b].y + 20 > enemyY[i]
      ) {
        // 맞음 💥
        safePlay(enemyDieSound);


        // 🎁 20% 확률 아이템 드랍
        if (Math.random() < 0.15) {
          items.push({
            x: enemyX[i],
            y: enemyY[i]
          });
        }



            bullets.splice(b, 1);
            enemyX.splice(i, 1);
            enemyY.splice(i, 1);
            enemyColor.splice(i, 1);

            return;
      }
    }
  }
}

function respawnPlayer() {
  x = (canvas.width - heroSize) / 2;
  y = canvas.height - heroSize - 10; // 맨 아래
}

function draw() {
   if (!gameStarted) {
    playerLife = maxLife;
  }
  if (gameStarted) {
  const now = Date.now();

  if (now - lastSpawn > spawnInterval) {
    spawnEnemy();

    // 점점 스폰 빨라짐
    spawnInterval = Math.max(400, spawnInterval - 40);

    lastSpawn = now;
  }
  }
  if (!gameStarted && playerLife <= 0) return;

  ctx.clearRect(0, 0, canvas.width, canvas.height);

  drawHero();
  drawEnemies();
  move_limit();
  drawInfo();
  drawTimer();
  drawEnergyBar();
  drawItems();


  if (gameStarted && stopTime === null) {
    if (keys.ArrowLeft) x -= moveAmount;
    if (keys.ArrowRight) x += moveAmount;
    if (keys.ArrowUp) y -= moveAmount;
    if (keys.ArrowDown) y += moveAmount;
  }

  // 💀 게임오버
  if (playerLife <= 0) {
  gameStarted = false;
  stopTime = (Date.now() - startTime) / 1000;

  bullets = [];



  showMessage(`게임 오버!\n생존 시간: ${stopTime.toFixed(2)}초\n아이디를 입력하세요`);

  return;
}


  // 🔴 총알 이동
  for (let i = 0; i < bullets.length; i++) {
    bullets[i].y -= bullets[i].speed;
    ctx.font = "20px Segoe UI Emoji";
    ctx.fillText("🔴", bullets[i].x, bullets[i].y);

    if (bullets[i].y < 0) {
      bullets.splice(i, 1);
      i--;
    }
  }

  collisionEnemies();
  bulletHitEnemies();
}
function drawItems() {
  ctx.font = "20px Segoe UI Emoji";

  for (let i = items.length - 1; i >= 0; i--) {

    const it = items[i];
    if (!it) continue;

    it.y += 1;

    ctx.fillText("🔋", it.x, it.y);

    // 플레이어랑 충돌
    if (
      x < it.x + 20 &&
      x + heroSize > it.x &&
      y < it.y + 20 &&
      y + heroSize > it.y
    ) {
      playerLife = Math.min(maxLife, playerLife + 1);
      safePlay(pickupSound);
      items.splice(i, 1);
      continue;
    }

    // 화면 밖
    if (it.y > canvas.height) {
      items.splice(i, 1);
    }
  }
}

function gameLoop(){
  draw();
  requestAnimationFrame(gameLoop);
}
requestAnimationFrame(gameLoop);
//총알변수
let bullets=[];
let items = [];

let ammo = 15;              // 탄창
const maxAmmo = 15;
let lastShot = 0;          // 마지막 발사 시간
const shootDelay = 300;    // ms (0.3초)
let reloading = false;

// 방향키
const keys = { ArrowLeft: false, ArrowRight: false, ArrowUp: false, ArrowDown: false };
document.addEventListener('keydown', e => {
   if (keys.hasOwnProperty(e.key)) keys[e.key] = true;
    if (e.code === "Space" && gameStarted && !reloading) {
  e.preventDefault();

  const now = Date.now();

  if (now - lastShot < shootDelay) return;   // 쿨타임

  if (ammo <= 0) {
    reloading = true;

    setTimeout(() => {
      ammo = maxAmmo;
      reloading = false;
    }, 2000); // 2초 재장전

    return;
  }

  bullets.push({
    x: x + 10,
    y: y,
    speed: 7
  });
  safePlay(shootSound);
  ammo--;
  if(gameStarted){
  playerLife -= 0.2;

  if (playerLife < 0) playerLife = 0;
  }
  lastShot = now;
}

   
  });
document.addEventListener('keyup', e => { if (keys.hasOwnProperty(e.key)) keys[e.key] = false; });

// 버튼
const setBtnHold = (key, isDown) => { keys[key] = isDown; };
function bindButton(id, key) {
  const btn = document.getElementById(id);
  if (!btn) return; 
  btn.addEventListener('touchstart', () => setBtnHold(key, true));
  btn.addEventListener('touchend', () => setBtnHold(key, false));
  btn.addEventListener('mousedown', () => setBtnHold(key, true));
  btn.addEventListener('mouseup', () => setBtnHold(key, false));
  btn.addEventListener('mouseleave', () => setBtnHold(key, false));
}
bindButton("leftBtn", "ArrowLeft");
bindButton("rightBtn", "ArrowRight");
bindButton("upBtn", "ArrowUp");
bindButton("downBtn", "ArrowDown");
const fireBtn = document.getElementById("fireBtn");

if (fireBtn) {
  fireBtn.addEventListener("touchstart", (e) => {
    e.preventDefault();
    shootMobile();
  }, { passive:false });

  fireBtn.addEventListener("mousedown", () => {
    shootMobile();
  });
}

function shootMobile() {
  if (!gameStarted || reloading) return;

  const now = Date.now();
  if (now - lastShot < shootDelay) return;

  if (ammo <= 0) {
    reloading = true;
    setTimeout(() => {
      ammo = maxAmmo;
      reloading = false;
    }, 2000);
    return;
  }

  bullets.push({
    x: x + 10,
    y: y,
    speed: 7
  });

  safePlay(shootSound);
  ammo--;

  if (gameStarted) {
    playerLife -= 0.2;
    if (playerLife < 0) playerLife = 0;
  }

  lastShot = now;
}
document.getElementById('btnRank').addEventListener('click',function(){
    location.replace("canvas_js_exam_1_15_exam_rankpage.html");
});
function enableUserInteraction() {
  userInteracted = true;
}

document.addEventListener('mousedown', enableUserInteraction, { once: true });
document.addEventListener('touchstart', enableUserInteraction, { once: true });
document.addEventListener('keydown', enableUserInteraction, { once: true });


window.addEventListener('pageshow', () => {
  console.log('pageshow → 강제 초기화');

  // 🎨 이모지 폰트 재설정
  ctx.font = `${heroSize}px "Segoe UI Emoji","Apple Color Emoji","Noto Color Emoji"`;

  // 🔊 오디오 초기화
  userInteracted = false;
  bgm.pause();
  bgm.currentTime = 0;

  soundEnabled = true;
  soundToggle.checked = true;
  

  // 🎮 게임 상태 리셋
  gameStarted = false;
  stopTime = null;
  playerLife = 3;
  time = 0;
  ammo = maxAmmo;
  reloading = false;
  respawnPlayer();


  initEnemies();

  startBtn.style.display = 'block';
});



</script>

<script>
const isMobileDevice =
  window.matchMedia("(pointer: coarse)").matches ||
  window.innerWidth <= 768;

if (!isMobileDevice) {
  for(let i=0;i<120;i++){
    const s=document.createElement("div");
    s.className="star";
    s.style.left=Math.random()*innerWidth+"px";
    s.style.top=Math.random()*innerHeight+"px";
    s.style.opacity=Math.random();
    s.style.transform=`scale(${Math.random()})`;
    document.body.appendChild(s);
  }
}
</script>

</body>
</html>
<!-- 😺🙀 -->😈
