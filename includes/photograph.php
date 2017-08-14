<?php
require_once(LIB_PATH.DS.'database.php');
class Photograph extends DatabaseObject{
    protected static $table_name = "photographs";
    protected static $db_fields = array('id' , 'filename' , 'type' , 'size' , 'caption');
    public $id ;
    public $filename ;
    public $type ;
    public $size ;
    public $caption ;
    
    private $temp_path;
    protected $upload_dir="images" ;
    public $errors = array();
    
    protected $upload_errors = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK 				=> "No errors.",
        UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL 	=> "Partial upload.",
        UPLOAD_ERR_NO_FILE 	=> "No file.",
        UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
    );
    
    //pass in $_FILE['uploaded_file'] as an argument
    public function attach_file($file){
        // Perform error checking on the form parameters
        if(!$file || empty($file) || !is_array($file)){
            //error: nothing uploaded or wrong argement
            $this->errors[]="No file was uploaded.";
            return false;
        }elseif ($file['error'] !=0) {
            // error: report what PHP says went wrong
            $this->errors[] = $this->upload_errors[$file['error']];
            return false ;
        }  else {
            // Set object attributes to the form parameters.
            $this->temp_path = $file['tmp_name'] ;
            $this->filename = basename($file['name']);
            $this->type = $file['type'] ;
            $this->size = $file['size'] ;
            // Don't worry about saving anything to the database yet.
            return true;
        }
    }
    
    public function save(){
        // A new record won't have an id yet.
        if(isset($this->id)){
            // Really just to update the caption
            $this->update();
        }else{
            // Make sure there are no errors
            
            // Can't save if there are pre-existing errors
            if(!empty($this->errors)){return false ;}
            
            // Make sure the caption is not too long for the DB
            if(strlen($this->caption)>255){
                $this->errors[] = "the caption can only be 255 characters long.";
                return false;
            }
            
            // Can't save without filename and temp location
            if(empty($this->filename)||empty($this->temp_path)){
                $this->errors[] = "the file location was not available.";
                return false ;
            }
            
            //Determain the target_path
            $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;
            
            // Make sure a file doesn't already exist in the target location
            if(file_exists($target_path)){
                $this->errors[] = "the file {$this->filename} already exists.";
                return false;
            }
            // Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path)){
               //Success
               // Save a corresponding entry to the database
               if($this->create()){
                   unset($this->temp_path);
                   return true ;
               }
            }  else {
                //file was not moved
                $this->errors[] = "the file upload failed,[possibly due to incorrect permissions on the upload folder.";
                return fales ;
            }
            
        }
        
        }
    
    public function destroy(){
        //first remove the database entry
        if($this->delete()){
        //then remove the file
            $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
            return unlink($target_path)? true : false;
        } else {
            return false ; 
        }
    }

    public function image_path(){
        return $this->upload_dir.DS.$this->filename;
    }
    
    public function size_as_text(){
        if($this->size <1024){
            return "{$this->size} bytes";
        } elseif ($this->size < 10248576) {
            $size_kb = round($this->size/1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size/10248576, 1);
            return "{$size_mb} MB";
        }
    }
    
    //Common Database Methouds 
    public static function find_all(){
        return self::find_by_sql("SELECT * FROM ".static::$table_name) ;
    }
    
    public static function find_by_id($id=0){
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM "
                .self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
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

    // replaced with a custom save()
    // public function save() {
    //   // A new record won't have an id yet.
    //   return isset($this->id) ? $this->update() : $this->create();
    // }
    
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
        $sql  = "UPDATE".self::$table_name."SET ";
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
        $sql  = "DELETE FROM ".self::$table_name;
        $sql .= " WHERE id=".$database->escape_value($this->id) ;
        $sql .= " LIMIT 1" ;
        $database->query($sql);
        return ($database->affected_rows() == 1)?true : false ;
    }
}