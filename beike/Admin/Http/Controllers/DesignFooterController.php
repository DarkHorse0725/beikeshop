<?php

namespace Beike\Admin\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Beike\Services\DesignService;
use Beike\Repositories\SettingRepo;

class DesignFooterController extends Controller
{
    /**
     * 展示所有模块编辑器
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $data = [
            'design_settings' => system_setting('base.footer_setting'),
        ];
        return view('admin::pages.design.builder.footer', $data);
    }

    /**
     * 预览模块显示结果
     *
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function preview(Request $request): View
    {
        $module = json_decode($request->getContent(), true);

        // $viewData = [
        //     'content' => DesignService::handleModuleContent($moduleCode, $content),
        //     'design' => (bool)$request->get('design')
        // ];

        // return view($viewPath, $viewData);
    }


    /**
     * 更新所有数据
     *
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function update(Request $request): array
    {
        $content = json_decode($request->getContent(), true);

        $data = [
            'type' => 'system',
            'space' => 'base',
            'name' => 'footer_setting',
            'value' => json_encode($content),
            'json' => 1
        ];
        SettingRepo::createOrUpdate($data);
        return json_success("保存成功");
    }
}
