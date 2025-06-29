<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// php artisan make:controller Admin\OptionController
class OptionController extends Controller
{
    public function index()
    {
        return view('admin.options.index');
    }
}
