<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Carbon\Carbon;

class CategoriesController extends Controller
{
    //
    public function index(Request $request)
    {
        if(Auth::check())
        {
            $data = Category::where('visible',1)->get();
            $data = $this->formatter($data);
            return response()->json(array('data' => $data, 'status' => true, 'messages' => 'Kategoriler Getirildi'), 200);

        }
        else{
            return response()->json(array('data' => null, 'status' => false, 'messages' => 'Oturum Gereklidir'), 401);

        }
    }
    private function formatter($data)
    {
        foreach ($data as $key => $value) {
             
            $value->eklenme = Carbon::parse($value->created_at)->format('d.m.Y H:i');
        }
        return $data;
    }
}
