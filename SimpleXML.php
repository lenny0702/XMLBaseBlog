
<?php 
class SimpleXML
{
    protected $xml;
    protected $xmlName;

    public function __construct($file)
    {
	    $this->xml = simplexml_load_file($file);
	    $this->xmlName = $file;
	    echo __CLASS__." initialized<br>";
        // code
    }
    public function __destruct(){
	    echo __CLASS__." closed<br>";
    }
    public function __toString(){
   	echo "test toString Method";
	return $this->xmlName;
    }
    public function out(){
   	print_r($this->xml);
    }
    public function deepSearch($xml){
    	$count = 1;
	foreach($xml->children() as $rootItem){
		$count++;
		print_r($count);
		print_r("&nbsp;&nbsp;&nbsp;&nbsp;");
		print_r($rootItem->getName()."</br>");
		print_r($rootItem."</br>");
		if($rootItem){
			$this->deepSearch($rootItem);
		}
	}
    }
    public function echoXMLTree(){
   	return $this->deepSearch($this->xml);
    }
    public function getXML(){
   	return $this->xml;
    }
}
/**
 * Class SimplexmlNew 
 * @author 
 */
class SimplexmlNew extends SimpleXML
{
	public static $count = 0;
	public static function pluc_one(){
		self::$count++;	
	}
	public function __construct($file){
		parent::__construct($file);
		echo "test new Contruct Method";
	}
	public function getLogs(){
	
	}
    public function newMethod()
    {
        // code
	echo $this->xmlName;
    }
}

?>
