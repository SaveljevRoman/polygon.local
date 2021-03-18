<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        /*$result['map']['all'] = $collection->map(function (array $item) { // обработчик пройдет по всем элементам коллекции
            // мутация базовой коллекции в другой формат, вернет мутированную копию коллекции
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            return $newItem;
        });
        // массив из удаленных элементов с переписанными индексами
        $result['map']['not_exists'] = $result['map']['all']->where('exists', '=', false)->values();
            dd($result);*/

/*        $collection->transform(function (array $item) { // мутирует текущую коллекцию и вернет ее
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });
//        dd($collection);

        $newItem = new \stdClass();
        $newItem->id = 9999;

        $newItem2 = new \stdClass();
        $newItem2->id = 8888;
//        dd($newItem, $newItem2);

//        $newItemFirst = $collection->prepend($newItem);    //Добавить элемент в начало коллекции
//        $newItemLast = $collection->push($newItem2);       //Добавитть элемент в конец коллекции

        $newItemFirst = $collection->prepend($newItem)->first();    //Добавить элемент в начало коллекции и забрать его
        $newItemLast = $collection->push($newItem2)->last();        //Добавитть элемент в конец коллекции и забрать его
        $pulledItem = $collection->pull(1);                     //забрать первый элемент (колличество элементов уменьшиться)
        dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));*/

    }
}
