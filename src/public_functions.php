<?php 
/*
*将文本保存到制定目录并返回Url
*$path:路径起始为根目录eg：/yora/uploaddata/house
*路径中没有的文件夹会自动创建
 */
	function saveContentToFile($path,$content){
    if (is_dir($_SERVER['DOCUMENT_ROOT'].$path)){  
    }else{
       $res=@mkdir($_SERVER['DOCUMENT_ROOT'].$path,0777,true); 
       if ($res){
           //echo "目录 $path 创建成功";
       }else{
           return "";
       }
    }
    //修改照片
    date_default_timezone_set('PRC');//设置时区
    $t=date('Y-m-d', time());
    $str="qwertyuiopasdghjklzxcvbnm1234567890";
    $file=$t.substr(str_shuffle($str),0,6);
    $new_file = "$path/$file.txt";
    if (file_put_contents($_SERVER['DOCUMENT_ROOT'].$new_file,$content)){
      return $new_file;
    }
    return "";
  }
/*
*返回用户Ip
 */
  function getIP(){
      static $realip;
      if (isset($_SERVER)){
          if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
              $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
          } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
              $realip = $_SERVER["HTTP_CLIENT_IP"];
          } else {
              $realip = $_SERVER["REMOTE_ADDR"];
          }
      } else {
          if (getenv("HTTP_X_FORWARDED_FOR")){
              $realip = getenv("HTTP_X_FORWARDED_FOR");
          } else if (getenv("HTTP_CLIENT_IP")) {
              $realip = getenv("HTTP_CLIENT_IP");
          } else {
              $realip = getenv("REMOTE_ADDR");
          }
      }
      return $realip;
  }

  /**
   * @Author    FengHongLi
   * @DateTime  2017-05-18
   * @copyright [copyright]
   * @license   [license]
   * @version   [version]
   * @return    [type]      [description]
   * 这个函数要在引入MySqlPDO.class.php后使用
   */
  function placeFromMysqlToJson(){
    $mypdo_province=new MySqlPDO();
    $mypdo_city=new MySqlPDO();
    $mypdo_school=new MySqlPDO();
    $data=array();
    $temp_school_all=array();
    $temp_city_all=array();
    $temp_province_all=array();
    $temp_school_all['name']="全部学校";
    $temp_school_all['Id']="";

    $temp_city_all['name']="全部城市";
    $temp_city_all['Id']="";
    $temp_city_all['sub']=array();
    $temp_city_all['sub'][]=$temp_school_all;

    $temp_province_all['name']="全国";
    $temp_province_all['Id']="";
    $temp_province_all['sub']=array();
    $temp_province_all['sub'][]=$temp_city_all;

    $data[]=$temp_province_all;
    $sql_province="SELECT * FROM `os_province`";
    $mypdo_province->prepare($sql_province);
    if($mypdo_province->executeArr(array())){
      while ($rs_province=$mypdo_province->fetch()) {
        $temp_province=array();
        $temp_province['name']=$rs_province['Name'];
        $temp_province['Id']=$rs_province['Id'];
        $temp_province['sub']=array();
        $temp_province['sub'][]=$temp_city_all;

        $sql_city="SELECT * FROM `os_city` WHERE `ProvinceId`=?";
        $mypdo_city->prepare($sql_city);
        if($mypdo_city->executeArr(array($rs_province['Id']))){
          while ($rs_city=$mypdo_city->fetch()) {
            $temp_city=array();
            $temp_city['name']=$rs_city['Name'];
            $temp_city['Id']=$rs_city['Id'];
            $temp_city['sub']=array();
            $temp_city['sub'][]=$temp_school_all;
            
            $sql_school="SELECT * FROM `os_school` WHERE `CityId`=?";
            $mypdo_school->prepare($sql_school);
            if($mypdo_school->executeArr(array($rs_city['Id']))){
              
              while ($rs_school=$mypdo_school->fetch()) {
                $temp_school=array();
                $temp_school['name']=$rs_school['Name'];
                $temp_school['Id']=$rs_school['Id'];
                $temp_city['sub'][]=$temp_school;
              }
            }

            $temp_province['sub'][]=$temp_city;
          }
        }
        $data[]=$temp_province;
      }
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT']."/onlineShop/src/v1/place/place.json", json_encode($data));
  }
?>