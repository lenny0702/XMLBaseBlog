<?PHP
/**
 * @fileoverflow A tools for I18N @Tencent - IBG
 * @author zemzheng
 */
define('_libRoot', dirname(__FILE__));

/**
 * Lectura de archivos MO de GetText y simplificación de su uso con PHP
 * @class analyseMO
 * @see http://www.tierra0.com/page/3/
 */
abstract class analyseMO{
  static function mo2array($archivo = 'traduccion.mo'){
    $file      = file_get_contents($archivo, FILE_BINARY);

    $i['magic'] = self::deco(substr($file, 0, 4), true); // extraigo el numero magico para verificar si es valido
    if($i['magic'] != 'DE 12 04 95'){ return array('error'=>'Archivo no valido, no contiene datos validos de internacionalizacion.', 'magic'=>$i['magic']); }
    $f=4;   $ini=4;
    $i['version']         = self::deco(substr($file,$ini,4),'d');  $ini+=$f;
    $i['len']             = self::deco(substr($file,$ini,4),'d');  $ini+=$f; //total de frases traducidas
    $i['ini_original']    = self::deco(substr($file,$ini,4),'d'); $ini+=$f;
    $i['ini_traduccion']  = self::deco(substr($file,$ini,4),'d');   $ini+=$f;
    $i['len_hash']        = self::deco(substr($file,$ini,4),'d'); $ini+=$f;
    $i['ini_hash']        = self::deco(substr($file,$ini,4),'d');

    $o = str_split( substr($file, $i['ini_original'],   $i['ini_traduccion']), 4);
    $t = str_split( substr($file, $i['ini_traduccion'], $i['ini_hash']      ), 4);

    for($k=1; $k<=$i['len']; $k++){
      if($k%2!=0){
        #$i['table'][$k ]['o'] = substr( $file, self::deco($o[$k],'d'), self::deco($o[$k-1],'d') );
        #$i['table'][$k ]['t'] = substr( $file, self::deco($t[$k],'d'), self::deco($t[$k-1],'d') );
        $i['table'][substr( $file, self::deco($o[$k],'d'), self::deco($o[$k-1],'d') )] = substr( $file, self::deco($t[$k],'d'), self::deco($t[$k-1],'d') );
      }
    }
    return $i;
  }

  static function deco($data, $jumps=false){ //pasa el contenido binario a HEX y lo preformatea
    if($jumps==='h'){
      $o = explode(' ', wordwrap(strtoupper(bin2hex($data)), 2, " ", 1) );
      $o = $o[3].$o[2].$o[1].$o[0];
    } elseif($jumps==='d'){ // bin2dec
      $o = explode(' ', wordwrap(strtoupper(bin2hex($data)), 2, " ", 1) );
      $o = hexdec($o[3].$o[2].$o[1].$o[0]);
    }  elseif($jumps===true){
      $o = wordwrap(strtoupper(bin2hex($data)), 2, " ", 1);
    } else {
      $o = strtoupper(bin2hex($data));
    }
    return $o;
  }
}

/**
 * @class zBuilder
 * @author zemzheng@tencent.com
 */
abstract class zBuilder{
  /**
   * @public 
   * @static
   * @description 根据路径读取文件。会echo读取情况。
   * 			        Read the file to string. Will echo the result. 
   * @function readFile
   * @param {string} $file_path 文件路径 
   * @return {string} 文件内容 File Content  
   */
  static function readFile($file_path){
    if (!file_exists($file_path)){
      echo "\n[F][readFile] $file_path\n";
      return false;
    } else {
      echo "\n[S][readFile] $file_path\n";
    }
    $content = file_get_contents($file_path);
    return $content;
  }

  /**
   * @public
   * @static
   * @description 写文件。
   * @function writeFile
   * @param {string} $file_path 文件路径
   * @param {string} $content 要写入的内容.Content to write.
   * @param {boolen} $clean 要不要先删除文件?Need to unlink the file if exists?
   * @return {int} 写入内容的长度。The length writed to file.
   */
  static function writeFile($file_path, $content, $clean=1){
    if ($clean && file_exists($file_path)){
      echo "\n[S][writeFile][rm]\n  $file_path\n";
      unlink($file_path);
    }
    $f = fopen($file_path, 'a');
    $result = fwrite($f, $content);
    fclose($f);
    echo "\n", $result ?  '[S]' : '[F]', "[writeFile][write] $file_path\n";
    return $result;
  }

  /**
   * @public 
   * @static 
   * @description 传入参数给模板，生成页面。
   * @function includeTmpl
   * @param {string} $path 导入的模板文件路径。file path
   * @param {array} $params 传给模板的参数。The params you want to pass to the template
   * @return {string} 模板运行完后的字符串结果。The content complie form template
   */
  static function includeTmpl($path, $params = array()){
    if(!file_exists($path)){
      return '';
    }
    foreach($params as $key => $val){
      $$key = $val;
    }
    ob_start();
    include($path);
    $result = ob_get_contents();
    ob_end_clean();
    echo "\n[S][includeTmpl] $path\n";
    return $result;
  }

  /**
   * @public
   * @static
   * @description 根据数组内来正则替换文本。Replace an string by reg in array.
   * @function pregReplaceByArr
   * @param {string} $str 需要替换的文本。 String input.
   * @param {array} $arr 替换的正则数组。 Array with reg.
   *           <pre>array(
   *                  $reg => $reStr // preg_replace($reg, $reStr, $str); 
   *                  $reg => $reFun // preg_replace_callback($reg, $reFun, $str); 
   *                )
   *                $reFunc($strResult)  // $strResult 为每一个符合 $reg 正则匹配的结果。 $strResult is the result by filter $reg</pre>
   * @return {string} 替换后的结果。The content after filter
   */
  static function pregReplaceByArr($str, $arr){
    $result = $str;
    foreach($arr as $reg => $replace){
      if(is_callable($replace)){
        $result = preg_replace_callback(
          $reg, 
          function($str) use ($replace){
            return $replace($str[0]);
          },
          $result
        );
      } else {
        while(preg_match_all($reg, $result, $tmp)){
          $result = preg_replace(
            $reg,
            $replace,
            $result
          );
        }
      }
    }
    return $result;
  }

  /**
   * @public 
   * @static
   * @description 判断一个文件里面是不是有PHP标签。 tell if an file with PHP tag.
   * @function isPHP
   * @param {string} $path 文件路径。 file path
   * @return {boolen} 
   */
  static function isPHP($path){ 
    $result = false;
    if(file_exists($path)){
      $result = preg_match(
        '/<\?PHP.*\?>/m',
        self::readFile($path)
      ) ? true : false;
    }
    return $result;
  }

  /**
   * @public 
   * @static
   * @description 为中文字符包裹上gettext，为后续国际化做准备。 wrap Chinese with gettext method.
   * @function wrapChs
   * @param {string} $str 输入的文本。The content we want to have a wrap
   * @return {string} 输出的结果。 OK, you got it.
   */
  static function wrapChs($str, $mode='*'){
  
    $reg_pre_gettext = '<\?PHP\secho\s\_\(\'';
    $reg_aft_gettext = '\'\);\?>';
    $reg_wchs = "$reg_pre_gettext([^']+)$reg_aft_gettext";

    $reg_chs_mark = '，、。！？；“”‘：（）';
    $reg_cht_mark = ',\.\_a-zA-Z0-9\?\\\!\%\$\/~\-@';
    
    // 不知道是不是把中文包在这里会好一些
    // 不是
    //$reg_chinside_mark = ',\.\_a-zA-Z' . $reg_chs_mark . '0-9\?\\\!\%\$';


    $func_unwrap = function($str) use($reg_wchs) {        
      $str = preg_replace("/$reg_wchs/u", '$1', $str);      
      return $str;
    };


    // 注释是否要过滤
    $reg_note_filter = array();

    switch(strtolower($mode)){    
      case 'html':
      case 'htm' :
        $reg_note_filter = array(
          '/<!--.*?-->/u' => $func_unwrap,
          '/<%#.*?%>/u' => $func_unwrap

          ,// mmbiz 这边html里面的js注释也去掉
          // 单行注释
          "/(\/\/.*)$reg_wchs/u" => '$1$2',

          // 这个被下面的多行给包括了
          //"/(\/\*.*?)$reg_wchs(.*\*\/)/" => '$1$2$3',

          // 多行注释
          "/\/\*.*?\*\//su" => $func_unwrap

        );
        break;
      case '*':
      case 'javascript':
      case 'js':
      default:
        $reg_note_filter = array(
          // 单行注释
          "/(\/\/.*)$reg_wchs/u" => '$1$2',

          // 这个被下面的多行给包括了
          //"/(\/\*.*?)$reg_wchs(.*\*\/)/" => '$1$2$3',

          // 多行注释
          "/\/\*.*?\*\//su" => $func_unwrap
        );
    }

    // 全部过滤
    $result = preg_replace("/([\x{4e00}-\x{9fa5}]+)/u", "<?PHP echo _('$1');?>", $str);

    // 注释过滤
    $result = self::pregReplaceByArr(
      $result,
      $reg_note_filter
    );


    // 中间的单词之类
    $result = self::pregReplaceByArr(
      $result, 
      array(
        // 两个输出中间的
        // 后面要把每行超过2个php-gettext的内容并入一起
        "/$reg_aft_gettext([$reg_chs_mark$reg_cht_mark\s]+?)$reg_pre_gettext/u" => '$1',
        
        // 前面的
        "/([$reg_cht_mark$reg_chs_mark]+?\s*)($reg_pre_gettext)/u" => '$2$1',

        // 后面的
        // 注意， $reg_cht_mark 放在后面
        // 理由是：会出现匹配中文字符串的时候把\t\n等给匹配进来
        // 理由不成立呀孩子
        "/($reg_aft_gettext)(\s*[$reg_chs_mark$reg_cht_mark]+?)/u" => '$2$1'
      )
    );
    /* 下面这个是把一行里面多个gettext转成一个 */
    $result = preg_split('/[\n\r]/', $result);
    $ii = count($result);
    while($ii--){
      $str = trim($result[$ii]);
      $num = preg_match_all("/$reg_wchs/u", $str, $matches);
      if($num > 0){ /* 凡是一行有中文要处理的，全部拖出来看看呢 */
        $params = preg_split("/$reg_wchs/u", $str);
        /* 首尾不放入 *//*
        $before = array_shift($params);
        $after = array_pop($params);
        /**/

        array_walk(
          $params,
          function(&$item){
            // 反斜杠过滤
            $item = str_replace('\\','\\\\', $item);
            // 将单引号过滤
            $item = str_replace('\'','\\\'', $item);            
          }
        );

        // 将% 过滤成 %%
        // 为替换的位置打上顺序
        $matches_txt = '';
        $matches = $matches[1];
        $_i = 0;
        $_ii = count($matches);
        $_pindex = 1;
        while($_i < $_ii){
          $_i++;
          $matches_txt .= "%$_i\$s" . str_replace('%','%%', $matches[$_i-1]);
        }
        $_i++;
        $matches_txt .= "%$_i\$s";

        
        
        $result[$ii] =  
          /* 首尾放入 */
          "<?PHP \n\techo sprintf(\n\t\t_('$matches_txt'),\n\t\t"
            . '\''. implode("',\n\t\t'", $params). "');\n?>";
          /* 首尾不放入 *//*
          $before . '<?PHP echo sprintf('
            . '_(\'' . (implode('%s',$matches[1])) . '\'),'
            . '\''. implode('\',\'', $params). '\');?>' . $after;
          /**/
      }
    }
    $result = implode("\n", $result);
    
    return $result;
  }

  /**
   * @static
   * @public
   * @description 遍历一个路径。 walk a path and visit every thing
   * @function filesWalker
   * @param {string} $path 指定的路径
   * @param {function} $funcForFile 如果是文件，处理的函数。Function for handle file. $funcForFile($file_path);
   * @param {function} $funcForFolder 如果是文件夹，处理的函数。 Function for handle folder. $funcForFolder($folder_path);
   * @return
   */
  static function filesWalker($path, $funcForFile='', $funcForFolder=''){
    if(!file_exists($path)){
      return false;
    }
    if(is_dir($path)){
      $path = preg_replace('/\/+$/', '', $path) . '/';
      if (is_callable($funcForFolder)){
        $funcForFolder($path);
      }
      
      $dp = dir($path);
      while($file = $dp->read()){
        if($file!='.' && $file!='..'){
          self::filesWalker($path . "$file", $funcForFile, $funcForFolder);
        }
      }

    }else{
      if (is_callable($funcForFile)){
        $funcForFile($path);
      }
    }
  }

  /**
   * @public
   * @static
   * @description 把输入的内容按照系统路径格式（斜杠OR反斜杠）组合起来
   * @function joinPath
   * @param {string} 可以多个参数，路径。 multi-params
   * @return {string} 组合后的路径
   */
  static function joinPath(){
    return implode(DIRECTORY_SEPARATOR,func_get_args());  
  }

  /**
   * @public 
   * @static 
   * @description 得到从 $from 到 $to 的相对路径
   * @function getRelativePath
   * @param {string} $from 起始路径。 Start path
   * @param {string} $to 目标路径。Target path
   * @return {string} 返回相对路径。 The relative path
   */
  static function getRelativePath($from, $to){
    $arr_from = explode(DIRECTORY_SEPARATOR,  realpath($from));
    $arr_to   = explode(DIRECTORY_SEPARATOR,  realpath($to)); 

    do{
      $current_from = array_shift($arr_from);
      $current_to   = array_shift($arr_to);
    }while($current_from == $current_to && count($current_from));
    array_unshift($arr_to, $current_to);

    $result = array();//'.');
    $ii = count($arr_from) + (is_dir($from)?1:0);

    while($ii--){
      array_push($result, '..');
    }

    $result = 
      call_user_func_array(
        'self::joinPath',
        array_merge($result, $arr_to)
        //$result
      );

    return $result;
  }

  /**
   * @public 
   * @static
   * @description 查看目标文件夹是否存在，不存在则创建
   * @function createDir
   * @param {string} $path 目标路径。Target path
   */
  static function createDir($path){
    $path = explode(DIRECTORY_SEPARATOR, $path);
    $i = 0;
    $t = '';
    while(isset($path[$i])){
      if($t){
        $t = self::joinPath($t, $path[$i++]);
      }else{
        $t = $path[$i++];
      }
      if(!is_dir($t)){
        mkdir($t);
      }
    }
  }

}

/**
 * @class translateLogs
 */
abstract class translateLogs{
  private static $lang;
  private static $file;
  private static $logs     = array();
  private static $dicts    = array();

  /**
   * @public
   * @static
   * @description 获得当前相关参数
   * @function getCurrent
   * @return {array} <pre>array(
   *  'lang' => 当前语言，current language. zh_CN or zh_TW or en_US
   *  'file' => 当前文件路径, current file path
   *  'logs' => 翻译过的词条记录
   *  'dicts'=> 翻译的词条对照
   * )</pre>
   */
  static function getCurrent(){
    return array(
      'lang' => self::$lang,
      'file' => self::$file,
      'logs' => self::$logs,
      'dicts'=> self::$dicts
    );
  }

  /**
   * @public 
   * @static
   * @description 清除所有记录 Clear translateLogs list
   * @function cleanList
   */
  static function cleanList(){
    self::$logs = array();
    self::$dicts = array();
  }

  /**
   * @public
   * @static
   * @function setCurrent
   * @param {array} $opt  参数设置，包括 <pre>
   *                            lang 当前语言, 
   *                            file 当前文件, 
   *                            filterLine 判断是不是要加入记录内的方法</pre>
   * @description #设置当前的语言、文件
   */
  static function setCurrent($opt){
    if(isset($opt['lang'])){
      //echo "[N][translateLogs][setCurrent] Set lang=", $opt['lang'];
      self::$lang = $opt['lang'];
    }
    if(isset($opt['file'])){
      self::$file = $opt['file'];
    }
    if(isset($opt['filterLine']) && is_callable($opt['filterLine'])){
      self::$filterLine = $opt['filterLine'];
    }
  }

  static private $filterLine;
  /**
   * @public
   * @static
   * @description 添加一条新记录
   * @function addLogs 
   * @param {string} $str 翻译的原文
   * @param {string} $result 翻译的译文
   */
  static function addLogs($str, $result){
    if (!(self::$lang && self::$file)){
      return;
    }
    if (!isset(self::$logs[self::$lang])){
      self::$logs[self::$lang] = array();
    }
    if (!isset(self::$logs[self::$lang][self::$file])){
      self::$logs[self::$lang][self::$file] = array();
    }
    self::$logs[self::$lang][self::$file][$str] = $result;
    
    if (!isset(self::$dicts[self::$lang])){
      self::$dicts[self::$lang] = array();
    }
    if (!isset(self::$dicts[self::$lang][$str])){
      self::$dicts[self::$lang][$str] = array(
        'msgstr' => $str !== $result ? $result : '',
        'where'  => array()
      );
    }
    
    $result = '';

    if(is_callable(self::$filterLine)){
      $func = self::$filterLine;
      $backtraces = debug_backtrace();
      $i = 0;
      while(isset($backtraces[$i])){
        $backtrace = $backtraces[$i++];
        if($func($backtrace)){
          $result = '#: ' . $backtrace['file'] . ':' . $backtrace['line'];
          break;
        }
      }
    }

    if($result){
      array_push(
        self::$dicts[self::$lang][$str]['where'],
        $result
      );
    }
  }

  /**
   * @static
   * @public
   * @description 根据记录生成po文件
   * @function createPo
   * @param {str} $lang 需要生成的语言
   */
  static function createPo($lang){
    if(!isset(self::$dicts[$lang])){
      echo "[F][createPo]$lang no found";
      print_r(self::$dicts);
      return '';
    }

    ob_start();
    echo implode("\n", array(
      'msgid ""',
      'msgstr ""',
      '"MIME-Version: 1.0\n"',
      '"Content-Type: text/plain; charset=utf-8\n"',
      '"Content-Transfer-Encoding: 8bit\n"',
      ''
    ));

    $dict = self::$dicts[$lang];
    foreach($dict as $id => $obj){
      echo 
        "\n", implode("\n", $obj['where']),
        "\n", 'msgid "', str_replace('"', '\\"', $id), '"', 
        "\n", 'msgstr "', str_replace('"', '\\"', $obj['msgstr']), '"', "\n";
    }

    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }

  /**
   * @static
   * @pulbic
   * @description 生成翻译日志数组结果
   * @function createLog
   * @return {string} 返回生成的日志
   */
  static function createLog(){
    ob_start();
    print_r(self::$logs);
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }
}

/**
 * @class gettext
 */
abstract class gettext{
  /**
   * @public
   * @static
   * @description GNU - gettext -xgettext 从php代码中提取需要翻译内容
   * @function xgettext
   * @param {array} $files 要翻译的文件列表
   * @param {string} $target 生成的目标文件
   * @param {string} $charset 编码。默认utf-8
   */
  static function xgettext($files, $target, $charset='utf-8'){
    if(!is_array($files)){
      return false;
    }
    $target = $target;
    $fileListPath = zBuilder::joinPath(
      _potFolder_, _projectName_ . '.list'
    );
    zBuilder::writeFile(
      $fileListPath,
      implode($files, "\n")
    );
    if(!file_exists($target)){
      touch($target);
    }

    $cmd = implode(
      array(
        '"' . zBuilder::joinPath(_libRoot, 'gettext', 'xgettext.exe') . '"',
        "-o \"$target\"",                       // output target 输出的pot 文件
        '-D ' . dirname($fileListPath),
        '--from-code', $charset,                // charset 字符编码
        '-L PHP',                               // 当作 php 来解析
        "-f $fileListPath",                   //读取文件列表
        '--copyright-holder="Tencent IBG 1998 - ' . date('Y') .'"',
        '--package-name=' . _projectName_,
        '--package-version=' . _startBuildTime_,
        '--no-wrap',
        '--msgid-bugs-address=zemzheng@gmail.com'
        //'-j'
      ),
      ' '
    );

    echo "\n[cmd] $cmd\n";
    return exec($cmd);
  }

  /**
   * @static
   * @public
   * @description GNU - gettext - msgfmt 根据po文件生成mo
   * @function msgfmt
   * @param {string} $po_path po 文件路径
   * @param {string} $mo_path mo 文件路径
   * @return {boolen|string} 命令行执行结果
   */
  static function msgfmt($po_path, $mo_path){
    if(!file_exists($po_path)){
      return false;
    }
    $cmd = implode(
      array(
        '"' . zBuilder::joinPath(_libRoot, 'gettext', 'msgfmt.exe') . '"',
        "\"$po_path\"", 
        "-o \"$mo_path\""
      ),
      ' '
    );
    echo "\n[cmd] $cmd\n";
    return exec($cmd);
  }

  /**
   * @public
   * @static
   * @description GNV - gettext - msgmerge 合并更新 po 文件
   * @function msgmerge
   * @param {string} $old_path 旧的po文件 Old po file path 
   * @param {string} $new_path 新的po路径 New po file path
   * @return {bollen|string}
   */
  static function msgmerge($old_path, $new_path){
    if(!(file_exists($old_path) && file_exists($new_path))){
      return false;
    }
    $cmd =  implode(
      array(
        '"' . zBuilder::joinPath(_libRoot, 'gettext', 'msgmerge.exe') . '"',
        "\"$old_path\"", "\"$new_path\"",
        '--update' // 更新 po 文件
	//'-N'//取消模糊匹配
      ),
      ' '
    );
    echo "\n[cmd] $cmd\n";
    return exec($cmd);
  }  
}
/*
 * @class nodejs
 */
abstract class nodejs{
  /**
   * @public 
   * @static
   * @function uglifyjs
   * @param {string} $path js文件路径。 js file path
   * @param {string} $otps 设置。 options
   * @return {string} 命令行返回的结果。 Result from cmd
   */
  public static function uglifyjs($path, $opts='--overwrite -nc'){
    $cmd = implode(
      array(
        zBuilder::joinPath(_libRoot, 'nodejs', 'uglifyjs.cmd'),
        $opts,
        $path
      ),
      ' '
    );
    echo "\n[cmd] $cmd\n";
    return exec($cmd);
  }

  /**
   * @public 
   * @static 
   * @function lessc
   * @param {string} $path less文件路径
   * @param {string} $opts 参数设置。 options
   * @return {string} 命令行返回的参数。 Result from cmd.
   */
  public static function lessc($path, $opts=""){
    $to = preg_replace('/\.less$/i','.less.css', $path);
    $to = $to !== $path ? $to : preg_replace('/\.css$/i', '.min.css', $path);
    if(!$opts){
      $opts = "--yui-compress >> \"$to\"";
    }
    $lessc = zBuilder::joinPath(_libRoot, 'nodejs', 'lessc.cmd');    
    $cmd = implode(
      array(
        "\"$lessc\"",
        "\"$path\"",
        $opts
      ),
      ' '
    );
    echo "\n[cmd] $cmd\n";
    $result = exec($cmd);
    unlink($path);
    rename($to, preg_replace('/\.(min|less)\.css$/','.css',$to));
    return $result;
  }

  /**
   * @public 
   * @static
   * @description 压缩文件（js/less/css） Compress files.
   * @param {string} $path 文件路径
   */
  public static function compress($path){
    if(!file_exists($path)){
      return;
    }
    if(preg_match('/\.js$/i', $path)){
      self::uglifyjs($path);
    } else if(preg_match('/\.(less|css)$/i',$path)){
      self::lessc($path);
    }
  }
}


# Global Methods
/**
 * @class Global
 * @description 一些全局变量，这堆东西现在还在被注释掉的状态
 */
/**
 * @function __s
 * @param {string} $str The string to translate
 * @return {string}
 */
/*
function __s($str){
  $func_num_args = func_num_args();
  $result = _($str);
  
  translateLogs::addLogs($str, $result); // -- Log --

  if($func_num_args > 1){
    $func_get_args = func_get_args();
    $func_get_args[0] = $result;
    $result = call_user_func_array('sprintf', $func_get_args);
  }
  return $result; 
}

/**
 * @function __
 * @param {string} $str The string to translate
 * @return {string}
 * @description echo the string after translate.
 */
/*
function __($str){
  $result = call_user_func_array('__s', func_get_args());
  echo $result;
  return $result;
}

/**
 * @function __f
 * @param {string} $str
 * @param {string} $char
 * @param {string} $pre
 * @return {string}
 */
/*
function __f($str, $char, $pre = '\\'){
  return str_replace($char, $pre . $str, $str);
}
/**/
