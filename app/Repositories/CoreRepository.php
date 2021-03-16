<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 *
 * @package App\Repositories
 *
 *
 *
 */
abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
//        $this->model = new $this->getModelClass();
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * Клонирование полученной модели, на случай обращения к модели другим классом
     *
     * @return \Illuminate\Contracts\Foundation\Application|Model|mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }


}
