<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCatalogMainJob extends AbstractJob
{

    public function handle()
    {
        $this->debug('start');

        //Кэшируем продукты
        GenerateCatalogCacheJob::dispatchNow(); // выполнит мгновенно

        //Создаем цепочку заданий формирования файлов с ценами
        $chainPrices = $this->getChainPrices();

        //Основные задачи
        $chainMain = [
            new GenerateCategoriesJob(), // генерация категорий
            new GenerateDeliveriesJob(), // генерация споссобов доставки
            new GeneratePointsJob(), // генерация пунктов выдачи
        ];

        //Подзадачи (выполняются самыми последними)
        $chainLast = [
          //Архивирование файлов и перенос архива в публичную папку
            new ArchiveUploadsJob,
          //Отправка уведомления стороннему сервису о том то можно скачать новый файл каталога товаров
            new SendPriceRequestJob,
        ];

        $chain = array_merge($chainPrices, $chainMain, $chainLast);

        GenerateGoodsFileJob::withChain($chain)->dispatch();
//        GenerateGoodsFileJob::dispatch()->chain($chain);

        $this->debug('finish');
    }

    private function getChainPrices()
    {
        $result = [];
        $poducts = collect([1, 2, 3, 4, 5]); // иммитация запроса в бд
        $fileNum = 1;

        foreach ($poducts->chunk(1) as $chunk) {
            $result[] = new GeneratePricesFileChunkJob($chunk, $fileNum);
            $fileNum++;
        }

        return $result;
    }
}
