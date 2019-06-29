# 如何使用

## 普通文档的编写
在`resources/mds/docs`中创建你的md文件,如`demo.md`,加入你需要的内容，
然后到`app/Http/Controllers/Docs/LaravelDocController.php`的`index_md`中加入数据即可访问，例如：

```
//默认已经加入了2个例子
private function index_md()
    {
        return  [
            [
                'name' => config('laravel_doc.languages.install'),
                'doc_link' => 'install.md',
            ],
            [
                'name' => config('laravel_doc.languages.how_use'),
                'doc_link' => 'how_use.md',
            ],
            [
                'name' => 'demo',
                'doc_link' => 'demo.md',
            ],
        ];
    }
```

然后访问`/doc`,即可看到效果

# 控制器说明

默认文档的路径
```
$this->mds_path=resource_path('mds/docs/');
```


`getMenu()`里面的代码是文档显示的菜单,这个是写文档需要用到的

* 配置多个菜单示例
```
protected function getMenu()
    return [
                [
                    'name'=>config('laravel_doc.languages.project_doc'),
                    'spread'=>true,//菜单是否展开，false不展开
                    'children'=>[
                            'name'=>config('laravel_doc.languages.install'),
                            'doc_link'=>'install.md',
                         ],
                ],
                [
                    'name'=>config('laravel_doc.languages.project_doc'),
                    'spread'=>false,//不展开菜单
                    'children'=>[
                            'name'=>config('laravel_doc.languages.install'),
                            'doc_link'=>'install.md',
                     ],
                ],
            ];
}        
```
* 配置好菜单后可以在`resources/mds/docs`中新建`doc_link`中指定的md文件，然后进行文档的编写

------------

## api接口文档的编写

在`resources/mds/apidocs`中创建你的md文件,如`demo.md`,加入你需要的内容，
然后到`app/Http/Controllers/Docs/LaravelApiDocController.php`的`index_md`中加入数据即可访问，例如：

```
private function index_md()
    {
        return  [
            [
                'name' => 'apidoc_html',
                'doc_link' => 'apidoc_html.md',
                //可自行修改你的$this->host来使用你自己定义的访问地址
                'url' => $this->host.'apidoc/html',
                'request_type' => 'get',//请求方式 get或者post
                //请求参数
                'params'=>[
                    'name'=>'apidoc_html.md',
                ]
            ],
            [
                'name' => 'demo',
                'doc_link' => 'demo.md',
                'url' => $this->host.'apidoc/html',
                'request_type' => 'get',//请求方式 get或者post
                //给定一些需要请求的参数
                'params'=>[
                    'name'=>'',
                    'user_id'=>'',
                ]
            ],
        ];
    }
```

然后访问`/apidoc`,即可看到效果

点击提供的demo:`apidoc_html`,即可看到上面的请求路径和需要的请求参数，以及下面的参数文档

点击`发送请求`按钮，可以执行ajax请求，如果接口没有问题的话，就会返回ajax数据了
这个时候点击`生成文档`，会打开一个`markdown`的编辑框和右侧的效果图，该界面获取了当前点击页面
中定义的请求路径，参数，返回值等，在预览效果中你可以修改`接口人`，`参数说明`中对每个参数进行说明，
以及返回值的说明等，然后点击`生成`按钮，会根据你定义的`$this->mds_path`.你配置的`doc_link`，
如：`resources/mds/apidocs/demo.md`，来产生文件

--------------------------

# `laravel_doc.php` 配置文件说明
```
    //laravel-doc的名字
    'name' => 'Laravel-doc',
    //用在了定义撰写接口人的名字
    'author' => env('DOC_AUTHOR','foryoufeng'),
    //接口请求发送了这个token
    'token' => env('DOC_TOKEN','doc'),
    //做国际化时可以用到
    'languages'=>[
        'search'=>'搜索',
        'search_result'=>'搜索结果',
        'project_doc'=>'项目文档',
        'doc_name'=>'文档名称',
        'install'=>'安装',
        'how_use'=>'使用说明',
        'request_type'=>'http请求方式',
        'request_url'=>'请求地址',
        'send_request'=>'发送请求',
        'generate_doc'=>'生成文档',
        'welcome_use'=>'欢迎使用',
        'param'=>'参数',
        'value'=>'值',
        'generate'=>'生成',
    ]
```


# 进阶
* ## 多项目
如果你的项目比较小，只用写一个文档和一个api接口文档，那么在`app/Http/Controllers/Docs/LaravelApiDocController.php`和`app/Http/Controllers/Docs/LaravelDocController.php`
中加入你的文档应该基本满足要求


如果有多个项目，可以复制`app/Http/Controllers/Docs`、`resources/views/docs`,可以在`resources/mds/`目录中新建你准备写文档的目录
然后在路由文件中定义好需要的路由，需要复制下面的这些路由
```
//doc route
Route::group(['namespace'=>'Docs'],function (){
    Route::get('doc', 'LaravelDocController@index')->name('doc.index');
    //md文件返回到html
    Route::get('doc/html', 'LaravelDocController@html')->name('doc.html');
    Route::get('apidoc', 'LaravelApiDocController@index')->name('doc.apidoc');
    //md文件返回到html
    Route::get('apidoc/html', 'LaravelApiDocController@html')->name('doc.apidoc.html');
    //预览api文档
    Route::post('apidoc/markdown', 'LaravelApiDocController@markdown')->name('doc.apidoc.markdown');
    //生成api文档
    Route::post('apidoc/save', 'LaravelApiDocController@save')->name('doc.apidoc.save');

});
```

* ## 国际化
可以修改`config/laravel_doc.php`中的`languages`来更换语言，默认提供的是`中文`

* ## 接口拦截
在`config/laravel_doc.php`中有一个`token`的配置，接口做ajax请求时在`header`中带了`Access-Token`,接口可以根据这个配置，
做一个`中间件`的处理，比如使用指定的`token`就可以获取对应用户的信息，进行接口的请求和赋值等

* tips

`项目为了通用，我并没有提供中间件进行文档和接口的拦截，出于安全考虑，建议使用者可以根据自身需求编写中间件进行文档的保护`
