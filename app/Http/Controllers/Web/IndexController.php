<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class IndexController
 */
class IndexController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('index.index');
    }
}
