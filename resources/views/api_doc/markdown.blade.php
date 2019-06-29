# {{ $name }}
- {{ $url }}
- 版本 V1 +
- 接口人 {{ config('laravel_doc.author') }}

**参数说明**

|参数 |是否必须 |说明 |
| --------|--------|-------- |
@if ($params)
@foreach($params as $param)
|`{{ $param }}`|是| - |
@endforeach
@endif

**返回说明**

* 正常情况下，会返回下述JSON数据包给调用者：

```
@if ($response)
{

@foreach($response as $k=>$item)
 "{{ $k }}":"{!!   str_replace('```','',$item) !!}"
@endforeach
@endif

}
```

|参数 |说明 |
| --------|-------- |
|`errcode`|`0` 成功  `1`失败|
