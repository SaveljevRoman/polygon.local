<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{
    public function collections()
    {
        $result = [];

        $eloquentCollection = BlogPost::withTrashed()->get(); // получить все данные включая удаленные

//        dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());

        /*dd(
            get_class($eloquentCollection), //"Illuminate\Database\Eloquent\Collection"
            get_class($collection), //"Illuminate\Support\Collection"
            $collection
        );*/

        /*$result['first'] = $collection->first();  //первый элемент коллекции
        $result['last'] = $collection->last();      //последний элемент коллекции
        dd($result);*/

        /*$result['where']['data'] = $collection
            ->where('category_id', 10) //category_id = 10
            ->values() // обновит ключи (поставит по умолчанию 0, 1, ...)
            ->keyBy('id'); // сделает ключами значения из поля id

        $result['where']['count'] = $result['where']['data']->count();           //колличество
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();       //пустая выборка?
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty(); //не пустая выборка?

        $result['where_first'] = $collection
            ->firstWhere('created_at', '>', '2021-01-10 18:41:10'); //получить первый элемент по условию*/



        dd($result);
    }
}
