<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06/01/2019
 * Time: 01:28
 */

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $images = auth()->user()->images;

        return view('main', compact('images'));
    }
}