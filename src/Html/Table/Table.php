<?php
namespace VSC\Html\Table;

use VSC\Html\Factory;

class Table extends Factory{
    
    public function __construct($results, array $options = [], array $attributes = []) {
        parent::__construct();
        
        $this->addData('results', $results);
        $this->addData('options', $options);
        
        if(isset($options['baseurl'])){
            $this->attribute('data-baseurl', (is_callable($options['baseurl']) ? call_user_func_array($options['baseurl'], []) : $options['baseurl']));
        }
        
        if(count($attributes) > 0){
            $this->attributes($attributes);
        }
    }
    
    public function getColumns(){
        $array = [];
        foreach($this->getData('columns') as $key => $item){
            $array[$key] = ['name' => (strlen($item['name']) === 0 ? $key : $item['name'])];
        }
        return $array;
    }
    
    public function getColumn($name){
        return (isset($this->getData('columns')[$name]) ? $this->getData('columns')[$name] : NULL);
    }
    
    public function getResults(){
        return $this->getData('results');
    }
    
    public function getOption($name){
        return (isset($this->data['options'][$name]) ? $this->data['options'][$name] : NULL);
    }
    
    public function getOptions(array $include = []){
        if(!empty($include)){
            $array = [];
            foreach($this->getData('options') as $name => $row){
                if(!in_array($name, $include)){
                    continue;
                }
                
                $array[$name] = $row;
            }
            
            return $array;
        }
        return $this->getData('options');
    }
    
    public function getRow($row, $name){
        $col = $this->getColumn($name);
        $toret = (isset($col['callback']) ? call_user_func_array($col['callback'], [$row]) : $row->{$name});
        
        if(isset($col['options'])){
            if(isset($col['options']['route'])){
                $toret = '<a href="'.call_user_func_array($col['options']['route'],[$row]).'">'.$toret.'</a>';
            }
        }
        
        return $toret;
    }
    
    public function getRowOption($row, $name, $callback = NULL){
        switch($name){
            case "edit":
                return [
                    'route' => call_user_func_array($callback, [$row])
                ];
                
            case "delete":
                $result = call_user_func_array($callback, [$row]);
                $attributes = [
                    'data-request-url' => $result['route'],
                    'data-question' => (isset($result['question']) ? $result['question'] : 'Are you sure you want to delete this item?')
                ];
                
                return [
                    'route' => '#',
                    'attributes' => join(' ',array_map(function($key,$item){
                        return $key.'="'.$item.'"';
                    },array_keys($attributes), array_values($attributes)))
                ];
                
            case "sortable":
                return [
                    'route' => '#'
                ];
                
        }
        
        return NULL;
    }
    
    public function column($field, $name = NULL, $callback = NULL, array $options = []){
        $this->prependData('columns', $field, ['name' => $name, 'callback' => $callback, 'options' => $options]);
        return $this;
    }
    
    public function columnAfter($afterField,$field, $name = NULL, $callback = NULL, array $options = []){
        $columns = [];
        foreach($this->getData('columns') as $key => $value){
            if($key === $afterField){
                $columns[$key] = $value;
                $columns[$field] = ['name' => $name, 'callback' => $callback, 'options' => $options];
            }
            else{
                $columns[$key] = $value;
            }
        }
        $this->data['columns'] = $columns;
        return $this;
    }
    
    public function columnBefore($beforeField,$field, $name = NULL, $callback = NULL, array $options = []){
        $columns = [];
        foreach($this->getData('columns') as $key => $value){
            if($key === $beforeField){
                $columns[$field] = ['name' => $name, 'callback' => $callback, 'options' => $options];
                $columns[$key] = $value;
            }
            else{
                $columns[$key] = $value;
            }
        }
        $this->data['columns'] = $columns;
        return $this;
    }
    
    public function totalResults(){
        return $this->getResults()->count();
    }
    
    public function make($template = 'default'){
        return view('components.tables.table_'.$template,['table' => $this])
            ->__toString();
    }
    
}