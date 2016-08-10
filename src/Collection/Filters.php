<?php
namespace VSC\Collection;

use Illuminate\Http\Request;

class Filters{
    
    protected $request;
    
    protected $validator;
    
    protected $errors;
    
    public function __construct(Request $request, array $attributes = []) {
        $this->request = $request;
        
        $this->validator = \Validator::make($request->all(),$attributes);
        
        $this->errors = $this->validator->messages();
    }
    
    public function get($name){
        if($this->errors->has($name)){
            return NULL;
        }
        
        if($this->request->has($name)){
            return trim($this->request->get($name));
        }
        return NULL;
    }
    
    public function getAll(){
        return $this->request->all();
    }
    
    public function getSpecificParameters(array $specific = []){
        $array = [];
        foreach($this->request->all() as $key => $value){
            if(in_array($key, $specific)){
                $array[$key] = $value;
            }
        }
        
        return $array;
    }
    
    public function count(){
        $count = 0;
        foreach($this->request->all() as $key => $value){
            if(in_array($key,['page'])){
                continue;
            }
            
            if(strlen($value) > 0){
                $count++;
            }
        }
        return $count;
    }
    
    public function has(){
        $items = func_get_args();
        
        if(empty($items)){
            return ($this->count() > 0 ? TRUE : FALSE);
        }
        
        foreach($items as $item){
            if($this->request->has($item)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
}