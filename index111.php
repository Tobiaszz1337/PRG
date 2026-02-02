if (isset($_FILES["soubor"])) {

    $maxSize = 1 * 1024 * 1024; // 1 MB
    $allowedTypes = ["png", "jpg", "jpeg"];

    $type = strtolower(pathinfo($_FILES["soubor"]["name"], PATHINFO_EXTENSION));
    $lokace = $_FILES["soubor"]["tmp_name"];
    $nazev = $_POST["nazev_souboru"];
    $velikost = $_FILES["soubor"]["size"];

    if ($velikost > $maxSize) {
        die("❌ Soubor je větší než 1 MB.");
    }

    if (!in_array($type, $allowedTypes)) {
        die("❌ Povolené jsou pouze soubory PNG a JPG/JPEG.");
    }

    $uploads = __DIR__ . "/uploads/";
    $new_file = $uploads . $nazev . "." . $type;

    // Přesun souboru z dočasné na trvalou lokaci
    move_uploaded_file($lokace, $new_file);
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">

    <label for="nazev_souboru">Pojmenování</label>
    <input type="text" name="nazev_souboru" required>

    <label for="soubor">Nahraj fotku</label>
    <input type="file" name="soubor" accept="image/png, image/jpeg" required>

    <input type="submit" value="Odeslat">

</form>

<h1>Nahrané</h1>
<div style="display: flex; gap: 10px; flex-wrap: wrap;">
<?php
$files = scandir(__DIR__ . "/uploads");
foreach ($files as $i => $file){
    if ($i < 2) continue;
    echo "<img style='border-radius: 3px; max-width: 30%' src='uploads/$file' />";
}
?>
</div>

</body>
</html>
