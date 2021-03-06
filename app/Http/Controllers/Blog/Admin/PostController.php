<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

class PostController extends BaseController
{
    private $blogPostRepository;

    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('paginator'));
    }

    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit',
            compact('item', 'categoryList'));
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = BlogPost::create($data);
        if ($item) {

//            $job = new BlogPostAfterCreateJob($item);
//            $this->dispatch($job);

            BlogPostAfterCreateJob::dispatch($item);

            return redirect()->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранений'])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit',
            compact('item', 'categoryList'));
    }

    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return $a = redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        //Софт удаление, остается в БД
        $result = BlogPost::destroy($id);

        //Полное удаление из БД
//        $result = BlogPost::find($id)->forceDelete();

        if ($result) {
            //Варианты запуска
            BlogPostAfterDeleteJob::dispatch($id)->delay(20); // отправляет в очередь и заполнит поле delay 20 сек,
            // благодаря этому задание будет выполнятся с отсрочкой в 20 сек
//            BlogPostAfterDeleteJob::dispatchNow($id); // выполнится моментально

//            dispatch(new BlogPostAfterDeleteJob($id)); //хелпер
//            dispatch_now(new BlogPostAfterDeleteJob($id)); //хелпер

//            $this->dispatch(new BlogPostAfterDeleteJob($id));
//            $this->dispatchNow(new BlogPostAfterDeleteJob($id));


            return redirect()
                ->route('blog.admin.posts.index')
                ->with(['success' => "Запись id[$id] удалена"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
