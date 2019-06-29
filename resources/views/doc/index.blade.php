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
            <li class="layui-this" lay-id="1">{{ config('laravel_doc.name') }}</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                {{ config('laravel_doc.languages.welcome_use') }}{{ config('laravel_doc.name') }}
            </div>

        </div>
    </div>
</div>
<div id="search_content" style="display: none">

</div>
<script src="/vendor/laravel-doc/js/layui.js" charset="utf-8"></script>
<script src="/vendor/laravel-doc/js/markdown.js"></script>
<script>
    layui.use(['tree', 'layer','element'], function(){
        var $ = layui.jquery;
        var layer = layui.layer
            ,element = layui.element();

        //触发事件
        var active = {
            tabAdd: function(item){
                $.ajaxSettings.async = false;
                $.get('{{ route('doc.html') }}?name='+item.doc_link,function (res) {
                    var mark_dowm=res.data;

                    var parse=new HyperDown();
                    var parse_html=parse.makeHtml(mark_dowm);
                    var html=$('#search_content').html();
                    html+=parse_html;
                    console.log(html);
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
                console.log(item);
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
