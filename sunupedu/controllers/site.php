<?php

/**
 * @copyright Copyright(c) 2011 jooyea.cn
 * @file site.php
 * @brief
 * @author webning
 * @date 2011-03-22
 * @version 0.6
 * @note
 */

/**
 * @brief Site
 * @class Site
 * @note
 */
class Site extends IController {

    public $layout = 'site';
    public $resultData = array();

    function init() {
        CheckRights::checkUserRights();
    }

    function index() {
        $user_id = $this->user['user_id'];
        $this->user_id = $this->user['user_id'];
        //首页未登录显示商品区域
        $this->area_id = 420103;
        if ($user_id) {
            /* $member = new IModel("member");
              $area = $member->getObj("user_id = ".$user_id,'area');
              if( $area['area'] ){
              $area_arr = explode(',', $area['area']);
              if($area_arr[3]){
              $this->area_id = $area_arr[3];
              }
              } */
            $addressObj = new IModel("address");
            $addr = $addressObj->query("user_id = " . $user_id, 'area', '`default`', 'desc');
            if ($addr = current($addr)) {
                $this->area_id = $addr['area'];
            }
        }

        $siteConfigObj = new Config("site_config");
        $site_config = $siteConfigObj->getInfo();
        $index_slide = isset($site_config['index_slide']) ? $this->mb_unserialize($site_config['index_slide']) : array();
        $this->index_slide = $index_slide;
        $this->redirect('index');
    }

    function mb_unserialize($serial_str) {
        $serial_str = preg_replace_callback('!s:(\d+):"(.*?)";!s', create_function('$math',"return 's:'.strlen(\$math[2]).':\"'.\$math[2].'\";';"), $serial_str);
        return unserialize($serial_str);
    }

    //[首页]商品搜索
    function search_list() {
        $this->word = IFilter::act(IReq::get('word'), 'text');
        $cat_id = IFilter::act(IReq::get('cat'), 'int');

        if (preg_match("|^[\w\x7f\s*-\xff*]+$|", $this->word)) {
            //搜索关键字
            $tb_sear = new IModel('search');
            $search_info = $tb_sear->getObj('keyword = "' . $this->word . '"', 'id');

            //如果是第一页，相应关键词的被搜索数量才加1
            if ($search_info && intval(IReq::get('page')) < 2) {
                //禁止刷新+1
                $allow_sep = "30";
                $flag = false;
                $time = ICookie::get('step');
                if (isset($time)) {
                    if (time() - $time > $allow_sep) {
                        ICookie::set('step', time());
                        $flag = true;
                    }
                } else {
                    ICookie::set('step', time());
                    $flag = true;
                }
                if ($flag) {
                    $tb_sear->setData(array('num' => 'num + 1'));
                    $tb_sear->update('id=' . $search_info['id'], 'num');
                }
            } elseif (!$search_info) {
                //如果数据库中没有这个词的信息，则新添
                $tb_sear->setData(array('keyword' => $this->word, 'num' => 1));
                $tb_sear->add();
            }
        } else {
            IError::show(403, '请输入正确的查询关键词');
        }
        $this->cat_id = $cat_id;
        $this->redirect('search_list');
    }

    //[site,ucenter头部分]自动完成
    function autoComplete() {
        $word = IFilter::act(IReq::get('word'));
        $isError = true;
        $data = array();

        if ($word != '' && $word != '%' && $word != '_') {
            $wordObj = new IModel('keyword');
            $wordList = $wordObj->query('word like "' . $word . '%" and word != "' . $word . '"', 'word, goods_nums', '', '', 10);

            if (!empty($wordList)) {
                $isError = false;
                $data = $wordList;
            }
        }

        //json数据
        $result = array(
            'isError' => $isError,
            'data' => $data,
        );

        echo JSON::encode($result);
    }

    //[首页]邮箱订阅
    function email_registry() {
        $email = IReq::get('email');
        $result = array('isError' => true);

        if (!IValidate::email($email)) {
            $result['message'] = '请填写正确的email地址';
        } else {
            $emailRegObj = new IModel('email_registry');
            $emailRow = $emailRegObj->getObj('email = "' . $email . '"');

            if (!empty($emailRow)) {
                $result['message'] = '此email已经订阅过了';
            } else {
                $dataArray = array(
                    'email' => $email,
                );
                $emailRegObj->setData($dataArray);
                $status = $emailRegObj->add();
                if ($status == true) {
                    $result = array(
                        'isError' => false,
                        'message' => '订阅成功',
                    );
                } else {
                    $result['message'] = '订阅失败';
                }
            }
        }
        echo JSON::encode($result);
    }

    //[列表页]商品
    function pro_list() {
        $this->catId = intval(IReq::get('cat')); //分类id
        
        if ($this->catId ===0) {
            IError::show(403, '缺少分类ID');
        }
        
        if( ISafe::get('user_id') != null){
            
            //已登录用户
            //获取用户地址
            $userId = ISafe::get('user_id');
            $addressModel = new IModel('address');
            $addressInfo = $addressModel ->getObj('user_id='.$userId);
            if($addressInfo){  
                $this->provinceId = intval($addressInfo['province']); //省id
                $this->cityId = intval($addressInfo['city']); //市id
                $this->areaId = intval($addressInfo['area']); //区域id
                $this->schoolId = intval($addressInfo['school']);  //学校id
            }
            
        }else{
            //未登录用户
            // /new/index.php?controller=site&action=pro_list&cat=4&province=110000&city=110100&area=110102&school=110102003
            //接收get参数
            //$this->catId = intval(IReq::get('cat')); //分类id
            $this->provinceId = intval(IReq::get('province')); //省id
            $this->cityId = intval(IReq::get('city')); //市id
            $this->areaId = intval(IReq::get('area')); //区域id
            $this->schoolId = intval(IReq::get('school'));  //学校id
//            echo $this->catId.'<br />';
//            echo $this->provinceId.'<br />';
//            echo $this->cityId.'<br />';
//            echo $this->areaId.'<br />';
//            echo $this->schoolId.'<br />';
            
            
            if ($this->provinceId === 0) {
                IError::show(403, '缺少省份ID');
            }
            if ($this->cityId === 0) {
                IError::show(403, '缺少城市ID');
            }
            if ($this->areaId === 0) {
                IError::show(403, '缺少地域ID');
            }
            
        }
            
            //通过地域id查找商家id
            $sallerObj = new IModel('seller');
            $sallerWhere = "province = '{$this->provinceId}' AND city = '{$this->cityId}' AND area = '{$this->areaId}' ";
            $this->saller = $sallerObj->getObj($sallerWhere, array('id'));
            //var_dump($sallerObj->getLastSql());
            //var_dump($this->saller);
            //通过商家id查找该商家的商品
            if($this->saller){
            $proObj = new IModel('goods');
            $this->proid = $proObj -> query('seller_id='.$this->saller['id'],array('id'));
            //var_dump($this->proid);
            //获取该商家的商品id
            $sallerGoodsIds = array();
                if(!empty($this->proid[0])){
                    foreach ($this->proid as $value) {
                        $sallerGoodsIds[] = $value['id'];
                    }
                   // var_dump($sallerGoodsIds);
//                    exit;
                }
            }
            
            //通过分类id查找商品id
            $procatObj = new IModel('category_extend');
            $this->proCat = $procatObj->query('category_id='.$this->catId,array('goods_id'));
            $catGoodsIds = array();
            //var_dump($this->proCat);
            if(!empty($this->proCat[0])){
                
                 foreach ($this->proCat as $val) {
                        $catGoodsIds[] = $val['goods_id'];
                    }
            }
            //var_dump($catGoodsIds);
            
            //取交集得到最终需要的产品id
            $searchGoodsIds =  array_intersect($sallerGoodsIds,$catGoodsIds);
            //var_dump($searchGoodsIds);
            if(empty($searchGoodsIds)){
                IError::show(403, '此区域商品已售光');
            }else{
                //获取满足条件的商品列表
                //$this->resultData = array();
                foreach ($searchGoodsIds as $v) {
                    $this->resultData[]= $proObj ->getObj('id = '.$v);
                }
                
            }
            //var_dump($this->resultData);
            //echo '</br></br></br>';
            //$goodsObj = search_goods::find(array('category_extend' => $this->childId));
            //$resultData1 = $goodsObj->find();
            //var_dump($resultData1);
            //exit;
            
           //查找分类信息
            $catObj = new IModel('category');
            $this->catRow = $catObj->getObj('id = ' . $this->catId);
            if ($this->catRow == null) {
                IError::show(403, '此分类不存在');
            }
          
            //获取子分类
            $this->childId = goods_class::catChild($this->catId);
          
        
        $this->redirect('pro_list');
    }

    //咨询
    function consult() {
        $this->goods_id = IFilter::act(IReq::get('id'), 'int');
        $this->callback = IReq::get('callback');

        if ($this->goods_id == 0) {
            IError::show(403, '缺少商品ID参数');
        }

        $goodsObj = new IModel('goods');
        $goodsRow = $goodsObj->getObj('id = ' . $this->goods_id);

        if (!$goodsRow) {
            IError::show(403, '商品数据不存在');
        }

        //获取次商品的评论数和平均分(保留小数点后一位)
        $goodsRow['apoint'] = $goodsRow['comments'] ? round($goodsRow['grade'] / $goodsRow['comments'], 1) : 0;
        $goodsRow['comments'] = $goodsRow['comments'];

        $this->goodsRow = $goodsRow;
        $this->redirect('consult');
    }

    //咨询动作
    function consult_act() {
        $goods_id = IFilter::act(IReq::get('goods_id', 'post'), 'int');
        $captcha = IFilter::act(IReq::get('captcha', 'post'));
        $question = IFilter::act(IReq::get('question', 'post'));
        $callback = IReq::get('callback');
        $message = '';

        if ($captcha != ISafe::get('captcha')) {
            $message = '验证码输入不正确';
        } else if (!trim($question)) {
            $message = '咨询内容不能为空';
        } else if ($goods_id == 0) {
            $message = '商品ID不能为空';
        } else {
            $goodsObj = new IModel('goods');
            $goodsRow = $goodsObj->getObj('id = ' . $goods_id);
            if (!$goodsRow) {
                $message = '不存在此商品';
            }
        }

        //有错误情况
        if ($message) {
            $this->callback = $callback;
            $this->goods_id = $goods_id;
            $dataArray = array(
                'question' => $question,
            );
            $this->consultRow = $dataArray;

            //渲染goods数据
            $goodsObj = new IModel('goods');
            $goodsRow = $goodsObj->getObj('id = ' . $this->goods_id);

            //获取次商品的评论数和平均分(保留小数点后一位)
            $goodsRow['apoint'] = $goodsRow['comments'] ? round($goodsRow['grade'] / $goodsRow['comments'], 1) : 0;
            $goodsRow['comments'] = $goodsRow['comments'];
            $this->goodsRow = $goodsRow;

            $this->redirect('consult', false);
            Util::showMessage($message);
        } else {
            $dataArray = array(
                'question' => $question,
                'goods_id' => $goods_id,
                'user_id' => isset($this->user['user_id']) ? $this->user['user_id'] : 0,
                'time' => ITime::getDateTime(),
            );

            $referObj = new IModel('refer');
            $referObj->setData($dataArray);
            $referObj->add();

            $this->redirect('success?callback=/site/products/id/' . $goods_id);
        }
    }

    //公告详情页面
    function notice_detail() {
        $this->notice_id = IFilter::act(IReq::get('id'), 'int');
        if ($this->notice_id == '') {
            IError::show(403, '缺少公告ID参数');
        } else {
            $noObj = new IModel('announcement');
            $this->noticeRow = $noObj->getObj('id = ' . $this->notice_id);
            if (empty($this->noticeRow)) {
                IError::show(403, '公告信息不存在');
            }
            $this->redirect('notice_detail');
        }
    }

    //咨询详情页面
    function article_detail() {
        $this->article_id = IFilter::act(IReq::get('id'), 'int');
        if ($this->article_id == '') {
            IError::show(403, '缺少咨询ID参数');
        } else {
            $articleObj = new IModel('article');
            $this->articleRow = $articleObj->getObj('id = ' . $this->article_id);
            if (empty($this->articleRow)) {
                IError::show(403, '资讯文章不存在');
                exit;
            }

            //关联商品
            $relationObj = new IQuery('relation as r');
            $relationObj->join = ' left join goods as go on r.goods_id = go.id ';
            $relationObj->where = ' r.article_id = ' . $this->article_id . ' and go.id is not null ';

            $this->relationList = $relationObj->find();
            $this->redirect('article_detail');
        }
    }

    //商品展示
    function products() {
        $goods_id = IFilter::act(IReq::get('id'), 'int');

        if (!$goods_id) {
            IError::show(403, "传递的参数不正确");
            exit;
        }

        //使用商品id获得商品信息
        $tb_goods = new IModel('goods');
        $goods_info = $tb_goods->getObj('id=' . $goods_id . " AND is_del=0");
        if (!$goods_info) {
            IError::show(403, "这件商品不存在");
            exit;
        }

        //品牌名称
        if ($goods_info['brand_id']) {
            $tb_brand = new IModel('brand');
            $brand_info = $tb_brand->getObj('id=' . $goods_info['brand_id']);
            if ($brand_info) {
                $goods_info['brand'] = $brand_info['name'];
            }
        }

        //获取商品分类
        $categoryObj = new IModel('category_extend as ca,category as c');
        $categoryRow = $categoryObj->getObj('ca.goods_id = ' . $goods_id . ' and ca.category_id = c.id', 'c.id,c.name');
        $goods_info['category'] = $categoryRow ? $categoryRow['id'] : 0;

        //商品图片
        $tb_goods_photo = new IQuery('goods_photo_relation as g');
        $tb_goods_photo->fields = 'p.id AS photo_id,p.img ';
        $tb_goods_photo->join = 'left join goods_photo as p on p.id=g.photo_id ';
        $tb_goods_photo->where = ' g.goods_id=' . $goods_id;
        $goods_info['photo'] = $tb_goods_photo->find();
        foreach ($goods_info['photo'] as $key => $val) {
            //对默认第一张图片位置进行前置
            if ($val['img'] == $goods_info['img']) {
                $temp = $goods_info['photo'][0];
                $goods_info['photo'][0] = $val;
                $goods_info['photo'][$key] = $temp;
            }
        }

        //商品是否参加促销活动(团购，抢购)
        $goods_info['promo'] = IReq::get('promo') ? IReq::get('promo') : '';
        $goods_info['active_id'] = IReq::get('active_id') ? IFilter::act(IReq::get('active_id'), 'int') : '';
        if ($goods_info['promo']) {
            switch ($goods_info['promo']) {
                //团购
                case 'groupon': {
                        $goods_info['regiment'] = Api::run("getRegimentRowById", array("#id#", $goods_info['active_id']));
                    }
                    break;

                //抢购
                case 'time': {
                        $goods_info['promotion'] = Api::run("getPromotionRowById", array("#id#", $goods_info['active_id']));
                    }
                    break;

                default: {
                        IError::show(403, "活动不存在或者已经过期");
                        exit;
                    }
            }
        }

        //获得扩展属性
        $tb_attribute_goods = new IQuery('goods_attribute as g');
        $tb_attribute_goods->join = 'left join attribute as a on a.id=g.attribute_id ';
        $tb_attribute_goods->fields = ' a.name,g.attribute_value ';
        $tb_attribute_goods->where = "goods_id='" . $goods_id . "' and attribute_id!=''";
        $tb_attribute_goods->order = "g.id asc";
        $goods_info['attribute'] = $tb_attribute_goods->find();

        //[数据挖掘]最终购买此商品的用户ID列表
        $tb_good = new IQuery('order_goods as og');
        $tb_good->join = 'left join order as o on og.order_id=o.id ';
        $tb_good->fields = 'DISTINCT o.user_id';
        $tb_good->where = 'og.goods_id = ' . $goods_id;
        $tb_good->limit = 5;
        $bugGoodInfo = $tb_good->find();
        if ($bugGoodInfo) {
            $shop_goods_array = array();
            foreach ($bugGoodInfo as $key => $val) {
                $shop_goods_array[] = $val['user_id'];
            }
            $goods_info['buyer_id'] = join(',', $shop_goods_array);
        }

        //购买记录
        $tb_shop = new IQuery('order_goods as og');
        $tb_shop->join = 'left join order as o on o.id=og.order_id';
        $tb_shop->fields = 'count(*) as totalNum';
        $tb_shop->where = 'og.goods_id=' . $goods_id . ' and o.status = 5';
        $shop_info = $tb_shop->find();
        $goods_info['buy_num'] = 0;
        if ($shop_info) {
            $goods_info['buy_num'] = $shop_info[0]['totalNum'];
        }

        //购买前咨询
        $tb_refer = new IModel('refer');
        $refeer_info = $tb_refer->getObj('goods_id=' . $goods_id, 'count(*) as totalNum');
        $goods_info['refer'] = 0;
        if ($refeer_info) {
            $goods_info['refer'] = $refeer_info['totalNum'];
        }

        //网友讨论
        $tb_discussion = new IModel('discussion');
        $discussion_info = $tb_discussion->getObj('goods_id=' . $goods_id, 'count(*) as totalNum');
        $goods_info['discussion'] = 0;
        if ($discussion_info) {
            $goods_info['discussion'] = $discussion_info['totalNum'];
        }

        //获得商品的价格区间
        $tb_product = new IModel('products');
        $product_info = $tb_product->getObj('goods_id=' . $goods_id, 'max(sell_price) as maxSellPrice ,min(sell_price) as minSellPrice,max(market_price) as maxMarketPrice,min(market_price) as minMarketPrice');
        $goods_info['maxSellPrice'] = '';
        $goods_info['minSellPrice'] = '';
        $goods_info['minMarketPrice'] = '';
        $goods_info['maxMarketPrice'] = '';
        if ($product_info) {
            $goods_info['maxSellPrice'] = $product_info['maxSellPrice'];
            $goods_info['minSellPrice'] = $product_info['minSellPrice'];
            $goods_info['minMarketPrice'] = $product_info['minMarketPrice'];
            $goods_info['maxMarketPrice'] = $product_info['maxMarketPrice'];
        }

        //获得会员价
        $countsumInstance = new countsum();
        $goods_info['group_price'] = $countsumInstance->getGroupPrice($goods_id, 'goods');

        //获取商家信息
        if ($goods_info['seller_id']) {
            $sellerDB = new IModel('seller');
            $goods_info['seller'] = $sellerDB->getObj('id = ' . $goods_info['seller_id']);
        }

        //增加浏览次数
        $visit = ISafe::get('visit');
        $checkStr = "#" . $goods_id . "#";
        if ($visit && strpos($visit, $checkStr) !== false) {
            
        } else {
            $tb_goods->setData(array('visit' => 'visit + 1'));
            $tb_goods->update('id = ' . $goods_id, 'visit');
            $visit = $visit === null ? $checkStr : $visit . $checkStr;
            ISafe::set('visit', $visit);
        }

        $this->setRenderData($goods_info);
        $this->redirect('products');
    }

    //商品讨论更新
    function discussUpdate() {
        $goods_id = IFilter::act(IReq::get('id'), 'int');
        $content = IFilter::act(IReq::get('content'), 'text');
        $captcha = IReq::get('captcha');
        $return = array('isError' => true, 'message' => '');

        if (!$this->user['user_id']) {
            $return['message'] = '请先登录系统';
        } else if ($captcha != ISafe::get('captcha')) {
            $return['message'] = '验证码输入不正确';
        } else if (trim($content) == '') {
            $return['message'] = '内容不能为空';
        } else {
            $return['isError'] = false;

            //插入讨论表
            $tb_discussion = new IModel('discussion');
            $dataArray = array(
                'goods_id' => $goods_id,
                'user_id' => $this->user['user_id'],
                'time' => date('Y-m-d H:i:s'),
                'contents' => $content,
            );
            $tb_discussion->setData($dataArray);
            $tb_discussion->add();

            $return['time'] = $dataArray['time'];
            $return['contents'] = $content;
            $return['username'] = $this->user['username'];
        }
        echo JSON::encode($return);
    }

    //获取货品数据
    function getProduct() {
        $jsonData = JSON::decode(IReq::get('specJSON'));
        if (!$jsonData) {
            echo JSON::encode(array('flag' => 'fail', 'message' => '规格值不符合标准'));
            exit;
        }

        $goods_id = IFilter::act(IReq::get('goods_id'), 'int');
        $specJSON = IFilter::act(IReq::get('specJSON'));

        //获取货品数据
        $tb_products = new IModel('products');
        $procducts_info = $tb_products->getObj("goods_id = " . $goods_id . " and spec_array = '" . $specJSON . "'");

        //匹配到货品数据
        if (!$procducts_info) {
            echo JSON::encode(array('flag' => 'fail', 'message' => '没有找到相关货品'));
            exit;
        }

        //获得会员价
        $countsumInstance = new countsum();
        $group_price = $countsumInstance->getGroupPrice($procducts_info['id'], 'product');

        //会员价格
        if ($group_price !== null) {
            $procducts_info['group_price'] = $group_price;
        }

        echo JSON::encode(array('flag' => 'success', 'data' => $procducts_info));
    }

    //顾客评论ajax获取
    function comment_ajax() {
        $goods_id = IFilter::act(IReq::get('goods_id'), 'int');
        $page = IFilter::act(IReq::get('page'), 'int') ? IReq::get('page') : 1;

        $commentDB = new IQuery('comment as c');
        $commentDB->join = 'left join goods as go on c.goods_id = go.id AND go.is_del = 0 left join user as u on u.id = c.user_id';
        $commentDB->fields = 'u.head_ico,u.username,c.time,c.comment_time,c.contents,c.point';
        $commentDB->where = 'c.goods_id = ' . $goods_id . ' and c.status = 1';
        $commentDB->order = 'c.id desc';
        $commentDB->page = $page;
        $data = $commentDB->find();
        $pageHtml = $commentDB->getPageBar("javascript:void(0);", 'onclick="comment_ajax([page])"');

        echo JSON::encode(array('data' => $data, 'pageHtml' => $pageHtml));
    }

    //购买记录ajax获取
    function history_ajax() {
        $goods_id = IFilter::act(IReq::get('goods_id'), 'int');
        $page = IFilter::act(IReq::get('page'), 'int') ? IReq::get('page') : 1;

        $orderGoodsDB = new IQuery('order_goods as og');
        $orderGoodsDB->join = 'left join order as o on og.order_id = o.id left join user as u on o.user_id = u.id';
        $orderGoodsDB->fields = 'o.user_id,og.goods_price,og.goods_nums,o.create_time as completion_time,u.username';
        $orderGoodsDB->where = 'og.goods_id = ' . $goods_id . ' and o.status = 5';
        $orderGoodsDB->order = 'o.create_time desc';
        $orderGoodsDB->page = $page;

        $data = $orderGoodsDB->find();
        $pageHtml = $orderGoodsDB->getPageBar("javascript:void(0);", 'onclick="history_ajax([page])"');

        echo JSON::encode(array('data' => $data, 'pageHtml' => $pageHtml));
    }

    //讨论数据ajax获取
    function discuss_ajax() {
        $goods_id = IFilter::act(IReq::get('goods_id'), 'int');
        $page = IFilter::act(IReq::get('page'), 'int') ? IReq::get('page') : 1;

        $discussDB = new IQuery('discussion as d');
        $discussDB->join = 'left join user as u on d.user_id = u.id';
        $discussDB->where = 'd.goods_id = ' . $goods_id;
        $discussDB->order = 'd.id desc';
        $discussDB->fields = 'u.username,d.time,d.contents';
        $discussDB->page = $page;

        $data = $discussDB->find();
        $pageHtml = $discussDB->getPageBar("javascript:void(0);", 'onclick="discuss_ajax([page])"');

        echo JSON::encode(array('data' => $data, 'pageHtml' => $pageHtml));
    }

    //买前咨询数据ajax获取
    function refer_ajax() {
        $goods_id = IFilter::act(IReq::get('goods_id'), 'int');
        $page = IFilter::act(IReq::get('page'), 'int') ? IReq::get('page') : 1;

        $referDB = new IQuery('refer as r');
        $referDB->join = 'left join user as u on r.user_id = u.id';
        $referDB->where = 'r.goods_id = ' . $goods_id;
        $referDB->order = 'r.id desc';
        $referDB->fields = 'u.username,u.head_ico,r.time,r.question,r.reply_time,r.answer';
        $referDB->page = $page;

        $data = $referDB->find();
        $pageHtml = $referDB->getPageBar("javascript:void(0);", 'onclick="refer_ajax([page])"');

        echo JSON::encode(array('data' => $data, 'pageHtml' => $pageHtml));
    }

    //评论列表页
    function comments_list() {
        $id = IFilter::act(IReq::get("id"), 'int');
        $type = IFilter::act(IReq::get("type"));

        $type_config = array('bad' => '1', 'middle' => '2,3,4', 'good' => '5');

        if (!isset($type_config[$type])) {
            $type = null;
        } else {
            $type = $type_config[$type];
        }

        $data['comment_list'] = array();

        $query = new IQuery("comment AS a");
        $query->fields = "a.*,b.username,b.head_ico";
        $query->join = "left join user AS b ON a.user_id=b.id";
        $query->where = " a.goods_id = {$id} ";

        if ($type !== null)
            $query->where = " a.goods_id={$id} AND a.status=1  AND a.point IN ($type)";
        else
            $query->where = "a.goods_id={$id} AND a.status=1 ";

        $query->order = "a.id DESC";
        $query->page = IReq::get('page') ? intval(IReq::get('page')) : 1;
        $query->pagesize = 10;

        $data['comment_list'] = $query->find();
        $this->comment_query = $query;

        if ($data['comment_list']) {
            $user_ids = array();
            foreach ($data['comment_list'] as $value) {
                $user_ids[] = $value['user_id'];
            }
            $user_ids = implode(",", array_unique($user_ids));
            $query = new IQuery("member AS a");
            $query->join = "left join user_group AS b ON a.user_id IN ({$user_ids}) AND a.group_id=b.id";
            $query->fields = "a.user_id,b.group_name";
            $user_info = $query->find();
            $user_info = Util::array_rekey($user_info, 'user_id');

            foreach ($data['comment_list'] as $key => $value) {
                $data['comment_list'][$key]['user_group_name'] = isset($user_info[$value['user_id']]['group_name']) ? $user_info[$value['user_id']]['group_name'] : '';
            }
        }

        $data = array_merge($data, Comment_Class::get_comment_info($id));
        $this->data = $data;
        $this->redirect('comments_list');
    }

    //提交评论页
    function comments() {
        $id = IFilter::act(IReq::get('id'), 'int');

        if (!$id) {
            IError::show(403, "传递的参数不完整");
        }

        if (!isset($this->user['user_id']) || $this->user['user_id'] == null) {
            IError::show(403, "登录后才允许评论");
        }

        $can_submit = Comment_Class::can_comment($id, $this->user['user_id']);
        if ($can_submit[0] == -1) {
            IError::show(403, "没有这条数据");
        }

        $this->can_submit = $can_submit[0] == 1;
        $this->comment = $can_submit[1];
        $this->comment_info = Comment_Class::get_comment_info($this->comment['goods_id']);
        $this->redirect("comments");
    }

    /**
     * @brief 进行商品评论 ajax操作
     */
    public function comment_add() {
        if (!isset($this->user['user_id']) || $this->user['user_id'] === null) {
            die("未登录用户不能评论");
        }

        if (IReq::get('id') === null) {
            die("传递的参数不完整");
        }

        $id = IFilter::act(IReq::get('id'), 'int');
        $data = array();
        $data['point'] = IFilter::act(IReq::get('point'), 'float');
        $data['contents'] = IFilter::act(IReq::get("contents"), 'content');
        $data['status'] = 1;

        if ($data['point'] == 0) {
            die("请选择分数");
        }

        $can_submit = Comment_Class::can_comment($id, $this->user['user_id']);
        if ($can_submit[0] != 1) {
            die("您不能评论此件商品");
        }

        $data['comment_time'] = date("Y-m-d", ITime::getNow());

        $tb_comment = new IModel("comment");
        $tb_comment->setData($data);
        $re = $tb_comment->update("id={$id}");

        if ($re) {
            //同步更新goods表,comments,grade
            $commentRow = $tb_comment->getObj('id = ' . $id);

            $goodsDB = new IModel('goods');
            $goodsDB->setData(array(
                'comments' => 'comments + 1',
                'grade' => 'grade + ' . $commentRow['point'],
            ));
            $goodsDB->update('id = ' . $commentRow['goods_id'], array('grade', 'comments'));

            echo "success";
        } else {
            die("评论失败");
        }
    }

    function pic_show() {
        $this->layout = "";
        $this->redirect("pic_show");
    }

    function help() {
        $id = intval(IReq::get("id"));
        $tb_help = new IModel("help");
        $help_row = $tb_help->query("id={$id}");
        if (!$help_row || !is_array($help_row)) {
            IError::show(404, "您查找的页面已经不存在了");
        }
        $this->help_row = end($help_row);

        $tb_help_cat = new IModel("help_category");
        $cat_row = $tb_help_cat->query("id={$this->help_row['cat_id']}");
        $this->cat_row = end($cat_row);
        $this->redirect("help");
    }

    function help_list() {
        $id = intval(IReq::get("id"));
        $tb_help_cat = new IModel("help_category");
        $cat_row = $tb_help_cat->query("id={$id}");
        if ($cat_row) {
            $this->cat_row = end($cat_row);
        } else {
            $this->cat_row = array('id' => 0, 'name' => '站点帮助');
        }
        $this->redirect("help_list");
    }

    //团购页面
    function groupon() {
        $id = IFilter::act(IReq::get("id"), 'int');

        //指定某个团购
        if ($id) {
            $this->regiment_list = Api::run('getRegimentRowById', array('#id#', $id));
            $this->regiment_list = $this->regiment_list ? array($this->regiment_list) : array();
        } else {
            $this->regiment_list = Api::run('getRegimentList');
        }

        //往期团购
        $this->ever_list = Api::run('getEverRegimentList');
        $this->redirect("groupon");
    }

}
