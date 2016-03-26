<?php
include('view.php');

use PhpGenHTML as V;

$view = New V\View;
echo $view->start();
echo $view->bodyStart();
echo $view->view([
	New V\Div([
		New V\H1('Sample'),
		New V\H2('Test', ['id' => 'htwo', 'class' => 'test'])
	), ['style' => 'width:100%']]
]);
echo $view->end();
