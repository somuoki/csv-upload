<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrdersImport implements ToModel,WithBatchInserts, WithChunkReading, WithStartRow, ShouldQueue
{
    use Importable;


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Order([
            'InvoiceNo' => $row[0],
            'StockCode' => $row[1],
            'Description' => $row[2],
            'Quantity' => $row[3],
            'InvoiceDate'=> date('Y-m-d H:i:s', strtotime($row[4])),
            'UnitPrice' => $row[5],
            'Customer' => $row[6],
            'Country' => $row[7]
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100000;
    }

    public function startRow(): int
    {
        return 2;
    }

}
