<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   

        <!-- styles -->
        <!-- <link rel="stylesheet" href="https://promlm.b-cdn.net/iconv15/assets/css/newsletter/newsletter-style_new.css"> -->
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('css/newsletter-style_new.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css3.css') }}">
        <link rel="stylesheet" href="{{ asset('css/allfonts.min.css') }}">

        <style>
            .tab-btn:hover:not(.active) {
                color: var(--text-color);
                background-color: #313131 !important;
            }
            .preview-canvas img {
                text-align: center;
                    margin: 0 auto;
                }
                .input-group input:focus, .input-group textarea:focus, .input-group select:focus {
                    outline: none;
                    border-color: var(--primary-color);
                    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
                    background-color: #141414 !important;
                }
                 .switch-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

     /* Decorative Border Styles */
        .gold-elegant {
            border: 3px solid #FFD700;
            box-shadow: 0 0 0 1px #FFA500 inset;
        }

        .gold-royal {
            border: 4px double #FFD700;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .gold-ornate {
            border: 2px solid #FFD700;
            box-shadow: 
                inset 0 0 0 6px white,
                inset 0 0 0 8px #FFD700,
                0 0 20px rgba(255, 215, 0, 0.4);
        }

        .gold-gradient {
            border: 4px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #FFD700, #FFA500, #FF8C00, #FFD700) border-box;
            animation: gradientRotate 4s linear infinite;
            background-size: 200% 200%;
        }

        .gold-vintage {
            border: 3px ridge #FFD700;
            box-shadow: 
                0 0 0 1px #B8860B,
                0 5px 15px rgba(184, 134, 11, 0.3);
        }

        .gold-luxury {
            border: 5px solid #FFD700;
            border-image: linear-gradient(45deg, #FFD700, #FFA500, #FFD700) 1;
            box-shadow: 
                inset 0 0 20px rgba(255, 215, 0, 0.1),
                0 0 30px rgba(255, 215, 0, 0.3);
        }

        .corner-art {
            position: relative;
            border: 2px solid #ddd;
        }

        .corner-art::before,
        .corner-art::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            border: 4px solid #FFD700;
        }

        .corner-art::before {
            top: -4px;
            left: -4px;
            border-right: none;
            border-bottom: none;
        }

        .corner-art::after {
            bottom: -4px;
            right: -4px;
            border-left: none;
            border-top: none;
        }

        .art-deco {
            border: 3px solid #FFD700;
            position: relative;
            background: white;
        }

        .art-deco::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            border: 1px solid #FFD700;
            pointer-events: none;
        }

        .art-deco::after {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 1px dashed #FFD700;
            pointer-events: none;
        }

        .neon-glow {
            border: 3px solid #FFD700;
            box-shadow: 
                0 0 10px #FFD700,
                0 0 20px #FFD700,
                0 0 30px #FFD700,
                inset 0 0 10px rgba(255, 215, 0, 0.2);
            animation: neonPulse 2s ease-in-out infinite;
        }

        .diamond-pattern {
            border: 4px solid #FFD700;
            position: relative;
            background: 
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 215, 0, 0.1) 10px,
                    rgba(255, 215, 0, 0.1) 20px
                );
        }

        .embossed {
            border: 3px solid #B8860B;
            box-shadow: 
                -2px -2px 4px rgba(255, 215, 0, 0.5),
                2px 2px 4px rgba(0, 0, 0, 0.3),
                inset -1px -1px 2px rgba(255, 215, 0, 0.3),
                inset 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .celtic-knot {
            border: 4px solid #FFD700;
            position: relative;
        }

        .celtic-knot::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: calc(100% - 20px);
            height: calc(100% - 20px);
            transform: translate(-50%, -50%) rotate(45deg);
            border: 2px dashed #FFD700;
            pointer-events: none;
        }

        .moroccan {
            border: 3px solid #FFD700;
            position: relative;
            background: 
                radial-gradient(circle at 0% 0%, rgba(255, 215, 0, 0.1) 10px, transparent 11px),
                radial-gradient(circle at 100% 0%, rgba(255, 215, 0, 0.1) 10px, transparent 11px),
                radial-gradient(circle at 0% 100%, rgba(255, 215, 0, 0.1) 10px, transparent 11px),
                radial-gradient(circle at 100% 100%, rgba(255, 215, 0, 0.1) 10px, transparent 11px),
                white;
        }

        .beveled-gold {
            border: none;
            box-shadow: 
                inset 3px 3px 6px rgba(255, 215, 0, 0.8),
                inset -3px -3px 6px rgba(184, 134, 11, 0.8),
                3px 3px 6px rgba(0, 0, 0, 0.2);
            background: linear-gradient(145deg, #FFD700, #FFA500);
        }

        .ribbon-border {
            border: none;
            position: relative;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .ribbon-border::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, 
                #FFD700 0%, #FFD700 25%, 
                #FFA500 25%, #FFA500 50%,
                #FFD700 50%, #FFD700 75%,
                #FFA500 75%, #FFA500 100%);
            background-size: 40px 100%;
        }

        .ribbon-border::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, 
                #FFD700 0%, #FFD700 25%, 
                #FFA500 25%, #FFA500 50%,
                #FFD700 50%, #FFD700 75%,
                #FFA500 75%, #FFA500 100%);
            background-size: 40px 100%;
        }

        @keyframes gradientRotate {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes neonPulse {
            0%, 100% {
                box-shadow: 
                    0 0 10px #FFD700,
                    0 0 20px #FFD700,
                    0 0 30px #FFD700,
                    inset 0 0 10px rgba(255, 215, 0, 0.2);
            }
            50% {
                box-shadow: 
                    0 0 20px #FFD700,
                    0 0 30px #FFD700,
                    0 0 40px #FFD700,
                    inset 0 0 15px rgba(255, 215, 0, 0.3);
            }
        }

        .selected-border {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .selected-title {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .selected-preview {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #666;
            background: #fafafa;
            border-radius: 8px;
        }
    .preview-canvas-wrapper {
    display: flex;
    justify-content: center;
    padding: 20px;
    background: #e5e7eb;
}

.preview-canvas {
    transition: all 0.3s ease;
    max-width: 100%;
}

.preview-canvas.desktop {
    width: 1200px;
}

.preview-canvas.mobile {
    width: 420px;
}

#emailContainer {
    width: 100%;
    max-width: 1024px;
}

.preview-canvas.mobile #emailContainer {
    max-width: 375px;
}
   .empty-canvas-msg {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
    border: 2px dashed #d1d5db;
    color: #9ca3af;
    font-size: 16px;
    font-weight: 500;
    text-align: center;
    margin: auto;
    
    
    width: 300px;        
    aspect-ratio: 1 / 1;  
    border-radius: 8px;
}
@media (max-width: 768px) {
    .empty-canvas-msg {
        width: 80%;       
        max-width: 250px;
    }
}


        </style>
    </head>
    <body class="edit">
      
        <div class="app-container">
            <!-- Sidebar -->
            <aside class="builder-sidebar">
                <div class="sidebar-header">
                    <h1><a href="admin/newslettertemplate" style="color: inherit; text-decoration: none;"><i class="fa-solid fa-envelope-open-text"></i>TEMPLATE</a></h1>
                </div>

                <div class="sidebar-tabs">
                    <button class="tab-btn active" data-tab="blocks">Blocks</button>
                    <button class="tab-btn" data-tab="settings">Settings</button>
                </div>

                <div class="sidebar-content">
                    <!-- Blocks Panel -->
                    <div id="blocksPanel" class="panel active">
                        <div class="blocks-grid">
                            <div class="draggable-block" draggable="true" data-type="columns">
                                <i class="fa-solid fa-table-columns"></i>
                                <span>2 Columns</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="columns-3">
                                <i class="fa-solid fa-table-columns"></i>
                            <span>3 Columns</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="columns-4">
                            <i class="fa-solid fa-table-columns"></i>
                            <span>4 Columns</span>
                            </div>  
                            <div class="draggable-block" draggable="true" data-type="hero">
                                <i class="fa-solid fa-image"></i>
                                <span>Hero</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="html">
                                <i class="fa-solid fa-code"></i>
                                <span>HTML</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="text">
                                <i class="fa-solid fa-font"></i>
                                <span>Text</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="image">
                                <i class="fa-regular fa-image"></i>
                                <span>Image</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="button">
                                <i class="fa-solid fa-square-check"></i>
                                <span>Button</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="divider">
                                <i class="fa-solid fa-minus"></i>
                                <span>Divider</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="spacer">
                                <i class="fa-solid fa-arrows-up-down"></i>
                                <span>Spacer</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="social">
                                <i class="fa-solid fa-share-nodes"></i>
                                <span>Social</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="image-text">
                                <i class="fa-solid fa-image"></i>
                                <i class="fa-solid fa-font"></i>
                                <span>Image + Text</span>
                            </div>
                            <div class="draggable-block" draggable="true" data-type="text-image">
                                <i class="fa-solid fa-font"></i>
                                <i class="fa-solid fa-image"></i>
                                <span>Text + Image</span>
                            </div>


                        </div>
                    </div>

                    <!-- Settings Panel (Dynamic) -->
                    <div id="settingsPanel" class="panel">
                        <div id="globalSettings">
                            <div class="control-group">
                                <h3>Global Styles</h3>
                                <div class="input-group">
                                    <label>Background Color</label>
                                    <input type="color" id="globalBgColor" value="#f4f4f9">
                                </div>
                                <div class="input-group">
                                    <label>Container Width (px)</label>
                                    <input type="number" id="globalWidth" value="600" min="300" max="900">
                                </div>
                                <div class="input-group">
                                    <label>Font Family</label>
                                    <select id="globalFont">
                                        <option value="'Outfit', sans-serif">Outfit (Modern)</option>
                                        <option value="Arial, sans-serif">Arial</option>
                                        <option value="'Times New Roman', serif">Times New Roman</option>
                                        <option value="'Courier New', monospace">Courier New</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="blockSettings" style="display: none;">
                    <div class="control-group">
                        <h3>Block Properties</h3>
                        <div id="dynamicControls">
                            <!-- Controls injected via JS -->
                        </div>
                    </div>
                    <div class="control-group">
                        <h3>Border Settings</h3>
                    

                        <div class="switch-container">
                                    <label class="switch">
                                        <input type="checkbox" id="borderToggle" onchange="toggleBorderControls()" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="switch-label">Border Enabled</span>
                                </div>

                        
                        <div class="input-group">
                            <label>Border Type</label>
                            <select id="borderType">
                                <option value="simple">Simple Border</option>
                                <option value="themed">Themed/Decorative Border</option>
                            </select>
                        </div>

                        <!-- Simple Border Controls -->
                        <div id="simpleBorderControls">
                            <div class="input-group">
                                <label>Border Color</label>
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <input type="color" id="borderColor" value="#000000">
                                    <input type="text" id="borderHex" placeholder="#hex" style="width: 80px;">
                                </div>
                            </div>
                            <div class="input-group">
                                <label>Border Thickness (px)</label>
                                <input type="number" id="borderThickness" min="0" value="1" step="1">
                            </div>
                            <div class="input-group">
                                <label>Border Style</label>
                                <select id="borderStyle">
                                    <option value="solid">Solid</option>
                                    <option value="dashed">Dashed</option>
                                    <option value="dotted">Dotted</option>
                                    <option value="double">Double</option>
                                    <option value="groove">Groove</option>
                                    <option value="ridge">Ridge</option>
                                    <option value="inset">Inset</option>
                                    <option value="outset">Outset</option>
                                </select>
                            </div>
                        </div>

                        <!-- Themed Border Controls -->
                        <div id="themedBorderControls" style="display: none;">
                            <div class="input-group">
                                <label>Themed Border Style</label>
                                <select id="themedBorder" onchange="selectBorderFromDropdown(this.value)">
                                        <option value="">Select a theme...</option>
                                        <optgroup label="Gold Themes">
                                            <option value="gold-elegant">Gold Elegant - Solid 2px</option>
                                            <option value="gold-royal">Gold Royal - Double 3px</option>
                                            <option value="gold-luxury">Gold Luxury - Ridge 4px</option>
                                            <option value="gold-gradient">Gold Gradient - Animated</option>
                                            <option value="gold-vintage">Gold Vintage - Ridge Style</option>
                                        </optgroup>
                                        <optgroup label="Premium Themes">
                                            <option value="beveled-gold">Beveled Gold - 3D Effect</option>
                                            <option value="gold-ornate">Gold Ornate - Triple Layer</option>
                                            <option value="embossed">Embossed - Raised Relief</option>
                                        </optgroup>
                                        <optgroup label="Gradient Borders">
                                            <option value="gold-gradient">Gold Gradient - Animated</option>
                                            <option value="neon-glow">Neon Glow - Pulsing Effect</option>
                                        </optgroup>
                                        <optgroup label="Decorative Patterns">
                                            <option value="corner-art">Corner Art - Gold Accents</option>
                                            <option value="art-deco">Art Deco - Geometric</option>
                                            <option value="celtic-knot">Celtic Knot - Interwoven</option>
                                            <option value="moroccan">Moroccan - Exotic Pattern</option>
                                            <option value="diamond-pattern">Diamond Pattern - Diagonal</option>
                                            <option value="ribbon-border">Ribbon Border - Award Style</option>
                                        </optgroup>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <button id="deleteBlockBtn" class="btn-secondary" style="color: #ef4444; border-color: #ef4444;">
                        <i class="fa-solid fa-trash"></i> Delete Block
                    </button>
                </div>
                    </div>
                </div>

                <div class="actions" style="padding: 20px; border-top: 1px solid var(--border-color);">
                    <!-- <div class="input-group">
                        <label>Template Name</label>
                        <input type="text" id="templateName" placeholder="my-newsletter-1">
                    </div> -->
                    <button type="button" id="saveBtn" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                </div>
           </aside>

    <!-- Preview Area -->
    <main class="preview-area">
        <div class="preview-toolbar">
            <div class="device-toggles">
                <button class="active" data-view="desktop"><i class="fa-solid fa-desktop"></i></button>
                <button data-view="mobile"><i class="fa-solid fa-mobile-screen"></i></button>
            </div>
            <button id="clearCanvasBtn" style="color: #ef4444; background: none; border: none; cursor: pointer; font-weight: 500;">Clear</button>
        </div>
        
        <div class="preview-canvas-wrapper">
            <div id="previewCanvas" class="preview-canvas">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="emailBody" style="background-color: #f4f4f9; font-family: 'Outfit', sans-serif; min-height: 100%;">
                    <tr>
                        <td align="center" style="padding: 40px 0;">
                            <table  border="0" cellspacing="0" cellpadding="0" id="emailContainer" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                                <tr>
                                    <td id="dropZone" class="drop-zone">
                                        <!-- Blocks go here -->
                                        <div class="empty-canvas-msg">
                                            Drag blocks here to start building
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</div>


<!-- Hidden File Input for Image Uploads -->
<input type="file" id="imageUploadInput" style="display: none;" accept="image/*">
<!-- Loader -->
<div id="loader" class="loader-overlay">
    <div class="spinner"></div>
</div>

<script type="text/javascript">   
const BCPATH = "{{ env('BCPATH') }}";
const templateName="{{$sub2}}";
const templaterandomid="{{$sub1}}";
const savedContent = {!! json_encode($funnnelpagecontent) !!};

document.getElementById('borderHex')?.addEventListener('input', function (e) {
    const hex = e.target.value.trim();
    if (/^#[0-9A-Fa-f]{6}$/.test(hex) || /^#[0-9A-Fa-f]{3}$/.test(hex)) {
        document.getElementById('borderColor').value = hex;
    }
});

function applyBorderToSelectedBlock() {
    const selectedBlock = document.querySelector('.canvas-block.selected');
    if (!selectedBlock) return;

    const wrapper = selectedBlock.firstElementChild; 

    const enabled     = document.getElementById('borderToggle').checked;
    const color       = document.getElementById('borderColor').value;
    const thickness   = document.getElementById('borderThickness').value + 'px';
    const style       = document.getElementById('borderStyle').value;

    if (enabled && thickness !== '0px') {
        wrapper.style.border = `${thickness} ${style} ${color}`;
        wrapper.style.boxSizing = 'border-box'; 
    } else {
        wrapper.style.border = 'none';
    }
    selectedBlock.dataset.borderEnabled    = enabled;
    selectedBlock.dataset.borderColor      = color;
    selectedBlock.dataset.borderThickness  = document.getElementById('borderThickness').value;
    selectedBlock.dataset.borderStyle      = style;
}


['borderToggle', 'borderThickness', 'borderStyle'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('change', applyBorderToSelectedBlock);
        el.addEventListener('input', applyBorderToSelectedBlock);
    }
});

// For borderColor, only apply on 'change' (when selection is final)
const borderColorEl = document.getElementById('borderColor');
if (borderColorEl) {
    borderColorEl.addEventListener('change', applyBorderToSelectedBlock);
}

// When user types a valid hex, update the color picker
document.getElementById('borderHex')?.addEventListener('blur', function () {
    const hex = this.value.trim();
    if (/^#([0-9A-Fa-f]{3}){1,2}$/i.test(hex)) {
        document.getElementById('borderColor').value = hex;
        applyBorderToSelectedBlock();
    }
});

const originalLoadFunction = window.loadTemplateFromStorage || function() {};
window.loadTemplateFromStorage = function(name) {
    originalLoadFunction(name);
    setTimeout(() => {
        document.querySelectorAll('.canvas-block').forEach(blockElement => {
            restoreBlockBorders(blockElement);
        });
    }, 100);
};

// Border control logic
const borderToggle = document.getElementById('borderToggle');
const borderType = document.getElementById('borderType');
const simpleBorderControls = document.getElementById('simpleBorderControls');
const themedBorderControls = document.getElementById('themedBorderControls');
const themedBorder = document.getElementById('themedBorder');
const borderPreview = document.getElementById('borderPreview');
const borderColor = document.getElementById('borderColor');
const borderHex = document.getElementById('borderHex');
const borderThickness = document.getElementById('borderThickness');
const borderStyle = document.getElementById('borderStyle');

// Toggle between simple and themed borders
borderType.addEventListener('change', function() {
    if (this.value === 'simple') {
        simpleBorderControls.style.display = 'block';
        themedBorderControls.style.display = 'none';
    } else {
        simpleBorderControls.style.display = 'none';
        themedBorderControls.style.display = 'block';
    }
});

// Sync color picker and hex input
borderColor.addEventListener('input', function() {
    borderHex.value = this.value;
    applyBorder();
});

borderHex.addEventListener('input', function() {
    if (/^#[0-9A-F]{6}$/i.test(this.value)) {
        borderColor.value = this.value;
        applyBorder();
    }
});

// Preview themed borders
themedBorder.addEventListener('change', function() {
    const theme = this.value;
    borderPreview.className = '';
    
    if (theme) {
        borderPreview.classList.add(`border-${theme}`);
        borderPreview.textContent = `${this.options[this.selectedIndex].text}`;
    } else {
        borderPreview.textContent = 'Preview: Select a themed border to see preview';
    }
    
    applyBorder();
});

// Apply border to selected block
function applyBorder() {
    const selectedBlock = document.querySelector('.block.selected');
    if (!selectedBlock) return;
    
    // Remove all existing border classes
    selectedBlock.className = selectedBlock.className.replace(/border-[\w-]+/g, '').trim();
    
    if (!borderToggle.checked) {
        selectedBlock.style.border = 'none';
        selectedBlock.style.boxShadow = 'none';
        selectedBlock.style.background = '';
        return;
    }
    
    if (borderType.value === 'simple') {
        // Apply simple border
        const color = borderColor.value;
        const thickness = borderThickness.value;
        const style = borderStyle.value;
        selectedBlock.style.border = `${thickness}px ${style} ${color}`;
    } else {
        // Apply themed border
        const theme = themedBorder.value;
        if (theme) {
            selectedBlock.classList.add(`border-${theme}`);
        }
    }
}

// Event listeners
borderToggle.addEventListener('change', applyBorder);
borderThickness.addEventListener('input', applyBorder);
borderStyle.addEventListener('change', applyBorder);

//preview canvas//
const previewCanvas = document.getElementById('previewCanvas');
const emailContainer = document.getElementById('emailContainer');
const deviceButtons = document.querySelectorAll('.device-toggles button');

deviceButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        deviceButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const view = btn.dataset.view;

        previewCanvas.classList.remove('desktop', 'mobile');
        previewCanvas.classList.add(view);

        if (view === 'desktop') {
            emailContainer.setAttribute('width', '1024');
            emailContainer.style.maxWidth = '1024px';
        } else {
            emailContainer.setAttribute('width', '375');
            emailContainer.style.maxWidth = '375px';
        }
    });
});

</script>

<script src="{{ asset('js/news_editor_script_v10812_builder.js') }}"></script>

</body>
</html>
