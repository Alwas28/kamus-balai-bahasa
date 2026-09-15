<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Models\Word;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalCategories' => Category::count(),
            'totalWords' => Word::count(),
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
            'latestWords' => Word::with('category')->latest()->take(5)->get(),
            'latestUsers' => User::with('role')->latest()->take(5)->get(),
        ]);
    }
}
