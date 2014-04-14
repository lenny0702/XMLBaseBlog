<meta charset="utf-8" />

<?php 
/*-
 * Copyright (c) 2013, LennyLan <lenny0702@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * Class SimpleXML 
 * @author 
 */
define("DB_PATH","./");
include "logs.php";
$old_path = getcwd();
chdir('./projects/tool/');
//$output = shell_exec('run.cmd');
chdir($old_path);
//Database::create("lenny",NULL,"lennyFirstTable");
//$row = Database::factory("logs",NULL,"Logs");
//$row->createTable("lennyFirstTable");
//$row->chooseTable("lennyFirstTable");
//$row->removeTable("lennyFirstTable");
//$row->removeTable("lenny2Table");
//`$row->save();
//foreach ($row->select()->find_all() as $log){
	//$logs[] = new Log($log);
//}
//var_dump($logs);
//print_r(replaceIndexLogs($logs));
//getSIngleLog($logs[1]);
$tmp = new Logs();
//$tmp->generateIndexLogs();
//$tmp->generateSingleLogPage();
$tmp->generateLogs();
echo "success";

?>
