<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Scan Barcode</title>
  <!-- html5-qrcode ships its own ZXing-based decoder -->
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
    #reader { width: 480px; margin: 0 auto; }
    #result { font-size: 1.4rem; text-align: center; margin-top: 1rem; }
  </style>
</head>
<body>
  <h2 style="text-align:center">Point your camera at the barcode</h2>
  <div id="reader"></div>
  <div id="result"></div>
  <p style="text-align:center"><a href="index.php">Home</a></p>

  <script>
    function onScanSuccess(decodedText, decodedResult) {
      document.getElementById('result').innerHTML =
        '<><><><> Decoded: <strong>' + decodedText + '</strong>';
      console.log('Format:', decodedResult.result.format.formatName);
    }

    // Restrict to formats you actually generate; speeds up & reduces false hits
    const formatsToSupport = [
      Html5QrcodeSupportedFormats.QR_CODE,
      Html5QrcodeSupportedFormats.CODE_128,
      Html5QrcodeSupportedFormats.CODE_39,
      Html5QrcodeSupportedFormats.EAN_13,
      Html5QrcodeSupportedFormats.EAN_8,
      Html5QrcodeSupportedFormats.UPC_A,
      Html5QrcodeSupportedFormats.UPC_E
    ];

    const html5QrcodeScanner = new Html5QrcodeScanner(
      "reader",
      {
        fps: 10,
        qrbox: { width: 300, height: 150 },   // wide box for 1D barcodes
        formatsToSupport: formatsToSupport
      },
      /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess);
  </script>
</body>
</html>
