<?php
/**
 * files_module.php
 * LEGAiSEE — File Manager
 *
 * Windows/macOS style file navigator — tree, list, viewer, create, delete, move.
 * Pattern: HTML fragment only — no DOCTYPE, no head, no body, no style tags
 * Styles:  ui/global.css (MODULE: files block)
 * API:     api/files_action.php handles all file operations
 * Loaded:  shell.php?module=files
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

// Render the shell — all data loads via JS calling api/files_action.php
ob_start();
?>
<div class="fm-wrap">

    <!-- ══ LEFT: Folder Tree ═══════════════════════════════════════════ -->
    <div class="fm-tree-col" id="fm-tree-col">

        <div class="fm-tree-header">
            <span class="fm-tree-title">📁 System Files</span>
            <button class="fm-icon-btn" onclick="fmRefreshTree()" title="Refresh tree">↺</button>
        </div>

        <div class="fm-tree-body" id="fm-tree-body">
            <div class="fm-loading">Loading…</div>
        </div>

    </div>

    <!-- ══ RIGHT: File List + Viewer ════════════════════════════════════ -->
    <div class="fm-main-col">

        <!-- Toolbar -->
        <div class="fm-toolbar">
            <span class="fm-breadcrumb" id="fm-breadcrumb">/</span>
            <div class="fm-toolbar-actions">
                <button class="fm-btn" onclick="fmNewFolder()">+ Folder</button>
                <button class="fm-btn" onclick="fmNewFile()">+ File</button>
                <button class="fm-btn fm-btn--upload" onclick="document.getElementById('fm-upload-input').click()">↑ Upload</button>
                <input type="file" id="fm-upload-input" style="display:none" onchange="fmUploadFile(this)">
            </div>
        </div>

        <!-- File list -->
        <div class="fm-list-wrap" id="fm-list-wrap">
            <table class="fm-list" id="fm-list">
                <thead>
                    <tr>
                        <th class="fm-th fm-th--icon"></th>
                        <th class="fm-th fm-th--name">Name</th>
                        <th class="fm-th fm-th--size">Size</th>
                        <th class="fm-th fm-th--date">Modified</th>
                        <th class="fm-th fm-th--actions"></th>
                    </tr>
                </thead>
                <tbody id="fm-list-body">
                    <tr><td colspan="5" class="fm-list-empty">Select a folder from the tree.</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Viewer -->
        <div class="fm-viewer-wrap" id="fm-viewer-wrap" style="display:none">
            <div class="fm-viewer-header">
                <span class="fm-viewer-filename" id="fm-viewer-filename"></span>
                <span class="fm-viewer-meta"    id="fm-viewer-meta"></span>
                <div class="fm-viewer-actions">
                    <button class="fm-btn fm-btn--save" id="fm-save-btn" onclick="fmSaveFile()" style="display:none">💾 Save</button>
                    <button class="fm-btn fm-btn--edit" id="fm-edit-btn" onclick="fmToggleEdit()">✏️ Edit</button>
                    <button class="fm-icon-btn" onclick="fmCloseViewer()" title="Close viewer">✕</button>
                </div>
            </div>
            <div id="fm-viewer-binary" class="fm-viewer-binary" style="display:none"></div>
            <textarea id="fm-viewer-text" class="fm-viewer-text" readonly></textarea>
        </div>

    </div>

</div>

<script>
(function () {
    'use strict';

    var API     = '/commandcenter/api/files_action.php';
    var curPath = '/';          // currently open folder
    var viewPath = null;        // currently viewed file
    var editing  = false;

    // ── Init ──────────────────────────────────────────────────────────────────
    fmLoadTree('/');
    fmLoadDir('/');

    // ── Load full tree from root ───────────────────────────────────────────────
    window.fmRefreshTree = function () { fmLoadTree('/'); };

    function fmLoadTree(root) {
        xhr('GET', API + '?action=list_dir&path=' + encodeURIComponent(root), null, function (data) {
            if (!data.ok) return;
            var body = document.getElementById('fm-tree-body');
            body.innerHTML = buildTreeNode(data, 0, true);
        });
    }

    function buildTreeNode(data, depth, expanded) {
        var html = '';
        data.dirs.forEach(function (dir) {
            html += '<div class="fm-tree-node" style="padding-left:' + (depth * 14 + 8) + 'px">'
                  + '<span class="fm-tree-arrow" onclick="fmToggleDir(this)" data-path="' + esc(dir.path) + '">▶</span>'
                  + '<span class="fm-tree-name" onclick="fmSelectDir(\'' + esc(dir.path) + '\', this)">'
                  + '📁 ' + esc(dir.name) + '</span>'
                  + '</div>'
                  + '<div class="fm-tree-children" id="fmtc-' + btoa(dir.path).replace(/=/g,'') + '" style="display:none"></div>';
        });
        return html;
    }

    window.fmToggleDir = function (arrow) {
        var path      = arrow.dataset.path;
        var key       = 'fmtc-' + btoa(path).replace(/=/g,'');
        var container = document.getElementById(key);
        if (!container) return;

        if (container.style.display === 'none') {
            arrow.textContent = '▼';
            container.style.display = 'block';
            if (!container.dataset.loaded) {
                container.innerHTML = '<div class="fm-tree-loading">…</div>';
                xhr('GET', API + '?action=list_dir&path=' + encodeURIComponent(path), null, function (data) {
                    if (!data.ok) { container.innerHTML = '<div class="fm-tree-err">Error</div>'; return; }
                    container.innerHTML = buildTreeNode(data, parseInt(container.closest('.fm-tree-node')?.style.paddingLeft || '8') / 14, false);
                    container.dataset.loaded = '1';
                });
            }
        } else {
            arrow.textContent = '▶';
            container.style.display = 'none';
        }
    };

    window.fmSelectDir = function (path, nameEl) {
        document.querySelectorAll('.fm-tree-name--active').forEach(function (el) {
            el.classList.remove('fm-tree-name--active');
        });
        if (nameEl) nameEl.classList.add('fm-tree-name--active');
        fmLoadDir(path);
    };

    // ── Load directory contents into file list ─────────────────────────────────
    window.fmLoadDir = function (path) {
        curPath = path;
        document.getElementById('fm-breadcrumb').textContent = path;
        document.getElementById('fm-list-body').innerHTML = '<tr><td colspan="5" class="fm-list-empty">Loading…</td></tr>';

        xhr('GET', API + '?action=list_dir&path=' + encodeURIComponent(path), null, function (data) {
            if (!data.ok) {
                document.getElementById('fm-list-body').innerHTML =
                    '<tr><td colspan="5" class="fm-list-empty fm-list-error">Error: ' + esc(data.error) + '</td></tr>';
                return;
            }

            var rows = '';

            // Parent folder row
            if (path !== '/') {
                var parent = path.split('/').slice(0, -1).join('/') || '/';
                rows += '<tr class="fm-row fm-row--dir" onclick="fmLoadDir(\'' + esc(parent) + '\')">'
                      + '<td class="fm-cell fm-cell--icon">📁</td>'
                      + '<td class="fm-cell fm-cell--name">..</td>'
                      + '<td class="fm-cell"></td><td class="fm-cell"></td><td class="fm-cell"></td></tr>';
            }

            data.dirs.forEach(function (dir) {
                rows += '<tr class="fm-row fm-row--dir" onclick="fmLoadDir(\'' + esc(dir.path) + '\')">'
                      + '<td class="fm-cell fm-cell--icon">📁</td>'
                      + '<td class="fm-cell fm-cell--name">' + esc(dir.name) + '</td>'
                      + '<td class="fm-cell fm-cell--size">' + dir.children + ' items</td>'
                      + '<td class="fm-cell fm-cell--date"></td>'
                      + '<td class="fm-cell fm-cell--actions">'
                      +   '<button class="fm-row-btn" onclick="event.stopPropagation();fmRenamePrompt(\'' + esc(dir.path) + '\',\'' + esc(dir.name) + '\')">Rename</button>'
                      +   '<button class="fm-row-btn fm-row-btn--del" onclick="event.stopPropagation();fmDelete(\'' + esc(dir.path) + '\',\'' + esc(dir.name) + '\',true)">Del</button>'
                      + '</td></tr>';
            });

            data.files.forEach(function (file) {
                rows += '<tr class="fm-row fm-row--file" onclick="fmViewFile(\'' + esc(file.path) + '\')">'
                      + '<td class="fm-cell fm-cell--icon">' + file.icon + '</td>'
                      + '<td class="fm-cell fm-cell--name">' + esc(file.name) + '</td>'
                      + '<td class="fm-cell fm-cell--size">' + esc(file.size) + '</td>'
                      + '<td class="fm-cell fm-cell--date">' + esc(file.modified) + '</td>'
                      + '<td class="fm-cell fm-cell--actions">'
                      +   '<button class="fm-row-btn" onclick="event.stopPropagation();fmRenamePrompt(\'' + esc(file.path) + '\',\'' + esc(file.name) + '\')">Rename</button>'
                      +   '<button class="fm-row-btn" onclick="event.stopPropagation();fmMovePrompt(\'' + esc(file.path) + '\',\'' + esc(file.name) + '\')">Move</button>'
                      +   '<button class="fm-row-btn fm-row-btn--del" onclick="event.stopPropagation();fmDelete(\'' + esc(file.path) + '\',\'' + esc(file.name) + '\',false)">Del</button>'
                      + '</td></tr>';
            });

            if (!rows) rows = '<tr><td colspan="5" class="fm-list-empty">Empty folder</td></tr>';
            document.getElementById('fm-list-body').innerHTML = rows;
        });
    };

    // ── View file ─────────────────────────────────────────────────────────────
    window.fmViewFile = function (path) {
        viewPath = path;
        editing  = false;
        document.getElementById('fm-viewer-wrap').style.display = 'flex';
        document.getElementById('fm-viewer-filename').textContent = path.split('/').pop();
        document.getElementById('fm-viewer-meta').textContent = 'Loading…';
        document.getElementById('fm-viewer-text').value = '';
        document.getElementById('fm-viewer-text').readOnly = true;
        document.getElementById('fm-viewer-binary').style.display = 'none';
        document.getElementById('fm-viewer-text').style.display = 'block';
        document.getElementById('fm-save-btn').style.display = 'none';
        document.getElementById('fm-edit-btn').style.display = 'inline-block';
        document.getElementById('fm-edit-btn').textContent = '✏️ Edit';

        xhr('GET', API + '?action=get_file&path=' + encodeURIComponent(path), null, function (data) {
            if (!data.ok) {
                document.getElementById('fm-viewer-text').value = 'Error: ' + data.error;
                return;
            }
            document.getElementById('fm-viewer-meta').textContent = data.size + (data.modified ? ' · ' + data.modified : '');
            if (data.binary) {
                document.getElementById('fm-viewer-text').style.display   = 'none';
                document.getElementById('fm-viewer-binary').style.display = 'block';
                document.getElementById('fm-viewer-binary').innerHTML =
                    '<div class="fm-binary-msg">📦 Binary file — ' + esc(data.size) + '<br>' + esc(data.name) + '</div>';
                document.getElementById('fm-edit-btn').style.display = 'none';
            } else {
                document.getElementById('fm-viewer-text').value = data.content;
            }
        });
    };

    window.fmCloseViewer = function () {
        document.getElementById('fm-viewer-wrap').style.display = 'none';
        viewPath = null;
        editing  = false;
    };

    window.fmToggleEdit = function () {
        var ta  = document.getElementById('fm-viewer-text');
        var btn = document.getElementById('fm-edit-btn');
        var sav = document.getElementById('fm-save-btn');
        editing = !editing;
        ta.readOnly = !editing;
        btn.textContent = editing ? '✏️ Editing' : '✏️ Edit';
        sav.style.display = editing ? 'inline-block' : 'none';
        if (editing) ta.focus();
    };

    window.fmSaveFile = function () {
        if (!viewPath) return;
        var content = document.getElementById('fm-viewer-text').value;
        var body    = 'action=save_file&path=' + encodeURIComponent(viewPath) + '&content=' + encodeURIComponent(content);
        xhr('POST', API, body, function (data) {
            if (data.ok) {
                document.getElementById('fm-viewer-meta').textContent = data.size + ' · saved';
                fmToggleEdit();
                fmLoadDir(curPath);
            } else {
                alert('Save failed: ' + data.error);
            }
        });
    };

    // ── Create folder ──────────────────────────────────────────────────────────
    window.fmNewFolder = function () {
        var name = prompt('New folder name:');
        if (!name) return;
        var body = 'action=create_dir&parent=' + encodeURIComponent(curPath) + '&name=' + encodeURIComponent(name);
        xhr('POST', API, body, function (data) {
            data.ok ? fmLoadDir(curPath) : alert('Error: ' + data.error);
        });
    };

    // ── Create file ────────────────────────────────────────────────────────────
    window.fmNewFile = function () {
        var name = prompt('New file name (e.g. notes.txt):');
        if (!name) return;
        var body = 'action=create_file&parent=' + encodeURIComponent(curPath) + '&name=' + encodeURIComponent(name);
        xhr('POST', API, body, function (data) {
            if (data.ok) { fmLoadDir(curPath); fmViewFile(data.path); }
            else alert('Error: ' + data.error);
        });
    };

    // ── Upload file ────────────────────────────────────────────────────────────
    window.fmUploadFile = function (input) {
        if (!input.files.length) return;
        var fd = new FormData();
        fd.append('action', 'upload');
        fd.append('dest',   curPath);
        fd.append('file',   input.files[0]);
        var req = new XMLHttpRequest();
        req.open('POST', API, true);
        req.onreadystatechange = function () {
            if (req.readyState !== 4) return;
            try {
                var data = JSON.parse(req.responseText);
                data.ok ? fmLoadDir(curPath) : alert('Upload error: ' + data.error);
            } catch (e) { alert('Upload error'); }
        };
        req.send(fd);
        input.value = '';
    };

    // ── Delete ────────────────────────────────────────────────────────────────
    window.fmDelete = function (path, name, isDir) {
        var what = isDir ? 'folder' : 'file';
        if (!confirm('Delete ' + what + ' "' + name + '"?\n\n' + (isDir ? 'Folder must be empty.' : 'This cannot be undone.'))) return;
        var body = 'action=delete&path=' + encodeURIComponent(path);
        xhr('POST', API, body, function (data) {
            if (data.ok) {
                fmLoadDir(curPath);
                if (viewPath === path) fmCloseViewer();
            } else {
                alert('Delete failed: ' + data.error);
            }
        });
    };

    // ── Rename ────────────────────────────────────────────────────────────────
    window.fmRenamePrompt = function (path, name) {
        var newName = prompt('Rename "' + name + '" to:', name);
        if (!newName || newName === name) return;
        var body = 'action=rename&path=' + encodeURIComponent(path) + '&new_name=' + encodeURIComponent(newName);
        xhr('POST', API, body, function (data) {
            data.ok ? fmLoadDir(curPath) : alert('Rename failed: ' + data.error);
        });
    };

    // ── Move ──────────────────────────────────────────────────────────────────
    window.fmMovePrompt = function (path, name) {
        var dest = prompt('Move "' + name + '" to folder path:\n(e.g. /data/cases)', curPath);
        if (!dest) return;
        var body = 'action=move&src=' + encodeURIComponent(path) + '&dest=' + encodeURIComponent(dest);
        xhr('POST', API, body, function (data) {
            data.ok ? fmLoadDir(curPath) : alert('Move failed: ' + data.error);
        });
    };

    // ── XHR helper ────────────────────────────────────────────────────────────
    function xhr(method, url, body, cb) {
        var req = new XMLHttpRequest();
        req.open(method, url, true);
        if (method === 'POST' && typeof body === 'string') {
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }
        req.onreadystatechange = function () {
            if (req.readyState !== 4) return;
            try { cb(JSON.parse(req.responseText)); }
            catch (e) { cb({ ok: false, error: 'Parse error: ' + req.responseText.substring(0, 100) }); }
        };
        req.send(body || null);
    }

    // ── Escape helper ─────────────────────────────────────────────────────────
    function esc(s) {
        return String(s)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
    }

})();
</script>
<?php
return ob_get_clean();