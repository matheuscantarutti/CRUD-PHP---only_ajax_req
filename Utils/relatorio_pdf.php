<?php
    require_once 'dompdf/autoload.inc.php';
    include_once "dompdf/lib/Cpdf.php";
    Use Dompdf\Dompdf;
    Use Dompdf\Options;
    $options = new Options();
    $dompdf = new Dompdf();
    $options->setIsHtml5ParserEnabled(true);
    $model = $_GET["model"];
    $url = "../Views/index_".$model.".php";
    $title = $model."s.pdf";
    //lendo o arquivo HTML correspondente
    $html = file_get_contents($url);
    //inserindo o HTML que queremos converter
    $dompdf->loadHtml($html);
    // Definindo o papel e a orientaчуo
    $dompdf->setPaper('A4');
    // Renderizando o HTML como PDF
    $dompdf->render();
    // Enviando o PDF para o browser
    $dompdf->stream($title);
?>