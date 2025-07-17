@extends('layouts.app')

@section('content')
<style>
    #preview-container {
        width: 100%;
        max-width: 30vw;    /* 画面幅の60%に縮小（任意でpx指定もOK） */
        aspect-ratio: 2500 / 1686;
        background: #f7f7f7;
        border-radius: 10px;
        border: 1.5px solid #bbf;
        margin: 24px auto;
        position: relative;
        overflow: hidden;
        touch-action: none;
    }
    #crop-canvas {
        width: 100%;
        height: 100%;
        display: block;
        background: #eee;
        border-radius: 10px;
    }
    #area-overlay {
        position: absolute;
        left: 0; top: 0; width: 100%; height: 100%;
        pointer-events: none;
    }
</style>

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">リッチメニュー新規作成</h2>
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">画像アップロード</label>
        <input type="file" id="image-input" accept="image/*" class="w-full" />
    </div>

    <div id="preview-container">
        <canvas id="crop-canvas" width="2500" height="1686"></canvas>
        <div id="area-overlay"></div>
    </div>
    <div class="text-xs text-gray-500 mb-3">画像をドラッグやピンチで移動・拡大縮小、見せたい部分に合わせてください</div>
    <div class="preset-select" id="preset-thumbs"></div>
</div>

<script>
const PRESETS = [
    {
        name: "4分割",
        areas: [
            { x: 0,    y: 0,    w: 1250, h: 843 },
            { x: 1250, y: 0,    w: 1250, h: 843 },
            { x: 0,    y: 843,  w: 1250, h: 843 },
            { x: 1250, y: 843,  w: 1250, h: 843 },
        ]
    },
    {
        name: "横2分割",
        areas: [
            { x: 0,    y: 0,    w: 1250, h: 1686 },
            { x: 1250, y: 0,    w: 1250, h: 1686 },
        ]
    },
    {
        name: "3分割(タブ)",
        areas: [
            { x: 0,    y: 336,  w: 833, h: 1350 },
            { x: 833,  y: 336,  w: 834, h: 1350 },
            { x: 1667, y: 336,  w: 833, h: 1350 },
        ]
    }
];
let selectedPreset = 0;

// プリセットサムネイル描画
const presetThumbs = document.getElementById('preset-thumbs');
PRESETS.forEach((preset, idx) => {
    let div = document.createElement('div');
    div.className = "preset-thumb" + (idx === 0 ? " selected" : "");
    div.title = preset.name;
    div.onclick = () => selectPreset(idx);

    // 枠の簡易イメージ
    let scale = 80/2500;
    preset.areas.forEach(area => {
        let box = document.createElement('div');
        box.style.position = "absolute";
        box.style.left = (area.x * scale) + "px";
        box.style.top = (area.y * scale) + "px";
        box.style.width = (area.w * scale) + "px";
        box.style.height = (area.h * scale) + "px";
        box.style.border = "1.2px solid #999";
        box.style.background = "rgba(0,0,0,0.05)";
        box.style.borderRadius = "3px";
        div.appendChild(box);
    });
    div.style.position = "relative";
    presetThumbs.appendChild(div);
});
function selectPreset(idx){
    selectedPreset = idx;
    document.querySelectorAll('.preset-thumb').forEach((el,i)=>el.classList.toggle('selected',i===idx));
    drawAreas();
}

// --- 画像の移動・拡大縮小トリミングUI ----
const canvas = document.getElementById('crop-canvas');
const ctx = canvas.getContext('2d');
let img = null, imgW=1, imgH=1, zoom=1, offsetX=0, offsetY=0, dragging=false, lastX=0, lastY=0, pinchDist=0, pinchZoom=1;

document.getElementById('image-input').addEventListener('change', function(e){
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev){
        img = new window.Image();
        img.onload = function(){
            imgW = img.naturalWidth;
            imgH = img.naturalHeight;
            // 最初は横か縦が枠ピッタリに
            let scaleX = 2500 / imgW, scaleY = 1686 / imgH;
            zoom = Math.max(scaleX, scaleY);
            offsetX = (2500 - imgW*zoom)/2;
            offsetY = (1686 - imgH*zoom)/2;
            drawCrop();
            drawAreas();
        };
        img.src = ev.target.result;
    };
    reader.readAsDataURL(file);
});

canvas.addEventListener('mousedown', function(e){
    dragging=true; lastX=e.offsetX; lastY=e.offsetY;
});
canvas.addEventListener('mousemove', function(e){
    if(dragging){
        offsetX += (e.offsetX-lastX);
        offsetY += (e.offsetY-lastY);
        lastX = e.offsetX; lastY = e.offsetY;
        drawCrop(); drawAreas();
    }
});
canvas.addEventListener('mouseup', ()=>{dragging=false;});
canvas.addEventListener('mouseleave',()=>{dragging=false;});

// ホイールでズーム
canvas.addEventListener('wheel', function(e){
    e.preventDefault();
    let scale = (e.deltaY<0) ? 1.06 : 0.94;
    let cx = e.offsetX, cy = e.offsetY;
    let zx = (cx-offsetX)/zoom, zy = (cy-offsetY)/zoom;
    zoom *= scale;
    offsetX = cx - zx*zoom;
    offsetY = cy - zy*zoom;
    drawCrop(); drawAreas();
},{passive:false});

// --- スマホ用タッチイベント ---
canvas.addEventListener('touchstart',function(e){
    if(e.touches.length==1){
        dragging=true; lastX=e.touches[0].clientX; lastY=e.touches[0].clientY;
    }
    if(e.touches.length==2){
        pinchDist = Math.hypot(
            e.touches[0].clientX-e.touches[1].clientX,
            e.touches[0].clientY-e.touches[1].clientY
        );
        pinchZoom = zoom;
    }
});
canvas.addEventListener('touchmove',function(e){
    if(e.touches.length==1 && dragging){
        let dx = e.touches[0].clientX-lastX, dy = e.touches[0].clientY-lastY;
        offsetX += dx; offsetY += dy; lastX=e.touches[0].clientX; lastY=e.touches[0].clientY;
        drawCrop(); drawAreas();
    }
    if(e.touches.length==2){
        let newDist = Math.hypot(
            e.touches[0].clientX-e.touches[1].clientX,
            e.touches[0].clientY-e.touches[1].clientY
        );
        zoom = pinchZoom * (newDist/pinchDist);
        drawCrop(); drawAreas();
    }
    e.preventDefault();
},{passive:false});
canvas.addEventListener('touchend',()=>{dragging=false;});

// トリミング描画
function drawCrop(){
    ctx.clearRect(0,0,2500,1686);
    if(!img) return;
    ctx.save();
    ctx.setTransform(zoom,0,0,zoom,offsetX,offsetY);
    ctx.drawImage(img,0,0);
    ctx.restore();
}

// 赤枠描画
function drawAreas(){
    const overlay = document.getElementById('area-overlay');
    overlay.innerHTML = "";
    let container = canvas.getBoundingClientRect();
    let scaleX = container.width / 2500;
    let scaleY = container.height / 1686;
    if(!img) return;
    PRESETS[selectedPreset].areas.forEach((area,idx)=>{
        let box = document.createElement('div');
        box.style.position = "absolute";
        box.style.left = (area.x * scaleX) + "px";
        box.style.top  = (area.y * scaleY) + "px";
        box.style.width = (area.w * scaleX) + "px";
        box.style.height = (area.h * scaleY) + "px";
        box.style.border = "2px solid #e22";
        box.style.background = "rgba(255,0,0,0.08)";
        box.style.borderRadius = "6px";
        box.title = "領域"+(idx+1);
        overlay.appendChild(box);
    });
}

</script>
@endsection
