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

if (file_exists("logs.xml")) {
	$xml = simplexml_load_file("logs.xml");
	printXML($xml);
}else{
		print_r("test");

}
function printXML($xml){
	$count = 1;
	foreach($xml->children() as $rootItem){
		$count++;
		print_r($count);
		print_r("&nbsp;&nbsp;&nbsp;&nbsp;");
		print_r($rootItem->getName()."</br>");
		print_r($rootItem."</br>");
		if($rootItem){
			printXML($rootItem);
		}
	}
}
?>
