<?php
include "xmlDB.php";
include "log.php";
/**
 * Class Logs 
 * @author lennylan
 */
class Logs
{
	/**
	* project path
	* @var string
	*/
	private $path;
	
	/**
	* templete Path
	* @var string
	*/
	private $templetePath;
	
	/**
	* htdocs Path
	* @var string
	*/
	private $htdocsPath;
	
	/**
	* css path
	* @var string
	*/
	private $cssPath;
	
	/**
	* tpl path
	* @var string
	*/
	private $tplPath;
	
	/**
	* js path
	* @var string
	*/
	private $jsPath;

	/**
	* logs xml file name
	* @var string
	*/
	private $fileName;

	/**
	* build log File 
	* @var string
	*/
	private $buildFileName;
	
	/**
	* image url base
	* @var string
	*/
	private $imageBase;

	/**
	* log list from xmlDB
	* @var Array
	*/
	private $logs;
	
	/**
	* specified log list from xmlDB
	* @var Array
	*/
	private $specifiedLogs;

	/**
	* configuration Array from xmlDB
	* @var Array
	*/
	private $conf;
	
	/**
	* default lang of logs
	* @var String
	*/
	private $defaultLang;

	//public function __construct($logs, $options)
	public function __construct()
	{
		$this->path = dirname(__FILE__);

		$this->templetePath = $this->path."/projects/template";

		$this->htdocsPath = $this->path."/projects/htdocs";

		$this->cssPath = $this->htdocsPath."/css";

		$this->tplPath = $this->path."/tpl";

		$this->jsPath = $this->htdocsPath."/js";

		$this->fileName = $this->path."/logs.xml";

		$this->buildFileName = $this->path."/buildLogs.xml";
	
		$this->imageBase ="//tips.wechat.com/wechatportal";

		$this->defaultLang ="en";

		$row = Database::factory("logs",NULL,"Logs");
        $this->logs = $this->initLogs($row->select()->order_by('date', 'DESC')->find_all());
		$row = Database::factory("logs",NULL,"configuration");
		foreach ($row->select()->find_all() as $confSingle){
			$this->conf[$confSingle->key] = $confSingle->value;
		}
	}

	private function getReplaceKeyword($keyword)
	{
	    return "@".$keyword."@";
	}
	
	function generateLogs() 
	{
        $handleFuncs = array();
        $handleFuncs[] = "generateIndexLogs";
        $handleFuncs[] = "generateUpdatePage";
        $handleFuncs[] = "generateSingleLogPage";
        $this->multiLangHandle($handleFuncs);
		//generateServiceTerm();
		//generateFeatures();
		//generateFaq();
		return null;
	}
	/**
	 * genHtmlFromTep
	 * @return exported html
	 * @author LennyLan
	 **/
	public function genHtmlFromTep($assignArray,$tpl)
	{
		$smarty = new Smarty;
		foreach ($assignArray as $key=>$value){
			$smarty->assign($key,$value,true);
		}
		return $smarty->fetch($tpl);
	}
	/**
	 * replaceLogs
	 * @return result
	 * @author LennyLan
	 **/
	public function replaceLogs($file, $find, $replace)
	{
		return file_put_contents($file,str_replace($find,$replace,file_get_contents($file)));
	}
    /**
     * initLogs
     * @return formatted logs array
     * @author LennyLan
     **/
    public function initLogs($logs)
    {

		$allLogs = $this->conf["isSpecified"] ? $this->specifiedLogs:$logs;
        $logs = array();
        foreach ($allLogs as $log){
            if(!array_key_exists ($log->lang,$logs)){
                $logs[$log->lang] = array();
            }
            $logs[$log->lang][] = new Log($log);
        }
        return $logs;
    }
    /**
     * multiLangHandle
     * @return boolean
     * @author LennyLan
     **/
    public function multiLangHandle($handleFuncs)
    {
        foreach ($this->conf["lang"] as $value => $langCode){
            foreach ($handleFuncs as $handleFunc){
                call_user_func(array($this,$handleFunc),$langCode);
            }
        }
    }

	function generateIndexLogs($langCode) 
	{
        $file = $this->htdocsPath."/".$langCode."/index.html";
        if((!array_key_exists($langCode, $this->logs) || count($this->logs[$langCode]) < 3 ) && $langCode !=$this->defaultLang){
            $langCode = $this->defaultLang;
        }

        $logs  = $this->logs[$langCode];
        $tpl =$this->tplPath."/".$langCode."/index.tpl";


        if(!file_exists($file)){
            throw new Exception("index.html not exists");
        }
        $assignArray["logs"] = $logs;
		$assignArray["IMAGEBASE"] = $this->imageBase;

        if(!file_exists($tpl)){
            $tpl =$this->tplPath."/" + $this->defaultLang + "/index.tpl";
            if(!file_exists($tpl)){
                throw new Exception("index tpl not exists");
            }
        };
        $replaceContent = $this->genHtmlFromTep($assignArray,$tpl);

        //print_r($replaceContent);
        //print_r($file);

        try
        {
            $this->replaceLogs($file,$this->getReplaceKeyword("Content"),$replaceContent);
            return true;
        }
        catch (Exception $e)
        {
            throw new Exception( 'Something gone wrong with replacement', 0, $e);
            return false;
        }
	}
    
	function generateSingleLogPage($langCode) 
	{
        $desLangCode = $langCode;
        if((!array_key_exists($langCode, $this->logs) || count($this->logs[$langCode]) <= 0 ) && $langCode !=$this->defaultLang){
            $langCode = $this->defaultLang;
        }
        $logs  = $this->logs[$langCode];

			foreach ($logs as $log){

                $file = $this->htdocsPath."/".$desLangCode."/".preg_replace("/\./","_",$log->platform."_".$log->version).".html";

				$tpl =$this->tplPath."/".$langCode."/log_".$log->platform.".tpl";

                $assignArray["log"] = $log;
                $assignArray["IMAGEBASE"] = $this->imageBase;

                if(!file_exists($file)){
                    //print_r($file);
                    throw new Exception("log html not exists");
                }
                if(!file_exists($tpl)){
                    $tpl =$this->tplPath."/" + $this->defaultLang + "/log_".$log->platform.".tpl";
                    if(!file_exists($tpl)){
                        throw new Exception("log tpl not exists");
                    }
                };

                $replaceContent = $this->genHtmlFromTep($assignArray,$tpl);

                //print_r($file);
                //print_r($tpl);

                try
                {
                    //print_r($replaceContent);
                    $this->replaceLogs($file,$this->getReplaceKeyword("Content"),$replaceContent);
                    $this->replaceLogs($file,$this->getReplaceKeyword("Title"),$log->title);
                    $this->replaceLogs($file,$this->getReplaceKeyword("pagetitle"),str_replace(" 全新發佈","",str_replace(" Release","",$log->title)));
                }
                catch (Exception $e)
                {
                    throw new Exception( 'Something gone wrong with replacement', 0, $e);
                    return false;
                }
			}
		
		return true;
	}
    /**
     * initPlatformLogs
     * @return array
     * @author LennyLan
     **/
    public function initPlatformLogs($logs)
    {
		$allLogs = $logs;
        $logs = array();
        foreach ($allLogs as $log){
            if(!array_key_exists ($log->platform,$logs)){
                $logs[$log->platform] = array();
            }
            $logs[$log->platform][] = $log;
        }
        return $logs;
    }
	function generateUpdatePage($langCode) 
	{
        $file = $this->htdocsPath."/".$langCode."/updates.html";
        if((!array_key_exists($langCode, $this->logs) || count($this->logs[$langCode]) <= 0 ) && $langCode !=$this->defaultLang){
            $langCode = $this->defaultLang;
        }
        $logs = $this->initPlatformLogs($this->logs[$langCode]);

        foreach ($logs as $platform=>$log){
            $assignArray[str_replace(" ","",$platform)."Logs"] = $logs[$platform];
        }

        $tpl =$this->tplPath."/".$langCode."/update.tpl";

        if(!file_exists($file)){
            throw new Exception("updates.html not exists");
        }

        if(!file_exists($tpl)){
            $tpl =$this->tplPath."/" + $this->defaultLang + "/update.tpl";
            if(!file_exists($tpl)){
                throw new Exception("update tpl not exists");
            }
        };

        $replaceContent = $this->genHtmlFromTep($assignArray,$tpl);

        //print_r($replaceContent);
		
        try
        {
            $this->replaceLogs($file,$this->getReplaceKeyword("Content"),$replaceContent);
            return true;
        }
        catch (Exception $e)
        {
            throw new Exception( 'Something gone wrong with replacement', 0, $e);
            return false;
        }
		return true;
	}
	function getSIngleLog($log) 
	{
		$smarty = new Smarty;
		$smarty->assign("log",$log,true);
		$smarty->assign("test","test",true);
		$smarty->assign("IMAGEBASE","imageBase",true);

		$content = $smarty->fetch("log.tpl");
		echo $content;
	}

}

?>
