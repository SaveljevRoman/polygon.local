<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository
 *
 * @package App\Repositories
 */
class BlogCategoryRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get model for admin edited
     *
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Get categories list for output in drop-down list
     *
     * @return Collection
     */
    public function getForComboBox()
    {
//        return $this->startConditions()->all();
/*        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);*/
/*        $result[] = $this->startConditions()->all();
        $result[] = $this
            ->startConditions()
            ->select('blog_categories.*',
                \DB::raw('CONCAT (id, ". ", title) AS id_title'))
            ->toBase()
            ->get();*/
        $result = $this->
        startConditions()
            ->selectRaw('id, CONCAT (id, ". ", title) AS id_title')
            ->toBase()
            ->get();

        return $result;
    }

    /**
     * Get categories for pagination output
     *
     * @param int\null $perPage
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->with([
                'parentCategory:id,title'
            ])
            ->paginate($perPage);

        return $result;
    }
}
