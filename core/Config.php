<?php
/*monsterlab v 1.0.0.10 */
 

if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");

/* settings */


$config["DEBUG"]=true;/*false*/
$config["SHOWLOG"]=true;
$config["session_max_time"]=60*2; 
$config["refurl"]=isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:null;

/*folders*/
/* dont forget to append the "/" after dir name*/

$folder=array(

"apps"=>BASEPATH."apps/",
"core"=>BASEPATH."core/",
"plugin"=>BASEPATH."plugin/",
"cache"=>BASEPATH."cache/",

"controller"=>BASEPATH."apps/controller/",
"css"=>BASEPATH."apps/css/",
"image"=>BASEPATH."apps/image/",
"js"=>BASEPATH."apps/js/",
"model"=>BASEPATH."apps/model/",
"vendor"=>BASEPATH."apps/vendor/",
"view"=>BASEPATH."apps/view/",
"router"=>BASEPATH."apps/router/", 
"security"=>BASEPATH."apps/security/",

"config"=>BASEPATH."core/config/",
"uploads"=>BASEPATH."apps/ext/uploads/",

"title"=>"Microwave"
);

$model=array("dbdriver"=>"mysqli",
		"hostname"=>"localhost",
		"username"=>"root",
		"database"=>"monsterlab",
		"password"=>"",
		"prefix"=>"_ml");

$config=array_merge($folder,$config); 
$config["db"]=$model;

ini_set("display_errors",$config["DEBUG"]);
