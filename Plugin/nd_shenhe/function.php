<?php
function plugin_install(){
    if(!get_plugin_install_state("nd_shenhe"))
    {
        $data = S("user");
        $sql = "
        ALTER TABLE `hy_thread` ADD `shenhe` TINYINT(1) UNSIGNED NULL DEFAULT '0' COMMENT '审核' AFTER `state`;
        CREATE TABLE `hy_plugins_shenhe` ( `id` INT NOT NULL AUTO_INCREMENT , `tid` INT(11) NOT NULL , `state` TINYINT(2) NOT NULL , UNIQUE (`id`)) ENGINE = InnoDB;
        ";
       if($data -> query($sql)){
            file_put_contents(PLUGIN_PATH."nd_shenhe/on","");
            return true;
        }else{
           return false;
       }
    }else{
        return false;
    }
    
}
function plugin_uninstall(){
    if (get_plugin_install_state("nd_shenhe"))
    {
        $data = S("user");
        $sql = "ALTER TABLE
            `hy_thread` DROP `shenhe`,
            `hy_plugins_shenhe`;";
            
        if($data -> query($sql))
        {
            unlink(PLUGIN_PATH."nd_shenhe/on");
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
                    