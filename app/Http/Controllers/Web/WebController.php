<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebController extends Controller
{
    private function fetchData () 
    {
        $banners = Banners::with('banner_image')->get()->toArray();

        return [
            'banners' => $banners,
        ];
    }

    public function index(Request $request)
    {
        return Cache::remember('homePage', 0, function () {
            $data = $this->fetchData();
            return view('web.home_page.home', $data)->render();
        });
    }
}
