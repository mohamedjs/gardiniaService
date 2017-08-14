<?php

class Product_type extends DatabaseObject{
    protected static $table_name = "product_type";
    protected static $db_fields = array('id','type' );
    
    public $id ; 
    public $type ;
    
    
    
    //Common Database Methouds 
    public static function find_all(){
        return self::find_by_sql("SELECT * FROM ".static::$table_name) ;
    }
    
    public static function find_by_id($id=0){
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM "
                .self::$table_name." WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array):false ;
    }
    
    public static function find_by_sql($sql=""){
        global $database ;
        $result_set = $database->query($sql) ;
        $object_array = array() ;
        while($row = $database->fetch_array($result_set)){
            $object_array[] = self::instantiate($row);  
        }
        return $object_array ;
    }
    
    private static function instantiate($record){
        $class_name = get_called_class();
        $object = new $class_name;
//        $object->id         = $record['id'];
//        $object->username   = $record['username'];
//        $object->password   = $record['password'];
//        $object->first_name = $record['first_name'];
//        $object->last_name  = $record['last_name'];
        
        foreach ($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute =$value ;
            }
        }
        return $object ;
    }
    
    private function has_attribute($attribute){
        //get_object_vars return associative array with all attributes
        //(incl.private ones!) as the keys and their current values ths value
        $object_vars = $this->attributes();
        //we don't care about the value ,we just want to know if ther exists
        //will return TRUE or FALSE 
        return array_key_exists($attribute , $object_vars);
    }
    
    protected function attributes(){
        //return an array of attribute Keys and their values
        //return get_object_vars($this);
        $attributes = array() ;
        foreach (self::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes ; 
    }
    
    protected function sanitized_attributes(){
        global $database;
        $clean_attributes = array();
        //sanitize the values before submitting
        //Note: does not alter the actual value of each attrribute
        foreach ($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function save(){
        // A new record won't have an id yet
        return isset($this->id)?$this->update():$this->create() ;
    }
    
    public function create(){
        global $database;
        //Don't forget your syntax and good habits:
        //-INSERT INTO table (Key , Key ) VALUES ('values' , 'values')
        $attributs = $this->sanitized_attributes();
        
        $sql  = "INSERT INTO ".self::$table_name."(" ;
        $sql .=join(", ", array_keys($attributs));
//      $sql .= "username, password, first_name, last_name";
        $sql .= ")VALUES('";
        $sql .= join("', '", array_values($attributs));
        $sql .= "')";
//      $sql .= $database->escape_value($this->username)."','";
//      $sql .= $database->escape_value($this->password)."','";
//      $sql .= $database->escape_value($this->first_name)."','";
//      $sql .= $database->escape_value($this->last_name)."')";
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true ;
        } else {
            return false; 
        }
    }
    
    public function update(){
        global $database ;
        //Don't forget your SQL and good habits:
        //-UPDATE teble SET key='value' , key='value' WHERE condition
        //- escape all values to prevent SQL injection
        $attributs = $this->sanitized_attributes();
        foreach ($attributs as $key => $value){
            $attribut_pairs[] = "{$key}='{$value}'";
        }
        $sql  = "UPDATE ".self::$table_name." SET ";
        $sql .= join(",", $attribut_pairs);
      //$sql .= "username='".$database->escape_value($this->username)."', ";
      //$sql .= "password='".$database->escape_value($this->password)."', ";
      //$sql .= "first_name='".$database->escape_value($this->first_name)."', ";
      //$sql .= "last_name='".$database->escape_value($this->last_name)."' ";
        $sql .= " WHERE id=".$database->escape_value($this->id);
        
        $database->query($sql);
        return ($database->affected_rows() == 1)?true : false ;
    }
    
    public function delete(){
        global $database;
        //Don't forget the SQL syntax and good habits:
        //- DELETE FROM table WHERE condition LIMIT 1
        //- escape all values to prevent SQL injection
        //use LIMIT 1
        $sql  = "DELETE FROM".self::$table_name;
        $sql .= " WHERE id=".$database->escape_value($this->id) ;
        $sql .= " LIMIT 1" ;
        $database->query($sql);
        return ($database->affected_rows() == 1)?true : false ;
    }
}
