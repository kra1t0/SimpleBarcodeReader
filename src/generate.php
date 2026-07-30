<?php
require __DIR__ . '/vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$text = $_GET["text"] ?? "081231723897";

// TYPE_CODE_128 supports the full ASCII set; also available:
// TYPE_EAN_13, TYPE_EAN_8, TYPE_CODE_39, TYPE_QR_CODE, etc.
$generator = new BarcodeGeneratorPNG();

// If the request asks for raw image, stream it directly
if (isset($_GET["raw"])) {
    header("Content-Type: image/png");
    echo $generator->getBarcode($text, $generator::TYPE_CODE_128, 3, 50);
    exit();
}

// Otherwise show a friendly page with the barcode embedded (base64)
$png = $generator->getBarcode($text, $generator::TYPE_CODE_128, 3, 50);
$b64 = base64_encode($png);
?>
<!DOCTYPE html>
<html><head><title>Generated Barcode</title></head>
<body>
  <h1>Barcode for: <?= htmlspecialchars($text) ?></h1>
  <img src="data:image/png;base64,<?= $b64 ?>" alt="barcode" />
  <p>
    <a href="generate.php?text=<?= urlencode(
        $text,
    ) ?>&raw=1">Direct image link</a> |
    <a href="scan.php">Scan it</a> |
    <a href="index.php">Home</a>
  </p>
  <form method="get">
    <input type="text" name="text" value="<?= htmlspecialchars($text) ?>">
    <button type="submit">Regenerate</button>
  </form>
</body></html>
