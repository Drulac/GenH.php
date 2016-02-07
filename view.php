<?php
    
namespace PhpGenHTML

{
    
    class View
    {
    
        private $level;
        private $html_start = 0;
        private $head_start = 0;
        private $body_start = 0;
    
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
            if ($this->body_start) {
                $code .= "\n".$this->level.'</body>';
                $this->body_start = 0;
                $this->level_down();
            }
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
                $code .= "\n".$this->level.'<body>';
                $this->body_start = 1;
                $this->level_up();
                return $code;
            }
            return '';
        }
    
        public function bodyEnd()
        {
            if ($this->body_start) {
                $code = '';
                $this->level_down();
                $code .= "\n".$this->level.'</body>';
                $this->body_start = 0;
                return $code;
            }
            return '';
        }
    
        public function form($array, $infos)
        {
            $code = "\n".$this->level.'<form';
    
            foreach ($infos as $cle => $element) {
                $code .= ' '.$cle.'="'.$element.'"';
            }
            $code .= '>';
    
            $i = 0;
            $c = count($array);
    
            $this->levelUp();
    
            while ($i < $c) {
                $code .= "\n".$this->level.$array[$i]->getCode();
    
                $i++;
            }
    
            $this->levelDown();
    
            $code .= "\n".$this->level.'</form>';
            return $code;
        }
    
        public function error($texte)
        {
            return $this->div(array(
                new texte(null, $texte)
            ), array(
                'class' => 'erreur'
            ));
        }
    
        public function div($array, $infos)
        {
            $code = "\n".$this->level.'<div';
            if (!empty($infos)) {
                foreach ($infos as $cle => $element) {
                    $code .= ' '.$cle.'="'.$element.'"';
                }
            }
            $code .= '>';
    
            $i = 0;
            $c = count($array);
    
            $this->level_up();
    
            while ($i < $c) {
                $code .= "\n".$this->level.$array[$i]->getCode();
    
                $i++;
            }
    
            $this->level_down();
    
            $code .= "\n".$this->level.'</div>';
            return $code;
        }
    
        
    
    
        private function levelUp()
        {
            $this->level .= "\t";
        }
    
        private function levelDown()
        {
            $this->level = substr($this->level, 0, -1);
        }
    }

    class Element
    {
        public $array;
    
        public function __construct($array, $texte = '')
        {
            if (!empty($array))
                $this->array = $array;
            if (!empty($texte))
                $this->texte = $texte;
            return 1;
        }
    }
    
    class Input
    {
        public $array;
    
        public function __construct($array)
        {
            if (!empty($array))
                $this->array = $array;
            if (empty($array['type'])) {
                $this->array['type'] = 'text';
            }
            return 1;
        }
    
        public function getCode()
        {
            $code = '<input';
            if (!empty($this->array)) {
                foreach ($this->array as $cle => $element) {
                    $code .= ' '.$cle.'="'.$element.'"';
                }
            }
            $code .= '>';
            return $code;
        }
    }
    
    class Link extends Element
    {
        public $texte = '';
    
        public function getCode()
        {
            $code = '<a';
            if (!empty($this->array)) {
                foreach ($this->array as $cle => $element) {
                    $code .= ' '.$cle.'="'.$element.'"';
                }
            }
            $code .= '>'.htmlspecialchars($this->texte).'</a>';
            return $code;
        }
    }
    
    class Text extends Element
    {
        public $texte = '';
    
        public function getCode()
        {
            $code = '<p';
            if (!empty($this->array)) {
                foreach ($this->array as $cle => $element) {
                    $code .= ' '.$cle.'="'.$element.'"';
                }
            }
            $code .= '>'.htmlspecialchars($this->texte).'</p>';
            return $code;
        }
    }
    
    class TextArea extends Element
    {
        public $texte = '';
    
        public function getCode()
        {
            $code = '<textarea';
            if (!empty($this->array)) {
                foreach ($this->array as $cle => $element) {
                    $code .= ' '.$cle.'="'.$element.'"';
                }
            }
            $code .= '>'.htmlspecialchars($this->texte).'</textarea>';
            return $code;
        }
    }
    
    class Line extends Element
    {
        public function getCode()
        {
            return '<br>';
        }
    }
}
