<?php
/**
 * @brief 营销模块
 * @class Market
 * @note  后台
 */
class Market extends IController
{
	public $checkRight  = 'all';
	public $layout = 'admin';
	private $ticketDir = 'backup/ticket';

	function init()
	{
		IInterceptor::reg('CheckRights@onCreateAction');
	}

	//修改代金券状态is_close和is_send
	function ticket_status()
	{
		$status    = IFilter::act(IReq::get('status'));
		$id        = IFilter::act(IReq::get('id'),'int');
		$ticket_id = IFilter::act(IReq::get('ticket_id'));

		if(!empty($id) && $status != null && $ticket_id != null)
		{
			$ticketObj = new IModel('prop');
			if(is_array($id))
			{
				foreach($id as $val)
				{
					$where = 'id = '.$val;
					$ticketRow = $ticketObj->getObj($where,$status);
					if($ticketRow[$status]==1)
					{
						$ticketObj->setData(array($status => 0));
					}
					else
					{
						$ticketObj->setData(array($status => 1));
					}
					$ticketObj->update($where);
				}
			}
			else
			{
				$where = 'id = '.$id;
				$ticketRow = $ticketObj->getObj($where,$status);
				if($ticketRow[$status]==1)
				{
					$ticketObj->setData(array($status => 0));
				}
				else
				{
					$ticketObj->setData(array($status => 1));
				}
				$ticketObj->update($where);
			}
			$this->redirect('ticket_more_list/ticket_id/'.$ticket_id);
		}
		else
		{
			$this->ticket_id = $ticket_id;
			$this->redirect('ticket_more_list',false);
			Util::showMessage('请选择要修改的id值');
		}
	}

	//[代金券]获取代金券数量
	function getTicketCount($propObj,$id)
	{
		$where     = '`condition` = "'.$id.'"';
		$propCount = $propObj->getObj($where,'count(*) as count');
		return $propCount['count'];
	}

	//[代金券]添加,修改[单页]
	function ticket_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$ticketObj       = new IModel('ticket');
			$where           = 'id = '.$id;
			$this->ticketRow = $ticketObj->getObj($where);
		}
		$this->redirect('ticket_edit');
	}

	//[代金券]添加,修改[动作]
	function ticket_edit_act()
	{
		$id        = IFilter::act(IReq::get('id'),'int');
		$ticketObj = new IModel('ticket');

		$dataArray = array(
			'name'      => IFilter::act(IReq::get('name','post')),
			'value'     => IFilter::act(IReq::get('value','post')),
			'start_time'=> IFilter::act(IReq::get('start_time','post')),
			'end_time'  => IFilter::act(IReq::get('end_time','post')),
			'point'     => IFilter::act(IReq::get('point','post')),
		);

		$ticketObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$ticketObj->update($where);
		}
		else
		{
			$ticketObj->add();
		}
		$this->redirect('ticket_list');
	}

	//[代金券]生成[动作]
	function ticket_create()
	{
		$propObj   = new IModel('prop');
		$prop_num  = intval(IReq::get('num'));
		$ticket_id = intval(IReq::get('ticket_id'));

		if($prop_num && $ticket_id)
		{
			$prop_num  = ($prop_num > 5000) ? 5000 : $prop_num;
			$ticketObj = new IModel('ticket');
			$where     = 'id = '.$ticket_id;
			$ticketRow = $ticketObj->getObj($where);

			for($item = 0; $item < intval($prop_num); $item++)
			{
				$dataArray = array(
					'condition' => $ticket_id,
					'name'      => $ticketRow['name'],
					'card_name' => 'T'.IHash::random(8),
					'card_pwd'  => IHash::random(8),
					'value'     => $ticketRow['value'],
					'start_time'=> $ticketRow['start_time'],
					'end_time'  => $ticketRow['end_time'],
				);

				//判断code码唯一性
				$where = 'card_name = \''.$dataArray['card_name'].'\'';
				$isSet = $propObj->getObj($where);
				if(!empty($isSet))
				{
					$item--;
					continue;
				}
				$propObj->setData($dataArray);
				$propObj->add();
			}
			$logObj = new Log('db');
			$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"生成了代金券","面值：".$ticketRow['value']."元，数量：".$prop_num."张"));
		}
		$this->redirect('ticket_list');
	}

	//[代金券]删除
	function ticket_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if(!empty($id))
		{
			$ticketObj = new IModel('ticket');
			$propObj   = new IModel('prop');
			$propRow   = $propObj->getObj(" `type` = 0 and `condition` = {$id} and (is_close = 2 or (is_userd = 0 and is_send = 1)) ");

			if($propRow)
			{
				$this->redirect('ticket_list',false);
				Util::showMessage('无法删除代金券，其下还有正在使用的代金券');
				exit;
			}

			$where = "id = {$id} ";
			$ticketRow = $ticketObj->getObj($where);
			if($ticketObj->del($where))
			{
				$where = " `type` = 0 and `condition` = {$id} ";
				$propObj->del($where);

				$logObj = new Log('db');
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"删除了一种代金券","代金券名称：".$ticketRow['name']));
			}
			$this->redirect('ticket_list');
		}
		else
		{
			$this->redirect('ticket_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[代金券详细]删除
	function ticket_more_del()
	{
		$id        = IFilter::act(IReq::get('id'),'int');
		$ticket_id = IFilter::act(IReq::get('ticket_id'),'int');
		if($id)
		{
			$ticketObj = new IModel('ticket');
			$ticketRow = $ticketObj->getObj('id = '.$ticket_id);
			$logObj    = new Log('db');
			$propObj   = new IModel('prop');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"批量删除了实体代金券","代金券名称：".$ticketRow['name']."，数量：".count($id)));
			}
			else
			{
				$where = 'id = '.$id;
				$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"删除了1张实体代金券","代金券名称：".$ticketRow['name']));
			}
			$propObj->del($where);
			$this->redirect('ticket_more_list/ticket_id/'.$ticket_id);
		}
		else
		{
			$this->ticket_id = $ticket_id;
			$this->redirect('ticket_more_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[代金券详细] 列表
	function ticket_more_list()
	{
		$this->ticket_id = IFilter::act(IReq::get('ticket_id'),'int');
		$this->redirect('ticket_more_list');
	}

	//[代金券] 输出excel表格
	function ticket_excel()
	{
		//代金券excel表存放地址
		$fileName = $this->ticketDir.'/t'.date('YmdHis').IHash::random(8).'.xls';
		$ticket_id = IFilter::act(IReq::get('id'));
		$ticket_id_array = array();

		if(!empty($ticket_id))
		{
			$excelStr = '<table><tr><th>名称</th><th>卡号</th><th>密码</th><th>面值</th>
			<th>已被使用</th><th>是否关闭</th><th>是否发送</th><th>开始时间</th><th>结束时间</th></tr>';

			$propObj = new IModel('prop');
			$where   = 'type = 0';
			if(is_array($ticket_id))
			{
				$ticket_id_array = $ticket_id;
			}
			else
			{
				$ticket_id_array[] = $ticket_id;
			}

			//当代金券数量没有时不允许备份excel
			foreach($ticket_id_array as $key => $tid)
			{
				if($this->getTicketCount($propObj,$tid) == 0)
				{
					unset($ticket_id_array[$key]);
				}
			}

			if($ticket_id_array)
			{
				$id_num_str = join('","',$ticket_id_array);
			}
			else
			{
				$this->redirect('ticket_list',false);
				Util::showMessage('实体代金券数量为0张，无法备份');
				exit;
			}

			$where.= ' and `condition` in("'.$id_num_str.'")';

			$propList = $propObj->query($where,'*','`condition`','asc','10000');
			foreach($propList as $key => $val)
			{
				$is_userd = ($val['is_userd']=='1') ? '是':'否';
				$is_close = ($val['is_close']=='1') ? '是':'否';
				$is_send  = ($val['is_send']=='1') ? '是':'否';

				$excelStr.='<tr>';
				$excelStr.='<td>'.$val['name'].'</td>';
				$excelStr.='<td>'.$val['card_name'].'</td>';
				$excelStr.='<td>'.$val['card_pwd'].'</td>';
				$excelStr.='<td>'.$val['value'].' 元</td>';
				$excelStr.='<td>'.$is_userd.'</td>';
				$excelStr.='<td>'.$is_close.'</td>';
				$excelStr.='<td>'.$is_send.'</td>';
				$excelStr.='<td>'.$val['start_time'].'</td>';
				$excelStr.='<td>'.$val['end_time'].'</td>';
				$excelStr.='</tr>';
			}
			$excelStr.='</table>';

			$fileObj = new IFile($fileName,'w+');
			$fileObj->write($excelStr);
			$this->ticket_excel_list();
		}
		else
		{
			$this->redirect('ticket_list',false);
			Util::showMessage('请选择要操作的文件');
		}
	}

	//[代金券] 展示excel文件
	function ticket_excel_list()
	{
		IFile::mkdir($this->ticketDir);

		$dirArray = array();
		$dirRes   = opendir($this->ticketDir);
		while($fileName = readdir($dirRes))
		{
			if(!in_array($fileName,IFile::$except))
			{
				$dirArray[$fileName]['name'] = $fileName;
				$dirArray[$fileName]['size'] = filesize($this->ticketDir.'/'.$fileName);
				$dirArray[$fileName]['time'] = date('Y-m-d',fileatime($this->ticketDir.'/'.$fileName));
			}
		}
		$this->dirArray = $dirArray;
		$this->redirect('ticket_excel_list',false);
	}

	//[代金券] excel文件删除
	function ticket_excel_del()
	{
		$id = IFilter::act(IReq::get('id'));
		if($id)
		{
			if(is_array($id))
			{
				foreach($id as $val)
				{
					IFile::unlink($this->ticketDir.'/'.$val);
				}
			}
			else
			{
				IFile::unlink($this->ticketDir.'/'.$id);
			}
			$this->ticket_excel_list();
		}
		else
		{
			$this->ticket_excel_list();
			Util::showMessage('请选择要删除的文件');
		}
	}

	//[代金券] excel文件下载
	function ticket_excel_download($fileName = null)
	{
		if($fileName==null)
		{
			$file = IFilter::act(IReq::get('file'),'filename');
		}
		else
		{
			$file = $fileName;
		}

		if($file != null)
		{
			header('Content-Description: File Transfer');
			header('Content-Length: '.filesize($this->ticketDir.'/'.$file));
			header('Content-Disposition: attachment; filename='.basename($file));
			readfile($this->ticketDir.'/'.$file);
		}
	}

	//[代金券] excel打包
	function ticket_excel_pack()
	{
		if(class_exists('ZipArchive'))
		{
			//获取要打包的文件数组
			$fileArray = IFilter::act(IReq::get('id'));
			if(!empty($fileArray))
			{
				$fileName = 'T_'.date('YmdHis').IHash::random(8).'.zip';
				$zip = new ZipArchive();
				$zip->open($this->ticketDir.'/'.$fileName,ZIPARCHIVE::CREATE);
				foreach($fileArray as $file)
				{
					$attachfile = $this->ticketDir.'/'.$file;
					$zip->addFile($attachfile,basename($attachfile));
				}
				$zip->close();
				$this->ticket_excel_download($fileName);
				@unlink($this->ticketDir.'/'.$fileName);
			}
			else
			{
				$this->ticket_excel_list();
				Util::showMessage('请选择要打包的文件');
			}
		}
		else
		{
			$this->ticket_excel_list();
			Util::showMessage('您的php环境没有打包工具类库');
		}
	}

	//[代金券]获取代金券数据
	function getTicketList()
	{
		$ticketObj  = new IModel('ticket');
		$ticketList = $ticketObj->query();
		echo JSON::encode($ticketList);
	}

	//[促销活动] 添加修改 [单页]
	function pro_rule_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$promotionObj = new IModel('promotion');
			$where = 'id = '.$id;
			$this->promotionRow = $promotionObj->getObj($where);
		}
		$this->redirect('pro_rule_edit');
	}

	//[促销活动] 添加修改 [动作]
	function pro_rule_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$promotionObj = new IModel('promotion');

		$group_all    = IReq::get('group_all','post');
		if($group_all == 'all')
		{
			$user_group_str = 'all';
		}
		else
		{
			$user_group = IFilter::act(IReq::get('user_group','post'),'int');
			$user_group_str = '';
			if($user_group)
			{
				$user_group_str = join(',',$user_group);
				$user_group_str = ','.$user_group_str.',';
			}
		}

		$dataArray = array(
			'name'       => IFilter::act(IReq::get('name','post')),
			'condition'  => IFilter::act(IReq::get('condition','post')),
			'is_close'   => IFilter::act(IReq::get('is_close','post')),
			'start_time' => IFilter::act(IReq::get('start_time','post')),
			'end_time'   => IFilter::act(IReq::get('end_time','post')),
			'intro'      => IFilter::act(IReq::get('intro','post'),'text'),
			'award_type' => IFilter::act(IReq::get('award_type','post')),
			'type'       => 0,
			'user_group' => $user_group_str,
			'award_value'=> IFilter::act(IReq::get('award_value','post')),
		);

		$promotionObj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id;
			$promotionObj->update($where);
		}
		else
		{
			$promotionObj->add();
		}
		$this->redirect('pro_rule_list');
	}

	//[促销活动] 删除
	function pro_rule_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if(!empty($id))
		{
			$promotionObj = new IModel('promotion');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$promotionObj->del($where);
			$this->redirect('pro_rule_list');
		}
		else
		{
			$this->redirect('pro_rule_list',false);
			Util::showMessage('请选择要删除的促销活动');
		}
	}

	//[限时抢购]添加,修改[单页]
	function pro_speed_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$promotionObj = new IModel('promotion');
			$where = 'id = '.$id;
			$promotionRow = $promotionObj->getObj($where);
			if(empty($promotionRow))
			{
				$this->redirect('pro_speed_list');
			}

			//促销商品
			$goodsObj = new IModel('goods');
			$goodsRow = $goodsObj->getObj('id = '.$promotionRow['condition'],'id,name,sell_price,img');
			if($goodsRow)
			{
				$result = array(
					'isError' => false,
					'data'    => $goodsRow,
				);
			}
			else
			{
				$result = array(
					'isError' => true,
					'message' => '关联商品被删除，请重新选择要抢购的商品',
				);
			}

			$promotionRow['goodsRow'] = JSON::encode($result);
			$this->promotionRow = $promotionRow;
		}
		$this->redirect('pro_speed_edit');
	}

	//[限时抢购]添加,修改[动作]
	function pro_speed_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		$condition    = IFilter::act(IReq::get('condition','post'));
		$award_value  = IFilter::act(IReq::get('award_value','post'));
		$group_all    = IFilter::act(IReq::get('group_all','post'));
		if($group_all == 'all')
		{
			$user_group_str = 'all';
		}
		else
		{
			$user_group = IFilter::act(IReq::get('user_group','post'),'int');
			$user_group_str = '';
			if(!empty($user_group))
			{
				$user_group_str = join(',',$user_group);
				$user_group_str = ','.$user_group_str.',';
			}
		}

		$dataArray = array(
			'id'         => $id,
			'name'       => IFilter::act(IReq::get('name','post')),
			'condition'  => $condition,
			'award_value'=> $award_value,
			'is_close'   => IFilter::act(IReq::get('is_close','post')),
			'start_time' => IFilter::act(IReq::get('start_time','post')),
			'end_time'   => IFilter::act(IReq::get('end_time','post')),
			'intro'      => IFilter::act(IReq::get('intro','post')),
			'type'       => 1,
			'award_type' => 0,
			'user_group' => $user_group_str,
		);

		if(!$condition || !$award_value)
		{
			$this->promotionRow = $dataArray;
			$this->redirect('pro_speed_edit',false);
			Util::showMessage('请添加促销的商品，并为商品填写价格');
		}

		$proObj = new IModel('promotion');
		$proObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$proObj->update($where);
		}
		else
		{
			$proObj->add();
		}
		$this->redirect('pro_speed_list');
	}

	//[限时抢购]删除
	function pro_speed_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if(!empty($id))
		{
			$propObj = new IModel('promotion');
			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$propObj->del($where);
			$this->redirect('pro_speed_list');
		}
		else
		{
			$this->redirect('pro_speed_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[团购]添加修改[单页]
	function regiment_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$regimentObj = new IModel('regiment');
			$where       = 'id = '.$id;
			$regimentRow = $regimentObj->getObj($where);
			if(!$regimentRow)
			{
				$this->redirect('regiment_list');
			}

			//促销商品
			$goodsObj = new IModel('goods');
			$goodsRow = $goodsObj->getObj('id = '.$regimentRow['goods_id']);

			$result = array(
				'isError' => false,
				'data'    => $goodsRow,
			);
			$regimentRow['goodsRow'] = JSON::encode($result);
			$this->regimentRow = $regimentRow;
		}
		$this->redirect('regiment_edit');
	}

	//[团购]添加修改[动作]
	function regiment_edit_act()
	{
		$id      = IFilter::act(IReq::get('id'),'int');
		$goodsId = IFilter::act(IReq::get('goods_id'),'int');

		$dataArray = array(
			'id'        	=> $id,
			'title'     	=> IFilter::act(IReq::get('title','post')),
			'start_time'	=> IFilter::act(IReq::get('start_time','post')),
			'end_time'  	=> IFilter::act(IReq::get('end_time','post')),
			'is_close'      => IFilter::act(IReq::get('is_close','post')),
			'intro'     	=> IFilter::act(IReq::get('intro','post')),
			'goods_id'      => $goodsId,
			'store_nums'    => IFilter::act(IReq::get('store_nums','post')),
			'limit_min_count' => IFilter::act(IReq::get('limit_min_count','post'),'int'),
			'limit_max_count' => IFilter::act(IReq::get('limit_max_count','post'),'int'),
			'regiment_price'=> IFilter::act(IReq::get('regiment_price','post')),
			'sort'          => IFilter::act(IReq::get('sort','post')),
		);

		if($goodsId)
		{
			$goodsObj = new IModel('goods');
			$where    = 'id = '.$goodsId;
			$goodsRow = $goodsObj->getObj($where);

			//处理上传图片
			if(isset($_FILES['img']['name']) && $_FILES['img']['name'] != '')
			{
				$uploadObj = new PhotoUpload();
				$photoInfo = $uploadObj->run();
				$dataArray['img'] = $photoInfo['img']['img'];
			}
			else
			{
				$dataArray['img'] = $goodsRow['img'];
			}

			$dataArray['sell_price'] = $goodsRow['sell_price'];
		}
		else
		{
			$this->regimentRow = $dataArray;
			$this->redirect('regiment_edit',false);
			Util::showMessage('请选择要关联的商品');
		}

		$regimentObj = new IModel('regiment');
		$regimentObj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id;
			$regimentObj->update($where);
		}
		else
		{
			$regimentObj->add();
		}
		$this->redirect('regiment_list');
	}

	//[团购]删除
	function regiment_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$regObj     = new IModel('regiment');

			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
				$uwhere= ' regiment_id in ('.$idStr.')';
			}
			else
			{
				$where  = 'id = '.$id;
				$uwhere = 'regiment_id = '.$id;
			}
			$regObj->del($where);
			$this->redirect('regiment_list');
		}
		else
		{
			$this->redirect('regiment_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//账户余额记录
	function account_list()
	{
		$page       = intval(IReq::get('page')) ? IReq::get('page') : 1;
		$event      = intval(IReq::get('event'));
		$startDate  = IFilter::act(IReq::get('startDate'));
		$endDate    = IFilter::act(IReq::get('endDate'));

		$where      = "event != 3";
		if($startDate)
		{
			$where .= " and time >= '{$startDate}' ";
		}

		if($endDate)
		{
			$temp   = $endDate.' 23:59:59';
			$where .= " and time <= '{$temp}' ";
		}

		if($event)
		{
			$where .= " and event = $event ";
		}

		$accountObj = new IQuery('account_log');
		$accountObj->where = $where;
		$accountObj->order = 'id desc';
		$accountObj->page  = $page;

		$this->accountObj  = $accountObj;
		$this->event       = $event;
		$this->startDate   = $startDate;
		$this->endDate     = $endDate;
		$this->accountList = $accountObj->find();

		$this->redirect('account_list');
	}

	//后台操作记录
	function operation_list()
	{
		$page       = intval(IReq::get('page')) ? IReq::get('page') : 1;
		$startDate  = IFilter::act(IReq::get('startDate'));
		$endDate    = IFilter::act(IReq::get('endDate'));

		$where      = "1";
		if($startDate)
		{
			$where .= " and datetime >= '{$startDate}' ";
		}

		if($endDate)
		{
			$temp   = $endDate.' 23:59:59';
			$where .= " and datetime <= '{$temp}' ";
		}

		$operationObj = new IQuery('log_operation');
		$operationObj->where = $where;
		$operationObj->order = 'id desc';
		$operationObj->page  = $page;

		$this->operationObj  = $operationObj;
		$this->startDate     = $startDate;
		$this->endDate       = $endDate;
		$this->operationList = $operationObj->find();

		$this->redirect('operation_list');
	}

	//清理后台管理员操作日志
	function clear_log()
	{
		$type  = IReq::get('type');
		$month = intval(IReq::get('month'));
		if(!$month)
		{
			die('请填写要清理日志的月份');
		}

		$diffSec = 3600*24*30*$month;
		$lastTime= strtotime(date('Y-m')) - $diffSec;
		$dateStr = date('Y-m',$lastTime);

		switch($type)
		{
			case "account":
			{
				$logObj = new IModel('account_log');
				$logObj->del("time <= '{$dateStr}'");
				$this->redirect('account_list');
				break;
			}
			case "operation":
			{
				$logObj = new IModel('log_operation');
				$logObj->del("datetime <= '{$dateStr}'");
				$this->redirect('operation_list');
				break;
			}
			default:
				die('缺少类别参数');
		}
	}

	//修改结算账单
	public function bill_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$billDB = new IModel('bill');
		$this->billRow = $billDB->getObj('id = '.$id);
		$this->redirect('bill_edit');
	}

	//结算单修改
	public function bill_update()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$pay_content = IFilter::act(IReq::get('pay_content'));
		$is_pay = IFilter::act(IReq::get('is_pay'),'int');

		if($id)
		{
			$data = array(
				'admin_id' => $this->admin['admin_id'],
				'pay_content' => $pay_content,
				'is_pay' => $is_pay,
			);

			$billDB = new IModel('bill');

			$data['pay_time'] = ($is_pay == 1) ? date('Y-m-d H:i:s') : "";

			$billRow= $billDB->getObj('id = '.$id);
			if(isset($billRow['order_goods_ids']) && $billRow['order_goods_ids'])
			{
				//更新订单商品关系表中的结算字段
				$orderGoodsDB = new IModel('order_goods');
				$orderGoodsIdArray = explode(',',$billRow['order_goods_ids']);
				foreach($orderGoodsIdArray as $key => $val)
				{
					$orderGoodsDB->setData(array('is_checkout' => $is_pay));
					$orderGoodsDB->update('id = '.$val);
				}
			}

			$billDB->setData($data);
			$billDB->update('id = '.$id);
		}
		$this->redirect('bill_list');
	}

	//结算单删除
	public function bill_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$billDB = new IModel('bill');
			$billDB->del('id = '.$id.' and is_pay = 0');
		}

		$this->redirect('bill_list');
	}

	//导出用户统计数据
	public function user_report(){
		$start = IFilter::act(IReq::get('start'));
		$end   = IFilter::act(IReq::get('end'));

		$_date = statistics::dateParse($start,$end);//处理起始和终止时间
		$startTime = strtotime($_date[0]); //开始时间戳
		$endTime = strtotime($_date[1]); //结束时间戳


		$dayNum = 1+($endTime-$startTime)/86400; //时间段内的天数


		$strTable ='<table style="width:475px;" border="1">';
		$strTable .= '<tr>';
		$strTable .= '<td style="width:120px;font-size:12px;padding:4px;text-align:center;">日期</td>';
		$strTable .= '<td width="*" style="font-size:12px;padding:4px;text-align:center;">用户名</td>';
		$strTable .= '<td style="width:40px;font-size:12px;padding:4px;text-align:center;">总数</td>';
		$strTable .= '</tr>';

		$memberQuery= new IQuery('member as m');
		$memberQuery->join = 'left join user as u on m.user_id=u.id';
		$memberQuery->fields = 'u.username,m.time';

		for($i=0;$i<$dayNum;$i++){
			//构建sql语句
			$endTime = $startTime+86400;
			$where = "m.time between '".date('Y-m-d',$startTime)."' and '".date('Y-m-d',$endTime)."'";
			$startTime = $endTime;
			$memberQuery->where = $where;
			$memberList = $memberQuery->find();
			$count = count($memberList);
			if ($count>0){
				foreach($memberList as $k=>$val){
					$strTable .= '<tr>';
					$strTable .= '<td style="font-size:12px;padding:4px;">'.$val['time'].' </td>';
					$strTable .= '<td style="text-align:left;font-size:12px;padding:4px">'.$val['username'].' </td>';
					if ($count>1) {
						$strTable .= '<td style="text-align:center;font-size:12px;padding:4px;line-height:'.$count.'em;" rowspan='.$count.' >'.$count.'</td>';
					}elseif($count==1) {
						$strTable .= '<td style="text-align:center;font-size:12px;padding:4px">'.$count.'</td>';
					}
					$strTable .= '</tr>';
					$count=0;
				}
			}
		}

		$strTable .='</table>';
		$reportObj = new report();
		$reportObj->setFileName('user');
		$reportObj->toDownload($strTable);
		exit();
	}

	//导出人均消费数据
	public function spanding_report(){
		$start = IFilter::act(IReq::get('start'));
		$end   = IFilter::act(IReq::get('end'));

		//获取时间段
		$_date       = statistics::dateParse($start,$end);
		$startArray = explode('-',$_date[0]);
		$endArray   = explode('-',$_date[1]);
		$startCondition = $startArray[0].'-'.$startArray[1].'-'.$startArray[2];
		$endCondition   = $endArray[0].'-'.$endArray[1].'-'.($endArray[2]+1);

		$strTable ='<table width="500" border="1">';
		$strTable .= '<tr>';
		$strTable .= '<td style="text-align:center;font-size:12px;width:120px;" >日期</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;">人均消费金额</td>';
		$strTable .= '</tr>';

		$db = new IQuery('collection_doc');
		$db->fields = 'sum(amount)/count(*) as count,`time`';
		$db->where  = 'pay_status = 1';
		$db->group   = "DATE_FORMAT(`time`,'Y-%m-%d') having `time` >= '{$startCondition}' and `time` < '{$endCondition}'";
		$spandingList = $db->find();
		foreach($spandingList as $k=>$val){
			$strTable .= '<tr>';
			$strTable .= '<td style="text-align:center;font-size:12px;">'.$val['time'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['count'].' </td>';
			$strTable .= '</tr>';
		}
		$strTable .='</table>';

		$reportObj = new report();
		$reportObj->setFileName('spanding');
		$reportObj->toDownload($strTable);
		exit();
	}

	//导出销售数据
	public function amount_report(){
		$start = IFilter::act(IReq::get('start'));
		$end   = IFilter::act(IReq::get('end'));

		//获取时间段
		$_date       = statistics::dateParse($start,$end);
		$startArray = explode('-',$_date[0]);
		$endArray   = explode('-',$_date[1]);
		$startCondition = $startArray[0].'-'.$startArray[1].'-'.$startArray[2];
		$endCondition   = $endArray[0].'-'.$endArray[1].'-'.($endArray[2]+1);

		$strTable ='<table width="500" border="1">';
		$strTable .= '<tr>';
		$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">日期</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单量</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">销售额</td>';
		$strTable .= '</tr>';

		$db = new IQuery('collection_doc');
		$db->fields = 'sum(amount) as count,count(order_id) as ordernum, `time`';
		$db->where  = 'pay_status = 1';
		$db->group   = "DATE_FORMAT(`time`,'Y-%m-%d') having `time` >= '{$startCondition}' and `time` < '{$endCondition}'";
		$spandingList = $db->find();
		foreach($spandingList as $k=>$val){
			$strTable .= '<tr>';
			$strTable .= '<td style="text-align:center;font-size:12px;">'.$val['time'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['ordernum'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['count'].' </td>';
			$strTable .= '</tr>';
		}
		$strTable .='</table>';

		$reportObj = new report();
		$reportObj->setFileName('amount');
		$reportObj->toDownload($strTable);
		exit();
	}

}
