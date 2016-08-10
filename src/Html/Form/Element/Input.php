<?php
namespace VSC\Html\Form\Element;

use VSC\Html\Factory;

class Input extends Factory{
    
    public function __construct($type = 'text', $name = '', $label = '', $value = '', array $attributes = []) {
        parent::__construct();
        
        $this->addData('type', $type);
        $this->attribute('class', 'form-control');
        $this->attributes(array_merge(['type' => $type, 'name' => $name, 'value' => $value],$attributes));
        
        if(strlen($label) > 0){
            $this->addData('label', $label);
        }
    }
    
    public function make(){
        return '<input '.$this->getParsedAttributes().'>';
    }
}