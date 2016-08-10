<?php
namespace VSC\Html\Button;

use VSC\Html\Factory;

class Button extends Factory{
    
    public function __construct($type = '', $name = '', array $attributes = []) {
        parent::__construct();
        
        $this->addData('type', $type);
        $this->addData('name', $name);
        if(count($attributes) > 0){
            $this->attributes($attributes);
        }
    }
    
    public function make(){
        switch($this->getData('type')){
            case "submit":
                $this->attributes(['type' => 'submit','class' => 'btn btn-primary formjs-event-binder', 'data-event' => 'submitForm']);
                break;
            
            default:
                $this->attributes(['type' => 'button','class' => 'btn btn-default formjs-event-binder']);
                break;
        }
        return '<button '.$this->getParsedAttributes().'>'.$this->getData('name').'</button>';
    }
    
    
    
}