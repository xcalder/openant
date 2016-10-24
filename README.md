[手动安装教程](http://www.openant.com/bbs.php/community/posting?posting_id=16)
- qq群(QQ Group)：<a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=a3aa61a22c4546f12c7ba200607e4a67fcf091f2d02413568cadfff081990bd5"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="openant1群" title="openant1群"></a>

![](http://www.openant.com/public/resources/default/image/favicon.png)

![](http://www.openant.com/image/catalog/banner-home/20160526050500ROPqBzEjak.jpg)

OpenAnt/蚂蚁开源

==========================

[![Build Status](http://www.openant.com/doc/001.png)](http://www.openant.com)[![Packagist](http://www.openant.com/doc/002.png)](http://www.openant.com)[![CodeIgniter](http://www.openant.com/doc/003.png)](http://www.codeigniter.org)

Openant——多语言、多商家、订单、商品功能强大的，（插件方式）支持全球支付方式，整站采用插件模块布局的购物车商城平台项目，该项目采用GPL3许可证授权，你可以在遵循GPL3许可证的前提下自由复制、分发，甚至出售原代码！

Openant——Multi-language, multi-merchant, order, commodity powerful, (plug-in) support global payment, the whole station plug-in module layout shopping mall platform project, the project license GPL3 license, you can follow the GPL3 license Free distribution, distribution, and even sale of the original code.


[官网主页](http://www.openant.com) | [文档手册](http://www.openant.com/bbs.php) | [中文项目](http://git.oschina.net/xcalder/openant).

[Official page](http://www.openant.com) | [Documentation](http://www.openant.com/bbs.php) | [English Readme](https://github.com/xcalder/openant).

1.新项目考虑了当前电商的更多新问题，没有历史包袱，系统架构设计更松偶合。

1. The new project takes into account the current electricity business more new problems, there is no historical burden, the system architecture design more loose coupling.

2.商家入驻，充值提现，全球语言，子帐号，推广分成，平台分成，站内竟价排名，每天登陆送积分，积分抵钱，商品折扣，商品会员价，平台优惠券，商家优惠券，预留接口全面。

2. Merchant settled, recharge the cash, the global language, sub-account number, promotion into the platform into the station price ranking, daily landing to send points, credit points, merchandise discounts, merchandise membership price, platform coupons, merchant coupons, Leave the interface comprehensive.

目前，这是一个试测试版本，欢迎试用反馈给我们，或者合并你的修改到仓库 ：

Currently, this is a beta test version, please try to feedback to us, or merge your changes to the repository:

开发版本包含的功能：

Development version contains the following features:

* 多语言：可以扩展支持全球语言，适合外贸使用

* Multi-language: can be extended to support the global language, suitable for foreign trade

* 一个帐号单点登陆：商家、用户、管理员相同帐号，分配不同权限即可

* An account single point of landing: businesses, users, administrators the same account, you can assign different permissions

* 订单管理：

* Order Management:

a.平台管理员后台可以查看标注订单，自动为商家统计订单总额

A. The platform manager can view the label order automatically and collect the order amount for the merchant

b.商家后台可以查看，修改订单，（不能删除），发货，管理退换货商品（可以为某个订单下的单个商品操作退换货）

B. Business background can view, modify orders, (can not be deleted), shipping, return shipping goods management (for a single order under the operation of goods Returns)

c.会员后台可以管理自己的订单，提醒商家发货，查看订单详情，申请退款（退款理由可以在管理后台设定供选择，退换方式【退款退货、仅退款、仅退货】可以在管理员后台设定）

C. Members can manage their own orders back to remind businesses to ship, view the order details, apply for a refund (refund reason can be set in the management background settings, returned [refund refund, refund only] In the admin background settings)

* 商品管理：

* Product Management:

a.平台后台可以查看所有商家的所有商品，可以对某一商家的某一商品进行屏蔽（不在前台展示），可以选择永久屏蔽、屏蔽时间（7天、15天、30天）

A. The background of the platform can view all the merchandise of all businesses, you can block a merchandise of a merchant (not in the foreground), you can choose permanent shielding, shielding time (7 days, 15 days, 30 days)

b.平台后台可以设置平台商品分类（类目），商品属性、商品选项，类目里可以为类目指定（选择）商品属性、商品选项（选项、属性可以设置在此类目下是否必填）

B. The platform background can be set platform commodity classification (category), commodity attributes, commodity options, category can be specified for the category (select) commodity attributes, commodity options (options, attributes can be set in this category is required )

c.平台后台可以设置、添加品牌，

C. Platform background can be set, add the brand,

d.商家后台添加商品，流程：选择类目-》填写商品详情（包括：平台后台设定好的类目属性、选项、运费模板，商品其它详细信息，折扣价，折扣价开始结束时间，会员价，会员价开始结束时间）

D. Add merchandise in the background, process: select the category - "fill in the product details (including: platform background set category attributes, options, shipping templates, other details of goods, discounts, discounts start and end, Price, member price start and end time)

e.可以申请添加品牌（需要平台通过审核才能在商品发布中选择）

E. You can apply to add the brand (need to be audited in order to release the product in the selection)

f.申请添加类目：需要在平台后台通过审核才能在添加商品时使用

F. Apply to add categories: the need for approval in the background platform to add products in use


* 扩展性：看官网就知道了，我们轻松的扩展了一个论坛，注意这个论坛是在openant上扩展出来的

* Scalability: Kuan Kung to know, we easily extended a forum, pay attention to this forum is openant on the expansion of the

*充值提现，全球语言，子帐号，推广分成，平台分成，站内竟价排名，每天登陆送积分，积分抵钱，商品折扣，商品会员价，平台优惠券，商家优惠券 这些功能 都是可以轻松扩展的，如果你充分理解了此项目的源代码

* Recharge the cash, the global language, sub-account number, promotion into the platform into the station price ranking, daily landing to send points, credit points, merchandise discounts, merchandise membership price, platform coupons, merchant coupons these features can be easily Extensible if you fully understand the source code for this project


依赖

rely
---

* LNMP/LAMP(php5.6+)

截图

Screenshots
---
![](http://www.openant.com/image/catalog/banner-home/20160629050604FlO6MTDJdx.jpg)

![](http://www.openant.com/image/catalog/banner-home/20160526050509AUtb5cw8rT.jpg)

交流讨论

Exchange of ideas
-------
- [常见问题及解决办法手册](http://www.openant.com/helper/faq.html)
- [Frequently Asked Questions and Solutions Manual](http://www.openant.com/helper/faq.html)

- [社区论坛](http://www.openant.com/bbs.php)
- [Community Forum](http://www.openant.com/bbs.php)
