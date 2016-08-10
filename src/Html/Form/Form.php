<?php
namespace VSC\Html\Form;

use VSC\Html\Factory;

use VSC\Html\Form\Element\Input;
use VSC\Html\Form\Element\Select;
use VSC\Html\Form\Element\Textarea;
use VSC\Html\Button\Button;
use VSC\Html\Button\Group as ButtonGroup;

class Form extends Factory{
    
    protected static $formsCount = 0;
    
    protected $formElementsTypes = [];
    
    public function __construct($method = 'POST', $action = '#', array $attributes = []) {
        parent::__construct();
        
        $this->attributes(['method' => (in_array($method, ['POST','GET']) ? $method : 'POST'),'action' => $action]);
        
        $this->attribute('class', 'formjs');
        
        if(is_null($this->getAttribute('id'))){
            $this->attribute('id', 'form'.static::$formsCount);
        }
        
        if(count($attributes) > 0){
            $this->attributes($attributes);
        }
        
        static::$formsCount++;
        
        $this->input('hidden','_method', '', $method);
        $this->input('hidden', '_token','', csrf_token());
        
        $this->addData('grid', '2:10');
    }
    
    public function grid($value = '2:10'){
        $this->addData('grid', $value);
        return $this;
    }
    
    public function cols($value = '2'){
        $this->addData('cols', $value);
        return $this;
    }
    
    public function input($type = 'text',$name = '', $label = '', $value = '', array $attributes = []){
        $this->formElementsTypes[] = 'input';
        $this->addElement($name, (new Input($type, $name, $label, $value, $attributes)));
        return $this;
    }
    
    public function text($name = '', $label = '', $value = '', array $attributes = []){
        $this->formElementsTypes[] = 'input';
        $this->addElement($name, (new Input('text', $name, $label, $value, $attributes)));
        return $this;
    }
    
    public function password($name = '', $label = '', $value = '', array $attributes = []){
        $this->formElementsTypes[] = 'input';
        $this->addElement($name, (new Input('password', $name, $label, $value, $attributes)));
        return $this;
    }
    
    public function email($name = '', $label = '', $value = '', array $attributes = []){
        $this->formElementsTypes[] = 'input';
        $this->addElement($name, (new Input('email', $name, $label, $value, $attributes)));
        return $this;
    }
    
    public function select($name = '', $label = '', array $options = [], $selected = '', array $attributes = []){
        $this->formElementsTypes[] = 'select';
        $this->addElement($name, (new Select('select',$name, $label, $options, $selected, $attributes)));
        return $this;
    }
    
    public function select2($name = '', $label = '', array $options = [], $selected = '', array $attributes = []){
        $this->formElementsTypes[] = 'select2';
        $this->addElement($name, (new Select('select2',$name, $label, $options, $selected, $attributes)));
        return $this;
    }
    
    public function textarea($name = '', $label = '', $value = '', array $attributes = []){
        $this->formElementsTypes[] = 'textarea';
        $this->addElement($name, (new Textarea('textarea',$name, $label, $value, $attributes)));
        return $this;
    }
    
    public function tinymce($name = '', $label = '', $value = '', array $attributes = []){
        $this->formElementsTypes[] = 'tinymce';
        $this->addElement($name, (new Textarea('tinymce',$name, $label, $value, $attributes)));
        return $this;
    }
    
    public function button($type = '', $name = '', array $attributes = []){
        $this->prependData('buttons', $type, (new Button($type, $name, $attributes)));
        return $this;
    }
    
    public function buttons($callable){
        call_user_func_array($callable,[$this]);
        return $this;
    }
    
    public function buttonsGroup($callable, $name = 'buttonsGroup', array $attributes = []){
        $this->prependData($name, (new ButtonGroup($attributes))->call($callable));
        return $this;
    }
    
    public function datalist(){
        
    }
    
    public function optgroup(){
        
    }
    
    public function fieldset(){
        
    }
    
    public function legend(){
        
    }
    
    public function hasElementType(){
        foreach(func_get_args() as $item){
            if(in_array($item, $this->formElementsTypes)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    public function make($template = 'horizontal'){
        return view('components.forms.form_'.$template,['form' => $this])
            ->__toString();
    }
    
}