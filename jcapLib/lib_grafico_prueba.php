<?php // content="text/plain; charset=utf-8"
session_start();
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_log.php');
require_once ('jpgraph/jpgraph_line.php');

if (array_key_exists('ydata', $_REQUEST)) {
	$ydata = explode(",", $_REQUEST['ydata']);
} else {
	$ydata = explode(",", $_SESSION['ydata']);
}

if (array_key_exists('xdata', $_REQUEST)) {
	$xdata = explode(",", $_REQUEST['xdata']);
} else {
	$xdata = explode(",", $_SESSION['xdata']);
}


//$ydata = array(11,3,8,42,5,1,9,13,5,7);
//$xdata = array("Jan","Feb","Mar","Apr","Maj","Jun","Jul","aug","Sep","Oct");

// Create the graph. These two calls are always required
$graph = new Graph(350,200);
$graph->clearTheme();
$graph->SetScale("textlog");

$graph->img->SetMargin(40,110,20,50);
$graph->SetShadow();

$graph->ygrid->Show(true,true);
$graph->xgrid->Show(true,false);

// Specify the tick labels
$a = $gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels($a);
//$graph->xaxis->SetTextLabelInterval(2);
$graph->xaxis->SetLabelAngle(90);

// Create the linear plot
$lineplot=new LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

$graph->title->Set("Examples 9");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$lineplot->SetColor("blue");
$lineplot->SetWeight(2);

$graph->yaxis->SetColor("blue");

$lineplot->SetLegend("Plot 1");

$graph->legend->Pos(0.05,0.5,"right","center");

// Display the graph
$graph->Stroke();
?>
