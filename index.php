<?php
session_start();
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    define('SITE_URL', 'http://localhost:8000');
    define('MAX_FILE_SIZE', 15 * 1024 * 1024);
    define('ALLOWED_TYPES', ['image/png', 'image/jpg', 'image/jpeg']);
    define('UPLOAD_DIR', 'u/');
    define('LOG_FILE', 'uploads.log');
}

function uploadFile() {
    global $output;

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $output = 'ERROR: No file uploaded or upload failed!';
        return;
    }

    $file = $_FILES['file'];

    if (!in_array($file['type'], ALLOWED_TYPES)) {
        $output = 'ERROR: Only PNG and JPG/JPEG formats are supported!';
        return;
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        $output = 'ERROR: Max file size is ' . (MAX_FILE_SIZE / 1024 / 1024) . ' megabytes!';
        return;
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $uniqueId = bin2hex(random_bytes(5));
    $newFileName = $uniqueId . '.' . $ext;
    $uploadPath = UPLOAD_DIR . $newFileName;

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $output = 'ERROR: Failed to save the file. Please try again.';
        return;
    }

    $fileUrl = SITE_URL . '/' . UPLOAD_DIR . $newFileName;
    $output = "Your file has been uploaded successfully. It's available at: " . $fileUrl;

    logUpload($newFileName, $file['type'], $file['size']);

    $_SESSION['last_upload'] = $fileUrl;
    header('Location: uploaded.php');
    exit;
}

function logUpload($fileName, $fileType, $fileSize) {
    $logEntry = date('Y-m-d H:i:s') . " | $fileName | $fileType | $fileSize bytes\n";
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    uploadFile();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lainhost - Simple File Hosting</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold mb-4 text-center">Lainhost</h1>
        <p class="text-gray-600 mb-6 text-center">The simplest PHP file-hosting service ever made</p>
        
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div class="flex flex-col items-center">
                <label for="file" class="mb-2 font-semibold">Upload your file here:</label>
                <input type="file" name="file" id="file" class="border p-2 w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                Upload
            </button>
        </form>

        <?php if (isset($output)): ?>
            <div class="mt-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                <?php echo htmlspecialchars($output); ?>
            </div>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="https://github.com/unwireddd/lainbox" class="text-blue-500 hover:underline">[Open Source]</a>
        </div>
    </div>
</body>
</html>