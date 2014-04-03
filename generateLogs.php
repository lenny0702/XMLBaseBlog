<?php
	require '../Smarty-3.1.15/libs/Smarty.class.php';
	/**
	 * Class Logs 
	 * @author lennylan
	 */
	class Log
	{

	/**
	* title of one log
	* @var string
	*/
	public $title;	

	/**
	* public date of log
	* @var Date
	*/
	public $publicDate; 
	/**
	* platform of product
	* @var string
	*/
	public $platform;

	/**
	* version of product
	* @var string
	*/
	public $version;

	/**
	* lang of log
	* @var string
	*/
	public $lang;

	/**
	* the tile of log displayed in index page
	* @var string
	*/
	public $indexDescrption;

	/**
	* log page Link
	* @var string
	*/
	public $link;

	/**
	* dir name of log image
	* @var string
	*/
	public $dir;

	/**
	* feature list of log
	* @var array
	*/
	public $features = array();

	/**
	* download version for download url in SingleLog page.
	* @var string
	*/
	public $downloadVersion;
	    public function __construct($xmlItem)
	    {
		$this->publicDate = $xmlItem->date;
		$this->version = $xmlItem->version;
		$this->platform = $xmlItem->platform;
		$this->lang = $xmlItem->lang;
		$this->title = $xmlItem->title;
		$this->description = $xmlItem->description;
		$this->indexDescription = $xmlItem->indexDescription;
		$this->features = $xmlItem->features;
		$this->link = preg_replace("/\./","_",$xmlItem->platform."_".$xmlItem->version).".html";
		$this->dir = preg_replace("/\./","_",$xmlItem->platform."_".$xmlItem->version);
		$this->downloadVersion = preg_replace("/\./","",$xmlItem->version);
	        // code
	    }
	}
	
?>
