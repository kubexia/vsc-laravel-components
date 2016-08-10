<?php
namespace VSC\Html;

class Factory{
    
    protected $data = [];
    
    public function __construct() {
        
    }
    
    public function attribute($key, $value){
        if($key === 'class' && isset($this->data['attributes']['class'])){
            $value = $this->data['attributes']['class'].' '.$value;
        }
        $this->data['attributes'][$key] = $value;
        return $this;
    }
    
    public function getAttribute($key){
        return (isset($this->data['attributes'][$key]) ? $this->data['attributes'][$key] : NULL);
    }
    
    public function addAttribute($key,$value){
        return $this->attribute($key, $value);
    }
    
    public function addAttributes(array $array){
        return $this->attributes($array);
    }
    
    public function attributes(array $array){
        foreach($array as $key => $value){
            $this->attribute($key, $value);
        }
        
        return $this;
    }
    
    public function getAttributes(){
        return (isset($this->data['attributes']) ? $this->data['attributes'] : []);
    }
    
    public function getParsedAttributes(){
        $array = [];
        foreach($this->getAttributes() as $key => $value){
            $array[] = $key.'="'.$value.'"';
        }
        return join(' ', $array);
    }
    
    public function addElement($key, $element){
        $this->data['elements'][$key] = $element;
        return $this;
    }
    
    public function getElement($key){
        return (isset($this->data['elements'][$key]) ? $this->data['elements'][$key] : NULL);
    }
    
    public function getElements(){
        return (isset($this->data['elements']) ? $this->data['elements'] : []);
    }
    
    public function addData($name, $value){
        $this->data[$name] = $value;
        return $this;
    }
    
    public function prependData($key, $item, $value = NULL){
        if(is_array($item) || is_object($item)){
            $this->data[$key] = $item;
        }
        else{
            $this->data[$key][$item] = $value;
        }
        return $this;
    }
    
    public function getData($name){
        return (isset($this->data[$name]) ? $this->data[$name] : NULL);
    }
    
    public function hasData(){
        foreach(func_get_args() as $name){
            if(array_key_exists($name, $this->data)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    public function call($callable){
        call_user_func_array($callable, [$this]);
        return $this;
    }
    
}