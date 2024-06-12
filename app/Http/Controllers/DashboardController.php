<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard.index',[
            'aktif' => User::all()->where('status','active')->count(),
            'nonaktif' => User::all()->where('status','inactive')->count(),
            'kategori' => Kategori::all()->count(),
            'total_buku' => Book::sum('stock'),
        ]);
    }
}
