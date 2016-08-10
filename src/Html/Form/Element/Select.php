<?php
namespace VSC\Html\Form\Element;

use VSC\Html\Factory;

class Select extends Factory{
    
    public function __construct($type = '', $name = '', $label = '', array $options = [], $selected = '', array $attributes = []) {
        parent::__construct();
        
        $this->addData('type', $type);
        $this->addData('options', $options);
        $this->addData('selected', $selected);
        $this->attribute('class', 'form-control');
        $this->attributes(array_merge(['name' => $name],$attributes));
        
        if(strlen($label) > 0){
            $this->addData('label', $label);
        }
    }
    
    public function getOptions(){
        return join("", array_map(function($item){
            return '<option value="'.$item['value'].'">'.$item['label'].'</option>';
        }, ($this->getData('options') ? $this->getData('options') : [])));
    }
    
    public function make(){
        if($this->getData('type') === 'select2'){
            $this->attribute('class', 'sel2');
        }
        return '<select '.$this->getParsedAttributes().'>'.$this->getOptions().'</select>';
    }
}