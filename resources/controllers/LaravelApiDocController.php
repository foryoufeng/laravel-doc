<?php

namespace App\Http\Controllers\Docs;

use Illuminate\Http\Request;

class LaravelApiDocController extends BaseController
{
    private $host;

    public function __construct()
    {
        $this->mds_path = resource_path('mds/apidocs/');
        $this->host = trim(config('app.url'), '/').'/';
    }

    /**
     * 首页.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keywords = $request->get('keywords');
        $menus = $this->menus($keywords);

        return view('docs.api_doc.index', compact('keywords', 'menus'));
    }

    /**
     * 获取ajax数据.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function markdown(Request $request)
    {
        $url = $request->get('url');
        $response = json_decode($request->get('response'), true);
        $params = $request->get('params');
        $name = $request->get('name');

        return view('docs.api_doc.markdown', compact('url', 'response', 'params', 'name'));
    }

    /**
     * 生成文件.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $md = $request->get('md');
        $doc_link = $request->get('doc_link');
        $file = $this->mds_path.trim($doc_link, '/');
        if (file_put_contents($file, $md)) {
            return $this->success('success');
        }

        return $this->error('error');
    }

    /**
     * 所有的接口菜单.
     *
     * @return array
     */
    protected function getMenu()
    {
        return [
            [
                'name' => config('laravel_doc.languages.project_doc'),
                'spread' => true,
                'children' => $this->index_md(),
            ],
        ];
    }

    private function index_md()
    {
        return  [
            [
                'name' => 'apidoc_html',
                'doc_link' => 'apidoc_html.md',
                'url' => $this->host.'apidoc/html',
                'request_type' => 'get', //请求方式 get或者post
                'params' => [
                    'name' => 'apidoc_html.md',
                ],
            ],
        ];
    }
}
