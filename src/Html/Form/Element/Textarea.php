<?php
namespace VSC\Html\Form\Element;

use VSC\Html\Factory;

class Textarea extends Factory{
    
    protected static $textareasCount = 0;
    
    public function __construct($type = '', $name = '', $label = '', $value = '', array $attributes = []) {
        parent::__construct();
        
        $this->addData('type', $type);
        $this->addData('value', $value);
        $this->attribute('class', 'form-control');
        $this->attributes(array_merge(['name' => $name],$attributes));
        
        if(strlen($label) > 0){
            $this->addData('label', $label);
        }
        
        if($this->getData('type') === 'tinymce'){
            $this->attributes(['id' => 'txt'.static::$textareasCount, 'class' => 'tinymce-object']);
            static::$textareasCount++;
        }
    }
    
    public function make(){
        return '<textarea '.$this->getParsedAttributes().'>'.$this->getData('value').'</textarea>';
    }
}