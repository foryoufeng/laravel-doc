# laravel-doc

## [中文文档](readme_zh_CN.md)

<p align="center">⛵<code>laravel-doc</code> is doc generator for laravel which can help you write document by markdown and you can access it by web</p>

Requirements
------------
 - PHP >= 7.0.0
 - Laravel >= 5
 

## Installation

Via Composer

``` bash
composer require foryoufeng/laravel-doc
```

If you do not run Laravel 5.5 (or higher), then add the service provider in `config/app.php`:
```
Foryoufeng\Doc\DocServiceProvider::class
```

You need to publish the resource files by run command
```

 php artisan vendor:publish --provider=Foryoufeng\Doc\DocServiceProvider::class

```

After run command you can find add many files in the project

```

/public/vendor/laravel-doc  //styles

/resources/views/docs   //views

/resources/mds/docs  //markdown doc files

/resources/mds/apidocs  //markdown apidoc files

/app/Http/Controllers/Docs  //Controllers

config/laravel_doc.php  //config

routes/web.php  //add access url in the route file
```

### to access the application
* access `/doc`,to see the document

* access`/apidoc`,to see the api doc document

* but they are write by Chinese language

# How To Use

## General document
create your md file in the `resources/mds/docs`, such as`demo.md`,and add your content
then to the`app/Http/Controllers/Docs/LaravelDocController.php`,find the method`index_md`to add data，such as：

```
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

access to `/doc`

# Controller

the default path for docs to save
```
$this->mds_path=resource_path('mds/docs/');
```

* config menus
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
* after add your menus,add the `doc_link` you add to the `resources/mds/docs` folder

------------

## api doc

create your md file in the `resources/mds/apidocs`, such as`demo.md`,and add your content
then to the`app/Http/Controllers/Docs/LaravelApiDocController.php`,find the method`index_md`to add data，such as：

```
private function index_md()
    {
        return  [
            [
                'name' => 'apidoc_html',
                'doc_link' => 'apidoc_html.md',
                'url' => $this->host.'apidoc/html',
                'request_type' => 'get',
                'params'=>[
                    'name'=>'apidoc_html.md',
                ]
            ],
            [
                'name' => 'demo',
                'doc_link' => 'demo.md',
                'url' => $this->host.'apidoc/html',
                'request_type' => 'get',
                'params'=>[
                    'name'=>'',
                    'user_id'=>'',
                ]
            ],
        ];
    }
```

access to `/doc`

--------------------------

# `laravel_doc.php`
```
    //laravel-doc name
    'name' => 'Laravel-doc',
    //the author who write the api doc 
    'author' => env('DOC_AUTHOR','foryoufeng'),
    //access token
    'token' => env('DOC_TOKEN','doc'),
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


# Advanced
* ## Multi-project

to add more project you can copy`app/Http/Controllers/Docs`、`resources/views/docs`,`resources/mds/`
and copy routes,then change it
```
//doc route
Route::group(['namespace'=>'Docs'],function (){
    Route::get('doc', 'LaravelDocController@index')->name('doc.index');
    Route::get('doc/html', 'LaravelDocController@html')->name('doc.html');
    Route::get('apidoc', 'LaravelApiDocController@index')->name('doc.apidoc');
    Route::get('apidoc/html', 'LaravelApiDocController@html')->name('doc.apidoc.html');
    Route::post('apidoc/markdown', 'LaravelApiDocController@markdown')->name('doc.apidoc.markdown');
    Route::post('apidoc/save', 'LaravelApiDocController@save')->name('doc.apidoc.save');

});
```

* ## i18n
change `languages` value in the`config/laravel_doc.php`to set your own language，Provided by default is`Chinese`


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email foryoufeng@gmail.com instead of using the issue tracker.

## License

MIT. Please see the [license file](license.md) for more information.
