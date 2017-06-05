<?php 
	/**
	 * @Author    FengHongLi
	 * @DateTime  2017-05-20
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [version]
	 * @param     [type]      $str [输入要验证的字符串]
	 * @return    boolean          [如果为空或者null返回true]
	 */
	function isEmpty($str){
		if(empty($str)&&$str!=0){
			return true;
		}else{
			return false;
		}
	}
 ?>