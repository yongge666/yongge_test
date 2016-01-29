<?php
/**
 * @brief 升级更新控制器
 */
class Update extends IController
{
	/**
	 * @brief iwebshop15051500 版本升级更新
	 */
	public function iwebshop15051500()
	{
		$sql = array(
			"ALTER TABLE `{pre}regiment` ADD `limit_min_count` int(11) NOT NULL default '0' COMMENT '每人限制最少购买数量'",
			"ALTER TABLE `{pre}regiment` ADD `limit_max_count` int(11) NOT NULL default '0' COMMENT '每人限制最多购买数量'",
			"ALTER TABLE `{pre}order` ADD `active_id` int(11) unsigned NOT NULL default '0' COMMENT '促销活动ID'",
			"INSERT INTO `{pre}payment` VALUES (NULL, '支付宝网银直连', 1, 'bank_alipay', '直接调用银行网关接口，通过网银直接付款，买家无需支付宝账号 <a href=\"http://www.alipay.com/\" target=\"_blank\">立即申请</a>', '/payments/logos/pay_alipay_bank.png', 0, 99, NULL, 0.00, 1, NULL,1);",
			"INSERT INTO `{pre}payment` VALUES (NULL, '银联在线支付', 1, 'unionpay', '银联unionpay平台接口。<a href=\'https://open.unionpay.com/ajweb/index\' target=\'_blank\'>立即申请</a>', '/payments/logos/pay_unionpay.png',0, 99, NULL, 0.00, 1, NULL,1);",
			"INSERT INTO `{pre}payment` VALUES (NULL, '银联支付', 1, 'chinapay', '银联chinapay平台接口。<a href=\'http://www.chinapay.com/\' target=\'_blank\'>立即申请</a>', '/payments/logos/pay_chinapay.png',0, 99, NULL, 0.00, 1, NULL,1);",
			"ALTER TABLE `{pre}order` ADD `checkcode` varchar(255) default NULL COMMENT '自提方式的验证码'",
		);

		foreach($sql as $key => $val)
		{
			$val = str_replace('{pre}',IWeb::$app->config['DB']['tablePre'],$val);
			IDBFactory::getDB()->query($val);
		}

		die('升级成功！');
	}
}