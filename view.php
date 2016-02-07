<?php
$view = New VIEW();
echo $view->start();
class VIEW{
	private $level;
	private $html_start = 0;
	private $head_start = 0;
	private $body_start = 0;
	public function start(){
		if(!$this->html_start){
			$code = '<!DOCTYPE html>'."\n".'<html>';
			$this->html_start = 1;
			$this->level_up();
			return $code;
		}
		return '';
		}
	public function end(){
		$code = '';
		if($this->body_start){
			$code .= "\n".$this->level.'</body>';
			$this->body_start = 0;
			$this->level_down();
		}
		if($this->html_start){
			$this->html_start = 0;
			$this->level_down();
			$code .= "\n".$this->level.'</html>';
		}
		return $code;
		}
	public function body_start(){
		if(!$this->body_start){
			$code = '';
			$code .= "\n".$this->level.'<body>';
			$this->body_start = 1;
			$this->level_up();
			return $code;
		}
		return '';
		}
	public function body_end(){
		if($this->body_start){
			$code = '';
			$this->level_down();
			$code .= "\n".$this->level.'</body>';
			$this->body_start = 0;
			return $code;
		}
		return '';
		}
	public function formulaire($array, $infos){
		$code = "\n".$this->level.'<form';
		foreach($infos as $cle => $element)
		{
			$code .= ' '.$cle.'="'.$element.'"';
		}
		$code .= '>';
		$i = 0;
		$c = count($array);
		$this->level_up();
		while($i < $c){
			$code .= "\n".$this->level.$array[$i]->GetCode();
			$i++;
		}
		$this->level_down();
		$code .= "\n".$this->level.'</form>';
		return $code;
		}
	public function erreur($texte){
		return $this->div(array(
			new texte(null, $texte)
		), array(
			'class' => 'erreur'
		));
		}
	public function div($array, $infos){
		$code = "\n".$this->level.'<div';
		if(!empty($infos)){
			foreach($infos as $cle => $element)
			{
				$code .= ' '.$cle.'="'.$element.'"';
			}
		}
		$code .= '>';
		$i = 0;
		$c = count($array);
		$this->level_up();
		while($i < $c){
			$code .= "\n".$this->level.$array[$i]->GetCode();
			$i++;
		}
		$this->level_down();
		$code .= "\n".$this->level.'</div>';
		return $code;
		}
	
	private function level_up(){
		$this->level .= "\t";
		}
	private function level_down(){
		$this->level = substr($this->level, 0, -1);
		}
	}
class input{
	public $array;
	public function __construct($array){
		if(!empty($array))
			$this->array = $array;
		if(empty($array['type'])){
			$this->array['type'] = 'text';
		}
		return 1;
		}
	public function GetCode(){
		$code = '<input';
		if(!empty($this->array)){
			foreach($this->array as $cle => $element)
			{
				$code .= ' '.$cle.'="'.$element.'"';
			}
		}
		$code .= '>';
		return $code;
		}
	}
class lien{
	public $array;
	public $texte = '';
	public function __construct($array, $texte = ''){
		if(!empty($array))
			$this->array = $array;
		if(!empty($texte))
			$this->texte = $texte;
		return 1;
		}
	public function GetCode(){
		$code = '<a';
		if(!empty($this->array)){
			foreach($this->array as $cle => $element)
			{
				$code .= ' '.$cle.'="'.$element.'"';
			}
		}
		$code .= '>'.htmlspecialchars($this->texte).'</a>';
		return $code;
		}
	}
class texte{
	public $array;
	public $texte = '';
	public function __construct($array, $texte = ''){
		if(!empty($array))
			$this->array = $array;
		if(!empty($texte))
			$this->texte = $texte;
		return 1;
		}
	public function GetCode(){
		$code = '<p';
		if(!empty($this->array)){
			foreach($this->array as $cle => $element)
			{
				$code .= ' '.$cle.'="'.$element.'"';
			}
		}
		$code .= '>'.htmlspecialchars($this->texte).'</p>';
		return $code;
		}
	}
class textarea{
	public $array;
	public $texte = '';
	public function __construct($array, $texte = ''){
		if(!empty($array))
			$this->array = $array;
		if(!empty($texte))
			$this->texte = $texte;
		return 1;
		}
	public function GetCode(){
		$code = '<textarea';
		if(!empty($this->array)){
			foreach($this->array as $cle => $element)
			{
				$code .= ' '.$cle.'="'.$element.'"';
			}
		}
		$code .= '>'.htmlspecialchars($this->texte).'</textarea>';
		return $code;
		}
	}
class ligne{
	public function GetCode(){
		return '<br>';
		}
	}
