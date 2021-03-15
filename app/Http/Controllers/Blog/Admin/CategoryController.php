<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index()
    {
        $paginator = BlogCategory::query()->paginate(15);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    public function create()
    {
        dd(__METHOD__);
    }

    public function store(Request $request)
    {
        dd(__METHOD__);
    }

    public function edit($id)
    {
        $item = BlogCategory::query()->findOrFail($id);
        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
/*        $rules = [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|min:3|max:500',
            'parent_id' => 'integer|required|exists:blog_categories,id',
        ];
        $validatedData = $this->validate($request, $rules);
        $validatedData = $request->validate($rules);
        $validatedData = \Validator::make($request->all(), $rules);*/

        $item = BlogCategory::query()->find($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput(); // при редиректе назад сохранит данные в поле
        }

        $data = $request->all();
        $result = $item
            ->fill($data)
            ->save();

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
}
