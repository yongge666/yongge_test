<?php
/**
 * @class sendgoods_platform_assure_alipay
 */
class sendgoods_platform_assure_alipay
{
	/**
	 * @brief 开始向接口发送数据
	 * @param $data array 订单和配送数据
	 */
	public function send($data)
	{
		require_once(dirname(__FILE__)."/lib/alipay_submit.class.php");
		/* if(isset($data['seller_id']) && $data['seller_id'] > 0 ){
			//获取商户的支付配置信息
			$sellPay = new IModel("seller_payment");
			$sellers = $sellPay->getObj("seller_id = ".$data['seller_id']);
			if(empty($sellers)){
				return false;
			}
		} */
		
		$alipay_config = array(
			'partner'       => Payment::getConfigParam($data['pay_type'],'M_PartnerId'),
			'key'           => Payment::getConfigParam($data['pay_type'],'M_PartnerKey'),
			'sign_type'     => strtoupper('MD5'),
			'input_charset' => strtolower('utf-8'),
			'cacert'        => getcwd().'/cacert.pem',
			'transport'     => 'http'
		);

        //支付宝交易号
        $trade_no = $data['trade_no'];

        //必填
        //物流公司名称
        $logistics_name = $data['freight_type'];

        //必填
        //物流发货单号
        $invoice_no = $data['delivery_code'];

        //物流运输类型 三个值可选：POST（平邮）、EXPRESS（快递）、EMS（EMS）
        $transport_type = 'EXPRESS';

		//构造要请求的参数数组，无需改动
		$parameter = array
		(
			"service"        => "send_goods_confirm_by_platform",
			"partner"        => trim($alipay_config['partner']),
			"trade_no"	     => $trade_no,
			"logistics_name" => $logistics_name,
			"invoice_no"	 => $invoice_no,
			"transport_type" => $transport_type,
			"_input_charset" => trim(strtolower('utf-8'))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($parameter);
	}
}