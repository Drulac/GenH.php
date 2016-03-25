<?php
	
namespace PhpGenHTML
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
			$code = '';
			$code .= $this->bodyEnd();
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
	
		public function setAttribut($attribut)
		{
			if (!empty($attribut))
				$this->attribut = $attribut;
			return 1;
		}

		public function code($view)
		{
			$code = '<'.$this->attribut;
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
		public $attribut;
		public $content;
	
		public function __construct($content = '', $array = NULL)
		{
			if (!empty($array))
				$this->array = $array;
			if (!empty($content))
				$this->content = $content;
			return 1;
		}
	
		public function setAttribut($attribut)
		{
			if (!empty($attribut))
				$this->attribut = $attribut;
			return 1;
		}
	
		public function code($view)
		{
			$code = '';
			if(!empty($this->array) || !empty($this->content)){
				$code = '<'.$this->attribut;
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

				$code .= '</'.$this->attribut.'>';
			}
			if($code == '<'.$this->attribut.'></'.$this->attribut.'>')
				$code = '';
			return $code;
		}
	}
	
	class Input extends Element
	{
		public function getCode($view)
		{
			$this->setAttribut('input');
			return $this->code($view);
		}
	}
	
	class Link extends Element
	{
		public function getCode($view)
		{
			$this->setAttribut('link');
			return $this->code($view);
		}
	}

	class Meta extends Element
	{
		public function getCode($view)
		{
			$this->setAttribut('meta');
			return $this->code($view);
		}
	}

	class Img extends Element
	{
		public function getCode($view)
		{
			$this->setAttribut('img');
			return $this->code($view);
		}
	}
	
	class Script extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('script');
			return $this->code($view);
		}
	}
	
	class Style extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('style');
			return $this->code($view);
		}
	}

	class Div extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('div');
			return $this->code($view);
		}
	}

	class Pre extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('pre');
			return $this->code($view);
		}
	}

	class Ul extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('ul');
			return $this->code($view);
		}
	}

	class Li extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('li');
			return $this->code($view);
		}
	}

	class Header extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('header');
			return $this->code($view);
		}
	}

	class Title extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('title');
			return $this->code($view);
		}
	}

	class Head extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('head');
			return $this->code($view);
		}
	}

	class Form extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('form');
			return $this->code($view);
		}
	}

	class Button extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('button');
			return $this->code($view);
		}
	}
	
	class A extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('a');
			return $this->code($view);
		}
	}
	
	class P extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('p');
			return $this->code($view);
		}
	}
	
	class Span extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('span');
			return $this->code($view);
		}
	}
	
	class Strong extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('strong');
			return $this->code($view);
		}
	}
	
	class Em extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('em');
			return $this->code($view);
		}
	}
	
	class Code extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('code');
			return $this->code($view);
		}
	}
	
	class H1 extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('h1');
			return $this->code($view);
		}
	}
	
	class H2 extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('h2');
			return $this->code($view);
		}
	}
	
	class H3 extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('h3');
			return $this->code($view);
		}
	}
	
	class H4 extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('h4');
			return $this->code($view);
		}
	}
	
	class H5 extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('h5');
			return $this->code($view);
		}
	}
	
	class H6 extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('h6');
			return $this->code($view);
		}
	}
	
	class TextArea extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('textarea');
			return $this->code($view);
		}
	}
	
	class Canvas extends Container
	{
		public function getCode($view)
		{
			$this->setAttribut('canvas');
			return $this->code($view);
		}
	}
	
	class Line
	{
		public function getCode($view)
		{
			return '<br>';
		}
	}
}
