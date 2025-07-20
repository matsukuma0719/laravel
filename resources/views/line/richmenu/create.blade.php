@extends('layouts.app')

@section('content')
<style>
    #preview-container {
        width: 100%;
        max-width: 380px;
        min-width: 240px;
        aspect-ratio: 2500 / 1686;
        background: #f7f7f7;
        border-radius: 10px;
        border: 1.5px solid #bbf;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
        touch-action: none;
        transition: background 0.2s, border-color 0.2s;
    }
    #crop-canvas, #area-overlay {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0; top: 0;
        border-radius: 10px;
        display: block;
    }
    #crop-canvas { z-index: 0; background: #eee; transition: background 0.2s; }
    #area-overlay { z-index: 1; pointer-events: none; }
    .preset-thumb {
        width: 80px; height: 54px; margin: 2px; border: 2px solid #bbb;
        border-radius: 5px; display: inline-block; background: #fff; cursor: pointer; box-sizing: border-box;
        position: relative; vertical-align: top;
        transition: background 0.2s, border-color 0.2s;
    }
    .preset-thumb.selected { border-color: #4af; box-shadow:0 2px 6px #99f2; }
    @media (prefers-color-scheme: dark) {
        #preview-container { background: #222C37; border-color: #466ab2; }
        #crop-canvas { background: #29303a; }
        .preset-thumb { background: #1d2631; border-color: #3e506d; }
        .preset-thumb.selected { border-color: #8ac8ff; box-shadow: 0 2px 8px #3af8; }
    }
</style>

<div class="max-w-5xl mx-auto mt-10 bg-white dark:bg-gray-900 p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">リッチメニュー新規作成</h2>
    <form id="area-form" method="POST" action="{{ route('richmenu.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- タイトル -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">タイトル</label>
            <input type="text" name="title"
                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 rounded px-2 py-1"
                placeholder="リッチメニュー名を入力" required />
        </div>

        <!-- 適用属性 -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">適用属性</label>
            <div class="flex flex-wrap gap-4">
                <div>
                    <div class="mb-1 text-xs text-gray-600 dark:text-gray-400">性別</div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="genders[]" value="male" class="form-checkbox" />
                        <span class="ml-1">男性</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="checkbox" name="genders[]" value="female" class="form-checkbox" />
                        <span class="ml-1">女性</span>
                    </label>
                </div>
            </div>
            <div class="flex flex-wrap gap-4">    
                <div>
                    <div class="mb-1 text-xs text-gray-600 dark:text-gray-400">年齢</div>
                    <label class="inline-flex items-center mr-3">
                        <input type="checkbox" name="ages[]" value="10" class="form-checkbox" />
                        <span class="ml-1">10代</span>
                    </label>
                    <label class="inline-flex items-center mr-3">
                        <input type="checkbox" name="ages[]" value="20" class="form-checkbox" />
                        <span class="ml-1">20代</span>
                    </label>
                    <label class="inline-flex items-center mr-3">
                        <input type="checkbox" name="ages[]" value="30" class="form-checkbox" />
                        <span class="ml-1">30代</span>
                    </label>
                    <label class="inline-flex items-center mr-3">
                        <input type="checkbox" name="ages[]" value="40" class="form-checkbox" />
                        <span class="ml-1">40代</span>
                    </label>
                    <label class="inline-flex items-center mr-3">
                        <input type="checkbox" name="ages[]" value="50" class="form-checkbox" />
                        <span class="ml-1">50代</span>
                    </label>
                    <label class="inline-flex items-center mr-3">
                        <input type="checkbox" name="ages[]" value="60" class="form-checkbox" />
                        <span class="ml-1">60代</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ages[]" value="70" class="form-checkbox" />
                        <span class="ml-1">70代以上</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- 左カラム -->
            <div class="flex-1 min-w-[320px] max-w-[420px]">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">画像アップロード</label>
                <input type="file" id="image-input" name="image" accept="image/*" class="w-full mb-2 bg-white dark:bg-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded" />
                <input type="hidden" name="cropped_image" id="cropped-image-field" />
                <div id="preview-container" class="my-2 w-full">
                    <canvas id="crop-canvas" width="2500" height="1686"></canvas>
                    <div id="area-overlay"></div>
                </div>
                <div class="text-xs mt-2 text-gray-700 dark:text-gray-300 text-center">
                    画像をドラッグやピンチで移動・拡大縮小、見せたい部分に合わせてください
                </div>
            </div>
            <!-- 右カラム -->
            <div class="flex-1 min-w-[320px]">
                <div>
                    <div class="font-semibold mb-2 text-gray-700 dark:text-gray-200">レイアウトプリセット</div>
                    <div class="preset-select mb-6" id="preset-thumbs"></div>
                </div>
                <div id="area-inputs"></div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded mt-4">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ★プリセット定義
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
    const AREA_TEXT_OPTIONS = [
        "ボタンA", "ボタンB", "キャンペーン", "予約", "お問い合わせ", "メニュー1", "メニュー2"
    ];
    let selectedPreset = 0;

    // ★プリセットサムネイル描画
    const presetThumbs = document.getElementById('preset-thumbs');
    const thumbW = 80, thumbH = Math.round(thumbW * (1686/2500));
    const scale = thumbW/2500;
    PRESETS.forEach((preset, idx) => {
        let div = document.createElement('div');
        div.className = "preset-thumb" + (idx === 0 ? " selected" : "");
        div.title = preset.name;
        div.style.position = "relative";
        div.style.width = thumbW + "px";
        div.style.height = thumbH + "px";
        div.style.margin = "6px";
        div.style.overflow = "hidden";
        div.style.display = "inline-block";
        div.style.background = "#f6f7fa";
        div.style.border = "1.5px solid #bbb";
        div.style.borderRadius = "7px";
        div.style.boxSizing = "border-box";
        div.style.cursor = "pointer";
        preset.areas.forEach(area => {
            let box = document.createElement('div');
            box.style.position = "absolute";
            box.style.left = Math.max(0, area.x * scale) + "px";
            box.style.top  = Math.max(0, area.y * scale) + "px";
            box.style.width  = Math.max(0, Math.min(thumbW - (area.x * scale), area.w * scale)) + "px";
            box.style.height = Math.max(0, Math.min(thumbH - (area.y * scale), area.h * scale)) + "px";
            box.style.border = "1.5px solid #6ca0ea";
            box.style.background = "rgba(100,140,220,0.07)";
            box.style.borderRadius = "4px";
            div.appendChild(box);
        });
        if(idx === 0){
            div.style.boxShadow = "0 0 0 2px #3b82f6";
        }
        div.onclick = () => selectPreset(idx);
        presetThumbs.appendChild(div);
    });

    // ★フォームのエリア入力欄生成
    function renderAreaInputs() {
        const areaInputs = document.getElementById('area-inputs');
        areaInputs.innerHTML = '';
        const n = PRESETS[selectedPreset].areas.length;
        for(let i=0; i<n; i++) {
            const wrap = document.createElement('div');
            wrap.className = 'mb-3';
            wrap.innerHTML = `
                <div class="font-semibold mb-1 text-gray-800 dark:text-gray-200">領域${String.fromCharCode(65+i)}</div>
                <select name="areas[${i}][text]"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 rounded mb-1 px-2 py-1">
                    <option value="">選択してください</option>
                    ${AREA_TEXT_OPTIONS.map(opt =>
                        `<option value="${opt}">${opt}</option>`
                    ).join('')}
                </select>
                <input name="areas[${i}][url]" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 rounded px-2 py-1" placeholder="リンク（URL）" />
            `;
            areaInputs.appendChild(wrap);
        }
    }

    // ★プリセット選択
    function selectPreset(idx){
        selectedPreset = idx;
        document.querySelectorAll('.preset-thumb').forEach((el,i)=>{
            el.classList.toggle('selected',i===idx);
            el.style.boxShadow = i===idx ? "0 0 0 2px #3b82f6" : "";
        });
        drawAreas();
        renderAreaInputs();
    }

    // ---- 画像トリミングUI ----
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

    function drawCrop(){
        ctx.clearRect(0,0,2500,1686);
        if(!img) return;
        ctx.save();
        ctx.setTransform(zoom,0,0,zoom,offsetX,offsetY);
        ctx.drawImage(img,0,0);
        ctx.restore();
    }

    function drawAreas(){
        const overlay = document.getElementById('area-overlay');
        overlay.innerHTML = "";
        const overlayW = overlay.offsetWidth;
        const overlayH = overlay.offsetHeight;
        const scale = Math.min(overlayW / 2500, overlayH / 1686);
        const offsetX = (overlayW - 2500 * scale) / 2;
        const offsetY = (overlayH - 1686 * scale) / 2;
        if(!img) return;
        PRESETS[selectedPreset].areas.forEach((area, idx) => {
            let box = document.createElement('div');
            box.style.position = "absolute";
            box.style.left   = (area.x * scale + offsetX) + "px";
            box.style.top    = (area.y * scale + offsetY) + "px";
            box.style.width  = (area.w * scale) + "px";
            box.style.height = (area.h * scale) + "px";
            box.style.border = "1px solid #e22";
            box.style.background = "rgba(255,0,0,0.08)";
            box.style.borderRadius = "6px";
            box.title = "領域" + (idx + 1);
            overlay.appendChild(box);
        });
    }

    // ★フォーム送信時、canvas画像をBase64で埋め込む
    document.getElementById('area-form').addEventListener('submit', function(e){
        var dataURL = canvas.toDataURL('image/png');
        document.getElementById('cropped-image-field').value = dataURL;
    });

    // 初期化
    renderAreaInputs();

    window.addEventListener('resize', () => {
        drawCrop();
        drawAreas();
    });

});
</script>

@if(session('success'))
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
@endif

@endsection
