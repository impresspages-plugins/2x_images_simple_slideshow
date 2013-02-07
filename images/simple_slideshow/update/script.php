<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */



namespace Modules\images\simple_slideshow;

class Update
{
    private $currentVersion;

    public function __construct($currentVersion)
    {
        $this->currentVersion = $currentVersion;
    }

    public function execute()
    {
        global $parametersMod;
        if ((float)$this->currentVersion < 1.03) {
            $moduleId = $this->getModuleId('images', 'simple_slideshow');
            $parametersGroup = $this->getParameterGroup($moduleId, 'options');
            $groupId = $parametersGroup['id'];
            $this->addParameter($groupId, array('name' => 'playback_options', 'translation' => 'Playback options (http://jquery.malsup.com/cycle/options.html)', 'admin' => 0, 'type'=> 'textarea', 'value' => 'delay:200', 'comment' => 'Available options: http://jquery.malsup.com/cycle/options.html'));

                $value="timeout:3000
    fx:'fade'
    speed:800
    pager:'.ipPluginSimpleSlideshowTabs'";

            $parametersMod->setValue('images', 'simple_slideshow', 'options', 'playback_options', $value);


        }


    }



    private function addParameter($groupId, $parameter) {
        $sql = "insert into `".DB_PREF."parameter`
        set `name` = '".mysql_real_escape_string($parameter['name'])."',
        `admin` = '".mysql_real_escape_string($parameter['admin'])."',
        `group_id` = ".(int)$groupId.",
        `translation` = '".mysql_real_escape_string($parameter['translation'])."',
        `comment` = '".mysql_real_escape_string($parameter['comment'])."',
        `type` = '".mysql_real_escape_string($parameter['type'])."'";

        $rs = mysql_query($sql);
        if($rs) {
            $last_insert_id = mysql_insert_id();
            switch($parameter['type']) {
                case "string_wysiwyg":
                    $sql = "insert into `".DB_PREF."par_string` set `value` = '".mysql_real_escape_string($parameter['value'])."', `parameter_id` = ".$last_insert_id."";
                    $rs = mysql_query($sql);
                    if(!$rs)
                        throw new \IpUpdate\Library\UpdateException("Can't insert parameter ".$sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    break;
                case "string":
                    $sql = "insert into `".DB_PREF."par_string` set `value` = '".mysql_real_escape_string($parameter['value'])."', `parameter_id` = ".$last_insert_id."";
                    $rs = mysql_query($sql);
                    if(!$rs)
                        throw new \IpUpdate\Library\UpdateException("Can't insert parameter ".$sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    break;
                case "integer":
                    $sql = "insert into `".DB_PREF."par_integer` set `value` = ".mysql_real_escape_string($parameter['value']).", `parameter_id` = ".$last_insert_id."";
                    $rs = mysql_query($sql);
                    if(!$rs)
                        throw new \IpUpdate\Library\UpdateException("Can't insert parameter ".$sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    break;
                case "bool":
                    $sql = "insert into `".DB_PREF."par_bool` set `value` = ".mysql_real_escape_string($parameter['value']).", `parameter_id` = ".$last_insert_id."";
                    $rs = mysql_query($sql);
                    if(!$rs)
                        throw new \IpUpdate\Library\UpdateException("Can't insert parameter ".$sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    break;
                case "textarea":
                    $sql = "insert into `".DB_PREF."par_string` set `value` = '".mysql_real_escape_string($parameter['value'])."', `parameter_id` = ".$last_insert_id."";
                    $rs = mysql_query($sql);
                    if(!$rs)
                        throw new \IpUpdate\Library\UpdateException("Can't insert parameter ".$sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    break;

                case "lang":
                    $languages = self::getLanguages();
                    foreach($languages as $key => $language) {
                        $sql3 = "insert into `".DB_PREF."par_lang` set `translation` = '".mysql_real_escape_string($parameter['value'])."', `language_id` = '".$language['id']."', `parameter_id` = ".$last_insert_id." ";
                        $rs3 = mysql_query($sql3);
                        if(!$rs3)
                            throw new \IpUpdate\Library\UpdateException("Can't update parameter ".$sql3." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    }
                    break;
                case "lang_textarea":
                    $languages = self::getLanguages();
                    foreach($languages as $key => $language) {
                        $sql3 = "insert into `".DB_PREF."par_lang` set `translation` = '".mysql_real_escape_string($parameter['value'])."', `language_id` = '".$language['id']."', `parameter_id` = ".$last_insert_id." ";
                        $rs3 = mysql_query($sql3);
                        if(!$rs3)
                            throw new \IpUpdate\Library\UpdateException("Can't update parameter ".$sql3." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    }
                    break;
                case "lang_wysiwyg":
                    $languages = self::getLanguages();
                    foreach($languages as $key => $language) {
                        $sql3 = "insert into `".DB_PREF."par_lang` set `translation` = '".mysql_real_escape_string($parameter['value'])."', `language_id` = '".$language['id']."', `parameter_id` = ".$last_insert_id." ";
                        $rs3 = mysql_query($sql3);
                        if(!$rs3)
                            throw new \IpUpdate\Library\UpdateException("Can't update parameter ".$sql3." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
                    }
                    break;
            }
        }else {
            throw new \IpUpdate\Library\UpdateException($sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
        }
    }    
    

    private function getModuleId($group_name, $module_name){
        $answer = array();
        $sql = "select m.id from `".DB_PREF."module` m, `".DB_PREF."module_group` g
        where m.`group_id` = g.`id` and g.`name` = '".mysql_real_escape_string($group_name)."' and m.`name` = '".mysql_real_escape_string($module_name)."' ";
        $rs = mysql_query($sql);
        if($rs){
            if($lock = mysql_fetch_assoc($rs)){
                return $lock['id'];
            } else {
                return false;
            }
        } else {
            throw new \IpUpdate\Library\UpdateException($sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
            return false;
        }

    }

    private function getParameterGroup($module_id, $group_name){
        $sql = "select * from `".DB_PREF."parameter_group` where `module_id` = '".(int)$module_id."' and `name` = '".mysql_real_escape_string($group_name)."'";
        $rs = mysql_query($sql);
        if($rs){
            if($lock = mysql_fetch_assoc($rs))
                return $lock;
            else
                return false;
        }else{
            throw new \IpUpdate\Library\UpdateException($sql." ".mysql_error(), \IpUpdate\Library\UpdateException::SQL);
            return false;
        }
    }

}
