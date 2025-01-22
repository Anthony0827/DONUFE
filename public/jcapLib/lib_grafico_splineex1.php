<?php // content="text/plain; charset=utf-8"
session_start();
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_line.php');
	require_once ('jpgraph/jpgraph_scatter.php');
	require_once ('jpgraph/jpgraph_regstat.php');

	// Original data points
	if (array_key_exists('titulo', $_REQUEST)) {
		$titulo = $_REQUEST['titulo'];
	} else {
		$titulo = $_SESSION['titulo'];
	}

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
	$labels = $xdata;
	// Get the interpolated values by creating
	// a new Spline object.
	//$spline = new Spline($xdata,$ydata);

	// For the new data set we want 40 points to
	// get a smooth curve.
	//list($newx,$newy) = $spline->Get(50);

	// Create the graph
	$graph = new Graph(400,300);
	$graph->SetScale("textint");
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->Set("Fechas");
	$graph->xaxis->SetTickLabels($labels);
	$graph->yaxis->title->Set("Valores");

	$p1 = new LinePlot($ydata);
	$p1->mark->SetType(MARK_FILLEDCIRCLE);
	$p1->mark->SetFillColor("red");
	$p1->mark->SetWidth(2);
	$p1->SetColor("blue");
	$p1->SetCenter();

	$graph->Add($p1);
	$graph->Stroke();

	/*
	$g = new Graph(300,200);
	$g->clearTheme();
	$g->SetMargin(30,20,40,30);
	$g->title->Set($title);
	$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
	*/
	//$g->subtitle->Set('(Control points shown in red)');
	//$g->subtitle->SetColor('darkred');
	//$g->SetMarginColor('lightblue');
	//$g->SetPlotGradient('white','darkred:0.6', 11);
	//$g->img->SetAntiAliasing();

	// We need a linlin scale since we provide both
	// x and y coordinates for the data points.
	//$g->SetScale('linlin');
	//$g->SetScale('datlin'); 

	// We want 1 decimal for the X-label
	// $g->xaxis->SetLabelFormat('%1.1f');

	// We use a scatterplot to illustrate the original
	// contro points.
/*
	$splot = new ScatterPlot($ydata,$xdata);

	//
	$splot->mark->SetFillColor('red@0.3');
	$splot->mark->SetColor('red@0.5');

	// And a line plot to stroke the smooth curve we got
	// from the original control points
	$lplot = new LinePlot($newy,$newx);
	$lplot->SetColor('navy');
	//$lplot->SetColor("blue");
	$lplot->SetFillGradient('red','yellow');
	// Add the plots to the graph and stroke
	$g->Add($lplot);
	$g->Add($splot);
	return $g->Stroke();
	*/

?>
