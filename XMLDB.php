
<?php 
	define("DB_PATH","./");
	defined("DB_PATH") or die('Define your DB_PATH constance');
	
	/**
	 * Class Data 
	 * singleton pattern class
	 * @author lennylan
	 */
	class Data{
		private static $_instance;
		public static function getInstance(){
			if(!self::$_instance){
				self::$_instance = new self();	
			}
			return self::$_instance;
		}
		public static function newInstance(){
			self::$_instance = new self();	
			return self::$_instance;
		}
	}
	/**
	 * Class Database 
	 * @author lennylan
	 */
	class Database
	{
	    private $xml;
	    private $_data;
	    public $file;
	    private $_fileName;
	    private $_fileContent;
	    public $filePath = DB_PATH;
	    public function __set($name,$value)
	    {
		    $this->_data->{$name} = $value;
		    return $this;
	    }
	    Public function save(){
		    if(isset($this->_row_id))	{
		   	$this->_edit(); 
		    }else{
		   	$this->_add(); 
		    }
		    print_r($this->file);
		    return $this->xml->asXML($this->file);
	    }
	    private function _add()
	    {
		    $data = $this->_data;
		    $row = $this->xml->addChild("row");
		    foreach (get_object_vars($data) as $name=>$value){
			    $field = $row->addChild("field",$value);
			    $field->addAttribute('name',$name);
		        
		    }
		    
	    }
	    
	    public static function factory($fileName,$id=NULL)
	    {
		    Data::newInstance();
		    $db = new Database();
		    $db->_data = new Data();
		    $db->_fileName = $fileName;
		    $db->setInformations($fileName);
		    $db->xml = simplexml_load_file($db->file);
		    return $db;
	    }
	    private function setInformations($fileName = NULL, $id = NULL)
	    {
		    if($fileName!==NULL){
		   	$this->file  = $this->filePath.$fileName.".xml";
			$this->_fileName = $fileName;
			$this->_fileContent = file_get_contents($this->file);
		    }
		    return $this;
	    }
	}
	$news = Database::factory('logs1');
	$news->test="1";
	$news->save();
		
?>
