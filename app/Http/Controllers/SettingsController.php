<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }
}

class FaqController extends Controller
{
    public function index()
    {
        return view('faq');
    }
}
