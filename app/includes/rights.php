<?php
 return array
(
    'mall_setting' => array
    (
        'default'     => 'default|all',//后台登录
        'setting'     => 'setting|all',//网站设置
        'region'       => 'region|all',//地区设置
        //'payment'    => 'payment|all',//支付方式
		'freight'    => 'freight|all',//支付方式
		'exchange'    => 'exchange|all',//支付方式
        'theme'     => 'theme|all',//主题设置
        'mailtemplate'   => 'mailtemplate|all',//邮件模板
        'template'  => 'template|all',//模板编辑
    ),
    'goods_admin' => array
    (
        'gcategory'    => 'gcategory|all',//分类列表
        //'brand' => 'brand|all',//品牌管理
        'goods_sku'    => 'goods_sku|all',//商品SKU
        'goods_price'    => 'goods_price|all',//商品价格
        'goods'    => 'goods|all',//商品管理
        'recommend'    => 'recommend|all',//推荐类型
    ),
    'purchasing_admin' => array
    (
        'purchasing'    => 'purchasing|index',//采购进货
		'purchasing_add'    => 'purchasing|add_purchasing,purchasing|show_store_list',//采购进货开单
		'purchasing_auto'    => 'purchasing|add_auto,purchasing|_add_auto_goods',//采购自动开单
		'purchasing_del'    => 'purchasing|del_purchasing',//采购进货删除
		'purchasing_ver'    => 'purchasing|verify_purchasing',//采购进货审核
		'purchasing_export'    => 'purchasing|export',//采购进货导出
		'purchasing_goods'    => 'purchasing_goods|index',//采购进货明细查看
		'purchasing_goods_edit'    => 'purchasing_goods|show_goods,purchasing_goods|show_goods_list,purchasing_goods|add_goods,purchasing_goods|edit_goods,purchasing_goods|del_goods',//采购进货明细修改
		'purchasing_goods_export'    => 'purchasing_goods|export',//采购进货明细查看
		'purchasing_receive'    => 'purchasing_receive|index',//采购收货
		'purchasing_receive_add'    => 'purchasing_receive|get_purchasing,purchasing_receive|show_purchasing_list,purchasing_receive|show_store_list,purchasing_receive|add_receive',//采购收货开单
		'purchasing_receive_del'    => 'purchasing_receive|del_receive',//采购收货删除
		'purchasing_receive_ver'    => 'purchasing_receive|verify_receive',//采购收货货审核
		'purchasing_receive_goods'    => 'purchasing_receive_goods|index',//采购收货明细查看
		'purchasing_receive_goods_edit'    => 'purchasing_receive_goods|show_goods,purchasing_receive_goods|show_goods_list,purchasing_receive_goods|add_goods,purchasing_receive_goods|edit_goods,purchasing_receive_goods|del_goods',//采购收货明细修改
		'purchasing_income'    => 'purchasing_income|index',//采购入库
		'purchasing_income_add'    => 'purchasing_income|get_receive,purchasing_income|show_receive_list,purchasing_income|add_income',//采购入库开单
		'purchasing_income_del'    => 'purchasing_income|del_income',//采购入库删除
		'purchasing_income_ver'    => 'purchasing_income|verify_income',//采购入库审核
		'purchasing_income_export'    => 'purchasing_income|export',//采购入库导出
		'purchasing_income_goods'    => 'purchasing_income_goods|index',//采购入库明细查看
		'purchasing_income_goods_edit'    => 'purchasing_income_goods|show_goods,purchasing_income_goods|show_goods_list,purchasing_income_goods|add_goods,purchasing_income_goods|edit_goods,purchasing_income_goods|del_goods',//采购入库明细修改
		'purchasing_return'    => 'purchasing_return|index',//采购退货
		'purchasing_return_add'    => 'purchasing_return|get_income,purchasing_return|show_income_list,purchasing_return|add_return',//采购退货开单
		'purchasing_return_del'    => 'purchasing_return|del_return',//采购退货删除
		'purchasing_return_ver'    => 'purchasing_return|verify_return',//采购退货货审核
		'purchasing_return_goods'    => 'purchasing_return_goods|index',//采购退货明细查看
		'purchasing_return_goods_edit'    => 'purchasing_return_goods|show_goods,purchasing_return_goods|show_goods_list,purchasing_return_goods|add_goods,purchasing_return_goods|edit_goods,purchasing_return_goods|del_goods',//采购退货明细修改
    ),
    'stock_admin' => array
    (
        'incoming'    => 'incoming|index',//直接入库查看
		'incoming_add'    => 'incoming|add_incoming,incoming|show_store_list',//直接入库增加
		'incoming_del'    => 'incoming|del_incoming',//直接入库删除
		'incoming_ver'    => 'incoming|verify_incoming',//直接入库审核
		'incoming_goods'    => 'incoming_goods|index',//直接入库明细查看
		'incoming_goods_edit'    => 'incoming_goods|show_goods,incoming_goods|show_goods_list,incoming_goods|add_sku_goods,incoming_goods|edit_goods_list,incoming_goods|del_goods_list',//直接入库明细编辑
        'outcoming'     => 'outcoming|index',//直接出库查看
		'outcoming_add'     => 'outcoming|add_outcoming,outcoming|show_store_list',//直接出库增加
		'outcoming_del'     => 'outcoming|del_outcoming',//直接出库删除
		'outcoming_ver'     => 'outcoming|verify_outcoming',//直接出库审核
		'outcoming_goods'    => 'outcoming_goods|index',//直接入库明细查看
		'outcoming_goods_edit'    => 'outcoming_goods|show_goods,outcoming_goods|show_goods_list,outcoming_goods|add_sku_goods,outcoming_goods|edit_goods,outcoming_goods|del_goods_list',//直接入库明细编辑
        'allocate'     => 'allocate|index',//调拨查看
		'allocate_add'     => 'allocate|add_allocate',//调拨增加
		'allocate_del'     => 'allocate|del_allocate',//调拨删除
		'allocate_ver'     => 'allocate|verify_allocate',//调拨出库审核
		'allocate_ver_done'     => 'allocate|verify_allocate_done',//调拨入库审核
		'allocate_goods'    => 'allocate_goods|index',//调拨明细查看
		'allocate_goods_edit'    => 'allocate_goods|show_goods,allocate_goods|show_goods_list,allocate_goods|add_sku_goods,allocate_goods|edit_goods_list,allocate_goods|del_goods_list',//调拨明细编辑
        'warecheck'     => 'warecheck|index',//库存盘点查看
		'warecheck_add'     => 'warecheck|add_warecheck',//库存盘点增加
		'warecheck_del'     => 'warecheck|del_warecheck',//库存盘点删除
		'warecheck_ver'     => 'warecheck|verify_warecheck',//库存盘点删除
		'warecheck_goods'    => 'warecheck_goods|index',//库存盘点明细查看
		'warecheck_goods_edit'    => 'warecheck_goods|show_goods,warecheck_goods|show_goods_list,warecheck_goods|add_sku_goods,warecheck_goods|edit_goods_list,warecheck_goods|del_goods_list',//库存盘点明细编辑
        'split'     => 'split|index',//商品拆分查看
		'split_add'     => 'split|add_split,split|show_goods_list',//商品拆分增加
		'split_del'     => 'split|del_split',//商品拆分删除
		'split_ver'     => 'split|verify_split',//商品拆分审核
		'split_goods'    => 'split_goods|index',//商品拆分明细查看
		'split_goods_edit'    => 'split_goods|show_goods,split_goods|show_goods_list,split_goods|add_goods,split_goods|edit_goods,split_goods|del_goods',//商品拆分明细编辑
        'bind'     => 'bind|index',//商品捆绑查看
		'bind_add'     => 'bind|add_bind,bind|show_goods_list',//商品捆绑增加
		'bind_del'     => 'bind|del_bind',//商品捆绑删除
		'bind_ver'     => 'bind|verify_bind',//商品捆绑审核
		'bind_goods'    => 'bind_goods|index',//商品捆绑明细查看
		'bind_goods_edit'    => 'bind_goods|show_goods,bind_goods|show_goods_list,bind_goods|add_goods,bind_goods|edit_goods,bind_goods|del_goods',//商品捆绑明细编辑
		'stock'   => 'stock|all',//库存查询
		'storage_flow'   => 'storage_flow|all',//库存流水
		'goods_change'   => 'goods_change|all',//库存流水
		
    ),
    'store_admin' => array
    (
        'sgrade'    => 'sgrade|all',//店铺等级
        'scategory'     => 'scategory|all',//店铺分类
        'store'   => 'store|all',//店铺管理
    ),
    'member' => array
    (
        'user'  => 'user|all',//会员管理
        'admin' => 'admin|all',//管理员管理
		'user_group' => 'user_group|all',//管理员管理
        'notice' => 'notice|all',//会员通知
    ),
    'order' => array
    (
        'order'   => 'order|index',//订单列表
		'order_view'   => 'order_view|index',//订单明细
		'order_memo_add'   => 'order_memo|add',//编辑备注
		'order_memo_index'   => 'order_memo|index',//查看备注
		'order_edit'   => 'order_view|show_shipping_fee,order_view|show_goods,order_view|show_goods_list,order_view|edit_order',//订单编辑
		'order_trash'   => 'order|trash',//订单回收站
		'order_shipped'   => 'order|shipped',//订单发货审核
		'order_verify'   => 'order|verify',//批量发货审核
		'order_returned_order'   => 'order|returned_order',//订单退货
		'order_cancel_order'   => 'order|cancel_order',//订单取消
		'order_recover_order'   => 'order|recover_order',//订单恢复
		'order_finished'   => 'order|finished',//订单完成
		'order_export'   => 'order|export',//订单导出
		'order_p_export'   => 'order|p_export',//订单导出
		'order_e_export'   => 'order|e_export',//导出E键发
		'order_shipping_export'   => 'order|shipping_export',//导出E键发
		'order_yanwen_export'   => 'order|yanwen_export',//导出燕文
		'order_connect_export'   => 'order|connect_export',//导出交接单
		'order_etk_export'   => 'order|etk_export',//导出E特快
		'order_freeze_add'   => 'order|freeze,order|freeze_add',//冻结单据
		'order_freeze_cancel'   => 'order|freeze,order|freeze_cancel',//取消冻结
		'order_mark_print'   => 'order|mark_print',//订单打印
		'order_edit_order_type'   => 'order|edit_order_type',//编辑发货状态
		'order_return'   => 'order_return|index',//退货管理
        'order_return_export'   => 'order_return|export',//退货导出
		'order_return_verify'   => 'order_return|verify_return',//退货审核
		'order_return_add'   => 'order_return|add,order_return|view,order_return|edit_order,order_return|save_order,order_return|delete',//退货处理
        'order_service'   => 'order_service|index,order_service|delete,order_service|trace,order_service|view,order_service|verify_service,order_service|cancel_verify_service,order_service|export',//售后管理
        'order_service_caiwu'   => 'order_service|index,order_service|index,order_service|trace,order_service|view,order_service|export,order_service|caiwu_verify_service',//财务售后审核
		'order_return_shipping'   => 'order_return_shipping|all',//换单重发
		'order_return_stock'   => 'order_return_stock|all',//退货入库
		'ups_print'   => 'ups_print|all',//UPS打印
    ),
    'finance' => array
    (
        'custom_money'    => 'custom_money|all,order|view',//客户现金银行
		'paypal'      => 'paypal|all',//paypal账目
        'custom_money_change'      => 'custom_money_change|all',//客户现金银行提进款
        'custom_money_flow'      => 'custom_money_flow|all',//客户现金银行提进款
        'order_cost'      => 'order_cost|all',//销售费用
        'order_return_money'   => 'order_return_money|all',//顾客退货
		'money_group'   => 'money_group|all',//客户现金组
    ),
    'statistics' => array
    (
        'statistics_purchase'    => 'statistics_purchase|all',//商品采购统计
		'statistics_stock'      => 'statistics_stock|all',//库存管理统计
        'statistics_sell'      => 'statistics_sell|all',//销售管理统计
        'statistics_cost'      => 'statistics_cost|all',//成本管理统计
        'statistics_goods'      => 'statistics_goods|all',//商品销售排行
        'statistics_seller'   => 'statistics_seller|all',//业务员业绩统计
		'statistics_all'   => 'statistics_all|all',//销售营业分析
		'statistics_group'   => 'statistics_group|all',//统计分组
    ),
    'website' => array
    (
        'acategory'    => 'acategory|all',//文章分类
        'article'      => array('article' => 'article|all', 'upload' => array('comupload' => 'comupload|all', 'swfupload' => 'swfupload|all')),//文章管理
        'partner'      => 'partner|all',//合作伙伴
        'navigation'   => 'navigation|all',//页面导航
        'db'           => 'db|all',//数据库
        'groupbuy'     => 'groupbuy|all',//团购
        'consulting'   => 'consulting|all',//咨询
        'share_link'   => 'share|all',//分享管理

    ),

    'external' => array
    (
        'plugin' => 'plugin|all',//插件管理
        'module'   => 'module|all',//模块管理
        'widget'   => 'widget|all',//挂件管理
    ),
    'clear_cache' =>array
    (
        'clear_cache' => 'clear_cache|all',//清空缓存
    )
);