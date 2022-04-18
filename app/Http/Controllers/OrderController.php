<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\UploadService;
use Illuminate\Http\Request;

class OrderController extends Controller {
    /**
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException
     */
    public function store(Request $request) {
        return (new UploadService)->upload($request);
    }

    public function index(Request $request){
        $orders = Order::simplePaginate(30);
        if($request->ajax())
        {
            return view('orders', compact('orders'));
        }
        return view('upload',compact('orders'));
    }
}
