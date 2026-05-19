<?php
/**
 * api/files_action.php
 * LEGAiSEE — File Manager API
 *
 * Handles all file system operations for files_module.php
 * Lives in api/ — bypasses shell.php, returns JSON only.
 *
 * Upload to: commandcenter/api/files_action.php
 * Called by: files_module.php JavaScript
 *
 * Actions:
 *   list_dir    — list contents of a directory
 *   get_file    — read a file's contents
 *   create_dir  — create a new folder
 *   create_file — create a new empty file
 *   delete      — delete a file or empty folder
 *   rename      — rename a file or folder
 *   move        — move a file or folder
 *   upload      — handle file upload (multipart)
 */

require_once __DIR__ . '/../kernel/kernel_boot.php';

header('Content-Type: application/json');

// ── Security: all operations must stay within this root ───────────────────────
// KERNEL_ROOT = commandcenter/ — operators can see everything in the system

define('FM_ROOT', realpath(KERNEL_ROOT));

if (!FM_ROOT) {
    echo json_encode(['ok' => false, 'error' => 'FM_ROOT not resolvable']);
    exit;
}

// ── Resolve and validate a path ───────────────────────────────────────────────

function fm_resolve(string $rel): string|false {
    // rel may already be absolute or relative to FM_ROOT
    $candidate = str_starts_with($rel, '/') ? $rel : FM_ROOT . '/' . ltrim($rel, '/');
    $real = realpath($candidate);
    if ($real === false) {
        // Path doesn't exist yet — validate the parent
        $parent = realpath(dirname($candidate));
        if (!$parent || strpos($parent, FM_ROOT) !== 0) return false;
        return $candidate; // return unresolved path (for create operations)
    }
    if (strpos($real, FM_ROOT) !== 0) return false; // escape attempt
    return $real;
}

function fm_rel(string $abs): string {
    return '/' . ltrim(str_replace(FM_ROOT, '', $abs), '/');
}

function fm_ext(string $name): string {
    return strtolower(pathinfo($name, PATHINFO_EXTENSION));
}

function fm_size(int $bytes): string {
    if ($bytes < 1024)    return $bytes . ' B';
    if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
    return round($bytes / 1048576, 2) . ' MB';
}

function fm_icon(string $name): string {
    $ext = fm_ext($name);
    $map = [
        'php'  => '🔷', 'js'   => '🟨', 'json' => '📋',
        'css'  => '🎨', 'html' => '🌐', 'htm'  => '🌐',
        'txt'  => '📄', 'md'   => '📝', 'sql'  => '🗄️',
        'pdf'  => '📕', 'docx' => '📘', 'doc'  => '📘',
        'xlsx' => '📗', 'xls'  => '📗', 'csv'  => '📊',
        'jpg'  => '🖼️', 'jpeg' => '🖼️', 'png'  => '🖼️',
        'gif'  => '🖼️', 'svg'  => '🖼️', 'webp' => '🖼️',
        'zip'  => '📦', 'tar'  => '📦', 'gz'   => '📦',
        'log'  => '📃', 'sh'   => '⚙️',
    ];
    return $map[$ext] ?? '📄';
}

// ── Detect if file is binary / unreadable as text ─────────────────────────────

function fm_is_text(string $path): bool {
    $text_ext = ['php','js','json','css','html','htm','txt','md','sql','csv',
                 'xml','yaml','yml','sh','log','htaccess','env','ini','conf','py'];
    $ext = fm_ext(basename($path));
    if ($ext === '') {
        // No extension — try sniffing
        $sample = file_get_contents($path, false, null, 0, 512);
        return mb_check_encoding($sample, 'UTF-8') && !str_contains($sample, "\x00");
    }
    return in_array($ext, $text_ext);
}

// ── Dispatch ──────────────────────────────────────────────────────────────────

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {

    // ── List directory ────────────────────────────────────────────────────────
    case 'list_dir': {
        $rel  = $_GET['path'] ?? '/';
        $path = fm_resolve($rel);
        if (!$path || !is_dir($path)) {
            echo json_encode(['ok' => false, 'error' => 'Directory not found: ' . $rel]);
            break;
        }
        $dirs  = [];
        $files = [];
        foreach (scandir($path) as $name) {
            if ($name === '.' || $name === '..') continue;
            $full = $path . DIRECTORY_SEPARATOR . $name;
            if (is_dir($full)) {
                $dirs[] = [
                    'name'     => $name,
                    'path'     => fm_rel($full),
                    'type'     => 'dir',
                    'children' => count(array_diff(scandir($full), ['.','..'])),
                ];
            } else {
                $files[] = [
                    'name'     => $name,
                    'path'     => fm_rel($full),
                    'type'     => 'file',
                    'ext'      => fm_ext($name),
                    'icon'     => fm_icon($name),
                    'size'     => fm_size(filesize($full)),
                    'size_raw' => filesize($full),
                    'modified' => date('Y-m-d H:i', filemtime($full)),
                    'is_text'  => fm_is_text($full),
                ];
            }
        }
        usort($dirs,  fn($a,$b) => strcasecmp($a['name'], $b['name']));
        usort($files, fn($a,$b) => strcasecmp($a['name'], $b['name']));
        echo json_encode(['ok' => true, 'path' => fm_rel($path), 'dirs' => $dirs, 'files' => $files]);
        break;
    }

    // ── Read file content ─────────────────────────────────────────────────────
    case 'get_file': {
        $rel  = $_GET['path'] ?? '';
        $path = fm_resolve($rel);
        if (!$path || !is_file($path)) {
            echo json_encode(['ok' => false, 'error' => 'File not found']);
            break;
        }
        if (!fm_is_text($path)) {
            echo json_encode(['ok' => true, 'binary' => true,
                'name' => basename($path), 'size' => fm_size(filesize($path))]);
            break;
        }
        $content = file_get_contents($path);
        echo json_encode(['ok' => true, 'binary' => false,
            'name' => basename($path), 'path' => fm_rel($path),
            'content' => $content, 'size' => fm_size(filesize($path)),
            'modified' => date('Y-m-d H:i', filemtime($path))]);
        break;
    }

    // ── Create directory ──────────────────────────────────────────────────────
    case 'create_dir': {
        $parent  = $_POST['parent'] ?? '/';
        $name    = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $_POST['name'] ?? '');
        if (!$name) { echo json_encode(['ok' => false, 'error' => 'Invalid folder name']); break; }
        $par_path = fm_resolve($parent);
        if (!$par_path || !is_dir($par_path)) {
            echo json_encode(['ok' => false, 'error' => 'Parent directory not found']); break;
        }
        $new_path = $par_path . DIRECTORY_SEPARATOR . $name;
        if (file_exists($new_path)) {
            echo json_encode(['ok' => false, 'error' => "'{$name}' already exists"]); break;
        }
        if (mkdir($new_path, 0755)) {
            echo json_encode(['ok' => true, 'path' => fm_rel($new_path), 'name' => $name]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'mkdir failed — check server permissions']);
        }
        break;
    }

    // ── Create empty file ─────────────────────────────────────────────────────
    case 'create_file': {
        $parent = $_POST['parent'] ?? '/';
        $name   = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $_POST['name'] ?? '');
        if (!$name) { echo json_encode(['ok' => false, 'error' => 'Invalid filename']); break; }
        $par_path = fm_resolve($parent);
        if (!$par_path || !is_dir($par_path)) {
            echo json_encode(['ok' => false, 'error' => 'Parent directory not found']); break;
        }
        $new_path = $par_path . DIRECTORY_SEPARATOR . $name;
        if (file_exists($new_path)) {
            echo json_encode(['ok' => false, 'error' => "'{$name}' already exists"]); break;
        }
        if (file_put_contents($new_path, '') !== false) {
            echo json_encode(['ok' => true, 'path' => fm_rel($new_path), 'name' => $name]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Could not create file — check permissions']);
        }
        break;
    }

    // ── Delete file or folder ─────────────────────────────────────────────────
    case 'delete': {
        $rel  = $_POST['path'] ?? '';
        $path = fm_resolve($rel);
        if (!$path || !file_exists($path)) {
            echo json_encode(['ok' => false, 'error' => 'Path not found']); break;
        }
        // Safety: never delete the root or kernel/
        $blocked = [FM_ROOT, FM_ROOT . '/kernel', FM_ROOT . '/kernel/'];
        foreach ($blocked as $b) {
            if (rtrim($path, '/') === rtrim($b, '/')) {
                echo json_encode(['ok' => false, 'error' => 'Cannot delete protected directory']); break 2;
            }
        }
        if (is_dir($path)) {
            $contents = array_diff(scandir($path), ['.','..']);
            if (!empty($contents)) {
                echo json_encode(['ok' => false, 'error' => 'Folder is not empty — delete contents first']); break;
            }
            rmdir($path)
                ? echo json_encode(['ok' => true])
                : echo json_encode(['ok' => false, 'error' => 'rmdir failed']);
        } else {
            unlink($path)
                ? echo json_encode(['ok' => true])
                : echo json_encode(['ok' => false, 'error' => 'unlink failed']);
        }
        break;
    }

    // ── Rename ────────────────────────────────────────────────────────────────
    case 'rename': {
        $rel     = $_POST['path'] ?? '';
        $new_name = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $_POST['new_name'] ?? '');
        $path    = fm_resolve($rel);
        if (!$path || !file_exists($path)) {
            echo json_encode(['ok' => false, 'error' => 'Path not found']); break;
        }
        if (!$new_name) {
            echo json_encode(['ok' => false, 'error' => 'Invalid new name']); break;
        }
        $new_path = dirname($path) . DIRECTORY_SEPARATOR . $new_name;
        if (file_exists($new_path)) {
            echo json_encode(['ok' => false, 'error' => "'{$new_name}' already exists"]); break;
        }
        rename($path, $new_path)
            ? echo json_encode(['ok' => true, 'new_path' => fm_rel($new_path), 'new_name' => $new_name])
            : echo json_encode(['ok' => false, 'error' => 'rename() failed']);
        break;
    }

    // ── Move ──────────────────────────────────────────────────────────────────
    case 'move': {
        $src_rel  = $_POST['src']  ?? '';
        $dest_rel = $_POST['dest'] ?? '';
        $src      = fm_resolve($src_rel);
        $dest_dir = fm_resolve($dest_rel);
        if (!$src || !file_exists($src)) {
            echo json_encode(['ok' => false, 'error' => 'Source not found']); break;
        }
        if (!$dest_dir || !is_dir($dest_dir)) {
            echo json_encode(['ok' => false, 'error' => 'Destination folder not found']); break;
        }
        $new_path = $dest_dir . DIRECTORY_SEPARATOR . basename($src);
        if (file_exists($new_path)) {
            echo json_encode(['ok' => false, 'error' => 'A file with that name already exists in the destination']); break;
        }
        rename($src, $new_path)
            ? echo json_encode(['ok' => true, 'new_path' => fm_rel($new_path)])
            : echo json_encode(['ok' => false, 'error' => 'move failed']);
        break;
    }

    // ── Upload ────────────────────────────────────────────────────────────────
    case 'upload': {
        $dest_rel = $_POST['dest'] ?? '/';
        $dest     = fm_resolve($dest_rel);
        if (!$dest || !is_dir($dest)) {
            echo json_encode(['ok' => false, 'error' => 'Destination folder not found']); break;
        }
        if (empty($_FILES['file']['tmp_name']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['ok' => false, 'error' => 'No file or upload error']); break;
        }
        $orig  = basename($_FILES['file']['name']);
        $safe  = preg_replace('/[^a-zA-Z0-9._-]/', '_', $orig);
        $target = $dest . DIRECTORY_SEPARATOR . $safe;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            echo json_encode(['ok' => true, 'path' => fm_rel($target), 'name' => $safe,
                'size' => fm_size(filesize($target))]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Upload failed — check permissions']);
        }
        break;
    }

    // ── Save file content ─────────────────────────────────────────────────────
    case 'save_file': {
        $rel     = $_POST['path']    ?? '';
        $content = $_POST['content'] ?? '';
        $path    = fm_resolve($rel);
        if (!$path || !is_file($path)) {
            echo json_encode(['ok' => false, 'error' => 'File not found']); break;
        }
        file_put_contents($path, $content) !== false
            ? echo json_encode(['ok' => true, 'size' => fm_size(filesize($path))])
            : echo json_encode(['ok' => false, 'error' => 'Write failed — check permissions']);
        break;
    }

    default:
        echo json_encode(['ok' => false, 'error' => 'Unknown action: ' . htmlspecialchars($action)]);
}
exit;