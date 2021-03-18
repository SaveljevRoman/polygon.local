<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * Если дата публикации не установлена и установлен - Опубликовано,
     * то устанавливаем дату публикации на текущую.
     *
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {
        if (empty($blogPost->published_at) && $blogPost->is_published) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Если поле слаг пустрое, то заполняем его конвертацией заголовка.
     *
     * @param BlogPost $blogPost
     */
    protected function setSlug(BlogPost $blogPost)
    {
        if (empty($blogPost->slug)) {
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }

    /**
     * Установка значения полю content_html относительно поля content_raw
     *
     * @param BlogPost $blogPost
     */
    protected function setHtml(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            // TODO: генерация markdown -> html
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    protected function setUser(BlogPost $blogPost)
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOW_USER;
    }

    /**
     * Отработает ПЕРЕД созданием записи
     *
     * @param BlogPost $blogPost
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);

        $this->setHtml($blogPost);

        $this->setUser($blogPost);
    }

    /**
     * Отработает ПЕРЕД обновлением записи
     *
     * @param BlogPost $blogPost
     */
    public function updating(BlogPost $blogPost)
    {
//        $test[] = $blogPost->isDirty();                           // изменялась ли модель
//        $test[] = $blogPost->isDirty('is_published');             // изменялось ли конкретное поле модели
//        $test[] = $blogPost->isDirty('user_id');                  // изменялось ли конкретное поле модели
//        $test[] = $blogPost->getAttribute('is_published');        // получить значение атрибута (текущего/измененного)
//        $test[] = $blogPost->is_published;                        // получить значение атрибута (текущего/измененного)
//        $test[] = $blogPost->getOriginal('is_published');         // получить значение атрибута (прошлое/до изменения)
//        dd($test);

        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);
    }

    public function deleting(BlogPost $blogPost)
    {
//        dd(__METHOD__, $blogPost);
//         return false;
    }


    /**
     * Handle the BlogPost "created" event.
     *
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "updated" event.
     *
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "deleted" event.
     *
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
//        dd(__METHOD__, $blogPost);
    }

    /**
     * Handle the BlogPost "restored" event.
     *
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "force deleted" event.
     *
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
