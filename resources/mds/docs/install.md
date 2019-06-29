# 安装

``` bash
 composer require foryoufeng/laravel-doc
```

如果你是运行的Laravel 5.5以下的版本，需要在`config/app.php`的service provider中添加：
```

 Foryoufeng\Doc\DocServiceProvider::class


```

运行如下命令来发布资源文件
```

 php artisan vendor:publish --provider=Foryoufeng\Doc\DocServiceProvider::class

```

发布资源之后会多出很多文件
```

/public/vendor/laravel-doc  //样式文件

/resources/views/docs   //界面文件

/resources/mds/docs  //文档文件

/resources/mds/apidocs  //api文件

/app/Http/Controllers/Docs  //增加了控制器文件

config/laravel_doc.php  //文档配置文件

routes/web.php中增加了路由文件
```

# 访问`/doc`,即可看到本项目的说明文档

# 访问`/apidoc`,即可看到本项目的接口说明文档
