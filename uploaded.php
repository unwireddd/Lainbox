<?php
session_start();

if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    define('SITE_URL', 'http://localhost:8000');
}

if (!isset($_SESSION['last_upload'])) {
    header('Location: index.php');
    exit;
}

$fileUrl = $_SESSION['last_upload'];
unset($_SESSION['last_upload']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Uploaded - Lainhost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-4">Lainhost</h1>
        <p class="text-green-600 mb-4">Your file has been uploaded successfully!</p>
        <div class="bg-gray-100 p-4 rounded mb-4">
            <p class="text-sm break-all">File URL: <a href="<?php echo htmlspecialchars($fileUrl); ?>" class="text-blue-500 hover:underline" target="_blank"><?php echo htmlspecialchars($fileUrl); ?></a></p>
        </div>
        <button onclick="copyToClipboard('<?php echo htmlspecialchars($fileUrl); ?>')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Copy URL to Clipboard
        </button>
        <a href="index.php" class="block mt-4 text-blue-500 hover:underline">[Upload Another File]</a>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('URL copied to clipboard!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
    </script>
</body>
</html>