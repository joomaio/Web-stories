<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query("limit",10);
        $offset = ($request->query("page",1) - 1) * $limit;

        $from = $request->query("from") ? ' AND `orders`.created_time >="'.$request->query("from").' 00:00:00"':'';
        $to = $request->query("to") ? ' AND `orders`.created_time <="'.$request->query("to").' 23:59:59"':'';
        
        $orders = DB::select('SELECT * FROM `orders` WHERE 1=1 '.$from.$to.' ORDER BY orders.created_time DESC LIMIT '.$limit.' OFFSET '.$offset);

        // $categories = DB::table('orders')->selectRaw('*')->limit($limit)->offset($offset)->get();
        
        $paginate = DB::select('SELECT count(*) as pages FROM `orders` WHERE 1=1 '.$from.$to);
        $paginate = ceil($paginate[0]->pages/$request->query("limit",10));
      
        $data = new \stdClass();
        $data->pages = $paginate;
        $data->result = $orders;
        // var_dump($data);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $request->all();

        $order = [];
        $order['customer_name'] = $req['orderName'];
        $order['address'] = $req['orderAddress'];
        $order['phone'] = $req['orderPhone'];
        $order['email'] = $req['orderEmail'];
        $order['note'] = ($req['orderMessege'] != null) ? $req['orderMessege']:'';
        $order['created_time'] = date("Y-m-d H:i:s");
        $order['total'] = $req['orderTotal'];
        $order['status'] = $req['orderStatus'];


        $insertedOrderId = DB::table('orders')->insertGetId($order);
        if($insertedOrderId){
            $items = array_map(function($x) use ($insertedOrderId) {
                return array(
                    'id_book' => $x['id'],
                    'order_qty' => $x['qty'],
                    'id_order' => $insertedOrderId
                );
            }, $req['orderItems']);

            if(DB::table('book_in_order')->insert($items)){
                return response()->json("Order has been created",201);
            }
        }else{
            return response()->json("Can not create");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update($orderId, Request $request)
    {
        $req = $request->all();

        $order = [];
        $order['customer_name'] = $req['orderName'];
        $order['address'] = $req['orderAddress'];
        $order['phone'] = $req['orderPhone'];
        $order['email'] = $req['orderEmail'];
        $order['note'] = ($req['orderMessege'] != null) ? $req['orderMessege']:'';
        $order['created_time'] = date("Y-m-d H:i:s");
        $order['total'] = $req['orderTotal'];
        $order['status'] = $req['orderStatus'];
        
        if(DB::table('orders')->where('id',$orderId)->update($order)){
            $newItems = array_map(function($x) use ($orderId) {
                return array(
                    'id_book' => $x['id'],
                    'order_qty' => $x['qty'],
                    'id_order' => $orderId
                );
            }, $req['orderItems']);

            //cap nhat lai so luong item cu trong bang books
            $oldItems = DB::table('book_in_order')->select(DB::raw("*"))->where('id_order','=',$orderId)->get();
            foreach($oldItems as $oldItem){
                DB::select('UPDATE `books` SET `books`.quantity = `books`.quantity + '.$oldItem->order_qty.' WHERE `books`.id = '.$oldItem->id_book);
            }
            //xoa item cu
            DB::table('book_in_order')->where('id_order', $orderId)->delete();
            //them item moi
            DB::table('book_in_order')->insert($newItems);
            //cap nhat so luong item trong bang books
            foreach($newItems as $newItem){
                DB::select('UPDATE `books` SET `books`.quantity = `books`.quantity + '.$newItem['order_qty'].' WHERE `books`.id = '.$newItem['id_book']);
            }
            return response()->json("Order has been updated",200);
        }else{
            return response()->json("Can not update");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($orderId)
    {
        if(DB::table('orders')->where('id', $orderId)->delete()){
            $items = DB::table('book_in_order')->select(DB::raw("*"))->where('id_order','=',$orderId)->get();
            foreach($items as $item){
                DB::select('UPDATE `books` SET `books`.quantity = `books`.quantity + '.$item->order_qty.' WHERE `books`.id = '.$item->id_book);
            }
            DB::table('book_in_order')->where('id_order', $orderId)->delete();
            return response()->json("Category has been deleted",200);
        }
        else{
            return response()->json("Can not delete");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrder($id)
    {
        $order = DB::table('orders')->selectRaw('*')->whereRaw('id = ?',[$id])->get();
        
        $order[0]->items = DB::table('book_in_order')->selectRaw('*')->whereRaw('id_order = ?',[$id])->get();
        
        return response()->json($order[0], 200);
    }
}
