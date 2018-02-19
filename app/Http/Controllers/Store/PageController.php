<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Public home page
     * 
     * @param null
     * @return view
     */
    
    public function index()
    {
        return view('store.index');
    }

    public function page($page)
    {
        if($page == 'next-steps')
        {
            \Auth::logout();
            \Session::flush();;
        }
        
        return view('store.'.$page);
    }
}
