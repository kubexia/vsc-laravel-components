<?php
namespace VSC\Html\Button;

use VSC\Html\Factory;
use VSC\Html\Button\Button;

class Group extends Factory{
    
    public function __construct(array $attributes = []) {
        parent::__construct();
        if(count($attributes) > 0){
            $this->attributes($attributes);
        }
    }
    
    public function button($type = '', $name = '', array $attributes = []){
        $this->addElement($type, (new Button($type, $name, $attributes)));
        return $this;
    }
    
}