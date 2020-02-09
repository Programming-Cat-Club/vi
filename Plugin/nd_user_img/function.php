<?php
function plugin_install(){
    if(!get_plugin_install_state("nd_user_img"))
    {
        $sql = file_get_contents(PLUGIN_PATH."nd_user_img/install.sql");
        $data = S("user");
       if($data -> query($sql))
        {
            file_put_contents(PLUGIN_PATH."nd_user_img/on","");
            return true;
        }else{
           return false;
       }
    }else{
        return false;
    }
}
function plugin_uninstall(){
    if (get_plugin_install_state("nd_user_img"))
    {
        $data = S("user");
        $sql = "DROP TABLE `hy_user_style`";
        if($data -> query($sql))
        {
            unlink(PLUGIN_PATH."nd_user_img/on");
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}