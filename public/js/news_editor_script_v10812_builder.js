document.addEventListener('DOMContentLoaded', () => {
    // State
    let selectedBlock = null;
    let draggedType = null;
    let draggedBlock = null;

    // Elements
    const blocksPanel = document.getElementById('blocksPanel');
    const settingsPanel = document.getElementById('settingsPanel');
    const globalSettings = document.getElementById('globalSettings');
    const blockSettings = document.getElementById('blockSettings');
    const dynamicControls = document.getElementById('dynamicControls');
    const mainDropZone = document.getElementById('dropZone');
    const emptyMsg = document.querySelector('.empty-canvas-msg');
    const tabBtns = document.querySelectorAll('.tab-btn');
    const imageUploadInput = document.getElementById('imageUploadInput');

    // Global Inputs
    const globalInputs = {
        bgColor: document.getElementById('globalBgColor'),
        width: document.getElementById('globalWidth'),
        font: document.getElementById('globalFont')
    };

    // --- Tab Switching ---
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById(btn.dataset.tab + 'Panel').classList.add('active');
        });
    });

    // --- Drag and Drop Logic ---

    // Sidebar Draggables
    document.querySelectorAll('.draggable-block').forEach(block => {
        block.addEventListener('dragstart', (e) => {
            draggedType = block.dataset.type;
            draggedBlock = null;
            e.dataTransfer.effectAllowed = 'copy';
            e.dataTransfer.setData('text/plain', draggedType);
        });
    });

    // Initialize Main Drop Zone
    initDropZone(mainDropZone);

    function initDropZone(zone) {
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Prevent bubbling to parent zones
            zone.classList.add('drag-over');
            e.dataTransfer.dropEffect = draggedType ? 'copy' : 'move';
        });

        zone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            e.stopPropagation();
            zone.classList.remove('drag-over');
        });

        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Stop bubbling!
            zone.classList.remove('drag-over');

            // Hide empty message if it's the main zone
            if (zone === mainDropZone && emptyMsg) emptyMsg.style.display = 'none';

            if (draggedType) {
                // New block from sidebar
                createBlock(draggedType, zone);
                draggedType = null;
            } else if (draggedBlock) {
                // Reordering logic
                // Check if we are trying to drop a block inside itself (infinite loop prevention)
                if (draggedBlock.contains(zone)) return;

                const afterElement = getDragAfterElement(zone, e.clientY);
                if (afterElement == null) {
                    zone.appendChild(draggedBlock);
                } else {
                    zone.insertBefore(draggedBlock, afterElement);
                }
            }
        });
    }

    // Helper for sorting
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll(':scope > .canvas-block:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    // --- Block Creation ---
    function createBlock(type, targetContainer) {
        const block = document.createElement('div');
        block.classList.add('canvas-block');
        block.setAttribute('draggable', 'true');
        block.dataset.type = type;

        // Default Content
        let innerHTML = '';
        switch (type) {

            case 'hero':
                innerHTML = `<div style="text-align: center; background-color: #f3f4f6; padding: 0;">
                    <img src="" style="width: 100%; height: auto; display: block;" alt="Hero">
                    <div style="padding: 30px 20px;">
                        <h1 style="margin: 0 0 15px 0; color: #1f2937; font-size: 28px;">Big Announcement</h1>
                        <p style="margin: 0 0 20px 0; color: #4b5563; font-size: 16px;">Introduce your main topic here with a bang.</p>
                        <a href="#" style="display: inline-block; padding: 12px 30px; background-color: #6366f1; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Learn More</a>
                    </div>
                </div>`;
                break;
            case 'columns':
                // Columns are now containers!
                innerHTML = `<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
                    <tr>
                        <td width="48%" valign="top" class="inner-drop-zone" style="padding: 10px; border: 2px dashed #e5e7eb; vertical-align: top; background: #fafafa;">
                            <div style="color: #ccc; text-align: center; padding: 10px; font-size: 12px;"></div>
                        </td>
                        <td width="4%">&nbsp;</td>
                        <td width="48%" valign="top" class="inner-drop-zone" style="padding: 10px; border: 2px dashed #e5e7eb; vertical-align: top; background: #fafafa;">
                            <div style="color: #ccc; text-align: center; padding: 10px; font-size: 12px;"></div>
                        </td>
                    </tr>
                </table>`;
                break;
            case 'html':
                innerHTML = `<div style="padding: 20px; background: #f8fafc; border: 1px dashed #cbd5e1; font-family: monospace; color: #64748b; text-align: center;">
                    &lt;!-- Custom HTML Block --&gt;<br>
                    Click to edit HTML content
                </div>`;
                block.dataset.htmlContent = "<div>Custom HTML Content</div>";
                break;
            case 'text':
                innerHTML = `<div style="padding: 20px; color: #333; line-height: 1.6;">
                    <h2 style="margin-top: 0; font-size: 24px;">Heading</h2>
                    <p style="margin-bottom: 0;">This is a text block. Click to edit.</p>
                </div>`;
                break;
            case 'image':
                innerHTML = `<div style="padding: 0;">
                    <img src="" style="width: 50%; height: auto; display: block;text-align: center; margin: 0 auto;" alt="Image">
                </div>`;
                break;
            case 'button':
                innerHTML = `<div style="padding: 20px; text-align: center;">
                    <a href="#" style="display: inline-block; padding: 12px 24px; background-color: #6366f1; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Click Me</a>
                </div>`;
                break;
            case 'divider':
                innerHTML = `<div style="padding: 20px;">
                    <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 0;">
                </div>`;
                break;
            case 'spacer':
                innerHTML = `<div style="height: 30px;"></div>`;
                break;
            case 'social':
                innerHTML = `<div style="padding: 20px; text-align: center;">
                    <a href="#" style="display: inline-block; margin: 0 5px; color: #333; text-decoration: none;">Facebook</a>
                    <a href="#" style="display: inline-block; margin: 0 5px; color: #333; text-decoration: none;">Twitter</a>
                    <a href="#" style="display: inline-block; margin: 0 5px; color: #333; text-decoration: none;">Instagram</a>
                </div>`;
                  break;
         case 'image-text':
                 innerHTML = `
    <table width="100%" border="0" cellspacing="0" cellpadding="0"
           style="color:#000000;">
        <tr>
            <td width="150" valign="top" style="padding: 10px;">
                <img src=""
                     width="150"
                     style="display: block; border-radius: 6px;"
                     alt="Image">
            </td>

            <td valign="top" style="padding: 10px; color:#333;"> 
                <h2 style="margin: 0 0 10px 0; font-size: 20px; color:#333;">
                    Heading
                </h2>
                <p style="margin: 0; line-height: 1.6; color:#333;">
                    This is image + text content.
                </p>
            </td>
        </tr>
    </table>`; 
    break;
    case 'text-image':
    innerHTML = `
    <table width="100%" border="0" cellspacing="0" cellpadding="0"
           style="color:#000000;">
        <tr>
            <!-- TEXT LEFT -->
            <td valign="top" style="padding: 10px; color:#333;"> 
                <h2 style="margin: 0 0 10px 0; font-size: 20px; color:#333;">
                    Heading
                </h2>
                <p style="margin: 0; line-height: 1.6; color:#333;">
                    This is text + image content.
                </p>
            </td>

            <!-- IMAGE RIGHT -->
            <td width="150" valign="top" style="padding: 10px;">
                <img src=""
                     width="150"
                     style="display: block; border-radius: 6px;"
                     alt="Image">
            </td>
        </tr>
    </table>`;
    break;
    case 'columns-3':
    innerHTML = `
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
        <tr>
            <td width="32%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background: #fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>

            <td width="2%">&nbsp;</td>

            <td width="32%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background: #fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>

            <td width="2%">&nbsp;</td>

            <td width="32%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background: #fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>
        </tr>
    </table>`;
    break;
    case 'columns-4':
    innerHTML = `
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
        <tr>
            <td width="23%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background:#fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>

            <td width="2%">&nbsp;</td>

            <td width="23%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background:#fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>

            <td width="2%">&nbsp;</td>

            <td width="23%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background:#fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>

            <td width="2%">&nbsp;</td>

            <td width="23%" valign="top" class="inner-drop-zone"
                style="padding: 10px; border: 2px dashed #e5e7eb; background:#fafafa;">
                <div style="color:#ccc; text-align:center; font-size:12px;">
                    
                </div>
            </td>
        </tr>
    </table>`;
    break;

        }

        block.innerHTML = innerHTML;
        targetContainer.appendChild(block);

        // If this block has inner drop zones (like columns), initialize them
        const innerZones = block.querySelectorAll('.inner-drop-zone');
        innerZones.forEach(zone => initDropZone(zone));

        // Event Listeners for the Block
        block.addEventListener('click', (e) => {
            e.stopPropagation();
            selectBlock(block);
        });

        block.addEventListener('dragstart', (e) => {
            e.stopPropagation(); // Important!
            draggedBlock = block;
            block.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        block.addEventListener('dragend', (e) => {
            e.stopPropagation();
            block.classList.remove('dragging');
            draggedBlock = null;
        });

        // Auto-select new block
        selectBlock(block);
    }

    // --- Block Selection & Editing ---
    function selectBlock(block) {
        if (selectedBlock) selectedBlock.classList.remove('selected');
        selectedBlock = block;
        block.classList.add('selected');

        // Switch to Settings Tab
        document.querySelector('[data-tab="settings"]').click();

        // Show Block Settings
        globalSettings.style.display = 'none';
        blockSettings.style.display = 'block';

        // Generate Controls
        generateControls(block);

        // Populate Border Settings Panel
        populateBorderSettings(block);
    }

    function populateBorderSettings(block) {


        const wrapper = block.firstElementChild;
        if (!wrapper) return;


        // Try to get border values from data attributes first (saved state)
        let enabled = block.dataset.borderEnabled === 'true';
        let color = block.dataset.borderColor || '#000000';
        let color2 = block.dataset.borderColor || '#000000';
        let thickness = block.dataset.borderThickness || '1';
        let style = block.dataset.borderStyle || 'solid';


        // If no data attributes, try to extract from inline styles
        const inline = wrapper.style.border;
        if (inline && inline !== 'none') {
            const parts = inline.split(' ');
            if (parts.length >= 3) {
                thickness = parseInt(parts[0]) || 1;
                style = parts[1] || 'solid';

                if (parts[2].startsWith('rgb(')) {
                    // Reconstruct RGB color string from potentially split parts
                    let rgbColorParts = [];
                    for (let i = 2; i < parts.length; i++) {
                        rgbColorParts.push(parts[i]);
                        if (parts[i].endsWith(')')) {
                            break; // Found the end of the RGB color
                        }
                    }
                    color = rgbColorParts.join(' '); // Join with space as values might be "rgb(167," "57," "57)"
                } else {
                    color = parts[2] || '#000000';
                }
                enabled = true;
            }
        }
        // Update UI controls
        const borderToggle = document.getElementById('borderToggle');
        const borderColor = document.getElementById('borderColor');
        const borderHex = document.getElementById('borderHex');
        const borderThickness = document.getElementById('borderThickness');
        const borderStyle = document.getElementById('borderStyle');
        const themedBorder = document.getElementById('themedBorder');
        const borderType = document.getElementById('borderType');
        const simpleBorderControls = document.getElementById('simpleBorderControls');
        const themedBorderControls = document.getElementById('themedBorderControls');


        if (borderToggle) borderToggle.checked = enabled;
        if (borderColor) borderColor.value = color2;
        if (borderHex) borderHex.value = color;
        if (borderThickness) borderThickness.value = thickness;
        if (borderStyle) borderStyle.value = style;

        if (themedBorder) {
            themedBorder.value = block.dataset.borderTheme || '';
        }
        if (borderType) {
            if (block.dataset.borderTheme) {
                borderType.value = 'themed';
                if (simpleBorderControls) simpleBorderControls.style.display = 'none';
                if (themedBorderControls) themedBorderControls.style.display = 'block';
            } else {
                borderType.value = 'simple';
                if (simpleBorderControls) simpleBorderControls.style.display = 'block';
                if (themedBorderControls) themedBorderControls.style.display = 'none';
            }
        }
    }

    function generateControls(block) {
        
        dynamicControls.innerHTML = '';
        const type = block.dataset.type;

        // Common Styles (Padding)
        const contentDiv = block.querySelector('div') || block.querySelector('table');
        if (contentDiv && type !== 'columns') { // Don't add simple padding to columns table
            let currentPadding = contentDiv.style.padding || '0px';
            addInput('Padding', 'text', currentPadding, (val) => {
                contentDiv.style.padding = val;
            });
        }

        if (type === 'text') {
            addInput('Heading', 'text', block.querySelector('h2').innerText, (val) => {
                block.querySelector('h2').innerText = val;
            });
            addTextarea('Content', block.querySelector('p').innerText, (val) => {
                block.querySelector('p').innerText = val;
            });
            addColorInput('Text Color', rgbToHex(block.querySelector('div').style.color || 'rgb(51, 51, 51)'), (val) => {
                block.querySelector('div').style.color = val;
            });
            addSelect('Align', ['left', 'center', 'right'], block.querySelector('div').style.textAlign || 'left', (val) => {
                block.querySelector('div').style.textAlign = val;
            });
        } else if (type === 'hero') {
            const img = block.querySelector('img');
            const h1 = block.querySelector('h1');
            const p = block.querySelector('p');
            const btn = block.querySelector('a');

            addImageUploadControl(img);
            addInput('Heading', 'text', h1.innerText, (val) => h1.innerText = val);
            addTextarea('Description', p.innerText, (val) => p.innerText = val);
            addInput('Button Text', 'text', btn.innerText, (val) => btn.innerText = val);
            addInput('Button Link', 'text', btn.getAttribute('href'), (val) => btn.setAttribute('href', val));
            addColorInput('Button Color', rgbToHex(btn.style.backgroundColor), (val) => btn.style.backgroundColor = val);

        } else if (type === 'columns') {
            const tds = block.querySelectorAll('td.inner-drop-zone');
            addInput('Column 1 Bg Color', 'color', rgbToHex(tds[0].style.backgroundColor), (val) => tds[0].style.backgroundColor = val);
            addInput('Column 2 Bg Color', 'color', rgbToHex(tds[1].style.backgroundColor), (val) => tds[1].style.backgroundColor = val);

        } else if (type === 'html') {
            addTextarea('Raw HTML', block.dataset.htmlContent || '', (val) => {
                block.dataset.htmlContent = val;
            });
        } else if (type === 'button') {
            const btn = block.querySelector('a');
            addInput('Button Text', 'text', btn.innerText, (val) => btn.innerText = val);
            addInput('Link URL', 'text', btn.getAttribute('href'), (val) => btn.setAttribute('href', val));
            addColorInput('Background Color', rgbToHex(btn.style.backgroundColor), (val) => btn.style.backgroundColor = val);
            addColorInput('Text Color', rgbToHex(btn.style.color), (val) => btn.style.color = val);
            addInput('Border Radius', 'text', btn.style.borderRadius || '6px', (val) => btn.style.borderRadius = val);
            addSelect('Align', ['left', 'center', 'right'], block.querySelector('div').style.textAlign || 'center', (val) => {
                block.querySelector('div').style.textAlign = val;
            });
        } else if (type === 'image') {
            const img = block.querySelector('img');
            addImageUploadControl(img);
            addInput('Image URL', 'text', img.src, (val) => img.src = val);
            addInput('Alt Text', 'text', img.alt, (val) => img.alt = val);
            addInput('Width', 'text', img.style.width || '100%', (val) => img.style.width = val);
            addInput('Border Radius', 'text', img.style.borderRadius || '0px', (val) => img.style.borderRadius = val);
        } else if (type === 'spacer') {
            addInput('Height (px)', 'number', parseInt(block.querySelector('div').style.height), (val) => {
                block.querySelector('div').style.height = val + 'px';
            });
        } else if (type === 'image-text') {
            const table = block.querySelector('table');
            const img = block.querySelector('img');
            const h2 = block.querySelector('h2');
            const p = block.querySelector('p');

            if (!table || !img || !h2 || !p) return;

            block.style.color = block.style.color || '#000000';

            addImageUploadControl(img);

            addInput('Heading', 'text', h2.innerText, val => h2.innerText = val);
            addTextarea('Text', p.innerText, val => p.innerText = val);

            addColorInput(
                'Text Color',
                rgbToHex(block.style.color),
                val => {
                    block.style.color = val;
                    h2.style.color = val;
                    p.style.color = val;
                }
            );

            addColorInput(
                'Background Color',
                rgbToHex(table.style.backgroundColor || '#ffffff'),
                val => table.style.backgroundColor = val
            );
        }
            else if (type === 'image-text' || type === 'text-image') {
            const table = block.querySelector('table');
            const img = block.querySelector('img');
            const h2 = block.querySelector('h2');
            const p = block.querySelector('p');

            if (!table || !img || !h2 || !p) return;

            const currentColor = h2.style.color || '#333333';
            block.style.color = currentColor;

            addImageUploadControl(img);

            addInput('Heading', 'text', h2.innerText, val => h2.innerText = val);
            addTextarea('Text', p.innerText, val => p.innerText = val);

            addColorInput(
                'Text Color',
                rgbToHex(currentColor),
                val => {
                    block.style.color = val;
                    h2.style.color = val;
                    p.style.color = val;
                }
            );

            addColorInput(
                'Background Color',
                rgbToHex(table.style.backgroundColor || '#ffffff'),
                val => table.style.backgroundColor = val
            );
        }else if (type === 'columns-3') {
    const tds = block.querySelectorAll('td.inner-drop-zone');

    addInput(
        'Column 1 Bg Color',
        'color',
        rgbToHex(tds[0].style.backgroundColor),
        val => tds[0].style.backgroundColor = val
    );

    addInput(
        'Column 2 Bg Color',
        'color',
        rgbToHex(tds[1].style.backgroundColor),
        val => tds[1].style.backgroundColor = val
    );

    addInput(
        'Column 3 Bg Color',
        'color',
        rgbToHex(tds[2].style.backgroundColor),
        val => tds[2].style.backgroundColor = val
    );
}else if (type === 'columns-4') {
    const tds = block.querySelectorAll('td.inner-drop-zone');

    addInput('Column 1 Bg Color', 'color', rgbToHex(tds[0].style.backgroundColor), val => tds[0].style.backgroundColor = val);
    addInput('Column 2 Bg Color', 'color', rgbToHex(tds[1].style.backgroundColor), val => tds[1].style.backgroundColor = val);
    addInput('Column 3 Bg Color', 'color', rgbToHex(tds[2].style.backgroundColor), val => tds[2].style.backgroundColor = val);
    addInput('Column 4 Bg Color', 'color', rgbToHex(tds[3].style.backgroundColor), val => tds[3].style.backgroundColor = val);
}


/* 🔥 THIS BRACE WAS MISSING */
}  // <-- CLOSE generateControls(block)



    // --- Helper Functions for Controls ---
    function addInput(label, type, value, onChange) {
        const group = document.createElement('div');
        group.className = 'input-group';
        group.innerHTML = `<label>${label}</label><input type="${type}" value="${value}">`;
        const input = group.querySelector('input');
        input.addEventListener('input', (e) => onChange(e.target.value));
        dynamicControls.appendChild(group);
    }

    function addTextarea(label, value, onChange) {
        const group = document.createElement('div');
        group.className = 'input-group';
        group.innerHTML = `<label>${label}</label><textarea rows="4">${value}</textarea>`;
        const input = group.querySelector('textarea');
        input.addEventListener('input', (e) => onChange(e.target.value));
        dynamicControls.appendChild(group);
    }

    function addColorInput(label, value, onChange) {
        const group = document.createElement('div');
        group.className = 'input-group';
        group.innerHTML = `<label>${label}</label><input type="color" value="${value}">`;
        const input = group.querySelector('input');
        input.addEventListener('input', (e) => onChange(e.target.value));
        dynamicControls.appendChild(group);
    }

    function addSelect(label, options, value, onChange) {
        const group = document.createElement('div');
        group.className = 'input-group';
        let opts = options.map(o => `<option value="${o}" ${o === value ? 'selected' : ''}>${o.charAt(0).toUpperCase() + o.slice(1)}</option>`).join('');
        group.innerHTML = `<label>${label}</label><select>${opts}</select>`;
        const select = group.querySelector('select');
        select.addEventListener('change', (e) => onChange(e.target.value));
        dynamicControls.appendChild(group);
    }

    function addImageUploadControl(imgElement) {
        const uploadBtn = document.createElement('div');
        uploadBtn.className = 'image-upload-zone';
        uploadBtn.innerHTML = '<i class="fa-solid fa-cloud-arrow-up"></i><p>Upload Image</p>';
        uploadBtn.style.padding = "10px";
        uploadBtn.style.marginBottom = "10px";

        uploadBtn.onclick = () => {
            imageUploadInput.click();
            imageUploadInput.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    uploadImage(file, (url) => {
                        imgElement.src = url;
                    });
                }
            };
        };
        dynamicControls.appendChild(uploadBtn);
    }

    function rgbToHex(rgb) {
        // If undefined, null, or empty â†’ fallback
        if (!rgb || typeof rgb !== "string") {
            return "#000000";
        }

        // Already valid hex
        if (rgb.startsWith("#") && /^#([0-9A-F]{3}){1,2}$/i.test(rgb)) {
            return rgb;
        }

        // Extract numbers
        const rgbValues = rgb.match(/\d+/g);

        // If not exactly 3 values â†’ invalid rgb() â†’ fallback
        if (!rgbValues || rgbValues.length !== 3) {
            console.warn("Invalid RGB detected:", rgb);
            return "#000000";
        }

        const [r, g, b] = rgbValues.map(v => Math.min(255, Math.max(0, parseInt(v))));

        return (
            "#" +
            ((1 << 24) + (r << 16) + (g << 8) + b)
                .toString(16)
                .slice(1)
        );
    }

function uploadImage(file, callback) {
    const loader = document.getElementById('loader');
    if (loader) loader.classList.add('active');

    const formData = new FormData();
    formData.append('file', file);

    fetch('/admin/newsbuilderv1/imageupload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === true) {
            callback(data.url);
        } else {
            alert('Upload failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Upload failed');
    })
    .finally(() => {
        if (loader) loader.classList.remove('active');
    });
}


    // --- Global Settings Events ---
    globalInputs.bgColor.addEventListener('input', (e) => {
        document.getElementById('emailBody').style.backgroundColor = e.target.value;
    });
    globalInputs.width.addEventListener('input', (e) => {
        document.getElementById('emailContainer').setAttribute('width', e.target.value);
    });
    globalInputs.font.addEventListener('change', (e) => {
        document.getElementById('emailBody').style.fontFamily = e.target.value;
    });

    // --- Delete Block ---
    document.getElementById('deleteBlockBtn').addEventListener('click', () => {
        if (selectedBlock) {
            selectedBlock.remove();
            selectedBlock = null;
            blockSettings.style.display = 'none';
            globalSettings.style.display = 'block';
            if (mainDropZone.querySelectorAll('.canvas-block').length === 0) {
                if (emptyMsg) emptyMsg.style.display = 'block';
            }
        }
    });

    // --- Clear Canvas ---
    document.getElementById('clearCanvasBtn').addEventListener('click', () => {
        if (confirm('Are you sure you want to clear everything?')) {
            mainDropZone.innerHTML = '';
            if (emptyMsg) {
                mainDropZone.appendChild(emptyMsg);
                emptyMsg.style.display = 'block';
            }
            selectedBlock = null;
            blockSettings.style.display = 'none';
            globalSettings.style.display = 'block';
        }
    });

    // --- Deselect on Background Click ---
    document.querySelector('.preview-area').addEventListener('click', (e) => {
        if (e.target === document.querySelector('.preview-area') || e.target.classList.contains('preview-canvas-wrapper')) {
            if (selectedBlock) {
                selectedBlock.classList.remove('selected');
                selectedBlock = null;
                blockSettings.style.display = 'none';
                globalSettings.style.display = 'block';
                document.querySelector('[data-tab="settings"]').click();
            }
        }
    });


    // --- Load Template Action ---
    if (typeof savedContent !== 'undefined' && savedContent) {
        console.log('Loading JSON content');
        mainDropZone.innerHTML = savedContent;

        // Re-attach listeners to all canvas-block elements
        const blocks = mainDropZone.querySelectorAll('.canvas-block');
        blocks.forEach(block => {
            block.addEventListener('click', (e) => {
                e.stopPropagation();
                selectBlock(block);
            });
            block.addEventListener('dragstart', (e) => {
                e.stopPropagation();
                draggedBlock = block;
                block.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
            });
            block.addEventListener('dragend', (e) => {
                e.stopPropagation();
                block.classList.remove('dragging');
                draggedBlock = null;
            });

            // Re-initialize inner drop zones for columns
            const innerZones = block.querySelectorAll('.inner-drop-zone');
            innerZones.forEach(zone => initDropZone(zone));
        });
    }

    // --- Save Template ---
    document.getElementById('saveBtn').addEventListener('click', () => {

        // Capture Editor State (ONLY the dropZone content, not the wrapper tables)
        const editorContent = mainDropZone.innerHTML;

        // Clone and Clean
        const clone = document.getElementById('emailBody').cloneNode(true);

        const msg = clone.querySelector('.empty-canvas-msg');
        if (msg) msg.remove();

        const fullHtml = `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>${templateName}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        body { margin: 0; padding: 0; min-width: 100%; }
        table { border-collapse: collapse; border-spacing: 0; }
        td { padding: 0; vertical-align: top; }
        .spacer, .border { font-size: 1px; line-height: 1px; }
        .spacer { width: 100%; }
        img { border: 0; -ms-interpolation-mode: bicubic; }
        .image { display: block; margin: 0; }
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
                repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 215, 0, 0.1) 10px,
                    rgba(255, 215, 0, 0.1) 20px);
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

            0%,
            100% {
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

        @media only screen and (max-width: 600px) {
            table[class="container"] {
                width: 100% !important;
            }

            td[class="mobile-block"] {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box;
            }

            img[class="mobile-img"] {
                width: 100% !important;
                height: auto !important;
            }

            td[class="mobile-pad"] {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: ${globalInputs.bgColor.value};">
    ${clone.outerHTML}
</body>
</html>`;

const BCPATH = '/admin';
    // Send to PHP
 
fetch(`${BCPATH}/newsbuilderv1/savecontent`, {
            method: 'POST',
             headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
    },
            body: JSON.stringify({
                template_name: templateName,
                html_content: fullHtml,
                editor_content: editorContent,
         
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); 
                    window.location.href = `${BCPATH}/newslettertemplate`;
                } else {
                    alert(data.message || 'Save failed');
                }
            })
                .catch(error => {
                console.error('Error:', error);
       
            });
    });


    // Device Toggles
    const deviceBtns = document.querySelectorAll('.device-toggles button');
    const previewCanvas = document.getElementById('previewCanvas');

    deviceBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            deviceBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const view = btn.dataset.view;
            if (view === 'mobile') {
                previewCanvas.style.width = '375px';
            } else {
                previewCanvas.style.width = '100%';
            }
        });
    });
    // --- Theme Border Handler ---
    const themeClasses = [
        'gold-elegant', 'gold-royal', 'gold-luxury', 'gold-gradient', 'gold-vintage',
        'beveled-gold', 'gold-ornate', 'embossed', 'neon-glow', 'diamond-pattern',
        'corner-art', 'art-deco', 'celtic-knot', 'moroccan', 'ribbon-border'
    ];

    window.selectBorderFromDropdown = function (theme) {
        if (!selectedBlock) {
            alert('Please select a block first.');
            return;
        }

        const wrapper = selectedBlock.firstElementChild;
        if (!wrapper) return;

        // Clean previous themes
        themeClasses.forEach(cls => wrapper.classList.remove(cls));

        // Clean inline border styles to allow class styles to take effect
        if (theme) {
            wrapper.style.removeProperty('border');
            wrapper.style.removeProperty('border-color');
            wrapper.style.removeProperty('border-width');
            wrapper.style.removeProperty('border-style');
            wrapper.style.removeProperty('box-shadow');
            wrapper.style.removeProperty('border-image');

            wrapper.classList.add(theme);

            // Update Preview
            const preview = document.getElementById('selectedPreview');
            if (preview) {
                preview.className = 'selected-preview ' + theme;
                preview.textContent = 'Preview: ' + theme.replace(/-/g, ' ').toUpperCase();
            }

            // Ensure Simple Border Mode is off visually if we are in themed mode
            // But actually, we might want to let the dropdown stick.
        } else {
            const preview = document.getElementById('selectedPreview');
            if (preview) {
                preview.className = 'selected-preview';
                preview.textContent = 'Select a theme to preview';
            }
        }

        // Save state
        selectedBlock.dataset.borderTheme = theme;
        selectedBlock.dataset.borderEnabled = 'true';
    };

    // --- Simple Border Logic ---
    function applySimpleBorder() {
        if (!selectedBlock) return;
        const wrapper = selectedBlock.firstElementChild;
        if (!wrapper) return;

        const enabled = document.getElementById('borderToggle').checked;
        const color = document.getElementById('borderColor').value;
        const thickness = document.getElementById('borderThickness').value;
        const style = document.getElementById('borderStyle').value;

        // If enabled, apply inline styles (clearing any themes first)
        if (enabled) {
            // Remove themes
            themeClasses.forEach(cls => wrapper.classList.remove(cls));

            wrapper.style.border = `${thickness}px ${style} ${color}`;
            wrapper.style.boxSizing = 'border-box';

            // Save state
            selectedBlock.dataset.borderEnabled = 'true';
            selectedBlock.dataset.borderColor = color;
            selectedBlock.dataset.borderThickness = thickness;
            selectedBlock.dataset.borderStyle = style;
            selectedBlock.dataset.borderTheme = ''; // Clear theme
        } else {
            wrapper.style.border = 'none';
            selectedBlock.dataset.borderEnabled = 'false';
        }
    }

    // Bind Simple Border Events
    const simpleInputs = ['borderToggle', 'borderColor', 'borderThickness', 'borderStyle'];
    simpleInputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', applySimpleBorder);
            el.addEventListener('change', applySimpleBorder);
        }
    });

    // Hex Sync
    const borderHex = document.getElementById('borderHex');
    const borderColor = document.getElementById('borderColor');
    if (borderHex && borderColor) {
        borderHex.addEventListener('input', (e) => {
            const val = e.target.value;
            if (/^#[0-9A-F]{6}$/i.test(val)) {
                borderColor.value = val;
                applySimpleBorder();
            }
        });
        borderColor.addEventListener('input', (e) => {
            borderHex.value = e.target.value;
        });
    }

    // Toggle Function for HTML onchange attribute (wrapper)
    window.toggleBorderControls = function () {
        applySimpleBorder();
    };

}); //last