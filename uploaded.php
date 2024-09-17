<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lainhost</title>
    <style>
        * {
            text-align: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['message']) && !empty($_GET['message'])) {
        $message = htmlspecialchars($_GET['message']); // Sanitize input to prevent XSS
    } else {
        $message = "No message provided.";
    }
    ?>
    
    <h1>Lainhost</h1>
    <p><?php echo $message; ?></p>
    <a href="http://localhost:8000">[Upload another]</a>
</body>
</html>
