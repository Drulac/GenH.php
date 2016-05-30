<?php
namespace GenH
{
	class View
	{
		private $level;
		private $html_start = 0;
		private $head_start = 0;
		private $body_start = 0;
		private $debug = 0;
	
		public function debug($var, $line)
		{
			echo 'ligne '.$line.' : debug N°'.$this->debug.' : ';
			$this->debug++;
			var_dump($var);
			echo '<br><br>';
		}
	
		public function start()
		{
			if (!$this->html_start) {
				$code = '<!DOCTYPE html>'."\n".'<html>';
				$this->html_start = 1;
				$this->levelUp();
				return $code;
			}
			return '';
		}
	
		public function end()
		{
			$code = $this->bodyEnd();
			if ($this->html_start) {
				$this->html_start = 0;
				$this->levelDown();
				$code .= "\n".$this->level.'</html>';
			}
			return $code;
		}
		
		public function bodyStart()
		{
			if (!$this->body_start) {
				$code = '';
				$code .= "\n".$this->level().'<body>';
				$this->body_start = 1;
				return $code;
			}
			return '';
		}
	
		public function bodyEnd()
		{
			if ($this->body_start) {
				$code = '';
				$code .= "\n".$this->level().'</body>';
				$this->body_start = 0;
				return $code;
			}
			return '';
		}
		public function view($array)
		{
			$code = '';
			if (gettype($array) == 'array') {
				$i = 0;
				$c = count($array);
		
				$this->levelUp();
		
				while ($i < $c) {
					if (gettype($array[$i]) == 'object') {
						$add = $array[$i]->getCode($this);
						if(!empty($add))
							$code .= "\n".$this->level.$add;
					}else if (gettype($array[$i]) == 'string') {
						$add = $array[$i];
						if(!empty($add))
							$code .= "\n".$this->level.$add;
					}
					$i++;
				}
		
				$this->levelDown();
			}else if (!empty($array) && gettype($array) == 'string'){
				$code .= htmlspecialchars($array);
			}else if (!empty($array) && gettype($array) == 'object'){
				if (gettype($array) == 'object') {
					$add = $array->getCode($this);
					if(!empty($add))
						$code .= "\n".$this->level.$add;
				}else if (gettype($array) == 'string') {
					$add = $array;
					if(!empty($add))
						$code .= "\n".$this->level.$add;
				}
			}
			//$this->debug($array, __LINE__);//l'entrée
			//$this->debug($code, __LINE__);//la sortie
			return $code;
		}
 
		public function error($texte)
		{
			return $this->view(array(0 => 
				New Div(array(
					new P($texte),
					new Img(array('src' => '/images/warning.png', 'alt' => 'erreur'))
				), array('class' => 'erreur'))
			));
		}
		private function levelUp()
		{
			$this->level .= "\t";
		}
	
		private function levelDown()
		{
			$this->level = substr($this->level, 0, -1);
		}
	
		public function level()
		{
			return $this->level;
		}
	}
	//__construct($array)
	class Element
	{
		public $array;
		public $attribut;
	
		public function __construct($array = NULL)
		{
			if (!empty($array))
				$this->array = $array;
			return 1;
		}
		public function getAttribut()
		{
			if(!empty($this->attribut))
			{
				return $this->attribut;
			}else{
				$class = get_class($this);
				$this->attribut = explode('\\' , strtolower($class))[1];
				return $this->attribut;
			}
		}
		public function getCode($view)
		{
			$code = '<'.$this->getAttribut();
			if (!empty($this->array)) {
				if (gettype($this->array) == 'array'){
					foreach ($this->array as $cle => $element) {
						$code .= ' '.$cle.'="'.$element.'"';
					}
				}else{
					$code .= htmlspecialchars($this->array);
				}
			}
			$code .= '>';
			return $code;
		}
	}
	//__construct($content, $array)
	class Container
	{
		public $array;
		private $attribut;
		public $content;
	
		public function __construct($content = '', $array = NULL)
		{
			if (!empty($array))
				$this->array = $array;
			if (!empty($content))
				$this->content = $content;
			return 1;
		}
		public function getAttribut()
		{
			if(!empty($this->attribut))
			{
				return $this->attribut;
			}else{
				$class = get_class($this);
				$this->attribut = explode('\\' , strtolower($class))[1];
				return $this->attribut;
			}
		}
	
		public function getCode($view)
		{
			$code = '';
			if(!empty($this->array) || !empty($this->content)){
				$code = '<'.$this->getAttribut();
				if (!empty($this->array)) {
					foreach ($this->array as $cle => $element) {
						if (!empty($element) && !empty($cle))
							$code .= ' '.$cle.'="'.$element.'"';
					}
				}
				$code .= '>';
				if(gettype($this->content) == 'string'){
					$code .= "\n".$view->level()."\t".htmlspecialchars($this->content)."\n".$view->level();
				}else{
					$add = $view->view($this->content);
					$code .= $add."\n".$view->level();
				}
				$code .= '</'.$this->getAttribut().'>';
			}
			if($code == '<'.$this->getAttribut().'></'.$this->getAttribut().'>')
				$code = '';
			return $code;
		}
	}
	
	class Input extends Element{}
	class Link extends Element{}
	class Meta extends Element{}
	class Img extends Element{}
	class Script extends Container{}
	class Style extends Container{}
	class Div extends Container{}
	class Pre extends Container{}
	class Ul extends Container{}
	class Li extends Container{}
	class Header extends Container{}
	class Title extends Container{}
	class Head extends Container{}
	class Form extends Container{}
	class Button extends Container{}
	class A extends Container{}
	class P extends Container{}
	class Span extends Container{}
	class Strong extends Container{}
	class Em extends Container{}
	class Code extends Container{}
	class H1 extends Container{}
	class H2 extends Container{}
	class H3 extends Container{}
	class H4 extends Container{}
	class H5 extends Container{}
	class H6 extends Container{}
	class TextArea extends Container{}
	class Canvas extends Container{}
	class Line
	{
		public function getCode($view)
		{
			return '<br>';
		}
	}
}
