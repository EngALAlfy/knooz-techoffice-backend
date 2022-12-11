<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderDoneRequest;
use App\Http\Requests\UpdateOrderDXFRequest;
use App\Http\Requests\UpdateOrderNotesRequest;
use App\Http\Requests\UpdateOrderPDFRequest;
use App\Http\Requests\UpdateOrderProblemsRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateOrderShippedRequest;
use App\Http\Resources\SuccessResource;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function current()
    {
        $orders = Order::where('archived' , false)->where('status' , 'start')->get();
        return new SuccessResource($orders);
    }

    public function stopped()
    {
        $orders = Order::where('archived' , false)->where('status' , 'stop')->get();
        return new SuccessResource($orders);
    }

    public function finished()
    {
        $orders = Order::where('archived' , false)->where('status' , 'finish')->get();
        return new SuccessResource($orders);
    }

    public function archived()
    {
        $orders = Order::where('archived' , true)->get();
        return new SuccessResource($orders);
    }


    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        //$request->file('pdf_file')->storePubliclyAs('dxf', $request->file('pdf_file')->getClientOriginalName() , 'uploads');

        if(isset($data['pdf_file'])){
            $pdf_name = $data['pdf_file']->getClientOriginalName();
            $data['pdf_file']->storePubliclyAs('pdf', $pdf_name , 'uploads');
            $data['pdf_file'] = $pdf_name;
        }

        if(isset($data['dxf_file'])){
            $dxf_name = $data['dxf_file']->getClientOriginalName();
            $data['dxf_file']->storePubliclyAs('dxf', $dxf_name , 'uploads');
            $data['dxf_file'] = $dxf_name;        }

        $order = Order::create($data);

        $this->notify("تم اضافة اوردر جديد" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }


    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
        $data = $request->validated();

        $order->update($data);
        $this->notify("تم تحديث اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        $this->notify("تم حذف اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    ###---------
    public function updateDone(Order $order , UpdateOrderDoneRequest $request)
    {$data = $request->validated();
        $old =  $order->done_count;
        $new = $data['done_count'];
        if($old == $new){
            return new SuccessResource([]);
        }
        $order->done_count = $data['done_count'];
        $order->save();
        $this->notify("تم تحديث انتاج اوردر" , "من : " .$old . " الي : " . $new ."\n" . "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function updatePdf(Order $order , UpdateOrderPDFRequest $request)
    {
        $data = $request->validated();

            $pdf_name = $data['pdf_file']->getClientOriginalName();
            $data['pdf_file']->storePubliclyAs('pdf', $pdf_name , 'uploads');
            //$data['pdf_file'] = $pdf_name;

        $order->pdf_file = $pdf_name;
        $order->save();
        $this->notify("تم تحديث ملف اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function updateDxf(Order $order , UpdateOrderDXFRequest $request)
    {
        $data = $request->validated();
        $dxf_name = $data['dxf_file']->getClientOriginalName();
        $data['dxf_file']->storePubliclyAs('dxf', $dxf_name , 'uploads');
        //$data['pdf_file'] = $pdf_name;

        $order->dxf_file = $dxf_name;

        $order->save();
        $this->notify("تم تحديث ملف اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function updateShipped(Order $order , UpdateOrderShippedRequest $request)
    {$data = $request->validated();
        $old =  $order->shipped_count;
        $new = $data['shipped_count'];
        if($old == $new){
            return new SuccessResource([]);
        }
        $order->shipped_count = $data['shipped_count'];
        $order->save();
        $this->notify("تم تحديث صادر اوردر" , "من : " .$old . " الي : " . $new ."\n" .  "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function updateNotes(Order $order , UpdateOrderNotesRequest $request)
    {
        $data = $request->validated();
        $order->notes = $data['notes'];
        $order->save();
        $this->notify("تم تحديث ملاحظات اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function updateProblems(Order $order , UpdateOrderProblemsRequest $request)
    {
        $data = $request->validated();
        $order->problems = $data['problems'];
        $order->save();
        $this->notify("تم تحديث مشاكل اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function start(Order $order)
    {
        $order->status = "start";$order->save();
        $this->notify("تم بدء اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function stop(Order $order)
    {
        $order->status = "stop";$order->save();
        $this->notify("تم ايقاف اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function finish(Order $order)
    {
        $order->status = "finish";$order->save();
        $this->notify("تم انتاء اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function archive(Order $order)
    {
        $order->archived = true;
        $order->save();
        $this->notify("تم ارشفة اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }

    public function unarchive(Order $order)
    {
        $order->archived = false;
        $order->save();
        $this->notify("تم الغاء ارشفة اوردر" , "اوردر رقم " . $order->number . " ( " . $order->project . " ) ");
        return new SuccessResource([]);
    }


    private function notify($title , $desc){
        $serverToken = "";
        $body = mb_convert_encoding( $desc , 'UTF-8', 'UTF-8');

        $data = [
            'notification'=> [
                'body'=> $body,
                'title'=> $title,
                //'image'=> 'https://plus18.xyz/uploads/photos/'.$item->photo,
            ],
            'priority'=> 'high',
            //'data' => [
            //    'id'=> $item->id,
            //],
            'to' => '/topics/all',
        ];

        $headers = [
            'Content-Type'=> 'application/json',
            'Authorization'=> 'key=' . $serverToken,
        ];

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';


        $response = Http::withHeaders($headers)->post($fcmUrl, $data);

        return $response;
    }

}
