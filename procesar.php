<?php

if (isset($_FILES['imagen'])) {
    $archivo = $_FILES["imagen"]["tmp_name"];
    $info = getimagesize($archivo);
    $tipo = $info["mime"];

    switch ($tipo) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($archivo);
            break;
        case 'image/png':
            $img = imagecreatefrompng($archivo);
            break;
        default:
            die("Solo se admiten imágenes JPG o PNG.");
    }

    $ancho = imagesx($img);
    $alto = imagesy($img);

    $histR = array_fill(0, 256, 0);
    $histG = array_fill(0, 256, 0);
    $histB = array_fill(0, 256, 0);

    for ($x = 0; $x < $ancho; $x++) {
        for ($y = 0; $y < $alto; $y++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            $histR[$r]++;
            $histG[$g]++;
            $histB[$b]++;
        }
    }

    imagedestroy($img);

    $data = [
        'R' => $histR,
        'G' => $histG,
        'B' => $histB
    ];

    // Guardar el histograma en JSON
    $ruta_json = __DIR__ . '/histograma.json';
    if (file_put_contents($ruta_json, json_encode($data)) === false) {
        die("❌ Error: no se pudo crear el archivo histograma.json en $ruta_json");
    }

    echo "<h2>✅ Histograma generado correctamente</h2>";
    echo "<canvas id='grafico' width='800' height='400'></canvas>";
    echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
    echo "<script src='grafico.js'></script>";

} else {
    echo "No se ha recibido ninguna imagen.";
}
?>
