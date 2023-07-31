<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'title' => 'Página Inicial',
            'user' => Auth::user()
        ]);
    }
}
