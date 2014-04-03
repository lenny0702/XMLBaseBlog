<?php
include "xmlDB.php";
include "generateLogs.php";
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
        $this->logs = initLogs($row->select()->find_all());
		$row = Database::factory("logs",NULL,"configuration");
		foreach ($row->select()->find_all() as $confSingle){
			$this->conf[$confSingle->key] = $confSingle->value;
		}
	}

	private function getReplaceKeyword($keyword)
	{
	    return "@".$keyword."@";
	}
	
	private function getPlatformName($keyword)
	{
        $platform = array("iOS"=>"iPhone","Android"=>"Android","Windows Phone"=>"Windows Phone");
	    return $platform[$keyword];
	}
	function generateLogs() 
	{
        $handleFuncs = array();
        $handleFuncs[] = "$this->generateIndexLogs";
        $this->multiLangHandle($handleFuncs);
		//$this->generateSingleLogPage();
		//$this->generateUpdatePage();
		//$this->generateIndexLogs();
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

		$allLogs = $this->conf["isSpecified"] ? $this->specifiedLogs:$this->logs;
        $logs = array();
        foreach ($allLogs as $log){
            if(!array_key_exists ($log->lang,$logs)){
                $logs[$log->lang] = array();
            }else{
                $logs[$log->lang][] = $log;
            }
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
            foreach ($handleFuncs as $handleFuncs){
                handleFunc($langCode);
            }
        }
    }

	function generateIndexLogs($langCode) 
	{
        $file = $this->htdocsPath."/".$langCode."/index.html";
        if(count( $logs[$langCode] ) < 3 && $langCode !=$this->defaultLang){
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

        print_r($replaceContent);
        print_r($file);

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
    
	function generateSingleLogPage() 
	{
		$allLogs = $this->conf["isSpecified"] ? $this->specifiedLogs:$this->logs;
		$assignArray["IMAGEBASE"] = $this->imageBase;
		foreach ($this->conf["lang"] as $value => $langCode){
			print_r($langCode."<br>");
			$isLangExist = false;
			foreach ($allLogs as $log){
				$tpl =$this->tplPath."/".$langCode."/log_".$log->platform.".tpl";
				if($log->lang == $langCode) {
					$isLangExist = true;
					$file = $this->htdocsPath."/".$langCode."/".preg_replace("/\./","_",$this->getPlatformName($log->platform)."_".$log->version).".html";
					print_r($file);
					$assignArray["log"] = $log;

                    if(!file_exists($file)){
                        throw new Exception("log html not exists");
                    }
                    if(!file_exists($tpl)){
						$tpl =$this->tplPath."/en/log_".$log->platform.".tpl";
                        if(!file_exists($tpl)){
                            throw new Exception("log tpl not exists");
                        }
                    };
					$replaceContent = $this->genHtmlFromTep($assignArray,$tpl);
					print_r($file);
					//print_r($replaceContent);
				}
			}
			if(!$isLangExist){
				foreach ($allLogs as $log){
					$tpl =$this->tplPath."/".$langCode."/log_".$log->platform.".tpl";
					if($log->lang == "en") {
						$isLangExist = true;
						$file = $this->htdocsPath."/".$langCode."/index.html";
						$assignArray["log"] = $log;
						if(!file_exists($file) || !file_exists($tpl)){
							$file = $this->htdocsPath."/en/index.html";
							$tpl =$this->tplPath."/en/log_".$log->platform.".tpl";
							if(!file_exists($file) || !file_exists($tpl)){
								throw new Exception("index tpl not exists");
							}
						};
						$replaceContent = $this->genHtmlFromTep($assignArray,$tpl);
						print_r($replaceContent);
					}
				}
			}

			//$this->replaceLogs($file,getReplaceKeyword("Content"),$replaceContent));
		}
		
		return true;
	}
	function generateUpdatePage() 
	{
		$allLogs = $this->conf["isSpecified"] ? $this->specifiedLogs:$this->logs;
		$assignArray["IMAGEBASE"] = $this->imageBase;
		foreach ($this->conf["lang"] as $value => $langCode){
			$logs = array();
			foreach ($allLogs as $log){
				if($log->lang == $langCode) {
					$logs[] = $log;
				}
			}
			if(count( $logs ) == 0){
				foreach ($allLogs as $log){
					if($log->lang == "en") {
						$logs[] = $log;
					}
				}
			
			}
			$assignArray["AndroidLogs"] = $logs;

			$file = $this->htdocsPath."/".$langCode."/updates.html";
			$tpl =$this->tplPath."/".$langCode."/update.tpl";
			if(!file_exists($file) || !file_exists($tpl)){
				$file = $this->htdocsPath."/en/updates.html";
				$tpl =$this->tplPath."/en/update.tpl";
				if(!file_exists($file) || !file_exists($tpl)){
					throw new Exception("index tpl not exists");
				}
			};
			$replaceContent = $this->genHtmlFromTep($assignArray,$tpl);
			print_r($replaceContent);
			$this->replaceLogs($file,$this->getReplaceKeyword("Content"),$replaceContent);
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
