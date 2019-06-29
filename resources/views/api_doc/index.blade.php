<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ config('laravel_doc.languages.project_doc') }}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/vendor/laravel-doc/css/layui.css"  media="all">
    <style>
        #tab_content{
            margin-left: 210px;
        }
        h1{font-size:24px;}
        #tab_content h1{padding-bottom:10px;}
        #tab_content h2,#tab_content h3,#tab_content h4,#tab_content h5,#tab_content p,#tab_content li{padding-bottom:10px;}
        li{list-style:disc;}
        layui-tab ul{margin:3px 0 3px 30px;}
        table{border-right:1px solid #e5e5e5;border-bottom:1px solid #e5e5e5;margin-bottom:10px;}
        table td,table th{border-left:1px solid #e5e5e5;border-top:1px solid #e5e5e5;padding:10px;}
        code ,pre{padding: 2px 4px;
            font-size: 90%;
            color: #c7254e;
            background-color: #f9f2f4;
            border-radius: 3px;}
        table th{background-color: #fafafa;}
        pre{margin-bottom:15px;}
        .string { color: green; }
        .number { color: darkorange; }
        .boolean { color: blue; }
        .null { color: magenta; }
        .key { color: red; }
        .layui-form{
            padding-top: 5px;
        }
        .float_left{
            float: left;
            margin-right: 20px;
            height: auto;
        }
    </style>
</head>
<body>
<form class="layui-form" action="" method="get">
    <div class="layui-form-item">
        <label class="layui-form-label"><strong>{{ config('laravel_doc.languages.doc_name') }}</strong></label>
        <div class="" style="float: left;width: 200px;">
            <input type="text" name="keywords" lay-verify="title" autocomplete="off" class="layui-input" value="{{ $keywords }}">
        </div>
        <button class="layui-btn">{{ config('laravel_doc.languages.search') }}</button>
    </div>
</form>
<div style="float: left;width: 180px; height:auto; min-height:500px;padding: 10px; border: 1px solid #ddd; overflow: auto;">
    <ul id="menu"></ul>
</div>
<div id="tab_content">
    <div class="layui-tab" lay-filter="tab-item" lay-allowclose="true">
        <ul class="layui-tab-title">
            <li class="layui-this" lay-id="1">{{ config('laravel_doc.languages.welcome_use') }}{{ config('laravel_doc.name') }}</li>
        </ul>

        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <h1>接口约定</h1>
                <ul>
                    <li>所有成功的数据的返回都放在了<code>json数组</code>中,如 成功返回
                        <h1>返回数据接口约定</h1>
                        <pre>
{
  "message": "success", //消息
  "errcode": 0, //状态码
  "data": [data]  //数据
}
                    </pre>失败返回
                        <pre>
{
  "message": "数据不存在", //错误消息存放进message
  "data": "",
  "errcode": 1
}
                    </pre>
                    </li>

                </ul>
                <h2>状态码约定</h2>
                <table class="layui-table">
                    <colgroup>
                        <col width="150">
                        <col width="200">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>状态码</th>
                        <th>说明</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>0</td>
                        <td>表示操作成功</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>表示失败</td>
                    </tr>
                    <tr>
                        <td>其他状态码</td>
                        <td>根据接口文档的说明进行处理</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div id="search_content" style="display: none">
    <div style="overflow:hidden;margin:15px 0px;">
        <label class="layui-form-label" style="font-size:20px;"><strong>{{ config('laravel_doc.languages.request_url') }}</strong></label>
        <div style="float: left;width: 800px;">
            <input type="text" name="keywords" lay-verify="title" autocomplete="off" class="layui-input api_url" id="api_url">
        </div>
        <button class="layui-btn api_get">{{ config('laravel_doc.languages.send_request') }}</button>
        <button class="layui-btn api_markdown">{{ config('laravel_doc.languages.generate_doc') }}</button>
        <input type="hidden" class="origin_api_content">
        <inputname>
            <request_type>
                <inputdoc_link>
                    <table class="layui-table" style="margin-top: 20px">
                        <colgroup>
                            <col width="150">
                            <col width="200">
                            <col>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>{{ config('laravel_doc.languages.param') }}</th>
                            <th>{{ config('laravel_doc.languages.value') }}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

    </div>

    <pre class="api_content">

        </pre>
</div>

<script src="/vendor/laravel-doc/js/layui.js" charset="utf-8"></script>
<script src="/vendor/laravel-doc/js/markdown.js"></script>
<script>
    layui.use(['tree', 'layer','element'], function(){
        var $ = layui.jquery;
        var layer = layui.layer
            ,element = layui.element();
        //发送请求
        $("body").on("click", ".api_get",function () {
            var url=$(this).parent().find('.api_url').val();
            var type=$(this).parent().find('.request_type').val();
            var _this=$(this);
            var data={}
            $(this).parent().find('.param').each(function(index,element){
                var key=$(this).find("input:eq(0)").val();
                var val=$(this).find("input:eq(1)").val();
                data[key]=val;
            });
            $.ajax({
                type:type,
                data:data,
                url:url,
                headers: {
                    'Access-Token':'{{ config('laravel_doc.token') }}',
                    'X-Requested-With':'XMLHttpRequest'
                },
                success:function (data) {
                    _this.parent().parent().find('.api_content').html(syntaxHighlight(data));
                    _this.parent().find('.origin_api_content').val(JSON.stringify(data));
                }
            });
        });
        //生成markdown
        $("body").on("click", ".api_markdown",function () {
            var data={};
            var params=[];
            $(this).parent().find('.param').each(function(index,element){
                params[index]=$(this).find("input:eq(0)").val();
            });
            data['params']=params;
            data['url']=$(this).parent().find('.api_url').val();
            data['name']=$(this).parent().find('.name').val();
            var doc_link=$(this).parent().find('.doc_link').val();
            data['response']=$(this).parent().find('.origin_api_content').val();
            $.ajax({
                type:'post',
                data:data,
                url:'{{ route('doc.apidoc.markdown') }}',
                headers: {
                    'Access-Token':'{{ config('laravel_doc.token') }}',
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                success:function (res) {
                    element.tabDelete('tab-item', 'api_markdown');
                    var parse=new HyperDown();
                    var parse_html=parse.makeHtml(res);
                    var html="<div class='float_left'>\n" +
                        "<textarea name=\"md_content\" class=\"layui-textarea\" id='api_doc_md' style='width: 500px;height:700px'>"
                        +res+
                        " </textarea>" +
                        "</div>" +
                        "<div class='float_left' id='api_markdown_pre'>"
                        +parse_html+
                        "</div><input id='doc_link' type='hidden' value='"+doc_link+"'><button class=\"layui-btn api_doc_save\">{{ config('laravel_doc.languages.generate') }}</button>"
                    element.tabAdd('tab-item', {
                        title: '{{ config('laravel_doc.languages.generate_doc') }}'
                        ,content: html
                        ,id: 'api_markdown'
                    });
                    element.tabChange('tab-item', 'api_markdown');
                }
            });
        });
        //监听输入框的改变
        $(document).on("input propertychange","textarea",function(){
            var val=$('#api_doc_md').val();
            var parse=new HyperDown();
            var parse_html=parse.makeHtml(val);
            $("#api_markdown_pre").html(parse_html);
        });

        $("body").on("click", ".api_doc_save",function () {
            var data={};
            data.md=$('#api_doc_md').val();
            data.doc_link=$('#doc_link').val();
            $.ajax({
                type:'post',
                data:data,
                url:'{{ route('doc.apidoc.save') }}',
                headers: {
                    'Access-Token':'{{ config('laravel_doc.token') }}',
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                success:function (res) {
                    alert(res.message);
                }
            });

        });
        //触发事件
        var active = {
            tabAdd: function(item){
                $.ajaxSettings.async = false;
                $.get('{{ route('doc.apidoc.html') }}?name='+item.doc_link,function (data) {
                    mark_dowm=data.data;
                    var parse=new HyperDown();
                    var parse_html=parse.makeHtml(mark_dowm);
                    var html=$('#search_content').html();
                    var request_type=item.request_type?item.request_type:'POST';
                    html+='<p><strong>{{ config('laravel_doc.languages.request_type') }}: '+request_type+'</strong></p>';
                    html=html.replace(/api_url"/,'api_url" value="'+item.url+'"');

                    var params="";
                    if(item.params){
                        for( param in item.params){
                            params+="<tr class='param'>";
                            params+="<td><input type=\"text\" value=\""+param+"\" class=\"layui-input\"></td>";
                            params+="<td><input type=\"text\" value=\""+item.params[param]+"\" class=\"layui-input\"></td>";
                            params+="</tr>";
                        }
                    }
                    html+=parse_html;
                    html=html.replace(/<tbody><\/tbody>/,params);
                    html=html.replace(/<inputname>/,"<input type=\"hidden\" class=\"name\" value=\""+item.name+"\">");
                    html=html.replace(/<request_type>/,"<input type=\"hidden\" class=\"request_type\" value=\""+request_type+"\">");
                    html=html.replace(/<inputdoc_link>/,"<input type=\"hidden\" class=\"doc_link\" value=\""+item.doc_link+"\">");
                    //新增一个Tab项
                    element.tabAdd('tab-item', {
                        title: item.name
                        ,content: html
                        ,id: item.doc_link
                    });
                });
            },tabDelete: function(id){
                element.tabDelete('tab-item', id);
            }
            ,tabChange: function(id){
                //切换到指定Tab项
                element.tabChange('tab-item', id); //切换到：用户管理
            }
        };
        layui.tree({
            elem: '#menu' //指定元素
            ,click: function(item){ //点击节点回调
                if(!item.hasOwnProperty('children')){
                    active.tabDelete(item.doc_link);
                    active.tabAdd(item);
                    active.tabChange(item.doc_link);
                }
            }
            ,nodes:{!! $menus !!}
        });
    });

    function syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, undefined, 2);
        }
        json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }
</script>
</body>
</html>
