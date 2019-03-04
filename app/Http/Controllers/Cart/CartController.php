<?php

namespace App\Http\Controllers\Cart;

use App\Model\CartModel;//购物车modeL
use App\Model\GoodsModel;//商品model
use App\Model\OrderModel;//订单model
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;//DB类库

class CartController extends Controller
{
    //购物车页面
    public function cart(Request $request){
        $user_id=$request->session()->get("id");//获取session值
        $data=DB::table('cart')
            ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
            ->where('user_id',$user_id)
            ->where('cart.status',1)
            ->get();//两表联查  购物车表和商品表
        $info=GoodsModel::get();//查询所有商品
        return view('cart.cart',['data'=>$data,'info'=>$info]);//渲染页面
    }

    //判断购物车
    public function cartadd(Request $request){
            $goods_id=$request->input('goods_id');//接收商品id
            $dataInfo=$request->session()->get("id");//接收session值
            if(!$dataInfo){//判断是否登录
                $arr=array(
                    'status'=>1,
                    'msg'=>"请先登录"
                );
                return $arr;
            }
            $data=[
                'goods_id'=>$goods_id,
                'user_id'=>$dataInfo,
                'goods_num'=>+1,
            'status'=>1,
            'creattime'=>time()
        ];//添加购物车的值
        $cart=CartModel::where('goods_id',$goods_id)->where('user_id',$dataInfo)->first();//查询购物车数据库数据     对象格式
        if($cart){
            $cart=CartModel::where('goods_id',$goods_id)->where('user_id',$dataInfo)->first()->toArray();//根据登录的用户获取他们购物车信息
        }else{
            $cart=CartModel::where('goods_id',$goods_id)->where('user_id',$dataInfo)->first();//根据登录的用户获取他们购物车信息
        }

        //判断库存和商品是否上架
        $goods=GoodsModel::where('goods_id',$goods_id)->first();
        if($goods) {
            $goods = GoodsModel::where('goods_id', $goods_id)->first()->toArray();//根据购物车获取商品数据
        }else{
            $goods = GoodsModel::where('goods_id', $goods_id)->first();//根据购物车获取商品数据
        }
        if($goods['is_on_sale']==0){//判断商品是否是上架状态
            $arr=array(
                'status'=>2,
                'msg'=>"商品已下架"
            );
            return $arr;
        }else if($goods['goods_number']<$cart['goods_num']+1){//判断商品库存是否充足
            $arr=array(
                'status'=>3,
                'msg'=>"商品库存不足"
            );
            return $arr;
        }else if(empty($goods)){//判断是否是非法请求（没有商品id之类的）
            $arr=array(
                'status'=>4,
                'msg'=>"无商品，无法添加"
            );
            return $arr;
        }


        if($cart['goods_id']&&$cart['user_id']){//判断登录用户的购物车中是否有该商品
            $update=[
                'goods_num'=>$cart['goods_num']+1,//购物车库存+1
                'creattime'=>time()
            ];
            $res=DB::table('cart')->where('goods_id',$cart['goods_id'])->where('user_id',$cart['user_id'])->update($update);//有商品修改数量
        }else {
            $res = DB::table('cart')->insert($data);//没有商品添加商品购物车
        }
        if($res){
            $arr=array(
                'status'=>0,
                'msg'=>"是否跳转购物车"
            );
            return $arr;
        }//返回添加商品到购物车结果
    }

    //删除购物车数据
    public function cartdelete(Request $request){
        $goods_id=$request->input();//接收商品id
        $user_id=$request->session()->get("id");//获取登录用户的session
        $data=[
            'status'=>2
        ];
        $res=CartModel::where('goods_id',$goods_id)->where('user_id',$user_id)->update($data);//更改购物车次商品状态
        if($res){
            $arr=[
                'status'=>1,
                'msg'=>'删除成功'
            ];
            return $arr;
        }else{
            $arr=[
                'status'=>2,
                'msg'=>'删除成功'
            ];
            return $arr;
        }//返回结果
    }

    //加减购物车数据数量
    public function jia(Request $request){
        $cart_id=$request->input();//获取购物车id
        $info=CartModel::where("cart_id",$cart_id)->first();//查询购物车单挑数据
        $goods_number=GoodsModel::where('goods_id',$info['goods_id'])->first();//查询商品表
        $number=intval($info->goods_num);//购物车商品数量
        if($number+1>$goods_number['goods_number']){
            $arr=array(
                'status'=>2,
                'msg'=>"库存不足"
            );
            return $arr;
        }//判断库存
        $data=[
            'goods_num'=>$info['goods_num']+1,
            'creattime'=>time()
        ];
        $res=CartModel::where('cart_id',$cart_id)->update($data);
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>"添加数量成功"
            );
            return $arr;
        }//返回结果
    }//添加数据
    public function jian(Request $request){
        $cart_id=$request->input();//获取id
        $info=CartModel::where("cart_id",$cart_id)->first();//查询数据
        $data=[
            'goods_num'=>$info['goods_num']-1,
            'creattime'=>time()
        ];
        $res=CartModel::where('cart_id',$cart_id)->update($data);
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>"削减成功"
            );
            return $arr;
        }//返回结果
    }//削减数据
    public function blur(Request $request){//更改数据
        $cart_id=$request->input('cart_id');//获取id
        $goods_num=$request->input('goods_num');//获取文本框的值
        $goods_num=ceil($goods_num);//向上取整

        $info=CartModel::where("cart_id",$cart_id)->first();//查询单挑数据
        $goods_number=GoodsModel::where('goods_id',$info['goods_id'])->first();//查询商品表


        if($goods_num>$goods_number['goods_number']){
            $arr=array(
                'status'=>2,
                'msg'=>"库存不足"
            );
            return $arr;
        }//判断库存
        if($goods_num<1){
            $arr=array(
                'status'=>2,
                'msg'=>"非法数字"
            );
            return $arr;
        }//判断是否为非法数字
        $data=[
            'goods_num'=>$goods_num,
            'creattime'=>time()
        ];//修改的数据
        $res=CartModel::where('cart_id',$cart_id)->update($data);//执行sql
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>"更改成功"
            );
            return $arr;
        }//返回数据
    }//更改数据
    public function pdel(Request $request){
        $cart_id=$request->input('cart_id');//获取id
        $cart_id=ltrim($cart_id,',');//去逗号
        $cart_id=explode(',',$cart_id);//变换数据类型
        $data=[
            'status'=>2,
        ];
        $res=DB::table('cart')->whereIn('cart_id',$cart_id)->update($data);//执行sql
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
        }//返回结果
        return $arr;
    }//批量删除

    //购物车结算 生成订单
    public function order(Request $request){
        $user_id=$request->session()->get("id");//用户id
        $cart_id=$request->input('cart_id');//多条选中的购物车表中商品的id
        $cart_id=ltrim($cart_id,',');//去除逗号
        $order_amount=$request->input('order_amount');//总金额
        $cart_id=explode(',',$cart_id);//修改数据类型

        $order_no=time().rand(1000,9999);//订单号
        $order_amount=intval($order_amount);//订单金额
        $data=[
            'order_no'=>$order_no,
            'user_id'=>$user_id,
            'order_amount'=>$order_amount,
            "order_pay_type"=>1,
            'ay_status'=>1,
            'pay_way'=>1,
            'status'=>1
        ];//添加订单数据
        $res=OrderModel::insert($data);//执行sql


        //订单详情添加
        $cartData=DB::table('cart')
            ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
            ->whereIn('cart.goods_id',$cart_id)
            ->where('user_id',$user_id)
            ->get();//两表联查 （购物车表和商品表）
        $orderdata=DB::table('order')->where('order_no',$order_no)->first();//根据订单号查询订单表单挑数据
        $order_id=$orderdata->order_id;//获取订单id
        $order_detail=[];//定义空数组
        foreach($cartData as $k=>$v){
            $order_detail[]=[
                'order_id'=>$order_id,
                'order_no'=>$order_no,
                'user_id'=>$user_id,
                'goods_id'=>$v->goods_id,
                'goods_name'=>$v->goods_name,
                'goods_price'=>$v->shop_price,
                'buy_number'=>$v->goods_number,
                'goods_image'=>$v->goods_img,
                'status'=>1
            ];

        }//循环数据并放到数组中
        DB::table('order_detail')->insert($order_detail);//执行订单详情添加
        if($res){//返回结果
            $data=[
                'status'=>2
            ];//定义空状态（2）

            DB::table('cart')
                ->whereIn('cart.goods_id',$cart_id)
                ->where('user_id',$user_id)
                ->update($data);//订单完成后，删除登录用户的已买的商品
            $arr=array(
                'status'=>1,
                'msg'=>"成功加入订单"
            );
            return $arr;
        }else{
            $arr=array(
                'status'=>2,
                'msg'=>"加入订单失败"
            );
            return $arr;
        }
    }

}
