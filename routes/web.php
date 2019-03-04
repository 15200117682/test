<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//基本路由
Route::get('/', function () {
    return view('welcome');
});
/*//路由映射控制器
Route::any('lianxi',"Lianxi\lianxiController@show");


//路由传参数
Route::any('lian','Lianxi\lianxiController@lianxi');


//路由加判断
Route::any('show/{id}',function($id){
    if($id<5){
        return redirect("http://www.baidu.com");//重定向百度
    }else{
        return $id;
        //return view('lianxi.lianxi');//路由显示视图
    }
});

//路由前缀
Route::prefix('admin')->group(function () {
    Route::get('likeyou',"Lianxi\lianxiController@likeyou");
});

//增删改查测试
Route::any("mysql","Lianxi\lianxiController@mysql");
Route::any("add","Lianxi\lianxiController@add");

//列表添加
Route::any("nameadd",'User\UserController@add');//添加
Route::any("cate",'User\UserController@cate');//添加
Route::any("doadd",'User\UserController@doadd');
Route::any("list",'User\UserController@list');//展示
Route::any("delete",'User\UserController@delete');//删除
Route::any("update",'User\UserController@update');//修改
Route::any("updateadd",'User\UserController@updateadd');//修改操作
Route::any("pole",'User\UserController@pole');//即点即改
Route::any("key",'User\UserController@key');//即点即改*/

//前台
Route::any("index",'Index\IndexController@index');//主页
Route::any("register",'Index\IndexController@register');//注册
Route::any("doadd",'Index\IndexController@doadd');//注册 添加新用户
Route::any("login",'Index\IndexController@login');//登录
Route::any("dologin",'Index\IndexController@dologin');//登录验证
Route::any("t1",'Index\IndexController@t1');//登录验证 测试
Route::any("code",'Index\IndexController@code');//登录验证
Route::any("liu",'Index\IndexController@liu');//流加载 测试

//商品
Route::any("goods","Goods\GoodsController@goods");//商品首页
Route::any("cate_goods","Goods\GoodsController@cate_goods");//分类商品
Route::any("shopcontent","Goods\GoodsController@shopcontent");//商品详情

//购物车
Route::any("cart","Cart\CartController@cart");//购物车主页面
Route::any("cartadd","Cart\CartController@cartadd");//添加商品购物车判断
Route::any("cartdelete","Cart\CartController@cartdelete");//购物车删除
Route::any("jia","Cart\CartController@jia");//购物车添加数据
Route::any("jian","Cart\CartController@jian");//购物车减去数据
Route::any("blur","Cart\CartController@blur");//购物车更改数据
Route::any("pdel","Cart\CartController@pdel");//购物车批量删除

//订单位置
Route::any("order","Cart\CartController@order");//订单页面

///订单支付页面
Route::any("pay","Order\OrderController@pay");//订单支付页面
Route::any("address","Order\OrderController@address");//订单收货地址
Route::any("addadd","Order\OrderController@addadd");//收货地址添加展示
Route::any("addressadd","Order\OrderController@addressadd");//收货地址添加
Route::any("addressdel","Order\OrderController@addressdel");//收货地址添加





Route::any("ceshi","Goods\GoodsController@ceshi");//测试