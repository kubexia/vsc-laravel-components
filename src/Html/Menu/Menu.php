<?php
namespace VSC\Html\Menu;

use VSC\Html\Factory;

class Menu extends Factory{
    
    public function __construct(array $attributes = []) {
        parent::__construct();
        
        if(count($attributes) > 0){
            $this->attributes($attributes);
        }
        
        if(!isset($this->data['items'])){
            $this->data['items'] = [];
        }
    }
    
    public function item($name, $url = '#', $icon = NULL, array $attributes = []){
        array_push($this->data['items'], ['name' => $name,'route' => $url,'icon' => $icon, 'attributes' => $attributes]);
        return $this;
    }
    
    public function group($name, $icon = '', $callback = NULL){
        array_push($this->data['items'], ['name' => $name, 'icon' => $icon, 'group' => (new Menu())->call($callback)]);
        return $this;
    }
    
    public function divider(){
        array_push($this->data['items'], ['divider' => true]);
        return $this;
    }
    
}