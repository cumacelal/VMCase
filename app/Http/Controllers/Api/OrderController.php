<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        if(Auth::check())
        {
            $data = Order::where('visible',1)->where('customer_id',Auth::id())->get();
            $data = $this->formatter($data);
            return response()->json(array('data' => $data, 'status' => true, 'messages' => 'Siparişler Getirildi'), 200);        }
        else{
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Oturum Gereklidir'), 401);
        }
    }

    public function newOrders(Request $request)
    {
        if(Auth::check())
        {
            $products = json_decode($request->product_id);
            $quantitiy = json_decode($request->quantitiy);
            $prices = [];
            $total = 0.0 ;
            $discount = 0 ;
            $minPrice = 0;
            $text = "";

            //Tüm Sip. için Stok Kontrolü
            //
            foreach ($products as $key => $value)
                if( Product::getStock($value,$quantitiy[$key]) == false)
                {
                    return response()->json(array('data' => null, 'status' => false, 'messages' => 'Yetersiz Stok [pid :' . $value .']'), 400);
                    die();
                }
            
            //Stok Kontrol Sonrası Güncel Akış
            foreach ($products as $key => $value) {
                //echo $quantitiy[$key]; 
                Product::setStock($value,(int)$quantitiy[$key]);
                    //Rules 
                    /*
                    Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.
2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.
1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.
                    */
                    $control = Product::find($value);
                    $text  .= $control->name . " : " 
                    .$quantitiy[$key] ." x ". $control->price." "." = " . ($quantitiy[$key]*$control->price) ;
                    $text .= "  ///  ";
                    $total += $control->price;
                    if( $control->category_id == 2 )
                    {   
                        if( $quantitiy[$key] >= 6 )
                        {
                            $kackez =  $quantitiy[$key] / 6 ;
                            $discount += $control->price * $kackez;
                            $ucretsiz = $control->price * $kackez;
                        }
                        else
                         $ucretsiz = 0 ;

                        
                          
                    }
                    if( $control->category_id == 1 )
                    {
                        if( $quantitiy[$key] >= 2 )
                        {
                            $prices[] = $value->price;
                        }
                    }
                
            }
            if( count($prices) > 0 )
             $discount +=  min($prices)  * 0.2;
             
             $subtotal = $total;
             $total = $subtotal - $discount ;

             $data = [
                'text' => $text ,
                'total' => $total , 
                'subtotal' => $subtotal ,
                'discount' => $discount
            ];

            //Stok azaltma modelde.
            Order::insert([
                'customer_id' => Auth::id(),
                'ciid' => time(),
                'total' => $total,
                'subtotal' => $subtotal,
                'status' => 1,
                'discount' => $discount ,
                'text' => $text,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'visible' => 1
            ]);

            return response()->json(array('data' => $data, 'status' => true, 'messages' => 'Siparişler Oluşturuldu'), 200);        }
        else{
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Oturum Gereklidir'), 401);
        }
    }

    private function formatter($data)
    {   
        $arr = [ 1 => 'Yeni' , 2 => 'Red' , 3 => 'Başarısız'];
        foreach ($data as $key => $value) {
            $value->durum = $arr[$value->status] ?? 'tanımsız';
            $value->eklenme = Carbon::parse($value->created_at)->format('d.m.Y H:i');
        }
        return $data;
    }
    
    function delOrders(Request $request)
    {
        if(Auth::check())
        {
            if(!is_numeric($request->order_id))
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Geçersiz Sip No'), 400);
            
            $order = Order::find($request->order_id);
    
            if(!$order)
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Bu Sip Bulunamadı'), 400);
            
            elseif( $order->customer_id != Auth::id())
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Bu Sip için işlem yapamazsınız'), 400);
            else
            {
                $order->delete();
            return response()->json(array('data' => null, 'status' => true, 'messages' => 'Sipariş Silindi'), 200);

            }
             
        }
        else{
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Oturum kapalıdır'), 401);

        }

         
    }
}
