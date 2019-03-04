<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    //跳转所有商品
    public function goods(){
        $info=DB::table('category')->where(['parent_id'=>0])->get();
        $data=DB::table('goods')->get();
        return view('goods.goods',['info'=>$info],['data'=>$data]);
    }

    //分类商品展示
    public function cate_goods(Request $request){
        $id=$request->input();
        $this->get($id);
        $cateId=implode(',',self::$arrCate);
        $info=DB::select("select * from goods where cat_id in ($cateId)");
        return view('goods.cate_goods',['info'=>$info]);
    }


    //递归方法
    protected static $arrCate=array();
    private function get($id){
        $arrIds=DB::table('category')->select('cate_id')->where("parent_id",$id)->get();
        if(count($arrIds) > 0){
                foreach($arrIds as $key=>$value){
                    $cateId=$value->cate_id;
                    $arrNews=$this->get($cateId);
                }
        }
        foreach($arrIds as $value){
            $cate_id=$value->cate_id;
            array_push(self::$arrCate,$cate_id);
        }
    }

    //商品详情
    public function shopcontent(Request $request){
        $id=$request->input('goods_id');
        $data=DB::table('goods')->where('goods_id',$id)->first();
        return view('goods.shopcontent',['data'=>$data]);
    }

    //二维数组转换    联系
    public function ceshi(){
            $arr=array(
                array("id"=>1,"name"=>"list","age"=>20),
                array("id"=>1,"name"=>"list","age"=>50),
                array("id"=>1,"name"=>"list","age"=>10),
                array("id"=>1,"name"=>"list","age"=>9),
                array("id"=>1,"name"=>"list","age"=>4),
            );
            $arrResult=array();
            foreach($arr as $key=>$value){
                $arrResult[$value['age']]=$value;
            }
            $arrAge=array();
            foreach($arr as $key=>$value){
                $arrAge[]=$value['age'];
            }
            sort($arrAge);
            $arrHandle=array();
            foreach($arrAge as $value){
                $arrHandle[]=$arrResult[$value];
            }
            print_r($arrHandle);
    }


}
