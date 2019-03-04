<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link href="css/cartlist.css" rel="stylesheet" type="text/css" />
    <script src="layui/layui.js"></script>
    <link rel="stylesheet" href="layui/css/layui.css">
</head>
<body id="loadingPicBlock" class="g-acc-bg">
<input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
<div>
    <!--首页头部-->
    <div class="m-block-header">
        <a href="/" class="m-public-icon m-1yyg-icon"></a>
        <a href="/" class="m-index-icon">编辑</a>
    </div>
    <!--首页头部 end-->
    <div class="g-Cart-list">
        <ul id="cartBody">
            @foreach($data as $v)
                <input type="hidden" count_price="{{$v->shop_price*$v->goods_num}}" id="Count" value="{{$v->goods_id}}">
            <li>
                <s class="xuan current"></s>
                <a class="fl u-Cart-img" href="/v44/product/12501977.do">
                    <img src="/images/uploads/uploads/{{$v->goods_img}}" border="0" alt="">
                </a>
                <div class="u-Cart-r">
                    <a href="/v44/product/12501977.do" class="gray6">{{$v->goods_name}}</a>
                    <span class="gray9">
                            <em>剩余{{$v->shop_price}}人次</em>
                        </span>
                    <div class="num-opt">
                        <em class="num-mius dis min"><i></i></em>
                        <input class="text_box" cart_id="{{$v->cart_id}}" name="num" maxlength="6" type="text" shop_price="{{$v->shop_price}}" value="{{$v->goods_num}}" codeid="12501977">
                        <em class="num-add add"><i></i></em>
                    </div>
                    <a href="javascript:;" goods_id="{{$v->goods_id}}" name="delLink" cid="12501977" isover="0" class="z-del"><s></s></a>
                </div>
            </li>
                @endforeach

        </ul>
        <div id="divNone" class="empty "  style="display: none"><s></s><p>您的购物车还是空的哦~</p><a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a></div>
    </div>
    <div id="mycartpay" class="g-Total-bt g-car-new" style="">
        <dl>
            <dt class="gray6">
                <s class="quanxuan current"></s>全选
                <p class="money-total">合计<em class="orange total" id="jine"><span>￥</span>12.00</em></p>

            </dt>
            <dd>
                <a href="javascript:;" id="a_payment" class="orangeBtn w_account remove">删除</a>
                <a href="javascript:;" id="a_payment" class="orangeBtn w_account order">去结算</a>
            </dd>
        </dl>
    </div>
    <div class="hot-recom">
        <div class="title thin-bor-top gray6">
            <span><b class="z-set"></b>人气推荐</span>
            <em></em>
        </div>
        <div class="goods-wrap thin-bor-top">
            <ul class="goods-list clearfix">
                @foreach($info as $value)
                <li>
                    <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                        <img src="/images/uploads/uploads/{{$value->goods_img}}" width="136" height="136">
                    </a>
                    <p class="g-name">
                        <a href="https://m.1yyg.com/v44/products/23458.do"><a href="">(第<i>{{$value->goods_sn}}</i>潮){{$value->goods_name}}</a></a>
                    </p>
                    <ins class="gray9">价值:￥{{$value->shop_price}}</ins>
                    <div class="btn-wrap">
                        <div class="Progress-bar">
                            <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                            </p>
                        </div>
                        <div class="gRate" data-productid="23458">
                            <a href="javascript:;"><s></s></a>
                        </div>
                    </div>
                </li>
                @endforeach
                {{--<li>
                    <a href="" class="g-pic">
                        <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                    </a>
                    <p class="g-name">
                        <a href="https://m.1yyg.com/v44/products/23458.do">(第368671潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                    </p>
                    <ins class="gray9">价值:￥7130</ins>
                    <div class="btn-wrap">
                        <div class="Progress-bar">
                            <p class="u-progress">
                                    <span class="pgbar" style="width:45%;">
                                        <span class="pging"></span>
                                    </span>
                            </p>
                        </div>
                        <div class="gRate" data-productid="23458">
                            <a href="javascript:;"><s></s></a>
                        </div>
                    </div>
                </li>--}}
            </ul>
        </div>
    </div>




    <div class="footer clearfix">
        <ul>
            <li class="f_home"><a href="index" ><i></i>潮购</a></li>
            <li class="f_announced"><a href="/v41/lottery/" ><i></i>最新揭晓</a></li>
            <li class="f_single"><a href="/v41/post/index.do" ><i></i>晒单</a></li>
            <li class="f_car"><a id="btnCart" href="cart" class="hover"><i></i>购物车</a></li>
            <li class="f_personal"><a href="/v41/member/index.do" ><i></i>我的潮购</a></li>
        </ul>
    </div>

    <script src="js/jquery-1.11.2.min.js"></script>
    <!---商品加减算总数---->
    <script type="text/javascript">
        $(function () {
            layui.use(['layer'],function() {
                var layer = layui.layer;
                //加数据
                $(".add").click(function () {
                    var cart_id = $(this).prev().attr('cart_id');//获取文本框中的商品id值
                    var data = {};
                    data.cart_id = cart_id;//传json数据
                    var url = "jia";
                    $.ajax({//走ajax
                        type: "post",
                        data: data,
                        url: url,
                        success: function (msg) {
                            if (msg.status == 1) {
                                layer.msg(msg.msg);
                                location.href="cart";
                            }else{
                                layer.msg(msg.msg);
                                location.href="cart";
                            }//接收返回的结果
                        }
                    });

                });
                //减数据
                $(".min").click(function () {
                    var cart_id = $(this).next().attr('cart_id');//获取文本框中的商品id值
                    var data = {};
                    data.cart_id = cart_id;//传json数据
                    var url = "jian";
                    var value=$(this).next().val();
                    if(value-1<1){
                        layer.msg("非法数量");
                    }else {
                        $.ajax({
                            type: "post",
                            data: data,
                            url: url,
                            success: function (msg) {
                                if (msg.status == 1) {
                                    layer.msg(msg.msg);
                                    location.href = "cart";
                                }//接收返回的结果
                            }
                        });
                    }

                })

                //失去焦点时间
                $('.text_box').blur(function () {
                    var cart_id = $(this).attr('cart_id');
                    var goods_num = $(this).prop('value');
                    var data = {};
                    data.cart_id = cart_id;
                    data.goods_num = goods_num;
                    var url = "blur";
                    // t.val(parseInt(t.val()) + 1);
                    $.ajax({
                        type: "post",
                        data: data,
                        url: url,
                        success: function (msg) {
                            if(msg.status==1){
                                layer.msg(msg.msg);
                                location.href="cart";
                            }else{
                                layer.msg(msg.msg);
                                location.href="cart";
                            }
                        }
                    });
                })

                //批量删除
                $('#a_payment').click(function () {
                    var goods_id='';
                    $(".g-Cart-list .xuan").each(function(){
                        var _this=$(this);
                        if ($(this).hasClass("current")){
                            var goods=_this.parent('li').prev().prop('value');
                            goods_id+=','+goods;
                        }
                    });
                    var data={};
                    data.cart_id=goods_id;
                    url="pdel";
                    $.ajax({
                        type: "post",
                        data: data,
                        url: url,
                        success: function (msg) {
                            if(msg.status==1){
                                layer.msg(msg.msg);
                                location.href="cart";
                            }
                        }
                    });

                })

                //订单生成
                $('.order').click(function () {
                    var goods_id='';
                    $(".g-Cart-list .xuan").each(function(){
                        var _this=$(this);
                        if ($(this).hasClass("current")){
                            var goods=_this.parent('li').prev().prop('value');
                            goods_id+=','+goods;
                        }
                    });
                    var shop_price=$('#jine').find('a').html();
                    var data={};
                    data.order_amount=shop_price;
                    data.cart_id=goods_id;
                    url='order';
                    $.ajax({
                        type: "post",
                        data: data,
                        url: url,
                        success: function (msg) {
                           if(msg.status==1){
                               layer.msg(msg.msg);
                               location.href="pay";
                           }else{
                               layer.msg(msg.msg);
                           }
                        }
                    });

                })

            })
        })
    </script>
    <script type="text/javascript">
        $('.z-del').click(function () {
            var _this=$(this);
            var goods_id=_this.attr('goods_id');
            var data={};
            var url="cartdelete";
            data.goods_id=goods_id;
            layui.use('layer',function () {
                var layer = layui.layer;
                layer.confirm("确认删除吗？", {title: "友情提示"}, function (index) {
                    if (index === 1) {
                        $.ajax({
                            type:"post",
                            data:data,
                            url:url,
                            success:function (msg) {
                                if(msg.status==1){
                                    layer.msg(msg.msg);
                                    location.href="cart";
                                }else{
                                    layer.msg(msg.msg);
                                }
                            }
                        });
                    }
                })
            })

        })
    </script>




    <script>

        // 全选
        $(".quanxuan").click(function () {
            if($(this).hasClass('current')){
                $(this).removeClass('current');

                $(".g-Cart-list .xuan").each(function () {
                    if ($(this).hasClass("current")) {
                        $(this).removeClass("current");
                    } else {
                        $(this).addClass("current");
                    }
                });
                GetCount();
            }else{
                $(this).addClass('current');

                $(".g-Cart-list .xuan").each(function () {
                    $(this).addClass("current");
                    // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
                });
                GetCount();
            }


        });
        // 单选
        $(".g-Cart-list .xuan").click(function () {
            if($(this).hasClass('current')){


                $(this).removeClass('current');

            }else{
                $(this).addClass('current');
            }
            if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                $('.quanxuan').addClass('current');

            }else{
                $('.quanxuan').removeClass('current');
            }
            // $("#total2").html() = GetCount($(this));
            GetCount();
            //alert(conts);
        });
        // 已选中的总额
        function GetCount(){
            var conts = 0;
            var aa = 0;
            $(".g-Cart-list .xuan").each(function () {
                var _this=$(this);
                if ($(this).hasClass("current")){
                    var count=parseInt(_this.parent('li').prev().attr('count_price'));
                    conts+=count
                }
            });
            $(".total").html('<span>￥</span>'+"<a>"+(conts)+"</a>");
        }
        GetCount();
    </script>
</body>
</html>
