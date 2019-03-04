<?php

namespace App\Http\Controllers\Index;

use App\extend\send\send;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\User;
use App\models\Goods;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //首页
    public function index(){
        $data=DB::table('chaoren')->paginate(2);
        return view('index.index',['data'=>$data]);
    }

    //注册
    public function register(){
        return view('index.register');
    }
    //注册  添加
    public function doadd(Request $request){
        $arr=$request->input();
        $tel=$arr['tel'];
        $pwd=$arr['pwd'];
        $conpwd=$arr['conpwd'];
        $code=$arr['code'];

        //判断两次密码是否一致
        if($pwd!=$conpwd){
            $arr=array(
                'status'=>0,
                'msg'=>"密码不一致",
            );
            return $arr;
        }

        //验证唯一性
        $res=User::where('tel',$tel)->first();
        if(!empty($res)){
            $arr=array(
                'status'=>0,
                'msg'=>"手机号已注册",
            );
            return $arr;
        }

        //验证验证码
        $time=time();
        $where=[
            'code'=>$code,
            'tel'=>$tel
        ];
        $bol=DB::table('code')->select("*")->where($where)->where("timeout",">",$time)->first();
        if(empty($bol)){
            $arr=array(
                'status'=>0,
                'msg'=>"验证码不正确",
            );
            return $arr;
        }
        //入库
        $pwd=md5($pwd);
        $arrInfo=array(
            'tel'=>$tel,
            "pwd"=>$pwd,
        );
        $res=DB::table('user')->insert($arrInfo);
        if($res){
            $where=[
                'code'=>$code,
                'tel'=>$tel
            ];
            $Info=[
                'status'=>0
            ];
            DB::table("code")->where($where)->update($Info);
            $arr=array(
                'status'=>1,
                'msg'=>"注册成功",
            );
            return $arr;
        }else{
            $arr=array(
                'status'=>0,
                'msg'=>"注册失败",
            );
            return $arr;
        }



    }

    //登录
    public function login(){
        return view('index.login');
    }

    //登录验证
    public  function dologin(Request $request){
        $arr=$request->input();
        $tel=$arr['tel'];
        $pwd=$arr['pwd'];
        if(empty($tel)){
            $arrInfo=array(
                'status'=>1,
                'msg'=>"手机号不能为空"
            );
            return $arrInfo;
        }
        if(empty($pwd)){
            $arrInfo=array(
                'status'=>1,
                'msg'=>"密码不能为空"
            );
            return $arrInfo;
        }
        $pwd=md5($pwd);
        $data=['tel'=>$tel,"pwd"=>$pwd];
        $Info=DB::table('user')->where($data)->first();
        //print_r($Info);exit;
        if($Info){
            $id=$Info->id;
            $tel=$Info->tel;
            session(['id'=>$id,"tel"=>$tel]);
            $arrInfo=array(
                'status'=>0,
                'msg'=>"登录成功"
            );
            return $arrInfo;
        }else{
            $arrInfo=array(
                'status'=>1,
                'msg'=>"登录失败"
            );
            return $arrInfo;
        }

    }

    //短信验证
    public function code(Request $request){
        $tel=$request->input("tel");

        //生成验证码
        $num = rand(1000,9999);
        $obj=new send();
        $res=$obj->show($tel,$num);
        if($res==100){
            $arr=array(
                'tel'=>$tel,
                'code'=>$num,
                'timeout'=>time()+120,
                'status'=>1,
            );
            $bool=DB::table('code')->insert($arr);
            if($bool){
                $arrInfo=array(
                    'status'=>1,
                    'msg'=>"验证码发送成功"
                );
                return $arrInfo;
            }

        }
    }

    //流加载测试
    public function liu(Request $request){
        $arr=array();
        $page=$request->input('page',1);
        $pageNum=2;
        $offset=($page-1) * $pageNum;
        $arrDataInfo=DB::table("goods")->offset($offset)->limit($pageNum)->get();//每页数据

        $totalData=DB::table('goods')->count();//条目数
        $pageTotal=ceil($totalData/$pageNum);//总页数;

        $objview=view('index.goodsliu',['info'=>$arrDataInfo]);

        $content=response($objview)->getContent();
        $arr['info']=$content;
        $arr['page']=$pageTotal;
        return $arr;
    }

}
