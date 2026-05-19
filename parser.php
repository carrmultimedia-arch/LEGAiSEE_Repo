<?php

function extractText($filePath, $ext) {

    $ext = strtolower($ext);

    // =====================
    // TXT / MD (DIRECT)
    // =====================
    if ($ext === "txt" || $ext === "md") {
        return file_get_contents($filePath);
    }
require_once __DIR__ . '/lib/semantic_diff_engine.php';
    // =====================
    // PDF (FALLBACK METHOD)
    // =====================
    if ($ext === "pdf") {

        // Try pdftotext if available
        $output = shell_exec("pdftotext " . escapeshellarg($filePath) . " -");

        if ($output && trim($output) !== "") {
            return $output;
        }

        return "[PDF: UNABLE TO EXTRACT TEXT - STORED RAW]";
    }

    // =====================
    // DOCX (ZIP XML PARSE)
    // =====================
    if ($ext === "docx") {

        $zip = new ZipArchive;
        if ($zip->open($filePath) === TRUE) {

            $xml = $zip->getFromName("word/document.xml");
            $zip->close();

            if ($xml) {
                $xml = strip_tags($xml);
                return $xml;
            }
        }

        return "[DOCX: UNABLE TO EXTRACT TEXT]";
    }

    // =====================
    // XLSX (BASIC EXTRACTION)
    // =====================
    if ($ext === "xlsx") {

        $zip = new ZipArchive;
        $text = "";

        if ($zip->open($filePath) === TRUE) {

            $xml = $zip->getFromName("xl/sharedStrings.xml");

            if ($xml) {
                $text = strip_tags($xml);
            }

            $zip->close();
        }

        return $text ?: "[XLSX: BASIC EXTRACTION FAILED]";
    }

    // =====================
    // UNKNOWN FILE TYPE
    // =====================
    return "[UNSUPPORTED FILE TYPE]";
}

function normalizeFile($filePath, $meta = []) {

    $ext = pathinfo($filePath, PATHINFO_EXTENSION);

    $text = extractText($filePath, $ext);

    $hash = md5($filePath . time());

    $baseDir = __DIR__ . "/normalized/";

    $client = $meta['client'] ?? "general";

    $dir = $baseDir . $client . "/";

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $mdFile = $dir . $hash . ".md";
    $jsonFile = $dir . $hash . ".json";

    file_put_contents($mdFile, $text);

    $metaOut = array_merge($meta, [
        "source_file" => $filePath,
        "type" => $ext,
        "word_count" => str_word_count($text),
        "timestamp" => date("Y-m-d H:i:s"),
        "extracted_from" => "parser"
    ]);

    file_put_contents($jsonFile, json_encode($metaOut, JSON_PRETTY_PRINT));

    return $mdFile;
}

?>