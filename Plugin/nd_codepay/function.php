<?php
function plugin_install(){
	if(!get_plugin_install_state("nd_codepay"))
    {
	    $sql = S("Plugin");
	    if(!$sql->query("
        CREATE TABLE `hy_nd_codepay_order` (
            `id` int(11) UNSIGNED NOT NULL,
            `pay_id` varchar(50) NOT NULL COMMENT '用户ID或订单ID',
            `money` decimal(6,2) UNSIGNED NOT NULL COMMENT '实际金额',
            `jinbi` int(10) DEFAULT '0' COMMENT '金币',
            `jifen` int(11) DEFAULT '0' COMMENT '网站积分',
            `price` decimal(6,2) UNSIGNED NOT NULL COMMENT '原价',
            `type` int(1) NOT NULL DEFAULT '1' COMMENT '支付方式',
            `pay_no` varchar(100) NOT NULL COMMENT '流水号',
            `param` varchar(200) DEFAULT NULL COMMENT '自定义参数',
            `pay_time` bigint(11) NOT NULL DEFAULT '0' COMMENT '付款时间',
            `pay_tag` varchar(100) NOT NULL DEFAULT '0' COMMENT '金额的备注',
            `status` int(1) NOT NULL DEFAULT '0' COMMENT '订单状态',
            `creat_time` bigint(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
            `up_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用于区分是否已经处理';
		ALTER TABLE `hy_nd_codepay_order`
		  ADD PRIMARY KEY (`id`),
		  ADD UNIQUE KEY `main` (`pay_id`,`pay_time`,`money`,`type`,`pay_tag`),
		  ADD UNIQUE KEY `pay_no` (`pay_no`,`type`);

		ALTER TABLE `hy_nd_codepay_order`
		  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
		COMMIT;
	    ")){
	        return false;
	    }
	    file_put_contents(PLUGIN_PATH."nd_codepay/on","");
	    return true;
	}
} 
//插件卸载时 执行的安装函数
function plugin_uninstall(){
	if (get_plugin_install_state("nd_codepay"))
    {
	    $sql = S("Plugin");
	    if(!$sql->query("DROP TABLE `hy_nd_codepay_order`;")){    	
	        return false;
	    }
	    unlink(PLUGIN_PATH."nd_codepay/on");
	    return true;
	}
}