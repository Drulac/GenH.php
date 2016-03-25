<?php
include('view.php');

use PhpGenHTML as V;

$view = New V\View;
echo $view->start();
echo $view->bodyStart();
echo $view->view(array(
	New V\Div(array(
		New V\H1('Sample'),
		New V\H2('Test', array('id' => 'htwo', 'class' => 'test'))
	), array('style' => 'width:100%'))
));
echo $view->end();
