<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
//        $paginator = BlogCategory::paginate(15);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    public function create()
    {
        $item = new BlogCategory();
//        $categoryList = BlogCategory::all();
        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input(); //результат как all
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
//      Создаст объект не добавляя в бд
        /*        $item = new BlogCategory($data);
                $item->save();*/

//        Создаст объект и добавит в БД
        $item = (new BlogCategory())->create($data);

        if ($item instanceof BlogCategory) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    public function edit($id)
    {
//        $item = BlogCategory::findOrFail($id);
//        $categoryList = BlogCategory::all();

//        $item = $categoryRepository->getEdit($id);
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

//        $categoryList = $categoryRepository->getForComboBox();
        $categoryList = $this->blogCategoryRepository->getForComboBox();
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

//        $item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput(); // при редиректе назад сохранит данные в поле
        }

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $result = $item->update($data);
//            ->fill($data)->save(); // выполнятся в update()

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
