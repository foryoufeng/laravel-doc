<?php

namespace App\Http\Controllers\Docs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BaseController.
 */
abstract class BaseController extends Controller
{
    /**
     * 保存文档的地址
     *
     * @var string
     */
    protected $mds_path;

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function html(Request $request)
    {
        $name = $request->get('name');
        $file = $this->mds_path.$name;
        $content = '';
        if (file_exists($file)) {
            $content = file_get_contents($file);
        }

        return $this->success($content);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data)
    {
        return response()->json(['message' => 'success', 'errcode' => 0, 'data' => $data]);
    }

    /**
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message)
    {
        return response()->json(['message' => $message, 'errcode' => 0, 'data' => '']);
    }

    /**
     * 获取菜单.
     *
     * @param $keywords
     *
     * @return string
     */
    protected function menus($keywords)
    {
        $menus = $this->getMenu();
        if ($keywords) {
            $res = [
                [
                    'name' => config('laravel_doc.languages.search_result'),
                    'spread' => true,
                    'children' => [],
                ],
            ];
            foreach ($menus as $menu) {
                foreach ($menu['children'] as $k => $v) {
                    if (strstr($v['name'], $keywords)) {
                        $res[0]['children'][] = $v;
                    }
                }
            }
        } else {
            $res = $menus;
        }

        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取菜单的数据.
     *
     * @return mixed
     */
    abstract protected function getMenu();
}
