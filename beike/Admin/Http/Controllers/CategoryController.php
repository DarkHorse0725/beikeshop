<?php

namespace Beike\Admin\Http\Controllers;

use Beike\Admin\Http\Requests\CategoryRequest;
use Beike\Admin\Http\Resources\CategoryResource;
use Beike\Admin\Services\CategoryService;
use Beike\Models\Category;
use Beike\Repositories\CategoryRepo;
use Beike\Repositories\LanguageRepo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected string $defaultRoute = 'categories.index';

    public function index()
    {
        $categories = CategoryRepo::getAdminList();
        $data       = [
            'categories' => CategoryResource::collection($categories),
        ];
        $data = hook_filter('admin.category.index.data', $data);

        return view('admin::pages.categories.index', $data);
    }

    public function create(Request $request)
    {
        return $this->form($request);
    }

    public function store(CategoryRequest $request)
    {
        return $this->save($request);
    }

    public function edit(Request $request, Category $category)
    {
        return $this->form($request, $category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        return $this->save($request, $category);
    }

    /**
     * 删除分类
     * @param Request  $request
     * @param Category $category
     * @return array
     * @throws \Exception
     */
    public function destroy(Request $request, Category $category): array
    {
        CategoryRepo::delete($category);
        hook_action('admin.category.destroy.after', $category);

        return json_success(trans('common.deleted_success'));
    }

    public function name(int $id)
    {
        $name = CategoryRepo::getName($id);

        return json_success(trans('common.get_success'), $name);
    }

    protected function form(Request $request, Category $category = null)
    {
        if ($category) {
            $descriptions = $category->descriptions->keyBy('locale');
        }

        $data = [
            'category'     => $category ?? new Category(),
            'languages'    => LanguageRepo::all(),
            'descriptions' => $descriptions ?? null,
            'categories'   => CategoryRepo::flatten(locale()),
            '_redirect'    => $this->getRedirect(),
        ];
        $data = hook_filter('admin.category.form.data', $data);

        return view('admin::pages.categories.form', $data);
    }

    protected function save(Request $request, ?Category $category = null)
    {
        $requestData = $request->all();
        $category    = (new CategoryService())->createOrUpdate($requestData, $category);
        $data        = [
            'category'     => $category,
            'request_data' => $requestData,
        ];

        hook_action('admin.category.save.after', $data);

        return redirect($this->getRedirect())->with('success', 'Category created successfully');
    }

    public function autocomplete(Request $request)
    {
        $categories = CategoryRepo::autocomplete($request->get('name') ?? '');

        return json_success(trans('common.get_success'), $categories);
    }
}
