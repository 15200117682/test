<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>信息流 - 滚动加载</legend>
</fieldset>

<ul class="flow-default" id="LAY_demo1"></ul>




<script src="layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use('flow', function(){
        var flow = layui.flow;

        flow.load({
            elem: '#LAY_demo1' //流加载容器

            ,done: function(page, next){ //执行下一页的回调

                /*//模拟数据插入
                setTimeout(function(){
                    var lis = [];
                    for(var i = 0; i < 8; i++){
                        lis.push('<li>'+ ( (page-1)*8 + i + 1 ) +'</li>')
                    }

                    next(lis.join(''), page < 10); //假设总页数为 10
                }, 500);*/
                var data={};
                data.page=page;
                var url="liu";
                $.ajax({
                    type:"post",
                    data:data,
                    url:url,
                    success:function (msg) {
                        var info=msg.info;
                        var pageTotal=msg.page;
                        $("#ulGoodsList").append(info);
                        next('',page < pageTotal);
                    }
                });
            }
        });

    });
</script>

</body>
</html>