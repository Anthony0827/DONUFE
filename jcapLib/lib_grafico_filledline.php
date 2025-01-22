<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

if (array_key_exists('titulo', $_REQUEST)) {
	$titulo = $_REQUEST['titulo'];
} else {
	$titulo = $_SESSION['titulo'];
}

if (array_key_exists('ydata', $_REQUEST)) {
	$ydata = $_REQUEST['ydata'];
} else {
	$ydata = $_SESSION['ydata'];
}

if (array_key_exists('xdata', $_REQUEST)) {
	$xdata = $_REQUEST['xdata'];
} else {
	$xdata = $_SESSION['xdata'];
}

if (count(explode(",", $ydata)) < 2) {
    $ydata = '0,'.$ydata;
    $xdata = ','.$xdata;
}
$ydata = explode(",", $ydata);
$labels = explode(",", $xdata);

$graph = new Graph(300,200);
$graph->img->SetMargin(40,40,40,40);	
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->title->Set($titulo);
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->Set("Fechas");
$graph->xaxis->SetTickLabels($labels);
$graph->yaxis->title->Set("Valores");
//$graph->subtitle->Set("(Starting from Y=0)");

$graph->yaxis->scale->SetAutoMin(0);

$p1 = new LinePlot($ydata);
$p1->SetFillColor("orange");
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("red");
$p1->mark->SetWidth(4);
$graph->Add($p1);

$graph->Stroke();
?>
