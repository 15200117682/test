<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\CartModel;//购物车model
use App\Model\DetailModel;//订单详情model
use App\Model\OrderModel;//订单页面model

class OrderController extends Controller
{
   public function pay(Request $request){
       $user_id=$request->session()->get('id');//登录用户的id(session值)
       $data=DB::table('order_detail')
           ->join('goods', 'order_detail.goods_id', '=', 'goods.goods_id')
           ->where('order_detail.user_id',$user_id)
           ->where('order_detail.status',1)
           ->get();//两表联查 （订单详情表和商品表）
       $info=DB::table('address')->where('post_code',2)->first();//地址
       return view('pay.pay',["data"=>$data,'info'=>$info]);
   }

   //订单的收获地址
    public function address(Request $request){
        $user_id=$request->session()->get('id');//登录用户的id(session值)
        $first=DB::table('address')->where('user_id',$user_id)->where('post_code',2)->first();
        $data=DB::table('address')->where('user_id',$user_id)->where('post_code',1)->get();
       return view('pay.address',['first'=>$first,'data'=>$data]);
    }

    //订单的收获地址添加展示
    public function addressadd(Request $request){
        return view('pay.addressadd');
    }

    //订单的收获地址添加展示
    public function addadd(Request $request){
        $user_id=$request->session()->get('id');//登录用户的id(session值)
       $arr=$request->input();
       $data=[
           'order_id'=>102,
           'user_id'=>$user_id,
           'order_receive_name'=>$arr['order_receive_name'],
           'receive_phone'=>$arr['receive_phone'],
           'province_id'=>null,
           'city_id'=>null,
           'area_id'=>null,
           "receive_address"=>$arr['receive_address'],
           'post_code'=>2
       ];
       $where=[
           'post_code'=>1
       ];
       DB::table('address')->where('user_id',$user_id)->update($where);
       $res=DB::table("address")->insert($data);
       if($res){
           $arr=array(
               'status'=>1,
               'msg'=>"添加成功"
           );
           return $arr;
       }
    }

    //删除订单收货地址
    public function addressdel(Request $request){
        $user_id=$request->session()->get('id');//登录用户的id(session值)
        $address_id=$request->input('address_id');
        $info=DB::table("address")->where('address_id',$address_id)->first();
        if($info->post_code==2){
            $arr=array(
                'status'=>2,
                'msg'=>'默认地址不能删除'
            );
            return $arr;
        }
        $res=DB::table('address')->where('address_id',$address_id)->where('user_id',$user_id)->delete();
        if($res){
            $arr=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
            return $arr;
        }
    }

}
