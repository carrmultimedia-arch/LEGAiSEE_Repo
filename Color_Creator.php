<?php
/**
 * Color Scheme Designer Tool
 * Interactive design tool for creating and exporting custom color schemes.
 */
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Scheme Designer</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-body: #0d0d0d;
            --bg-card: #1a1a1a;
            --bg-card-hover: #252525;
            --border-color: #333333;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --text-muted: #666666;
            --accent-blue: #3b82f6;
            --accent-blue-hover: #2563eb;
            --input-bg: #2a2a2a;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 20px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header,
        .main-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 24px;
            margin-bottom: 20px;
        }

        .header-left {
            flex: 1;
        }

        .header-left input {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 15px;
            font-weight: 500;
            outline: none;
        }

        .header-actions,
        .card-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn,
        .toggle-btn,
        .prompt-btn,
        .preset-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-primary);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover,
        .toggle-btn:hover,
        .prompt-btn:hover,
        .preset-btn:hover {
            background: var(--bg-card-hover);
            border-color: #555;
        }

        .btn-primary {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--accent-blue-hover);
            border-color: var(--accent-blue-hover);
        }

        .prompt-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .prompt-btn {
            border-radius: var(--radius-xl);
            padding: 10px 20px;
        }

        .main-card {
            padding: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            outline: none;
        }

        .section-title {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin: 24px 0 12px;
            text-transform: uppercase;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .color-grid,
        .scale-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .color-swatch,
        .gradient-swatch,
        .scale-swatch {
            border-radius: var(--radius-md);
            cursor: pointer;
            overflow: hidden;
            position: relative;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .color-swatch,
        .gradient-swatch {
            flex: 1;
            min-width: 120px;
        }

        .scale-swatch {
            flex: 1;
            min-width: 72px;
        }

        .color-swatch:hover,
        .gradient-swatch:hover,
        .scale-swatch:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
            z-index: 2;
        }

        .color-swatch-inner,
        .gradient-swatch-inner {
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 92px;
            padding: 20px 12px;
            position: relative;
        }

        .scale-swatch-inner {
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 72px;
            padding: 14px 8px;
        }

        .color-name,
        .scale-number {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .color-hex,
        .scale-hex {
            font-family: "SF Mono", Monaco, Consolas, monospace;
            font-size: 10px;
            opacity: 0.82;
        }

        .color-actions {
            display: flex;
            gap: 4px;
            opacity: 0;
            position: absolute;
            right: 6px;
            top: 6px;
            transition: opacity 0.15s;
        }

        .color-swatch:hover .color-actions {
            opacity: 1;
        }

        .color-action-btn {
            align-items: center;
            background: rgba(0, 0, 0, 0.45);
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            display: flex;
            font-size: 11px;
            height: 24px;
            justify-content: center;
            width: 24px;
        }

        .color-action-btn:hover {
            background: rgba(0, 0, 0, 0.75);
        }

        .two-col {
            display: grid;
            gap: 20px;
            grid-template-columns: 1fr 1fr;
        }

        .hidden-section {
            display: none;
        }

        .hidden-section.visible {
            display: block;
        }

        .toggle-btn {
            display: block;
            margin: 24px auto 0;
        }

        /* Relationships */
        .relationship-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        }

        .relationship-card {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .relationship-preview,
        .palette-row {
            display: flex;
            min-height: 54px;
        }

        .relationship-preview span,
        .palette-row span {
            cursor: pointer;
            flex: 1;
            min-width: 0;
            transition: transform 0.15s;
        }

        .relationship-preview span:hover,
        .palette-row span:hover {
            transform: scaleY(1.12);
        }

        .relationship-meta {
            padding: 10px;
        }

        .relationship-name {
            font-size: 12px;
            font-weight: 700;
        }

        .relationship-detail {
            color: var(--text-secondary);
            font-size: 11px;
            margin-top: 3px;
        }

        .palette-layout {
            display: grid;
            gap: 16px;
            grid-template-columns: 1fr 1fr;
        }

        .palette-panel {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .palette-label {
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 700;
            padding: 10px 12px;
            text-transform: uppercase;
        }

        /* Modal */
        .modal-overlay {
            align-items: center;
            background: rgba(0, 0, 0, 0.72);
            bottom: 0;
            display: flex;
            justify-content: center;
            left: 0;
            opacity: 0;
            position: fixed;
            right: 0;
            top: 0;
            transition: all 0.2s;
            visibility: hidden;
            z-index: 1000;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-height: 92vh;
            max-width: 590px;
            overflow-y: auto;
            padding: 24px;
            transform: translateY(20px);
            transition: transform 0.2s;
            width: 92%;
        }

        .modal-overlay.active .modal {
            transform: translateY(0);
        }

        .modal-header,
        .export-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .modal-title,
        .export-title {
            font-size: 16px;
            font-weight: 600;
        }

        .modal-close,
        .export-close {
            align-items: center;
            background: var(--input-bg);
            border: none;
            border-radius: 50%;
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            font-size: 20px;
            height: 32px;
            justify-content: center;
            width: 32px;
        }

        .modal-close:hover,
        .export-close:hover {
            background: #444;
        }

        .color-preview-large {
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            height: 100px;
            margin-bottom: 16px;
            transition: background 0.1s;
            width: 100%;
        }

        .picker-row {
            align-items: center;
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
        }

        .picker-row label {
            color: var(--text-secondary);
            font-size: 13px;
            min-width: 70px;
        }

        .picker-row input[type="color"] {
            background: none;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-sm);
            cursor: pointer;
            height: 40px;
            width: 50px;
        }

        .picker-row input[type="text"],
        .picker-row select {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            flex: 1;
            font-size: 13px;
            padding: 10px 14px;
        }

        .picker-row input[type="text"] {
            font-family: "SF Mono", Monaco, Consolas, monospace;
            font-size: 14px;
        }

        .picker-row input[type="text"]:focus,
        .picker-row select:focus {
            border-color: var(--accent-blue);
            outline: none;
        }

        .picker-row input[type="range"] {
            flex: 1;
        }

        .angle-value {
            color: var(--text-secondary);
            font-family: monospace;
            font-size: 12px;
            min-width: 40px;
        }

        .eyedropper-btn {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            cursor: pointer;
            font-size: 13px;
            padding: 10px 16px;
        }

        .eyedropper-btn:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .gradient-editor {
            border-top: 1px solid var(--border-color);
            margin-top: 16px;
            padding-top: 16px;
        }

        .gradient-editor-title {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .gradient-preview {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            height: 64px;
            margin-bottom: 12px;
            width: 100%;
        }

        .gradient-stops {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .gradient-stop {
            align-items: center;
            display: flex;
            gap: 8px;
        }

        .gradient-stop input[type="color"] {
            background: none;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-sm);
            cursor: pointer;
            height: 36px;
            width: 36px;
        }

        .gradient-stop input[type="range"] {
            flex: 1;
        }

        .stop-value {
            color: var(--text-secondary);
            font-family: monospace;
            font-size: 11px;
            min-width: 38px;
            text-align: right;
        }

        .remove-stop {
            align-items: center;
            background: #dc2626;
            border: none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            display: flex;
            font-size: 15px;
            height: 24px;
            justify-content: center;
            width: 24px;
        }

        .gradient-presets {
            display: grid;
            gap: 8px;
            grid-template-columns: repeat(2, 1fr);
            margin: 12px 0;
        }

        .preset-btn {
            background: var(--input-bg);
            font-size: 12px;
            padding: 9px;
            text-align: center;
        }

        .add-stop-btn {
            background: transparent;
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 12px;
            margin-top: 10px;
            padding: 9px;
            width: 100%;
        }

        .add-stop-btn:hover {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        /* Export panel */
        .export-panel {
            background: var(--bg-card);
            border-left: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            height: 100vh;
            max-width: 100%;
            position: fixed;
            right: -500px;
            top: 0;
            transition: right 0.3s;
            width: 460px;
            z-index: 1001;
        }

        .export-panel.active {
            right: 0;
        }

        .export-header {
            border-bottom: 1px solid var(--border-color);
            margin: 0;
            padding: 20px 24px;
        }

        .export-body {
            flex: 1;
            overflow: auto;
            padding: 20px 24px;
        }

        .export-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-bottom: 16px;
        }

        .export-tab {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 13px;
            padding: 8px 14px;
        }

        .export-tab.active {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            color: #fff;
        }

        .export-content {
            display: none;
        }

        .export-content.active {
            display: block;
        }

        .code-block {
            background: #0d0d0d;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: #e0e0e0;
            font-family: "SF Mono", Monaco, Consolas, monospace;
            font-size: 12px;
            line-height: 1.6;
            max-height: 420px;
            overflow: auto;
            padding: 16px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .copy-btn {
            margin-top: 12px;
            width: 100%;
        }

        .toast {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            bottom: 24px;
            box-shadow: var(--shadow);
            font-size: 14px;
            left: 50%;
            padding: 12px 24px;
            position: fixed;
            transform: translateX(-50%) translateY(100px);
            transition: transform 0.3s;
            z-index: 2000;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
        }

        @media (max-width: 900px) {
            .two-col,
            .palette-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            body {
                padding: 12px;
            }

            .header,
            .card-header {
                align-items: stretch;
                flex-direction: column;
            }

            .header-actions,
            .card-actions {
                width: 100%;
            }

            .header-actions .btn,
            .card-actions .btn {
                flex: 1;
            }

            .color-swatch,
            .gradient-swatch {
                min-width: calc(50% - 5px);
            }

            .scale-swatch {
                min-width: calc(25% - 5px);
            }

            .gradient-presets {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <input
                    type="text"
                    id="siteName"
                    value="A professional free AI tool website"
                    placeholder="Enter site name..."
                >
            </div>

            <div class="header-actions">
                <button class="btn" onclick="randomizeColors()">Regenerate</button>
                <button class="btn" onclick="toggleTheme()">Dark</button>
            </div>
        </div>

        <div class="prompt-bar">
            <button class="prompt-btn" onclick="showPromptModal()">
                See Prompt Examples
            </button>
        </div>

        <div class="main-card">
            <div class="card-header">
                <div class="card-title" id="cardTitle" contenteditable="true">
                    Pro-Intelligence Dark Mode
                </div>

                <div class="card-actions">
                    <button class="btn btn-primary" onclick="saveScheme()">Save</button>
                    <button class="btn" onclick="openExportPanel()">Export CSS</button>
                    <button class="btn" onclick="loadScheme()">Load</button>
                    <input
                        type="file"
                        id="loadInput"
                        accept=".json"
                        style="display:none"
                        onchange="handleLoad(event)"
                    >
                </div>
            </div>

            <div class="section-title">Primary</div>
            <div class="color-grid" id="primaryColors"></div>

            <div class="section-title">Primary Scale</div>
            <div class="scale-grid" id="primaryScale"></div>

            <div class="section-title">Color Relationships</div>
            <div class="relationship-grid" id="colorRelationships"></div>

            <div class="section-title">Recommended Palettes</div>
            <div class="palette-layout">
                <div class="palette-panel">
                    <div class="palette-label">Recommended 3-Color Palette</div>
                    <div class="palette-row" id="palette3"></div>
                </div>

                <div class="palette-panel">
                    <div class="palette-label">Recommended 5-Color Palette</div>
                    <div class="palette-row" id="palette5"></div>
                </div>
            </div>

            <div class="two-col">
                <div>
                    <div class="section-title">Grey Scale</div>
                    <div class="scale-grid" id="greyScale"></div>
                </div>

                <div>
                    <div class="section-title">System</div>
                    <div class="color-grid" id="systemColors"></div>
                </div>
            </div>

            <div class="hidden-section" id="additionalSection">
                <div class="section-title">Gradients</div>
                <div class="color-grid" id="gradients"></div>

                <div class="section-title">Semantic</div>
                <div class="color-grid" id="semanticColors"></div>

                <div class="section-title">Extended</div>
                <div class="color-grid" id="extendedColors"></div>
            </div>

            <button class="toggle-btn" id="toggleBtn" onclick="toggleAdditional()">
                Show Additional Colors
            </button>
        </div>
    </div>

    <div class="modal-overlay" id="colorModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Edit Color</div>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>

            <div class="color-preview-large" id="colorPreview"></div>

            <div class="picker-row">
                <label>Color</label>
                <input type="color" id="colorInput" oninput="onColorInput(this.value)">
                <input type="text" id="hexInput" maxlength="7" oninput="onHexInput(this.value)">
            </div>

            <div class="picker-row">
                <label></label>
                <button class="eyedropper-btn" id="eyedropperBtn" onclick="startEyedropper()">
                    Pick from Screen
                </button>
            </div>

            <div class="gradient-editor" id="gradientEditor" style="display:none">
                <div class="gradient-editor-title">Gradient Controls</div>

                <div class="picker-row">
                    <label>Style</label>
                    <select id="gradientType" onchange="updateGradientType(this.value)">
                        <option value="linear">Linear</option>
                        <option value="radial">Radial</option>
                        <option value="conic">Angle / Conic</option>
                        <option value="corners">4 Corner Stops</option>
                    </select>
                </div>

                <div class="picker-row" id="gradientAngleRow">
                    <label>Angle</label>
                    <input
                        type="range"
                        id="gradientAngle"
                        min="0"
                        max="360"
                        value="135"
                        oninput="updateGradientAngle(this.value)"
                    >
                    <span class="angle-value" id="gradientAngleValue">135°</span>
                </div>

                <div class="gradient-preview" id="gradientPreview"></div>

                <div class="gradient-editor-title">Presets</div>
                <div class="gradient-presets">
                    <button class="preset-btn" onclick="applyGradientPreset('linear2')">Linear · 2 Stops</button>
                    <button class="preset-btn" onclick="applyGradientPreset('linear3')">Linear · 3 Stops</button>
                    <button class="preset-btn" onclick="applyGradientPreset('radial2')">Radial · 2 Stops</button>
                    <button class="preset-btn" onclick="applyGradientPreset('conic3')">Angle · 3 Stops</button>
                    <button class="preset-btn" onclick="applyGradientPreset('corners4')">4 Corner Stops</button>
                </div>

                <div class="gradient-editor-title">Gradient Stops</div>
                <div class="gradient-stops" id="gradientStops"></div>
                <button class="add-stop-btn" onclick="addGradientStop()">+ Add Stop</button>
            </div>

            <div class="modal-actions">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn btn-primary" onclick="saveColor()">Apply</button>
            </div>
        </div>
    </div>

    <div class="export-panel" id="exportPanel">
        <div class="export-header">
            <div class="export-title">Export Color Tokens</div>
            <button class="export-close" onclick="closeExportPanel()">&times;</button>
        </div>

        <div class="export-body">
            <div class="export-tabs">
                <button class="export-tab active" data-tab="css" onclick="setExportTab('css', event)">
                    CSS Variables
                </button>
                <button class="export-tab" data-tab="scss" onclick="setExportTab('scss', event)">
                    SCSS
                </button>
                <button class="export-tab" data-tab="json" onclick="setExportTab('json', event)">
                    JSON
                </button>
            </div>

            <div class="export-content active" id="export-css">
                <div class="code-block" id="cssOutput"></div>
                <button class="btn btn-primary copy-btn" onclick="copyExport('cssOutput')">Copy CSS</button>
                <button class="btn copy-btn" onclick="downloadFile('colors.css', getCSSOutput())">Download .css</button>
            </div>

            <div class="export-content" id="export-scss">
                <div class="code-block" id="scssOutput"></div>
                <button class="btn btn-primary copy-btn" onclick="copyExport('scssOutput')">Copy SCSS</button>
                <button class="btn copy-btn" onclick="downloadFile('colors.scss', getSCSSOutput())">Download .scss</button>
            </div>

            <div class="export-content" id="export-json">
                <div class="code-block" id="jsonOutput"></div>
                <button class="btn btn-primary copy-btn" onclick="copyExport('jsonOutput')">Copy JSON</button>
                <button class="btn copy-btn" onclick="downloadFile('colors.json', getJSONOutput())">Download .json</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
        const defaultScheme = {
            name: "Pro-Intelligence Dark Mode",
            siteName: "A professional free AI tool website",

            colors: {
                surface: "#1E1E1E",
                primary: "#237DC7",
                secondary: "#FFD25D",
                background: "#1E1E1E",
                text2: "#6C757D",
                text: "#FFFFFF"
            },

            primaryScale: {},
            greyScale: {},

            system: {
                success: "#4CAF50",
                warning: "#FFC107",
                error: "#D32F2F",
                info: "#2196F3"
            },

            gradients: {},

            semantic: {
                link: "#3B82F6",
                linkHover: "#60A5FA",
                border: "#333333",
                borderHover: "#555555",
                shadow: "#000000",
                overlay: "#000000",
                actionGradient: {
                    type: "linear",
                    angle: 90,
                    stops: [
                        { color: "#237DC7", pos: 0 },
                        { color: "#165780", pos: 100 }
                    ]
                }
            },

            extended: {
                accent1: "#8B5CF6",
                accent2: "#EC4899",
                accent3: "#10B981",
                accent4: "#F59E0B",
                accent5: "#EF4444",
                accent6: "#06B6D4",
                accentGradient: {
                    type: "radial",
                    angle: 0,
                    stops: [
                        { color: "#8B5CF6", pos: 0 },
                        { color: "#EC4899", pos: 100 }
                    ]
                }
            },

            colorRelationships: {}
        };

        let scheme = JSON.parse(JSON.stringify(defaultScheme));
        let editingType = null;
        let editingKey = null;
        let currentGradient = null;

        function init() {
            loadFromStorage();
            normalizeScheme();

            document.getElementById("siteName").value = scheme.siteName || "";
            document.getElementById("cardTitle").textContent = scheme.name || "Untitled Scheme";

            if (!window.EyeDropper) {
                const button = document.getElementById("eyedropperBtn");
                button.disabled = true;
                button.title = "EyeDropper is not supported in this browser. Try Chrome or Edge.";
            }

            renderAll();
            updateExport();
        }

        function normalizeScheme() {
            scheme = {
                ...JSON.parse(JSON.stringify(defaultScheme)),
                ...scheme,
                colors: {
                    ...defaultScheme.colors,
                    ...(scheme.colors || {})
                },
                system: {
                    ...defaultScheme.system,
                    ...(scheme.system || {})
                },
                semantic: {
                    ...defaultScheme.semantic,
                    ...(scheme.semantic || {})
                },
                extended: {
                    ...defaultScheme.extended,
                    ...(scheme.extended || {})
                }
            };

            regeneratePrimaryDerivedTokens(false);
        }

        function regeneratePrimaryDerivedTokens(overwriteGradients = true) {
            const primary = scheme.colors.primary;

            scheme.primaryScale = generatePrimaryScale(primary);
            scheme.greyScale = generateTintedGreyScale(primary);
            scheme.colorRelationships = buildColorRelationships(primary);

            if (overwriteGradients || !scheme.gradients || Object.keys(scheme.gradients).length === 0) {
                scheme.gradients = generatePrimaryGradients(primary);
            }
        }

        function renderAll() {
            renderPrimaryColors();
            renderPrimaryScale();
            renderGreyScale();
            renderColorRelationships();
            renderSystemColors();
            renderTokenSection("gradients", "gradients");
            renderTokenSection("semanticColors", "semantic");
            renderTokenSection("extendedColors", "extended");
        }

        function renderPrimaryColors() {
            const container = document.getElementById("primaryColors");

            const colors = [
                { key: "surface", label: "Surface" },
                { key: "primary", label: "Primary" },
                { key: "secondary", label: "Secondary" },
                { key: "background", label: "Background" },
                { key: "text2", label: "Text 2" },
                { key: "text", label: "Text" }
            ];

            container.innerHTML = colors.map(item => {
                const color = scheme.colors[item.key];
                const contrast = getContrastColor(color);

                return `
                    <div
                        class="color-swatch"
                        onclick="openColorPicker('colors', '${item.key}')"
                        style="background:${color}"
                    >
                        <div class="color-swatch-inner">
                            <div class="color-actions">
                                <button
                                    class="color-action-btn"
                                    title="Copy"
                                    onclick="event.stopPropagation(); copyColor('${color}')"
                                >⧉</button>

                                <button
                                    class="color-action-btn"
                                    title="Edit"
                                    onclick="event.stopPropagation(); openColorPicker('colors', '${item.key}')"
                                >✎</button>
                            </div>

                            <div class="color-name" style="color:${contrast}">${item.label}</div>
                            <div class="color-hex" style="color:${contrast}">${color.toUpperCase()}</div>
                        </div>
                    </div>
                `;
            }).join("");
        }

        function renderPrimaryScale() {
            renderScale("primaryScale", scheme.primaryScale, "primaryScale");
        }

        function renderGreyScale() {
            renderScale("greyScale", scheme.greyScale, "greyScale");
        }

        function renderScale(containerId, scale, type) {
            const container = document.getElementById(containerId);

            container.innerHTML = Object.entries(scale).map(([step, color]) => {
                const contrast = getContrastColor(color);

                return `
                    <div
                        class="scale-swatch"
                        onclick="openColorPicker('${type}', '${step}')"
                        style="background:${color}"
                    >
                        <div class="scale-swatch-inner">
                            <div class="scale-number" style="color:${contrast}">${step}</div>
                            <div class="scale-hex" style="color:${contrast}">${color.toUpperCase()}</div>
                        </div>
                    </div>
                `;
            }).join("");
        }

        function renderSystemColors() {
            const container = document.getElementById("systemColors");

            container.innerHTML = Object.entries(scheme.system).map(([key, color]) => {
                const contrast = getContrastColor(color);

                return `
                    <div
                        class="color-swatch"
                        onclick="openColorPicker('system', '${key}')"
                        style="background:${color}"
                    >
                        <div class="color-swatch-inner">
                            <div class="color-name" style="color:${contrast}; text-transform:capitalize">${key}</div>
                            <div class="color-hex" style="color:${contrast}">${color.toUpperCase()}</div>
                        </div>
                    </div>
                `;
            }).join("");
        }

        function renderTokenSection(containerId, groupName) {
            const container = document.getElementById(containerId);
            const tokens = scheme[groupName] || {};

            container.innerHTML = Object.entries(tokens).map(([key, value]) => {
                if (isGradient(value)) {
                    const gradientCss = gradientToCSS(value);

                    return `
                        <div
                            class="gradient-swatch"
                            onclick="openGradientPicker('${groupName}', '${key}')"
                            style="background:${gradientCss}"
                        >
                            <div class="gradient-swatch-inner">
                                <div class="color-name" style="color:#fff; text-shadow:0 1px 3px rgba(0,0,0,.6)">
                                    ${formatLabel(key)}
                                </div>
                                <div class="color-hex" style="color:#fff; text-shadow:0 1px 3px rgba(0,0,0,.6)">
                                    ${gradientLabel(value)}
                                </div>
                            </div>
                        </div>
                    `;
                }

                const contrast = getContrastColor(value);

                return `
                    <div
                        class="color-swatch"
                        onclick="openColorPicker('${groupName}', '${key}')"
                        style="background:${value}"
                    >
                        <div class="color-swatch-inner">
                            <div class="color-name" style="color:${contrast}">
                                ${formatLabel(key)}
                            </div>
                            <div class="color-hex" style="color:${contrast}">
                                ${value.toUpperCase()}
                            </div>
                        </div>
                    </div>
                `;
            }).join("");
        }

        function renderColorRelationships() {
            const primary = scheme.colors.primary;
            const relationships = buildColorRelationships(primary);
            scheme.colorRelationships = relationships;

            const details = {
                complementary: "Opposite hues · high contrast",
                analogous: "Adjacent hues · smooth harmony",
                triadic: "120° apart · balanced contrast",
                splitComplementary: "Base plus adjacent opposites",
                tetradic: "90° apart · rich variety",
                monochromatic: "One hue · tonal variation"
            };

            const labels = {
                complementary: "Complementary",
                analogous: "Analogous",
                triadic: "Triadic",
                splitComplementary: "Split-Complementary",
                tetradic: "Tetradic (Square)",
                monochromatic: "Monochromatic"
            };

            document.getElementById("colorRelationships").innerHTML =
                Object.entries(relationships).map(([type, colors]) => `
                    <div class="relationship-card">
                        <div class="relationship-preview">
                            ${colors.map(color => `
                                <span
                                    style="background:${color}"
                                    title="Copy ${color}"
                                    onclick="copyColor('${color}')"
                                ></span>
                            `).join("")}
                        </div>

                        <div class="relationship-meta">
                            <div class="relationship-name">${labels[type]}</div>
                            <div class="relationship-detail">${details[type]}</div>
                        </div>
                    </div>
                `).join("");

            const palette3 = relationships.triadic;

            const palette5 = [
                shiftLightness(primary, 28),
                primary,
                rotateHue(primary, 28),
                rotateHue(primary, 180),
                shiftLightness(rotateHue(primary, 180), -20)
            ];

            document.getElementById("palette3").innerHTML = palette3.map(color => `
                <span
                    style="background:${color}"
                    title="Copy ${color}"
                    onclick="copyColor('${color}')"
                ></span>
            `).join("");

            document.getElementById("palette5").innerHTML = palette5.map(color => `
                <span
                    style="background:${color}"
                    title="Copy ${color}"
                    onclick="copyColor('${color}')"
                ></span>
            `).join("");
        }

        function openColorPicker(type, key) {
            editingType = type;
            editingKey = key;
            currentGradient = null;

            const color = scheme[type][key];

            document.getElementById("modalTitle").textContent = `Edit ${formatLabel(key)}`;
            document.getElementById("gradientEditor").style.display = "none";

            document.getElementById("colorInput").value = color;
            document.getElementById("hexInput").value = color.toUpperCase();
            document.getElementById("colorPreview").style.background = color;

            document.getElementById("colorModal").classList.add("active");
        }

        function openGradientPicker(type, key) {
            editingType = type;
            editingKey = key;
            currentGradient = JSON.parse(JSON.stringify(scheme[type][key]));

            currentGradient.type = currentGradient.type || "linear";
            currentGradient.angle = Number.isFinite(currentGradient.angle) ? currentGradient.angle : 135;

            document.getElementById("modalTitle").textContent = `Edit ${formatLabel(key)} Gradient`;
            document.getElementById("gradientEditor").style.display = "block";

            document.getElementById("gradientType").value = currentGradient.type;
            document.getElementById("gradientAngle").value = currentGradient.angle;
            document.getElementById("gradientAngleValue").textContent = `${currentGradient.angle}°`;

            updateGradientAngleVisibility();

            const firstStop = currentGradient.stops[0] || { color: "#000000" };
            document.getElementById("colorInput").value = firstStop.color;
            document.getElementById("hexInput").value = firstStop.color.toUpperCase();
            document.getElementById("colorPreview").style.background = gradientToCSS(currentGradient);

            renderGradientStops();
            document.getElementById("colorModal").classList.add("active");
        }

        function closeModal() {
            document.getElementById("colorModal").classList.remove("active");
            editingType = null;
            editingKey = null;
            currentGradient = null;
        }

        function onColorInput(value) {
            const hex = value.toUpperCase();

            document.getElementById("hexInput").value = hex;
            document.getElementById("colorPreview").style.background = hex;

            if (currentGradient && currentGradient.stops.length > 0) {
                currentGradient.stops[0].color = hex;
                renderGradientStops();
            }
        }

        function onHexInput(value) {
            const hex = value.trim();

            if (!isValidHex(hex)) {
                return;
            }

            const normalized = hex.toUpperCase();

            document.getElementById("colorInput").value = normalized;
            document.getElementById("colorPreview").style.background = normalized;

            if (currentGradient && currentGradient.stops.length > 0) {
                currentGradient.stops[0].color = normalized;
                renderGradientStops();
            }
        }

        async function startEyedropper() {
            if (!window.EyeDropper) {
                showToast("EyeDropper is not supported. Use Chrome or Edge.");
                return;
            }

            try {
                const eyeDropper = new EyeDropper();
                const result = await eyeDropper.open();

                if (!result || !result.sRGBHex) {
                    return;
                }

                const hex = result.sRGBHex.toUpperCase();

                document.getElementById("colorInput").value = hex;
                document.getElementById("hexInput").value = hex;
                document.getElementById("colorPreview").style.background = hex;

                if (currentGradient && currentGradient.stops.length > 0) {
                    currentGradient.stops[0].color = hex;
                    renderGradientStops();
                }

                showToast(`Color picked: ${hex}`);
            } catch (error) {
                // User canceled the eyedropper.
            }
        }

        function renderGradientStops() {
            if (!currentGradient) {
                return;
            }

            currentGradient.stops.sort((a, b) => a.pos - b.pos);

            document.getElementById("gradientPreview").style.background = gradientToCSS(currentGradient);
            document.getElementById("colorPreview").style.background = gradientToCSS(currentGradient);

            document.getElementById("gradientStops").innerHTML =
                currentGradient.stops.map((stop, index) => `
                    <div class="gradient-stop">
                        <input
                            type="color"
                            value="${stop.color}"
                            onchange="updateStopColor(${index}, this.value)"
                        >

                        <input
                            type="range"
                            min="0"
                            max="100"
                            value="${stop.pos}"
                            oninput="updateStopPos(${index}, this.value)"
                        >

                        <span class="stop-value">${stop.pos}%</span>

                        ${
                            currentGradient.stops.length > 2
                                ? `<button class="remove-stop" onclick="removeStop(${index})">&times;</button>`
                                : ""
                        }
                    </div>
                `).join("");
        }

        function updateStopColor(index, color) {
            currentGradient.stops[index].color = color.toUpperCase();
            renderGradientStops();
        }

        function updateStopPos(index, value) {
            currentGradient.stops[index].pos = Math.max(0, Math.min(100, parseInt(value, 10)));
            renderGradientStops();
        }

        function removeStop(index) {
            if (currentGradient.stops.length <= 2) {
                showToast("A gradient needs at least two stops.");
                return;
            }

            currentGradient.stops.splice(index, 1);
            renderGradientStops();
        }

        function addGradientStop() {
            if (!currentGradient) {
                return;
            }

            const stops = currentGradient.stops.slice().sort((a, b) => a.pos - b.pos);
            const last = stops[stops.length - 1];
            const previous = stops[stops.length - 2] || last;

            const position = last
                ? Math.min(100, Math.round((last.pos + previous.pos) / 2) || 50)
                : 50;

            currentGradient.stops.push({
                color: last ? last.color : scheme.colors.primary,
                pos: position
            });

            renderGradientStops();
        }

        function updateGradientType(type) {
            if (!currentGradient) {
                return;
            }

            currentGradient.type = type;
            updateGradientAngleVisibility();
            renderGradientStops();
        }

        function updateGradientAngle(value) {
            if (!currentGradient) {
                return;
            }

            currentGradient.angle = parseInt(value, 10);
            document.getElementById("gradientAngleValue").textContent = `${currentGradient.angle}°`;
            renderGradientStops();
        }

        function updateGradientAngleVisibility() {
            const type = currentGradient ? currentGradient.type : "linear";
            document.getElementById("gradientAngleRow").style.display =
                type === "radial" ? "none" : "flex";
        }

        function applyGradientPreset(name) {
            const presets = generatePrimaryGradients(scheme.colors.primary);

            if (!presets[name]) {
                return;
            }

            currentGradient = JSON.parse(JSON.stringify(presets[name]));

            document.getElementById("gradientType").value = currentGradient.type;
            document.getElementById("gradientAngle").value = currentGradient.angle || 0;
            document.getElementById("gradientAngleValue").textContent = `${currentGradient.angle || 0}°`;

            updateGradientAngleVisibility();
            renderGradientStops();
        }

        function saveColor() {
            if (!editingType || !editingKey) {
                return;
            }

            if (currentGradient) {
                scheme[editingType][editingKey] = currentGradient;
            } else {
                const hex = document.getElementById("hexInput").value.trim().toUpperCase();

                if (!isValidHex(hex)) {
                    showToast("Enter a valid 6-digit hex color.");
                    return;
                }

                scheme[editingType][editingKey] = hex;

                if (editingType === "colors" && editingKey === "primary") {
                    regeneratePrimaryDerivedTokens(true);
                }
            }

            renderAll();
            updateExport();
            saveToStorage();
            closeModal();
            showToast("Color system updated");
        }

        function gradientToCSS(gradient) {
            const stops = gradient.stops
                .slice()
                .sort((a, b) => a.pos - b.pos)
                .map(stop => `${stop.color} ${stop.pos}%`)
                .join(", ");

            const angle = Number.isFinite(gradient.angle) ? gradient.angle : 135;

            switch (gradient.type) {
                case "radial":
                    return `radial-gradient(circle, ${stops})`;

                case "conic":
                    return `conic-gradient(from ${angle}deg, ${stops})`;

                case "corners":
                    return `linear-gradient(${angle}deg, ${stops})`;

                case "linear":
                default:
                    return `linear-gradient(${angle}deg, ${stops})`;
            }
        }

        function gradientLabel(gradient) {
            const typeNames = {
                linear: "Linear",
                radial: "Radial",
                conic: "Angle",
                corners: "4 Corner"
            };

            return `${typeNames[gradient.type] || "Linear"} · ${gradient.stops.length} Stops`;
        }

        function generatePrimaryGradients(primary) {
            const scale = generatePrimaryScale(primary);
            const complementary = rotateHue(primary, 180);

            return {
                hero: {
                    type: "linear",
                    angle: 135,
                    stops: [
                        { color: scale[300], pos: 0 },
                        { color: scale[700], pos: 100 }
                    ]
                },

                button: {
                    type: "linear",
                    angle: 135,
                    stops: [
                        { color: scale[400], pos: 0 },
                        { color: scale[700], pos: 100 }
                    ]
                },

                linear2: {
                    type: "linear",
                    angle: 135,
                    stops: [
                        { color: scale[400], pos: 0 },
                        { color: scale[700], pos: 100 }
                    ]
                },

                linear3: {
                    type: "linear",
                    angle: 135,
                    stops: [
                        { color: scale[300], pos: 0 },
                        { color: primary, pos: 50 },
                        { color: scale[800], pos: 100 }
                    ]
                },

                radial2: {
                    type: "radial",
                    angle: 0,
                    stops: [
                        { color: scale[300], pos: 0 },
                        { color: scale[800], pos: 100 }
                    ]
                },

                conic3: {
                    type: "conic",
                    angle: 0,
                    stops: [
                        { color: primary, pos: 0 },
                        { color: rotateHue(primary, 120), pos: 50 },
                        { color: rotateHue(primary, 240), pos: 100 }
                    ]
                },

                corners4: {
                    type: "corners",
                    angle: 135,
                    stops: [
                        { color: scale[300], pos: 0 },
                        { color: primary, pos: 33 },
                        { color: complementary, pos: 66 },
                        { color: scale[800], pos: 100 }
                    ]
                }
            };
        }

        function generatePrimaryScale(baseHex) {
            const { h, s, l } = hexToHsl(baseHex);

            const values = [
                [50, 97, Math.max(18, s - 42)],
                [100, 93, Math.max(22, s - 35)],
                [200, 84, Math.max(28, s - 24)],
                [300, 73, Math.max(34, s - 14)],
                [400, 62, Math.max(40, s - 6)],
                [500, l, s],
                [600, Math.max(8, l - 10), Math.min(100, s + 2)],
                [700, Math.max(6, l - 20), Math.min(100, s + 5)],
                [800, Math.max(4, l - 30), Math.min(100, s + 7)],
                [900, Math.max(3, l - 40), Math.min(100, s + 8)],
                [950, Math.max(2, l - 48), Math.min(100, s + 8)]
            ];

            return Object.fromEntries(
                values.map(([step, lightness, saturation]) => [
                    step,
                    hslToHex(h, saturation, lightness)
                ])
            );
        }

        function generateTintedGreyScale(baseHex) {
            const { h, s } = hexToHsl(baseHex);
            const greySaturation = Math.min(14, Math.max(4, Math.round(s * 0.12)));

            const values = [
                [50, 98],
                [100, 95],
                [200, 89],
                [300, 80],
                [400, 69],
                [500, 56],
                [600, 45],
                [700, 34],
                [800, 24],
                [900, 15],
                [950, 9]
            ];

            return Object.fromEntries(
                values.map(([step, lightness]) => [
                    step,
                    hslToHex(h, greySaturation, lightness)
                ])
            );
        }

        function buildColorRelationships(primary) {
            return {
                complementary: [
                    primary,
                    rotateHue(primary, 180)
                ],

                analogous: [
                    rotateHue(primary, -30),
                    primary,
                    rotateHue(primary, 30)
                ],

                triadic: [
                    primary,
                    rotateHue(primary, 120),
                    rotateHue(primary, 240)
                ],

                splitComplementary: [
                    primary,
                    rotateHue(primary, 150),
                    rotateHue(primary, 210)
                ],

                tetradic: [
                    primary,
                    rotateHue(primary, 90),
                    rotateHue(primary, 180),
                    rotateHue(primary, 270)
                ],

                monochromatic: [
                    shiftLightness(primary, 30),
                    shiftLightness(primary, 14),
                    primary,
                    shiftLightness(primary, -14),
                    shiftLightness(primary, -28)
                ]
            };
        }

        function rotateHue(hex, degrees) {
            const { h, s, l } = hexToHsl(hex);
            return hslToHex((h + degrees + 360) % 360, s, l);
        }

        function shiftLightness(hex, amount) {
            const { h, s, l } = hexToHsl(hex);
            return hslToHex(h, s, Math.max(3, Math.min(97, l + amount)));
        }

        function openExportPanel() {
            updateExport();
            document.getElementById("exportPanel").classList.add("active");
        }

        function closeExportPanel() {
            document.getElementById("exportPanel").classList.remove("active");
        }

        function setExportTab(tab, event) {
            document.querySelectorAll(".export-tab").forEach(button => {
                button.classList.remove("active");
            });

            document.querySelectorAll(".export-content").forEach(content => {
                content.classList.remove("active");
            });

            event.currentTarget.classList.add("active");
            document.getElementById(`export-${tab}`).classList.add("active");
        }

        function getCSSOutput() {
            let css = `/* ${scheme.name} - Generated by Color Scheme Designer */\n:root {\n`;

            css += `\n  /* Primary Colors */\n`;
            Object.entries(scheme.colors).forEach(([key, value]) => {
                css += `  --color-${kebab(key)}: ${value};\n`;
            });

            css += `\n  /* Primary Scale */\n`;
            Object.entries(scheme.primaryScale).forEach(([key, value]) => {
                css += `  --primary-${key}: ${value};\n`;
            });

            css += `\n  /* Tinted Grey Scale */\n`;
            Object.entries(scheme.greyScale).forEach(([key, value]) => {
                css += `  --grey-${key}: ${value};\n`;
            });

            css += `\n  /* System Colors */\n`;
            Object.entries(scheme.system).forEach(([key, value]) => {
                css += `  --${kebab(key)}: ${value};\n`;
            });

            css += `\n  /* Gradient Tokens */\n`;
            appendCssTokens(css, scheme.gradients, "gradient");
            Object.entries(scheme.gradients).forEach(([key, value]) => {
                css += `  --gradient-${kebab(key)}: ${gradientToCSS(value)};\n`;
            });

            css += `\n  /* Semantic Tokens */\n`;
            Object.entries(scheme.semantic).forEach(([key, value]) => {
                css += isGradient(value)
                    ? `  --semantic-${kebab(key)}: ${gradientToCSS(value)};\n`
                    : `  --semantic-${kebab(key)}: ${value};\n`;
            });

            css += `\n  /* Extended Tokens */\n`;
            Object.entries(scheme.extended).forEach(([key, value]) => {
                css += isGradient(value)
                    ? `  --extended-${kebab(key)}: ${gradientToCSS(value)};\n`
                    : `  --extended-${kebab(key)}: ${value};\n`;
            });

            css += `}\n`;

            return css;
        }

        function appendCssTokens(css, tokens, prefix) {
            return css;
        }

        function getSCSSOutput() {
            let scss = `// ${scheme.name} - Generated by Color Scheme Designer\n\n`;

            scss += `// Primary Colors\n`;
            Object.entries(scheme.colors).forEach(([key, value]) => {
                scss += `$color-${kebab(key)}: ${value};\n`;
            });

            scss += `\n// Primary Scale\n`;
            Object.entries(scheme.primaryScale).forEach(([key, value]) => {
                scss += `$primary-${key}: ${value};\n`;
            });

            scss += `\n// Tinted Grey Scale\n`;
            Object.entries(scheme.greyScale).forEach(([key, value]) => {
                scss += `$grey-${key}: ${value};\n`;
            });

            scss += `\n// System Colors\n`;
            Object.entries(scheme.system).forEach(([key, value]) => {
                scss += `$${kebab(key)}: ${value};\n`;
            });

            scss += `\n// Gradients\n`;
            Object.entries(scheme.gradients).forEach(([key, value]) => {
                scss += `$gradient-${kebab(key)}: ${gradientToCSS(value)};\n`;
            });

            scss += `\n// Semantic Tokens\n`;
            Object.entries(scheme.semantic).forEach(([key, value]) => {
                scss += isGradient(value)
                    ? `$semantic-${kebab(key)}: ${gradientToCSS(value)};\n`
                    : `$semantic-${kebab(key)}: ${value};\n`;
            });

            scss += `\n// Extended Tokens\n`;
            Object.entries(scheme.extended).forEach(([key, value]) => {
                scss += isGradient(value)
                    ? `$extended-${kebab(key)}: ${gradientToCSS(value)};\n`
                    : `$extended-${kebab(key)}: ${value};\n`;
            });

            return scss;
        }

        function getJSONOutput() {
            return JSON.stringify(scheme, null, 2);
        }

        function updateExport() {
            document.getElementById("cssOutput").textContent = getCSSOutput();
            document.getElementById("scssOutput").textContent = getSCSSOutput();
            document.getElementById("jsonOutput").textContent = getJSONOutput();
        }

        function copyExport(id) {
            copyText(document.getElementById(id).textContent, "Copied to clipboard");
        }

        function downloadFile(filename, content) {
            const blob = new Blob([content], { type: "text/plain" });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");

            link.href = url;
            link.download = filename;
            link.click();

            URL.revokeObjectURL(url);
            showToast(`Downloaded ${filename}`);
        }

        function saveScheme() {
            scheme.name = document.getElementById("cardTitle").textContent.trim() || "Untitled Scheme";
            scheme.siteName = document.getElementById("siteName").value.trim();

            const blob = new Blob([JSON.stringify(scheme, null, 2)], {
                type: "application/json"
            });

            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");

            link.href = url;
            link.download = `color-scheme-${Date.now()}.json`;
            link.click();

            URL.revokeObjectURL(url);

            saveToStorage();
            showToast("Scheme saved");
        }

        function loadScheme() {
            document.getElementById("loadInput").click();
        }

        function handleLoad(event) {
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function(readEvent) {
                try {
                    scheme = JSON.parse(readEvent.target.result);
                    normalizeScheme();

                    document.getElementById("siteName").value = scheme.siteName || "";
                    document.getElementById("cardTitle").textContent = scheme.name || "Loaded Scheme";

                    renderAll();
                    updateExport();
                    saveToStorage();

                    showToast("Scheme loaded");
                } catch (error) {
                    showToast("Invalid JSON file");
                }
            };

            reader.readAsText(file);
            event.target.value = "";
        }

        function saveToStorage() {
            try {
                scheme.name = document.getElementById("cardTitle").textContent.trim() || scheme.name;
                scheme.siteName = document.getElementById("siteName").value;
                localStorage.setItem("colorSchemeDesigner", JSON.stringify(scheme));
            } catch (error) {
                // Storage unavailable.
            }
        }

        function loadFromStorage() {
            try {
                const saved = localStorage.getItem("colorSchemeDesigner");

                if (saved) {
                    scheme = JSON.parse(saved);
                }
            } catch (error) {
                scheme = JSON.parse(JSON.stringify(defaultScheme));
            }
        }

        function randomizeColors() {
            const primary = randomHex();
            const secondary = randomHex();

            scheme.colors.primary = primary;
            scheme.colors.secondary = secondary;

            regeneratePrimaryDerivedTokens(true);

            renderAll();
            updateExport();
            saveToStorage();

            showToast("Primary scales, gradients, and palettes updated");
        }

        function toggleAdditional() {
            const section = document.getElementById("additionalSection");
            const button = document.getElementById("toggleBtn");

            section.classList.toggle("visible");

            button.textContent = section.classList.contains("visible")
                ? "Hide Additional Colors"
                : "Show Additional Colors";
        }

        function toggleTheme() {
            showToast("Theme toggle is visual-only in this demo.");
        }

        function showPromptModal() {
            showToast('Prompt: "A professional dark mode dashboard with blue accents and warm highlights."');
        }

        function hexToRgb(hex) {
            const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

            return result
                ? {
                    r: parseInt(result[1], 16),
                    g: parseInt(result[2], 16),
                    b: parseInt(result[3], 16)
                }
                : { r: 0, g: 0, b: 0 };
        }

        function rgbToHex(r, g, b) {
            return "#" + [r, g, b]
                .map(value => Math.min(255, Math.max(0, Math.round(value)))
                    .toString(16)
                    .padStart(2, "0"))
                .join("")
                .toUpperCase();
        }

        function hexToHsl(hex) {
            const { r, g, b } = hexToRgb(hex);

            const red = r / 255;
            const green = g / 255;
            const blue = b / 255;

            const max = Math.max(red, green, blue);
            const min = Math.min(red, green, blue);

            let h = 0;
            let s = 0;

            const l = (max + min) / 2;

            if (max !== min) {
                const delta = max - min;

                s = l > 0.5
                    ? delta / (2 - max - min)
                    : delta / (max + min);

                switch (max) {
                    case red:
                        h = (green - blue) / delta + (green < blue ? 6 : 0);
                        break;

                    case green:
                        h = (blue - red) / delta + 2;
                        break;

                    default:
                        h = (red - green) / delta + 4;
                        break;
                }

                h *= 60;
            }

            return {
                h: Math.round(h),
                s: Math.round(s * 100),
                l: Math.round(l * 100)
            };
        }

        function hslToHex(h, s, l) {
            const hue = ((h % 360) + 360) % 360;
            const saturation = s / 100;
            const lightness = l / 100;

            const chroma = (1 - Math.abs(2 * lightness - 1)) * saturation;
            const x = chroma * (1 - Math.abs((hue / 60) % 2 - 1));
            const match = lightness - chroma / 2;

            let r = 0;
            let g = 0;
            let b = 0;

            if (hue < 60) {
                [r, g, b] = [chroma, x, 0];
            } else if (hue < 120) {
                [r, g, b] = [x, chroma, 0];
            } else if (hue < 180) {
                [r, g, b] = [0, chroma, x];
            } else if (hue < 240) {
                [r, g, b] = [0, x, chroma];
            } else if (hue < 300) {
                [r, g, b] = [x, 0, chroma];
            } else {
                [r, g, b] = [chroma, 0, x];
            }

            return rgbToHex(
                (r + match) * 255,
                (g + match) * 255,
                (b + match) * 255
            );
        }

        function getContrastColor(hex) {
            const { r, g, b } = hexToRgb(hex);
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

            return luminance > 0.5 ? "#000000" : "#FFFFFF";
        }

        function isValidHex(hex) {
            return /^#[0-9A-Fa-f]{6}$/.test(hex);
        }

        function isGradient(value) {
            return Boolean(
                value &&
                typeof value === "object" &&
                Array.isArray(value.stops)
            );
        }

        function formatLabel(value) {
            return value
                .replace(/([a-z0-9])([A-Z])/g, "$1 $2")
                .replace(/[-_]/g, " ")
                .replace(/\b\w/g, character => character.toUpperCase());
        }

        function kebab(value) {
            return value
                .replace(/([a-z0-9])([A-Z])/g, "$1-$2")
                .replace(/[_\s]/g, "-")
                .toLowerCase();
        }

        function randomHex() {
            return "#" + Math.floor(Math.random() * 16777215)
                .toString(16)
                .padStart(6, "0")
                .toUpperCase();
        }

        function copyColor(hex) {
            copyText(hex.toUpperCase(), `Copied ${hex.toUpperCase()}`);
        }

        function copyText(text, message) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text)
                    .then(() => showToast(message))
                    .catch(() => fallbackCopy(text, message));
            } else {
                fallbackCopy(text, message);
            }
        }

        function fallbackCopy(text, message) {
            const area = document.createElement("textarea");
            area.value = text;
            area.style.position = "fixed";
            area.style.opacity = "0";

            document.body.appendChild(area);
            area.select();
            document.execCommand("copy");
            area.remove();

            showToast(message);
        }

        function showToast(message) {
            const toast = document.getElementById("toast");

            toast.textContent = message;
            toast.classList.add("show");

            clearTimeout(window.toastTimer);

            window.toastTimer = setTimeout(() => {
                toast.classList.remove("show");
            }, 2500);
        }

        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                closeModal();
                closeExportPanel();
            }
        });

        init();
    </script>
</body>
</html>