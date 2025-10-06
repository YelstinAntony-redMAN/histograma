<?php 

if (isset($__FILES['imagen'])){
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

        // Guardar como JSON para JavaScript
    file_put_contents('histograma.json', json_encode($data));

    echo "<h2>Histograma generado</h2>";
    echo "<canvas id='grafico' width='800' height='400'></canvas>";
    echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
    echo "<script src='grafico.js'></script>";

} else {
    echo "No se ha recibido ninguna imagen.";
}
?>