<?php

namespace App\Http\Controllers\Docs;

use Illuminate\Http\Request;

class LaravelDocController extends BaseController
{
    public function __construct()
    {
        $this->mds_path = resource_path('mds/docs/');
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

        return view('docs.doc.index', compact('keywords', 'menus'));
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
                'name' => config('laravel_doc.languages.install'),
                'doc_link' => 'install.md',
            ],
            [
                'name' => config('laravel_doc.languages.how_use'),
                'doc_link' => 'how_use.md',
            ],
        ];
    }
}
