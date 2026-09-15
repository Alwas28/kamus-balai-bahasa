<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('order')->pluck('name', 'id');

        $words = Category::with('words')
            ->orderBy('order')
            ->get()
            ->flatMap(fn (Category $category) => $category->words->map(fn ($word) => [
                'id' => $word->word_id,
                'konawe' => $word->word_konawe,
                'mekongga' => $word->word_mekongga,
                'category' => $category->name,
                'image' => $word->imageUrl(),
                'audio' => $word->audioUrl(),
                'voice' => $word->audio_voice,
            ]))
            ->values();

        return view('welcome', [
            'categories' => $categories,
            'words' => $words,
            'totalWords' => $words->count(),
            'totalCategories' => $categories->count(),
            'totalUsers' => User::count(),
        ]);
    }
}
