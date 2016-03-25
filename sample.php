<?php
include('view.php');

use PhpGenHTML as V;

$view = New V\View;
echo $view->start();
echo $view->view(array(
	New V\Head(array(
		New V\Title('View all statistiques'),
		New V\Script('', array('src' => 'Chart.js')),
		New V\Meta(array('name' => 'viewport', 'content' => 'initial-scale = 1, user-scalable = no'))
	))
));
echo $view->bodyStart();
echo $view->view(array(
	New V\Div(array(
		New V\Canvas('', array('id' => 'canvas', 'height' => 450, 'width' => 450)),
		New V\Canvas('', array('id' => 'chart-area', 'height' => 300, 'width' => 300))
	), array('style' => 'width:100%'))
));
echo $view->end();
