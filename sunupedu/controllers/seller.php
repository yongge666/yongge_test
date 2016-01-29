<?php

/**
 * @brief 商家模块
 * @class Seller
 * @author chendeshan
 * @datetime 2014/7/19 15:18:56
 */
class Seller extends IController {

    public $layout = 'seller';

    /**
     * @brief 初始化检查
     */
    public function init() {
        IInterceptor::reg('CheckRights@onCreateAction');
    }

    /**
     * @brief 商品添加中图片上传的方法
     */
    public function goods_img_upload() {
        //获得配置文件中的数据
        $config = new Config("site_config");

        //调用文件上传类
        $photoObj = new PhotoUpload();
        $photo = current($photoObj->run());

        //判断上传是否成功，如果float=1则成功
        if ($photo['flag'] == 1) {
            $result = array(
                'flag' => 1,
                'img' => $photo['img']
            );
        } else {
            $result = array('flag' => $photo['flag']);
        }
        echo JSON::encode($result);
    }

    /**
     * @brief 商品添加和修改视图
     */
    public function goods_edit() {
        $goods_id = IFilter::act(IReq::get('id'), 'int');

        //初始化数据
        $goods_class = new goods_class($this->seller['seller_id']);

        //获取商品分类列表
        $tb_category = new IModel('category');
        $this->category = $goods_class->sortdata($tb_category->query(false, '*', 'sort', 'asc'), 0, '--');

        //获取所有商品扩展相关数据
        $data = $goods_class->edit($goods_id);

        if ($goods_id && !$data) {
            die("没有找到相关商品！");
        }

        $this->setRenderData($data);
        $this->redirect('goods_edit');
    }

    //商品更新动作
    public function goods_update() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $callback = IFilter::act(IReq::get('callback'), 'url');
        $callback = strpos($callback, 'seller/goods_list') === false ? '' : $callback;

        //检查表单提交状态
        if (!$_POST) {
            die('请确认表单提交正确');
        }

        //初始化商品数据
        unset($_POST['id']);
        unset($_POST['callback']);

        $goodsObject = new goods_class($this->seller['seller_id']);
        $goodsObject->update($id, $_POST);

        $callback ? $this->redirect($callback) : $this->redirect("goods_list");
    }

    //商品列表
    public function goods_list() {
        $this->redirect('goods_list');
    }

    //商品列表
    public function goods_report() {
        $seller_id = $this->seller['seller_id'];
        $condition = Util::search(IFilter::act(IReq::get('search'), 'strict'));

        $where = 'go.seller_id=' . $seller_id;
        $where .= $condition ? " and " . $condition : "";

        $goodHandle = new IQuery('goods as go');
        $goodHandle->order = "go.id desc";
        $goodHandle->fields = "go.*";
        $goodHandle->where = $where;
        $goodList = $goodHandle->find();

        //构建 Excel table;
        $strTable = '<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;">商品名称</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="160">分类</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="60">售价</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="60">库存</td>';
        $strTable .= '</tr>';

        foreach ($goodList as $k => $val) {
            $strTable .= '<tr>';
            $strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;' . $val['name'] . '</td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . goods_class::getGoodsCategory($val['id']) . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['sell_price'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['store_nums'] . ' </td>';
            $strTable .= '</tr>';
        }
        $strTable .='</table>';
        unset($goodList);
        $reportObj = new report();
        $reportObj->setFileName('goods');
        $reportObj->toDownload($strTable);
        exit();
    }

    //商品删除
    public function goods_del() {
        //post数据
        $id = IFilter::act(IReq::get('id'), 'int');

        //生成goods对象
        $goods = new goods_class();
        $goods->seller_id = $this->seller['seller_id'];

        if ($id) {
            if (is_array($id)) {
                foreach ($id as $key => $val) {
                    $goods->del($val);
                }
            } else {
                $goods->del($id);
            }
        }
        $this->redirect("goods_list");
    }

    //商品状态修改
    public function goods_status() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $is_del = IFilter::act(IReq::get('is_del'), 'int');
        $is_del = $is_del === 0 ? 3 : $is_del; //不能等于0直接上架
        $seller_id = $this->seller['seller_id'];

        $goodsDB = new IModel('goods');
        $goodsDB->setData(array('is_del' => $is_del));

        if ($id) {
            if (is_array($id)) {
                foreach ($id as $key => $val) {
                    $goodsDB->update("id = " . $val . " and seller_id = " . $seller_id);
                }
            } else {
                $goodsDB->update("id = " . $val . " and seller_id = " . $seller_id);
            }
        }
        $this->redirect("goods_list");
    }

    //规格删除
    public function spec_del() {
        $id = IFilter::act(IReq::get('id'), 'int');

        if ($id) {
            $idString = is_array($id) ? join(',', $id) : $id;
            $specObj = new IModel('spec');
            $specObj->del("id in ( {$idString} ) and seller_id = " . $this->seller['seller_id']);
            $this->redirect('spec_list');
        } else {
            $this->redirect('spec_list', false);
            Util::showMessage('请选择要删除的规格');
        }
    }

    //修改排序
    public function ajax_sort() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $sort = IFilter::act(IReq::get('sort'), 'int');

        $goodsDB = new IModel('goods');
        $goodsDB->setData(array('sort' => $sort));
        $goodsDB->update("id = {$id} and seller_id = " . $this->seller['seller_id']);
    }

    //咨询回复
    public function refer_reply() {
        $rid = IFilter::act(IReq::get('refer_id'), 'int');
        $content = IFilter::act(IReq::get('content'), 'text');

        if ($rid && $content) {
            $tb_refer = new IModel('refer');
            $seller_id = $this->seller['seller_id']; //商户id
            $data = array(
                'answer' => $content,
                'reply_time' => date('Y-m-d H:i:s'),
                'seller_id' => $seller_id,
                'status' => 1
            );
            $tb_refer->setData($data);
            $tb_refer->update("id=" . $rid);
        }
        $this->redirect('refer_list');
    }

    /**
     * @brief查看订单
     */
    public function order_show() {
        //获得post传来的值
        $order_id = IFilter::act(IReq::get('id'), 'int');
        $data = array();
        if ($order_id) {
            $order_show = new Order_Class();
            $data = $order_show->getOrderShow($order_id);
            if ($data) {
                //获得折扣前的价格
                $rule = new ProRule($data['real_amount']);
                $this->result = $rule->getInfo();

                //获取地区
                $data['area_addr'] = join('&nbsp;', area::name($data['province'], $data['city'], $data['area']));

                $this->setRenderData($data);
                $this->redirect('order_show', false);
            }
        }
        if (!$data) {
            $this->redirect('order_list');
        }
    }

    /**
     * @brief 发货订单页面
     */
    public function order_deliver() {
        $order_id = IFilter::act(IReq::get('id'), 'int');
        $data = array();
        if ($order_id) {
            $order_show = new Order_Class();
            $data = $order_show->getOrderShow($order_id);
        }
        //var_dump($data);
        $this->setRenderData($data);
        $this->redirect('order_deliver');
    }

    /**
     * @brief 发货操作
     */
    public function order_delivery_doc() {
        //获得post变量参数
        $order_id = IFilter::act(IReq::get('id'), 'int');
           //var_dump($order_id);
        //发送的商品关联
        $sendgoods = IFilter::act(IReq::get('sendgoods'));
          //var_dump($sendgoods);exit;
        if (!$sendgoods) {
            die('请选择要发货的商品');
        }

        Order_Class::sendDeliveryGoods($order_id, $sendgoods, $this->seller['seller_id'], 'seller');
        $this->redirect('order_list');
    }

    /**
     * 批量发货
     */
    public function order_deliveries() {
        $order_ids = IFilter::act(IReq::get('ids'), 'array');
        $order_idArr =explode(',',$order_ids);
        $order_show = new Order_Class();
        $orderModel =new IModel('order_goods');

        foreach($order_idArr as $k => $v){
            if ($v) {
                 $orderArr = $orderModel->getObj('id='.$v);
                $order_id = $orderArr['order_id'];
                $data = $order_show->getOrderShow($order_id);
                //var_dump($data);

            $sql = "select  og.*,go.seller_id from sunup_order_goods as og left join sunup_goods  as go on go.id = og.goods_id where og.order_id = {$order_id} and go.seller_id = {$data['seller_id']} limit 10000";
            $sendgoods = $orderModel->db->query($sql);
            //var_dump($sendgoods);
                if(isset($sendgoods[0]['id'])){
                   // var_dump($sendgoods[0]['id']);
                    $paramArray = array(
                        'order_id'      => $order_id,
                        'user_id'       => $data['user_id'],
                        'name'          => $data['accept_name'],
                        'postcode'      => $data['postcode'],
                        'telphone'      => $data['telphone'],
                        'province'      => $data['province'],
                        'city'          => $data['city'],
                        'area'          => $data['area'],
                        'address'       => $data['address'],
                        'mobile'        => $data['mobile'],
                        'freight'       => $data['real_freight'],
                        'delivery_code' => 000000,
                        'delivery_type' => 1,
                        'note'          => $data['note'],
                        'time'          => ITime::getDateTime(),
                        'freight_id'    => 17,
                    );
                    Order_Class::batchSendDeliveryGoods($order_id, array($sendgoods[0]['id']), $data['seller_id'], 'seller',$paramArray);

                }
            }

            //var_dump($v);
        }
    }

    private function getAddr($addrObj, $address_id) {
        $oneAddr = $addrObj->getObj("id = " . $address_id);
        if ($oneAddr) {
            $areaDB = new IModel('areas');
            $province_val = $areaDB->getObj("area_id = " . $oneAddr['province']);
            if ($province_val) {
                $arr['province_val'] = $province_val['area_name'];
            } else {
                $arr['province_val'] = '未知';
            }

            $city_val = $areaDB->getObj("area_id = " . $oneAddr['city']);
            if ($city_val) {
                $arr['city_val'] = $city_val['area_name'];
            } else {
                $arr['city_val'] = '未知';
            }

            $area_val = $areaDB->getObj("area_id = " . $oneAddr['area']);
            if ($area_val) {
                $arr['area_val'] = $area_val['area_name'];
            } else {
                $arr['area_val'] = '未知';
            }

            $school_val = $areaDB->getObj("area_id = '" . $oneAddr['school'] . "'");
            if ($school_val) {
                $arr['school'] = $school_val['area_name'];
            } else {
                $arr['school'] = '未知';
            }

            $arr['accept_name'] = $oneAddr['accept_name'];
            $arr['address'] = $oneAddr['address'];

            $arr['grade'] = $oneAddr['grade'];
            $arr['class'] = $oneAddr['class'];

            $arr['mobile'] = $oneAddr['mobile'];
            $arr['telphone'] = $oneAddr['telphone'];
            return $arr;
        }
        return null;
    }

    //订单导出 Excel
    public function order_report() {
        $seller_id = $this->seller['seller_id'];
        $search = IFilter::act(IReq::get('search'));

        /* //必须为已支付状态
          $search['pay_status='] = 1;
          //必须为未发货状态
          $search['distribution_status='] = 0; */
        $condition = Util::search($search);

        $where = "go.seller_id = " . $seller_id;
        $where .= $condition ? " and " . $condition : "";

        //拼接sql
        $orderHandle = new IQuery('order_goods as og');
        $orderHandle->order = "o.id desc";
        $orderHandle->fields = "o.*,p.name as payment_name";
        $orderHandle->join = "left join goods as go on go.id=og.goods_id left join order as o on o.id=og.order_id left join payment as p on p.id = o.pay_type";
        $orderHandle->where = $where;
        $orderList = $orderHandle->find();
        //pr($orderList);
        //对订单进行重构
        if (empty($orderList)) {
            IError::show(403, "数据为空");
            exit;
        } else {
            $addrObj = new IModel("address");
            foreach ($orderList as $k => $v) {
                if ($v['address_id']) {
                    $order_addr = explode(',', $v['address_id']);
                    $count = count($order_addr);
                    for ($i = 0; $i < $count; $i++) {
                        $new = $v;
                        $new['old_book_count'] = $count;
                        $new['one_book_price'] = round($new['order_amount'] / $count, 2);

                        $addr_detil = $this->getAddr($addrObj, $order_addr[$i]);
                        if ($addr_detil) {
                            $new['accept_name'] = $addr_detil['accept_name'];
                            $new['province_val'] = $addr_detil['province_val'];
                            $new['city_val'] = $addr_detil['city_val'];
                            $new['area_val'] = $addr_detil['area_val'];
                            $new['address'] = $addr_detil['address'];
                            $new['school'] = $addr_detil['school'];
                            $new['grade'] = $addr_detil['grade'];
                            $new['class'] = $addr_detil['class'];
                            $new['mobile'] = $addr_detil['mobile'];
                            $new['telphone'] = $addr_detil['telphone'];
                        } else {
                            $new['province_val'] = '';
                            $new['city_val'] = '';
                            $new['area_val'] = '';
                            $new['school'] = '';
                            $new['grade'] = '';
                            $new['class'] = '';
                        }
                        $new_order[] = $new;
                    }
                }
            }
        }

        //pr($new_order);
        //构建 Excel table
        $strTable = '<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">订单编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="100">下单日期</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">省</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">市</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">区</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">学校</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">年级</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">班级</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">电话</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单金额</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">原有本数</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">单本金额</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付方式</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付状态</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付时间</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">发货状态</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品信息</td>';
        $strTable .= '</tr>';

        foreach ($new_order as $k => $val) {
            $strTable .= '<tr>';
            $strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;' . $val['order_no'] . '</td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['create_time'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['accept_name'] . ' </td>';

            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['province_val'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['city_val'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['area_val'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['school'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['grade'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['class'] . ' </td>';

            $strTable .= '<td style="text-align:left;font-size:12px;">&nbsp;' . $val['telphone'] . '&nbsp;' . $val['mobile'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['order_amount'] . ' </td>';

            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['old_book_count'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['one_book_price'] . ' </td>';

            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['payment_name'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . Order_Class::getOrderPayStatusText($val) . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['pay_time'] . ' </td>';
            $strTable .= '<td style="text-align:left;font-size:12px;">' . Order_Class::getOrderDistributionStatusText($val) . ' </td>';

            $orderGoods = Order_class::getOrderGoods($val['id']);

            $strGoods = "";
            foreach ($orderGoods as $good) {
                $strGoods .= "商品编号：" . $good->goodsno . " 商品名称：" . $good->name;
                if ($good->value != '')
                    $strGoods .= " 规格：" . $good->value;
                $strGoods .= "<br />";
            }
            unset($orderGoods);

            $strTable .= '<td style="text-align:left;font-size:12px;">' . $strGoods . ' </td>';
            $strTable .= '</tr>';
        }
        $strTable .='</table>';
        //输出成EXcel格式文件并下载
        $reportObj = new report();
        $reportObj->setFileName('order');
        $reportObj->toDownload($strTable);
        exit();
    }

    //修改商户信息
    public function seller_edit() {
        $seller_id = $this->seller['seller_id'];
        $sellerDB = new IModel('seller');
        $this->sellerRow = $sellerDB->getObj('id = ' . $seller_id);
        $this->redirect('seller_edit');
    }

    /**
     * @brief 商户的增加动作
     */
    public function seller_add() {
        $seller_id = $this->seller['seller_id'];
        $email = IFilter::act(IReq::get('email'));
        $password = IFilter::act(IReq::get('password'));
        $repassword = IFilter::act(IReq::get('repassword'));
        $phone = IFilter::act(IReq::get('phone'));
        $mobile = IFilter::act(IReq::get('mobile'));
        $province = IFilter::act(IReq::get('province'), 'int');
        $city = IFilter::act(IReq::get('city'), 'int');
        $area = IFilter::act(IReq::get('area'), 'int');
        $address = IFilter::act(IReq::get('address'));
        $account = IFilter::act(IReq::get('account'));
        $server_num = IFilter::act(IReq::get('server_num'));
        $home_url = IFilter::act(IReq::get('home_url'));

        if (!$seller_id && $password == '') {
            $errorMsg = '请输入密码！';
        }

        if ($password != $repassword) {
            $errorMsg = '两次输入的密码不一致！';
        }

        //操作失败表单回填
        if (isset($errorMsg)) {
            $this->sellerRow = $_POST;
            $this->redirect('seller_edit', false);
            Util::showMessage($errorMsg);
        }

        //待更新的数据
        $sellerRow = array(
            'account' => $account,
            'phone' => $phone,
            'mobile' => $mobile,
            'email' => $email,
            'address' => $address,
            'province' => $province,
            'city' => $city,
            'area' => $area,
            'server_num' => $server_num,
            'home_url' => $home_url,
        );

        //创建商家操作类
        $sellerDB = new IModel("seller");

        //修改密码
        if ($password) {
            $sellerRow['password'] = md5($password);
        }

        $sellerDB->setData($sellerRow);
        $sellerDB->update("id = " . $seller_id);

        $this->redirect('seller_edit');
    }

    //[团购]添加修改[单页]
    function regiment_edit() {
        $id = IFilter::act(IReq::get('id'), 'int');

        if ($id) {
            $regimentObj = new IModel('regiment');
            $where = 'id = ' . $id;
            $regimentRow = $regimentObj->getObj($where);
            if (!$regimentRow) {
                $this->redirect('regiment_list');
            }

            //促销商品
            $goodsObj = new IModel('goods');
            $goodsRow = $goodsObj->getObj('id = ' . $regimentRow['goods_id']);

            $result = array(
                'isError' => false,
                'data' => $goodsRow,
            );
            $regimentRow['goodsRow'] = JSON::encode($result);
            $this->regimentRow = $regimentRow;
        }
        $this->redirect('regiment_edit');
    }

    /**
     * 商家支付信息
     */
    public function payment_conf() {
        $seller_id = $this->seller['seller_id'];
        $seller_paymentDB = new IModel('seller_payment');
        $this->paymentRow = $seller_paymentDB->getObj('seller_id = ' . $seller_id);
        $this->redirect('payment_conf');
    }

    /**
     * 商家支付信息保存
     */
    public function payment_conf_save() {
        $parent_id = IFilter::act(IReq::get('parent_id'));
        $parent_key = IFilter::act(IReq::get('parent_key'));
        $parent_email = IFilter::act(IReq::get('parent_email'));
        $seller_id = $this->seller['seller_id'];

        //判断新增  or 修改
        $sellerObj = new IModel("seller_payment");
        $payment = $sellerObj->getObj("seller_id = '{$seller_id}'");

        $arr = array(
            'seller_id' => $seller_id,
            'parent_id' => $parent_id,
            'parent_key' => $parent_key,
            'parent_email' => $parent_email,
        );
        $sellerObj->setData($arr);
        if (!$payment) {
            //增加模式
            $sellerObj->add();
        } else {
            //修改模式
            unset($arr['seller_id']);
            $sellerObj->update("seller_id = '{$seller_id}'");
        }
        $this->redirect('payment_conf');
    }

    //[团购]删除
    function regiment_del() {
        $id = IFilter::act(IReq::get('id'), 'int');
        if ($id) {
            $regObj = new IModel('regiment');

            if (is_array($id)) {
                $idStr = join(',', $id);
                $where = ' id in (' . $idStr . ')';
                $uwhere = ' regiment_id in (' . $idStr . ')';
            } else {
                $where = 'id = ' . $id;
                $uwhere = 'regiment_id = ' . $id;
            }
            $regObj->del($where);
            $this->redirect('regiment_list');
        } else {
            $this->redirect('regiment_list', false);
            Util::showMessage('请选择要删除的id值');
        }
    }

    //[团购]添加修改[动作]
    function regiment_edit_act() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $goodsId = IFilter::act(IReq::get('goods_id'), 'int');

        $dataArray = array(
            'id' => $id,
            'title' => IFilter::act(IReq::get('title', 'post')),
            'start_time' => IFilter::act(IReq::get('start_time', 'post')),
            'end_time' => IFilter::act(IReq::get('end_time', 'post')),
            'is_close' => 1,
            'intro' => IFilter::act(IReq::get('intro', 'post')),
            'goods_id' => $goodsId,
            'store_nums' => IFilter::act(IReq::get('store_nums', 'post')),
            'limit_min_count' => IFilter::act(IReq::get('limit_min_count', 'post'), 'int'),
            'limit_max_count' => IFilter::act(IReq::get('limit_max_count', 'post'), 'int'),
            'regiment_price' => IFilter::act(IReq::get('regiment_price', 'post')),
        );

        if ($goodsId) {
            $goodsObj = new IModel('goods');
            $where = 'id = ' . $goodsId . ' and seller_id = ' . $this->seller['seller_id'];
            $goodsRow = $goodsObj->getObj($where);

            //商品信息不存在
            if (!$goodsRow) {
                $this->regimentRow = $dataArray;
                $this->redirect('regiment_edit', false);
                Util::showMessage('请选择商户自己的商品');
            }

            //处理上传图片
            if (isset($_FILES['img']['name']) && $_FILES['img']['name'] != '') {
                $uploadObj = new PhotoUpload();
                $photoInfo = $uploadObj->run();
                $dataArray['img'] = $photoInfo['img']['img'];
            } else {
                $dataArray['img'] = $goodsRow['img'];
            }

            $dataArray['sell_price'] = $goodsRow['sell_price'];
        } else {
            $this->regimentRow = $dataArray;
            $this->redirect('regiment_edit', false);
            Util::showMessage('请选择要关联的商品');
        }

        $regimentObj = new IModel('regiment');
        $regimentObj->setData($dataArray);

        if ($id) {
            $where = 'id = ' . $id;
            $regimentObj->update($where);
        } else {
            $regimentObj->add();
        }
        $this->redirect('regiment_list');
    }

    //结算单修改
    public function bill_edit() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $billRow = array();

        if ($id) {
            $billDB = new IModel('bill');
            $billRow = $billDB->getObj('id = ' . $id . ' and seller_id = ' . $this->seller['seller_id']);
        }

        $this->billRow = $billRow;
        $this->redirect('bill_edit');
    }

    //结算单删除
    public function bill_del() {
        $id = IFilter::act(IReq::get('id'), 'int');

        if ($id) {
            $billDB = new IModel('bill');
            $billDB->del('id = ' . $id . ' and seller_id = ' . $this->seller['seller_id'] . ' and is_pay = 0');
        }

        $this->redirect('bill_list');
    }

    //结算单更新
    public function bill_update() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $start_time = IFilter::act(IReq::get('start_time'));
        $end_time = IFilter::act(IReq::get('end_time'));
        $apply_content = IFilter::act(IReq::get('apply_content'));

        $billDB = new IModel('bill');

        if ($id) {
            $billRow = $billDB->getObj('id = ' . $id);
            if ($billRow['is_pay'] == 0) {
                $billDB->setData(array('apply_content' => $apply_content));
                $billDB->update('id = ' . $id . ' and seller_id = ' . $this->seller['seller_id']);
            }
        } else {
            //判断是否存在未处理的申请
            $isSubmitBill = $billDB->getObj(" seller_id = " . $this->seller['seller_id'] . " and is_pay = 0");
            if ($isSubmitBill) {
                $this->redirect('bill_list', false);
                Util::showMessage('请耐心等待管理员结算后才能再次提交申请');
            }

            $queryObject = CountSum::getSellerGoodsFeeQuery($this->seller['seller_id'], $start_time, $end_time, 0);
            $countData = CountSum::countSellerOrderFee($queryObject->find());

            if ($countData['orderAmountPrice'] > 0) {
                $replaceData = array(
                    '{startTime}' => $start_time,
                    '{endTime}' => $end_time,
                    '{goodsNums}' => count($countData['order_goods_ids']),
                    '{goodsSums}' => $countData['goodsSum'],
                    '{deliveryPrice}' => $countData['deliveryPrice'],
                    '{protectedPrice}' => $countData['insuredPrice'],
                    '{taxPrice}' => $countData['taxPrice'],
                    '{totalSum}' => $countData['orderAmountPrice'],
                );

                $billString = AccountLog::sellerBillTemplate($replaceData);
                $data = array(
                    'seller_id' => $this->seller['seller_id'],
                    'apply_time' => date('Y-m-d H:i:s'),
                    'apply_content' => IFilter::act(IReq::get('apply_content')),
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'log' => $billString,
                    'order_goods_ids' => join(",", $countData['order_goods_ids']),
                );
                $billDB->setData($data);
                $billDB->add();
            } else {
                $this->redirect('bill_list', false);
                Util::showMessage('当前时间段内没有任何结算货款');
            }
        }
        $this->redirect('bill_list');
    }

    //计算应该结算的货款明细
    public function countGoodsFee() {
        $seller_id = $this->seller['seller_id'];
        $start_time = IFilter::act(IReq::get('start_time'));
        $end_time = IFilter::act(IReq::get('end_time'));

        $queryObject = CountSum::getSellerGoodsFeeQuery($seller_id, $start_time, $end_time, 0);
        $countData = CountSum::countSellerOrderFee($queryObject->find());

        if ($countData['orderAmountPrice'] > 0) {
            $replaceData = array(
                '{startTime}' => $start_time,
                '{endTime}' => $end_time,
                '{goodsNums}' => count($countData['order_goods_ids']),
                '{goodsSums}' => $countData['goodsSum'],
                '{deliveryPrice}' => $countData['deliveryPrice'],
                '{protectedPrice}' => $countData['insuredPrice'],
                '{taxPrice}' => $countData['taxPrice'],
                '{totalSum}' => $countData['orderAmountPrice'],
            );

            $billString = AccountLog::sellerBillTemplate($replaceData);
            $result = array('result' => 'success', 'data' => $billString);
        } else {
            $result = array('result' => 'fail', 'data' => '当前没有任何款项可以结算');
        }

        die(JSON::encode($result));
    }

    /**
     * @brief 显示评论信息
     */
    function comment_edit() {
        $cid = IFilter::act(IReq::get('cid'), 'int');

        if (!$cid) {
            $this->comment_list();
            return false;
        }
        $query = new IQuery("comment as c");
        $query->join = "left join goods as goods on c.goods_id = goods.id left join user as u on c.user_id = u.id";
        $query->fields = "c.*,u.username,goods.name,goods.seller_id";
        $query->where = "c.id=" . $cid . " and goods.seller_id = " . $this->seller['seller_id'];
        $items = $query->find();

        if ($items) {
            $this->comment = current($items);
            $this->redirect('comment_edit');
        } else {
            $this->comment_list();
            $msg = '没有找到相关记录！';
            Util::showMessage($msg);
        }
    }

    /**
     * @brief 回复评论
     */
    function comment_update() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $recontent = IFilter::act(IReq::get('recontents'));
        if ($id) {
            $commentDB = new IQuery('comment as c');
            $commentDB->join = 'left join goods as go on go.id = c.goods_id';
            $commentDB->where = 'c.id = ' . $id . ' and go.seller_id = ' . $this->seller['seller_id'];
            $checkList = $commentDB->find();
            if (!$checkList) {
                IError::show(403, '该商品不属于您，无法对其评论进行回复');
            }

            $updateData = array(
                'recontents' => $recontent,
                'recomment_time' => ITime::getDateTime(),
            );
            $commentDB = new IModel('comment');
            $commentDB->setData($updateData);
            $commentDB->update('id = ' . $id);
        }
        $this->redirect('comment_list');
    }

    //商品退款详情
    function refundment_show() {
        //获得post传来的退款单id值
        $refundment_id = IFilter::act(IReq::get('id'), 'int');
        $data = array();
        if ($refundment_id) {
            $tb_refundment = new IQuery('refundment_doc as c');
            $tb_refundment->join = ' left join order as o on c.order_id=o.id left join user as u on u.id = c.user_id';
            $tb_refundment->fields = 'o.order_no,o.create_time,u.username,c.*';
            $tb_refundment->where = 'c.id=' . $refundment_id . ' and seller_id = ' . $this->seller['seller_id'];
            $refundment_info = $tb_refundment->find();
            if ($refundment_info) {
                $data = current($refundment_info);
                $this->setRenderData($data);
                $this->redirect('refundment_show', false);
            }
        }

        if (!$data) {
            $this->redirect('refundment_list');
        }
    }

    //商品退款操作
    function refundment_update() {
        $id = IFilter::act(IReq::get('id'), 'int');
        $pay_status = IFilter::act(IReq::get('pay_status'), 'int');
        $dispose_idea = IFilter::act(IReq::get('dispose_idea'));

        //商户处理退款
        if ($id && Order_Class::isSellerRefund($id, $this->seller['seller_id']) == 2) {
            $tb_refundment_doc = new IModel('refundment_doc');
            $updateData = array(
                'dispose_time' => ITime::getDateTime(),
                'dispose_idea' => $dispose_idea,
                'pay_status' => $pay_status,
            );
            $tb_refundment_doc->setData($updateData);
            $tb_refundment_doc->update('id = ' . $id);

            if ($pay_status == 2) {
                $result = Order_Class::refund($id, $this->seller['seller_id'], 'seller');
                if (!$result) {
                    die('退款失败');
                }
            }
        }
        $this->redirect('refundment_list');
    }

    //商品复制
    function goods_copy() {
        $idArray = explode(',', IReq::get('id'));
        $idArray = IFilter::act($idArray, 'int');

        $goodsDB = new IModel('goods');
        $goodsAttrDB = new IModel('goods_attribute');
        $goodsPhotoRelationDB = new IModel('goods_photo_relation');
        $productsDB = new IModel('products');

        $goodsData = $goodsDB->query('id in (' . join(',', $idArray) . ') and is_share = 1 and is_del = 0 and seller_id = 0', '*');
        if ($goodsData) {
            foreach ($goodsData as $key => $val) {
                //判断是否重复
                if ($goodsDB->getObj('seller_id = ' . $this->seller['seller_id'] . ' and name = "' . $val['name'] . '"')) {
                    die('商品不能重复复制');
                }

                $oldId = $val['id'];

                //商品数据
                unset($val['id'], $val['visit'], $val['favorite'], $val['sort'], $val['comments'], $val['sale'], $val['grade'], $val['is_share']);
                $val['seller_id'] = $this->seller['seller_id'];
                $val['goods_no'] .= '-' . $this->seller['seller_id'];

                $goodsDB->setData($val);
                $goods_id = $goodsDB->add();

                //商品属性
                $attrData = $goodsAttrDB->query('goods_id = ' . $oldId);
                if ($attrData) {
                    foreach ($attrData as $k => $v) {
                        unset($v['id']);
                        $v['goods_id'] = $goods_id;
                        $goodsAttrDB->setData($v);
                        $goodsAttrDB->add();
                    }
                }

                //商品图片
                $photoData = $goodsPhotoRelationDB->query('goods_id = ' . $oldId);
                if ($photoData) {
                    foreach ($photoData as $k => $v) {
                        unset($v['id']);
                        $v['goods_id'] = $goods_id;
                        $goodsPhotoRelationDB->setData($v);
                        $goodsPhotoRelationDB->add();
                    }
                }

                //货品
                $productsData = $productsDB->query('goods_id = ' . $oldId);
                if ($productsData) {
                    foreach ($productsData as $k => $v) {
                        unset($v['id']);
                        $v['products_no'].= '-' . $this->seller['seller_id'];
                        $v['goods_id'] = $goods_id;
                        $productsDB->setData($v);
                        $productsDB->add();
                    }
                }
            }
            die('success');
        } else {
            die('复制的商品不存在');
        }
    }

}
