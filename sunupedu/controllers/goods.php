<?php
/**
 * @brief 商品模块
 * @class Goods
 * @note  后台
 */
class Goods extends IController
{
	public $checkRight  = 'all';
    public $layout = 'admin';
    private $data = array();

	public function init()
	{
		IInterceptor::reg('CheckRights@onCreateAction');
	}
	/**
	 * 选择规格数据
	 */
	function select_spec()
	{
		$this->layout = '';
		$this->redirect('select_spec');
	}
	/**
	 * @brief 商品添加中图片上传的方法
	 */
	public function goods_img_upload()
	{
		//获得配置文件中的数据
		$config = new Config("site_config");

	 	//调用文件上传类
		$photoObj = new PhotoUpload();
		$photo    = current($photoObj->run());

		//判断上传是否成功，如果float=1则成功
		if($photo['flag'] == 1)
		{
			$result = array(
				'flag'=> 1,
				'img' => $photo['img']
			);
		}
		else
		{
			$result = array('flag'=> $photo['flag']);
		}
		echo JSON::encode($result);
	}
    /**
	 * @brief 商品模型添加/修改
	 */
    public function model_update()
    {
    	// 获取POST数据
    	$model_id   = IFilter::act(IReq::get("model_id"),'int');
    	$model_name = IFilter::act(IReq::get("model_name"));
    	$attribute  = IFilter::act(IReq::get("attr"));
    	$spec       = IFilter::act(IReq::get("spec"));

    	//初始化Model类对象
		$modelObj = new Model();

		//更新模型数据
		$result = $modelObj->model_update($model_id,$model_name,$attribute,$spec);

		if($result)
		{
			$this->redirect('model_list');
		}
		else
		{
			//处理post数据，渲染到前台
    		$result = $modelObj->postArrayChange($attribute,$spec);
			$this->data = array(
				'id'         => $model_id,
				'name'       => $model_name,
				'model_attr' => $result['model_attr'],
				'model_spec' => $result['model_spec']
			);
    		$this->setRenderData($this->data);
			$this->redirect('model_edit',false);
		}
    }
	/**
	 * @brief 商品模型修改
	 */
    public function model_edit()
    {
    	// 获取POST数据
    	$id = IFilter::act(IReq::get("id"),'int');
    	if($id)
    	{
    		//初始化Model类对象
    		$modelObj = new Model();
    		//获取模型详细信息
			$model_info = $modelObj->get_model_info($id);
			//向前台渲染数据
			$this->setRenderData($model_info);
    	}
		$this->redirect('model_edit');
    }

	/**
	 * @brief 商品模型删除
	 */
    public function model_del()
    {
    	//获取POST数据
    	$id = IFilter::act(IReq::get("id"),'int');
    	$id = !is_array($id) ? array($id) : $id;

    	if($id)
    	{
	    	foreach($id as $key => $val)
	    	{
	    		//初始化goods_attribute表类对象
	    		$goods_attrObj = new IModel("goods_attribute");

	    		//获取商品属性表中的该模型下的数量
	    		$attrData = $goods_attrObj->query("model_id = ".$val);
	    		if($attrData)
	    		{
	    			$this->redirect('model_list',false);
	    			Util::showMessage("无法删除此模型，请确认该模型下以及回收站内都无商品");
	    		}

	    		//初始化Model表类对象
	    		$modelObj = new IModel("model");

	    		//删除商品模型
				$result = $modelObj->del("id = ".$val);
	    	}
    	}
		$this->redirect('model_list');
    }
	/*
	 * @breif 后台添加给商品规格
	 * */
	function search_spec()
	{
		$this->layout = '';
		$data = array();

		//获得model_id的值
		$model_id = IFilter::act(IReq::get('model_id'),'int');
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');
		$specId   = '';

		if($goods_id)
		{
			$tb_goods = new IModel('goods');
			$goods_info = $tb_goods->getObj('id = '.$goods_id,'spec_array');
			$data['goodsSpec'] = JSON::decode($goods_info['spec_array']);
			if($data['goodsSpec'])
			{
				foreach($data['goodsSpec'] as $item)
				{
					$specId .= $item['id'].',';
				}
			}
		}
		else if($model_id)
		{
			$modelObj  = new IModel('model');
			$modelInfo = $modelObj->getObj('id = '.$model_id,'spec_ids');
			$specId    = $modelInfo['spec_ids'] ? $modelInfo['spec_ids'] : '';
		}

		if($specId)
		{
			$specObj = new IModel('spec');
			$data['specData'] = $specObj->query('id in ('.trim($specId,',').')');
		}

		$this->setRenderData($data);
		$this->redirect("search_spec");
	}
	/**
	 * @breif 后台添加为每一件商品添加会员价
	 * */
	function member_price()
	{
		$this->layout = '';

		$goods_id   = IFilter::act(IReq::get('goods_id'),'int');
		$product_id = IFilter::act(IReq::get('product_id'),'int');
		$sell_price = IFilter::act(IReq::get('sell_price'),'float');

		$date = array(
			'sell_price' => $sell_price
		);

		if($goods_id)
		{
			$where  = 'goods_id = '.$goods_id;
			$where .= $product_id ? ' and product_id = '.$product_id : '';

			$priceRelationObject = new IModel('group_price');
			$priceData = $priceRelationObject->query($where);
			$date['price_relation'] = $priceData;
		}

		$this->setRenderData($date);
		$this->redirect('member_price');
	}
	/**
	 * @brief 商品添加和修改视图
	 */
	public function goods_edit()
	{
		$goods_id = IFilter::act(IReq::get('id'),'int');

		//初始化数据
		$goods_class = new goods_class();

		//获取商品分类列表
		$tb_category = new IModel('category');
		$this->category = $goods_class->sortdata($tb_category->query(false,'*','sort','asc'),0,'--');

		//获取所有商品扩展相关数据
		$data = $goods_class->edit($goods_id);

		if($goods_id && !$data)
		{
			die("没有找到相关商品！");
		}

		$this->setRenderData($data);
		$this->redirect('goods_edit');
	}
	/**
	 * @brief 保存修改商品信息
	 */
	function goods_update()
	{
		$id       = IFilter::act(IReq::get('id'),'int');
		$callback = IFilter::act(IReq::get('callback'),'url');
		$callback = strpos($callback,'goods/goods_list') === false ? '' : $callback;

		//检查表单提交状态
		if(!$_POST)
		{
			die('请确认表单提交正确');
		}

		//初始化商品数据
		unset($_POST['id']);
		unset($_POST['callback']);

		$goodsObject = new goods_class();
		$goodsObject->update($id,$_POST);

		$callback ? $this->redirect($callback) : $this->redirect("goods_list");
	}

	/**
	 * @brief 删除商品
	 */
	function goods_del()
	{
		//post数据
	    $id = IFilter::act(IReq::get('id'),'int');

	    //生成goods对象
	    $tb_goods = new IModel('goods');
	    $tb_goods->setData(array('is_del'=>1));
	    if($id)
		{
			$tb_goods->update(Util::joinStr($id));
		}
		else
		{
			die('请选择要删除的数据');
		}
		$this->redirect("goods_list");
	}
	/**
	 * @brief 商品上下架
	 */
	function goods_stats()
	{
		//post数据
	    $id   = IFilter::act(IReq::get('id'),'int');
	    $type = IFilter::act(IReq::get('type'));

	    //生成goods对象
	    $tb_goods = new IModel('goods');
	    if($type == 'up')
	    {
	    	$updateData = array('is_del' => 0,'up_time' => ITime::getDateTime(),'down_time' => null);
	    }
	    else if($type == 'down')
	    {
	    	$updateData = array('is_del' => 2,'up_time' => null,'down_time' => ITime::getDateTime());
	    }
	    else if($type == 'check')
	    {
	    	$updateData = array('is_del' => 3,'up_time' => null,'down_time' => null);
	    }

	    $tb_goods->setData($updateData);

	    if($id)
		{
			$tb_goods->update(Util::joinStr($id));
		}
		else
		{
			Util::showMessage('请选择要操作的数据');
		}

		if(IClient::isAjax() == false)
		{
			$this->redirect("goods_list");
		}
	}
	/**
	 * @brief 商品彻底删除
	 * */
	function goods_recycle_del()
	{
		//post数据
	    $id = IFilter::act(IReq::get('id'),'int');

	    //生成goods对象
	    $goods = new goods_class();
	    if($id)
		{
			if(is_array($id))
			{
				foreach($id as $key => $val)
				{
					$goods->del($val);
				}
			}
			else
			{
				$goods->del($id);
			}
		}

		$this->redirect("goods_recycle_list");
	}
	/**
	 * @brief 商品还原
	 * */
	function goods_recycle_restore()
	{
		//post数据
	    $id = IFilter::act(IReq::get('id'),'int');
	    //生成goods对象
	    $tb_goods = new IModel('goods');
	    $tb_goods->setData(array('is_del'=>0));
	    if($id)
		{
			$tb_goods->update(Util::joinStr($id));
		}
		else
		{
			Util::showMessage('请选择要删除的数据');
		}
		$this->redirect("goods_recycle_list");
	}

	/**
	 * @brief 商品列表
	 */
	function goods_list()
	{
		//搜索条件
		$search = IFilter::act(IReq::get('search'),'strict');
		$page   = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1;

		//条件筛选处理
		list($join,$where) = goods_class::getSearchCondition($search);

		//拼接sql
		$goodsHandle = new IQuery('goods as go');
		$goodsHandle->order    = "go.sort asc,go.id desc";
		$goodsHandle->distinct = "go.id";
		$goodsHandle->fields   = "go.*,seller.true_name";
		$goodsHandle->page     = $page;
		$goodsHandle->where    = $where;
		$goodsHandle->join     = $join;

		$this->search      = $search;
		$this->goodsHandle = $goodsHandle;
		$this->redirect("goods_list");
	}

	//商品导出 Excel
	public function goods_report()
	{
		//搜索条件
		$search = IFilter::act(IReq::get('search'),'strict');
		//条件筛选处理
		list($join,$where) = goods_class::getSearchCondition($search);
		//拼接sql
		$goodsHandle = new IQuery('goods as go');
		$goodsHandle->order    = "go.sort asc,go.id desc";
		$goodsHandle->distinct = "go.id";
		$goodsHandle->fields   = "go.id, go.name,go.sell_price,go.store_nums,go.sale,go.is_del,go.create_time,seller.true_name";
		$goodsHandle->join     = $join;
		$goodsHandle->where    = $where;
		$goodsHandle->limit    = 'all';
		$goodsList = $goodsHandle->find();

		//构建 Excel table;
		$strTable ='<table width="500" border="1">';
		$strTable .= '<tr>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品名称</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="160">分类</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="60">售价</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="60">库存</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="60">销量</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="60">发布时间</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="60">状态</td>';
		$strTable .= '<td style="text-align:center;font-size:12px;" width="60">隶属商户</td>';
		$strTable .= '</tr>';

		foreach($goodsList as $k=>$val){
			$strTable .= '<tr>';
			$strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;'.$val['name'].'</td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.goods_class::getGoodsCategory($val['id']).' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['sell_price'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['store_nums'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['sale'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['create_time'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.goods_class::statusText($val['is_del']).' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['true_name'].'&nbsp;</td>';
			$strTable .= '</tr>';
		}
		$strTable .='</table>';
		unset($goodsList);
		$reportObj = new report();
		$reportObj->setFileName('goods');
		$reportObj->toDownload($strTable);
		exit();
	}

	/**
	 * @brief 商品分类添加、修改
	 */
	function category_edit()
	{
		$category_id = IFilter::act(IReq::get('cid'),'int');
		$parent_id = IFilter::act(IReq::get('pid'),'int');
		$this->data['category']['parent_id'] = $parent_id;

		//编辑商品分类 读取商品分类信息
		if($category_id)
		{
			$obj_category = new IModel('category');
			$category_info = $obj_category->getObj('id='.$category_id);
			if($category_info)
			{
				$this->data['category'] = $category_info;
			}
			else
			{
				$this->category_list();
				Util::showMessage("没有找到相关商品分类！");
				return;
			}
		}
		//加载分类
		if(!isset($obj_category))
		{
			$obj_category = new IModel('category');
		}

		$goods = new goods_class();
		$this->data['all_category'] = $goods->sortdata($obj_category->query(false,'*','sort','asc'),0,'--');
		$this->setRenderData($this->data);
		$this->redirect('category_edit');
	}

	/**
	 * @brief 保存商品分类
	 */
	function category_save()
	{
		//获得post值
		$category_id = IFilter::act(IReq::get('category_id'),'int');
		$name = IFilter::act(IReq::get('name'));
		$parent_id = IFilter::act(IReq::get('parent_id'),'int');
		$visibility = IFilter::act(IReq::get('visibility'),'int');
		$sort = IFilter::act(IReq::get('sort'),'int');
		$title = IFilter::act(IReq::get('title'));
		$keywords = IFilter::act(IReq::get('keywords'));
		$descript = IFilter::act(IReq::get('descript'));

		if(!$name)
		{
			$this->category_list();
			exit;
		}

		$tb_category = new IModel('category');
		$category_info = array(
			'name'      => $name,
			'parent_id' => $parent_id,
			'sort'      => $sort,
			'visibility'=> $visibility,
			'keywords'  => $keywords,
			'descript'  => $descript,
			'title'     => $title
		);
		$tb_category->setData($category_info);
		if($category_id)									//保存修改分类信息
		{
			$where = "id=".$category_id;
			$tb_category->update($where);
		}
		else												//添加新商品分类
		{
			$tb_category->add();
		}

		$this->category_list();
	}

	/**
	 * @brief 删除商品分类
	 */
	function category_del()
	{
		$category_id = IFilter::act(IReq::get('cid'),'int');
		if($category_id)
		{
			$tb_category = new IModel('category');
			$catRow      = $tb_category->getObj('parent_id = '.$category_id);

			//要删除的分类下还有子节点
			if(!empty($catRow))
			{
				$this->category_list();
				Util::showMessage('无法删除此分类，此分类下还有子分类，或者回收站内还留有子分类');
				exit;
			}

			if($tb_category->del('id = '.$category_id))
			{
				$tb_category_extend  = new IModel('category_extend');
				$tb_category_extend->del('category_id = '.$category_id);
				$this->category_list();
			}
			else
			{
				$this->category_list();
				$msg = "没有找到相关分类记录！";
				Util::showMessage($msg);
			}
		}
		else
		{
			$this->category_list();
			$msg = "没有找到相关分类记录！";
			Util::showMessage($msg);
		}
	}

	/**
	 * @brief 商品分类列表
	 */
	function category_list()
	{
		$tb_category = new IModel('category');
		$goods = new goods_class();
		$this->data['category'] = $goods->sortdata($tb_category->query(false,'*','sort','asc'));
		$this->setRenderData($this->data);
		$this->redirect('category_list',false);
	}

	//修改规格页面
	function spec_edit()
	{
		$this->layout = '';

		$id        = IFilter::act(IReq::get('id'),'int');
		$seller_id = IFilter::act(IReq::get('seller_id'),'int');

		$dataRow = array(
			'id'        => '',
			'name'      => '',
			'type'      => '',
			'value'     => '',
			'note'      => '',
			'seller_id' => $seller_id,
		);

		if($id)
		{
			$obj     = new IModel('spec');
			$dataRow = $obj->getObj("id = {$id}");
		}

		$this->setRenderData($dataRow);
		$this->redirect('spec_edit');
	}

	//增加或者修改规格
    function spec_update()
    {
    	$id         = IFilter::act(IReq::get('id'),'int');
    	$name       = IFilter::act(IReq::get('name'));
    	$specType   = IFilter::act(IReq::get('type'));
    	$valueArray = IFilter::act(IReq::get('value'));
    	$note       = IFilter::act(IReq::get('note'));
    	$seller_id  = IFilter::act(IReq::get('seller_id'),'int');

		//要插入的数据
    	if(is_array($valueArray) && isset($valueArray[0]) && $valueArray[0]!='')
    	{
    		$valueArray = array_unique($valueArray);
    		foreach($valueArray as $key => $rs)
    		{
    			if($rs=='')
    			{
    				unset($valueArray[$key]);
    			}
    		}

			if(!$valueArray)
			{
				$isPass = false;
				$errorMessage = "请上传规格图片";
			}
			else
			{
				$value = JSON::encode($valueArray);
			}
		}
    	else
    	{
    		$value = '';
    	}

    	$editData = array(
    		'id'        => $id,
    		'name'      => $name,
    		'value'     => $value,
    		'type'      => $specType,
    		'note'      => $note,
    		'seller_id' => $seller_id,
    	);

    	//校验
    	$isPass = true;
    	if($value=='')
    	{
    		$isPass = false;
    		$errorMessage = '规格值不能为空,请填写规格值或上传规格图片';
    	}

    	if($editData['name']=='')
    	{
    		$isPass = false;
    		$errorMessage = '规格名称不能为空';
    	}

    	if($isPass==false)
    	{
    		echo JSON::encode(array('flag' => 'fail','message' => $errorMessage));
    		exit;
    	}
    	else
    	{
    		$obj = new IModel('spec');

			//执行操作
	    	$obj->setData($editData);

	    	//更新修改
	    	if($id)
	    	{
	    		$where = 'id = '.$id;
	    		if($seller_id)
	    		{
	    			$where .= ' and seller_id = '.$seller_id;
	    		}
	    		$result = $obj->update($where);
	    	}
	    	//添加插入
	    	else
	    	{
	    		$result = $obj->add();
	    	}

			//执行状态
	    	if($result===false)
	    	{
    			echo JSON::encode(array('flag' => 'fail','message' => '数据库更新失败'));
	    	}
	    	else
	    	{
	    		//获取自动增加ID
	    		$editData['id'] = $id ? $id : $result;
	    		echo JSON::encode(array('flag' => 'success','data' => $editData));
	    	}
    	}
    }

	//批量删除规格
    function spec_del()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$obj = new IModel('spec');
			$obj->setData(array('is_del'=>1));
			$obj->update(Util::joinStr($id));
			$this->redirect('spec_list');
		}
		else
		{
			$this->redirect('spec_list',false);
			Util::showMessage('请选择要删除的规格');
		}
    }
	//彻底批量删除规格
    function spec_recycle_del()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$obj = new IModel('spec');
			$obj->del(Util::joinStr($id));
			$this->redirect('spec_recycle_list');
		}
		else
		{
			$this->redirect('spec_recycle_list',false);
			Util::showMessage('请选择要删除的规格');
		}
    }
	//批量还原规格
    function spec_recycle_restore()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$obj = new IModel('spec');
			$obj->setData(array('is_del'=>0));
			$obj->update(Util::joinStr($id));
			$this->redirect('spec_recycle_list');
		}
		else
		{
			$this->redirect('spec_recycle_list',false);
			Util::showMessage('请选择要还原的规格');
		}
    }
    //规格图片删除
    function spec_photo_del()
    {
    	$id = IReq::get('id','post');
    	if(isset($id[0]) && $id[0]!='')
    	{
    		$obj = new IModel('spec_photo');
    		$id_str = '';
    		foreach($id as $rs)
    		{
    			if($id_str!='')
    			{
    				$id_str.=',';
    			}
    				$id_str.=$rs;

    			$photoRow = $obj->getObj('id = '.$rs,'address');
    			if(file_exists($photoRow['address']))
    			{
    				unlink($photoRow['address']);
    			}
    		}

	    	$where = ' id in ('.$id_str.')';
	    	$obj->del($where);
	    	$this->redirect('spec_photo');
    	}
    	else
    	{
    		$this->redirect('spec_photo',false);
    		Util::showMessage('请选择要删除的id值');
    	}
    }

	/**
	 * @brief 分类排序
	 */
	function category_sort()
	{
		$category_id = IFilter::act(IReq::get('id'),'int');
		$sort = IFilter::act(IReq::get('sort'),'int');

		$flag = 0;
		if($category_id)
		{
			$tb_category = new IModel('category');
			$category_info = $tb_category->getObj('id='.$category_id);
			if(count($category_info)>0)
			{
				if($category_info['sort']!=$sort)
				{
					$tb_category->setData(array('sort'=>$sort));
					if($tb_category->update('id='.$category_id))
					{
						$flag = 1;
					}
				}
			}
		}
		echo $flag;
	}
	/**
	 * @brief 品牌分类排序
	 */
	public function brand_sort()
	{
		$brand_id = IFilter::act(IReq::get('id'),'int');
		$sort = IFilter::act(IReq::get('sort'),'int');
		$flag = 0;
		if($brand_id)
		{
			$tb_brand = new IModel('brand');
			$brand_info = $tb_brand->getObj('id='.$brand_id);
			if(count($brand_info)>0)
			{
				if($brand_info['sort']!=$sort)
				{
					$tb_brand->setData(array('sort'=>$sort));
					if($tb_brand->update('id='.$brand_id))
					{
						$flag = 1;
					}
				}
			}
		}
		echo $flag;
	}
	/**
	 * @brief import csv file
	 */
	public function csvImport()
	{
		$this->layout = '';
		$this->redirect('csvImport');
	}
	/**
	 * @brief csv file import
	 */
	public function importCsvFile()
	{
		csvimport_facade::run();
	}

	/**
	 * @brief web goods collect
	 */
	public function collect_import()
	{
		$this->layout = '';
		$this->redirect('collect_import');
	}

	/**
	 * @brief 开始采集商品信息
	 */
	public function collect_goods()
	{
		$category = IFilter::act(IReq::get('category'),'int');
		$url      = IFilter::act(IReq::get('url'));
		$start    = IFilter::act(IReq::get('start'),'int');
		$end      = IFilter::act(IReq::get('end'),'int');
		$urlType  = IFilter::act(IReq::get('urlType'),'int');

		if($url)
		{
			//设置要插入的分类
			collect_facade::$category = $category;

			foreach($url as $key => $val)
			{
				if($val)
				{
					//单品采集
					if($urlType == 1)
					{
						$result = collect_facade::once($val);
					}
					//列表采集
					else
					{
						$result = collect_facade::many($val,$start,$end);
					}

					if($result['result'] == 'fail')
					{
						die($result['msg']);
					}
				}
			}
		}
		die('<script type="text/javascript">parent.artDialogCallback();</script>');
	}

	//采集商品详情页面
	public function collect_goods_detail()
	{
		$collectUrl  = IFilter::act(IReq::get('collectUrl'),'url');
		$result      = collect_facade::runDetail($collectUrl);
		if(isset($result['result']) && $result['result'] == 'success')
		{
			die(JSON::encode( array('result' => 'success','data' => $result['data']) ));
		}
		else
		{
			die(JSON::encode( array('result' => 'fail','msg' => $result['msg']) ));
		}
	}

	//修改排序
	public function ajax_sort()
	{
		$id   = IFilter::act(IReq::get('id'),'int');
		$sort = IFilter::act(IReq::get('sort'),'int');

		$goodsDB = new IModel('goods');
		$goodsDB->setData(array('sort' => $sort));
		$goodsDB->update("id = {$id}");
	}

	//更新库存
	public function update_store()
	{
		$data     = IFilter::act(IReq::get('data'),'int'); //key => 商品ID或货品ID ; value => 库存数量
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');//存在即为货品
		$goodsSum = array_sum($data);

		if(!$data)
		{
			die(JSON::encode(array('result' => 'fail','data' => '商品数据不存在')));
		}

		//货品方式
		if($goods_id)
		{
			$productDB = new IModel('products');
			foreach($data as $key => $val)
			{
				$productDB->setData(array('store_nums' => $val));
				$productDB->update('id = '.$key);
			}
		}
		else
		{
			$goods_id = key($data);
		}

		$goodsDB = new IModel('goods');
		$goodsDB->setData(array('store_nums' => $goodsSum));
		$goodsDB->update('id = '.$goods_id);

		die(JSON::encode(array('result' => 'success','data' => $goodsSum)));
	}

	//更新商品价格
	public function update_price()
	{
		$data     = IFilter::act(IReq::get('data'),'float'); //key => 商品ID或货品ID ; value => 库存数量
		$goods_id = IFilter::act(IReq::get('goods_id'),'int');//存在即为货品

		if(!$data)
		{
			die(JSON::encode(array('result' => 'fail','data' => '商品数据不存在')));
		}

		//货品方式
		if($goods_id)
		{
			$productDB  = new IModel('products');
			$updateData = current($data);
			foreach($data as $pid => $item)
			{
				$productDB->setData($item);
				$productDB->update("id = ".$pid);
			}
		}
		else
		{
			$goods_id   = key($data);
			$updateData = current($data);
		}

		$goodsDB = new IModel('goods');
		$goodsDB->setData($updateData);
		$goodsDB->update('id = '.$goods_id);

		die(JSON::encode(array('result' => 'success','data' => number_format($updateData['sell_price'],2))));
	}

	//更新商品推荐标签
	public function update_commend()
	{
		$data = IFilter::act(IReq::get('data'),'int'); //key => 商品ID或货品ID ; value => commend值 1~4
		if(!$data)
		{
			die(JSON::encode(array('result' => 'fail','data' => '商品数据不存在')));
		}

		$goodsCommendDB = new IModel('commend_goods');

		//清理旧的commend数据
		$goodsIdArray = array_keys($data);
		$goodsCommendDB->del("goods_id in (".join(',',$goodsIdArray).")");

		//插入新的commend数据
		foreach($data as $id => $commend)
		{
			foreach($commend as $k => $value)
			{
				$goodsCommendDB->setData(array('commend_id' => $value,'goods_id' => $id));
				$goodsCommendDB->add();
			}
		}
		die(JSON::encode(array('result' => 'success')));
	}

	//商品标签分词
	public function goods_tags_words()
	{
		$content = IFilter::act(IReq::get('content'));
		$words   = words_facade::run($content);

		$result = array('result' => 'fail');

		if(isset($words['data']) && $words['data'])
		{
			$result = array(
				'result' => 'success',
				'data'   => join(",",$words['data']),
			);

		}
		die( JSON::encode($result) );
	}

	//商品共享
	public function goods_share()
	{
		$idArray = explode(',',IReq::get('id'));
		$id      = IFilter::act($idArray,'int');

		$goodsDB = new IModel('goods');
		$goodsData = $goodsDB->query('id in ('.join(',',$id).')');

		foreach($goodsData as $key => $val)
		{
			$is_share = $val['is_share'] == 1 ? 0 : 1;
			$goodsDB->setData(array('is_share' => $is_share));
			$goodsDB->update('id = '.$val['id'].' and seller_id = 0');
		}
	}
}
