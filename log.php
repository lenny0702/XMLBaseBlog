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
	* count of images of each feature
	* @var array
	*/
	public $featuresNum = array();
	/**
	* download version for download url in SingleLog page.
	* @var string
	*/
	public $downloadVersion;

	/**
	* determine if add new tag to the log.
	* @var int
	*/
	public $isNew;

    public function __construct($xmlItem)
    {
        $this->publicDate = $xmlItem->date;
        $this->version = $xmlItem->version;
        $this->platform = $xmlItem->platform;
        $this->lang = $xmlItem->lang;
        $this->title = $xmlItem->title;
        $this->description = $xmlItem->description;
        $this->indexDescription = $xmlItem->indexDescription;
        if (isset($xmlItem->features)) {
            $this->features = $xmlItem->features;
        }
        if (isset($xmlItem->featuresNum)) {
            $this->featuresNum = $xmlItem->featuresNum;
        }
        $this->link = preg_replace("/\./","_",$xmlItem->platform."_".$xmlItem->version).".html";
        $this->dir = preg_replace("/\./","_",$xmlItem->platform."_".$xmlItem->version);
        $this->downloadVersion = preg_replace("/\./","",$xmlItem->version);

        $date =  date_create_from_format('Y-m-d',$xmlItem->date);
        $now = new DateTime();
        $this->isNew = $date->diff($now)->format("%a") < 30 ? 1 : 0;
    }
	}
	
?>
