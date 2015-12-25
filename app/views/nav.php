        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
            <ul class="acc-menu" id="sidebar" app="<?php echo $_G['app']?>" act="<?php echo $_G['act']?>">
                <li><a href="?app=Index"><i class="fa fa-home"></i> <span>首页</span></a></li>
				<li class="divider"></li>
                <li><a href="javascript:;"><i class="fa fa-shopping-cart"></i> <span>零售管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=Sale"><span>零售管理</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="fa fa-group"></i> <span>会员管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=MemberLevel"><span>会员级别</span></a></li>
                        <li><a href="?app=Member"><span>会员信息</span></a></li>
                        <li><a href="?app=MemberExchange"><span>积分兑换</span></a></li>
                        <li><a href="?app=MemberRecharge"><span>会员充值</span></a></li>
                        <li><a href="?app=MemberConsume"><span>消费查询</span></a></li>
                    </ul>
                </li>
				<li class="divider"></li>
                <li><a href="javascript:;"><i class="fa fa-truck"></i> <span>批发管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=Trade"><span>批发销售</span></a></li>
                        <li><a href="?app=TradeReturn"><span>批发退货</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="fa fa-suitcase"></i> <span>客户管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=Customer"><span>客户信息</span></a></li>
                        <li><a href="?app=CustomerPay"><span>收款查询</span></a></li>
                        <li><a href="?app=CustomerDebt"><span>欠款查询</span></a></li>
                    </ul>
                </li>
				<li class="divider"></li>
                <li><a href="javascript:;"><i class="fa fa-th"></i> <span>库存管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=Stock"><span>库存查询</span></a></li>
                        <li><a href="?app=StockIncome"><span>直接入库</span></a></li>
                        <li><a href="?app=StockOutcome"><span>直接出库</span></a></li>
                        <li><a href="?app=StockAllocate"><span>库存调拨</span></a></li>
						<li><a href="?app=StockWarecheck"><span>库存盘点</span></a></li>
                        <li><a href="?app=GoodsSplit"><span>拆分商品</span></a></li>
                        <li><a href="?app=GoodsBind"><span>捆绑商品</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="fa fa-bar-chart-o"></i> <span>统计管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=SaleStatistic"><span>零售统计</span></a></li>
                        <li><a href="?app=TradeStatistic"><span>批发统计</span></a></li>
                        <li><a href="?app=StockAllocateStatistic"><span>调拨统计</span></a></li>
                        <li><a href="?app=StockIncomeStatistic"><span>入库统计</span></a></li>
                        <li><a href="?app=StockOutcomeStatistic"><span>出库统计</span></a></li>
						<li><a href="?app=AllStatistic"><span>综合统计</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="fa fa-gift"></i> <span>商品管理</span> </a>
                    <ul class="acc-menu">
						<li><a href="?app=Category"><span>商品分类</span></a></li>
                        <li><a href="?app=Goods"><span>商品信息</span></a></li>
                        <li><a href="?app=GoodsSale"><span>特价商品</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="fa fa-cog"></i> <span>系统管理</span> </a>
                    <ul class="acc-menu">
                        <li><a href="?app=Staff"><span>员工信息</span></a></li>
                        <li><a href="?app=User"><span>用户设置</span></a></li>
                        <li><a href="?app=Role"><span>角色设置</span></a></li>
                        <li><a href="?app=Shop"><span>分店设置</span></a></li>
						<li><a href="?app=Option"><span>其他设置</span></a></li>
						<li><a href="?app=Database"><span>数据维护</span></a></li>
                    </ul>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </nav>