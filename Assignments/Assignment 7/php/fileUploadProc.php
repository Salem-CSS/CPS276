<?php
declare(strict_types=1);
require_once __DIR__ . "/../classes/Pdo_methods.php";

$output = "";

function is_pdf_mime(string $tmpPath, string $originalFilename): bool {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmpPath);

    $allowed = [
        "application/pdf",
        "application/x-pdf",
        "application/acrobat",
        "application/vnd.pdf",
        "text/pdf",
        "text/x-pdf",
    ];

    if (in_array($mime, $allowed, true)) {
        return true;
    }

    // Some servers report PDFs as octet-stream; allow only when extension is .pdf
    $ext = strtolower(pathinfo($originalFilename, PATHINFO_EXTENSION));
    if ($ext === "pdf" && $mime === "application/octet-stream") {
        return true;
    }

    return false;
}

function safe_filename(string $name): string {
    $name = trim($name);
    $name = preg_replace('/[^\w\s\-]/u', '', $name) ?? '';
    $name = preg_replace('/\s+/', ' ', $name) ?? '';
    return $name !== "" ? $name : "Untitled";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $enteredName = safe_filename($_POST["file_name"] ?? "");

    if (!isset($_FILES["pdf_file"]) || ($_FILES["pdf_file"]["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $output = "<p style='color:red;'>Error: You must choose a PDF file to upload.</p>";
    } else {

        $tmpPath = (string)$_FILES["pdf_file"]["tmp_name"];
        $size = (int)$_FILES["pdf_file"]["size"];
        $original = (string)$_FILES["pdf_file"]["name"];

        if ($size > 100000) {
            $output = "<p style='color:red;'>Error: File is too large. Must be under 100000 bytes.</p>";
        } elseif (!is_pdf_mime($tmpPath, $original)) {
            $output = "<p style='color:red;'>Error: File must be a PDF (invalid mime type).</p>";
        } else {

            // Store physically in /files
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $ext = ($ext === "pdf") ? "pdf" : "pdf";

            $unique = bin2hex(random_bytes(8));
            $serverFileName = $unique . ".pdf";

            // Parent of php/ is the app root (same folder as index.php); files/ lives there.
            $filesDirAbs = dirname(__DIR__) . DIRECTORY_SEPARATOR . "files";
            if (!is_dir($filesDirAbs)) {
                @mkdir($filesDirAbs, 0775, true);
            }
            if (!is_dir($filesDirAbs)) {
                $output = "<p style='color:red;'>Error: Server folder <code>files</code> could not be found or created. It must be next to <code>index.php</code> (sibling of the <code>php</code> folder), with permissions the web server can write.</p>";
            } elseif (!is_writable($filesDirAbs)) {
                $output = "<p style='color:red;'>Error: Server folder 'files' is not writable.</p>";
            } else {
                $destAbs = $filesDirAbs . DIRECTORY_SEPARATOR . $serverFileName;
                $dbPath = "files/" . $serverFileName;

                if (!move_uploaded_file($tmpPath, $destAbs)) {
                    $output = "<p style='color:red;'>Error: Upload failed while moving the file.</p>";
                } else {
                    try {
                        $pdo = new Pdo_methods();
                        $sql = "INSERT INTO uploaded_pdfs (file_name, file_path) VALUES (:file_name, :file_path)";
                        $bindings = [
                            ["param" => ":file_name", "value" => $enteredName, "type" => PDO::PARAM_STR],
                            ["param" => ":file_path", "value" => $dbPath, "type" => PDO::PARAM_STR],
                        ];
                        $result = $pdo->otherBinded($sql, $bindings);

                        if (($result["status"] ?? "") === "success") {
                            $output = "<p style='color:green;'>Upload successful.</p>"
                                    . "<p><strong>File name:</strong> " . htmlspecialchars($enteredName, ENT_QUOTES, "UTF-8") . "</p>"
                                    . "<p><strong>File path:</strong> " . htmlspecialchars($dbPath, ENT_QUOTES, "UTF-8") . "</p>";
                        } else {
                            @unlink($destAbs);
                            $msg = htmlspecialchars((string)($result["message"] ?? "Unknown error"), ENT_QUOTES, "UTF-8");
                            $output = "<p style='color:red;'>Database error: {$msg}</p>";
                        }
                    } catch (PDOException $e) {
                        @unlink($destAbs);
                        $output = "<p style='color:red;'>Database connection failed. Check <code>classes/Db_conn.php</code> and that the <code>uploaded_pdfs</code> table exists (see <code>sql/create_uploaded_pdfs.sql</code>).</p>";
                    }
                }
            }
        }
    }
}
