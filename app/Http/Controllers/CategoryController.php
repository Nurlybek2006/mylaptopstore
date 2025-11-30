<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->paginate(12);
        
        return view('categories.show', compact('category', 'products'));
    }

    // Админ функциялары
    public function create()
    {
        // Тек админдер үшін
        $this->authorize('admin');
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Тек админдер үшін
        $this->authorize('admin');

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория сәтті қосылды!');
    }

    public function edit($id)
    {
        // Тек админдер үшін
        $this->authorize('admin');
        
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Тек админдер үшін
        $this->authorize('admin');

        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500'
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория сәтті жаңартылды!');
    }

    public function destroy($id)
    {
        // Тек админдер үшін
        $this->authorize('admin');

        $category = Category::findOrFail($id);

        // Категорияда өнімдер бар ма тексеру
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Бұл категорияда өнімдер бар, сондықтан жойылмайды. Алдымен өнімдерді басқа категорияға көшіріңіз.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория сәтті өшірілді!');
    }

    // Админдер үшін категориялар тізімі
    public function adminIndex()
    {
        // Тек админдер үшін
        $this->authorize('admin');

        $categories = Category::withCount('products')->get();
        
        // Статистика
        $stats = [
            'total_categories' => $categories->count(),
            'categories_with_products' => $categories->where('products_count', '>', 0)->count(),
            'empty_categories' => $categories->where('products_count', 0)->count(),
            'total_products' => Product::count()
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    // Категорияға өнімдерді көшіру
    public function mergeCategories(Request $request)
    {
        // Тек админдер үшін
        $this->authorize('admin');

        $request->validate([
            'source_category_id' => 'required|exists:categories,id',
            'target_category_id' => 'required|exists:categories,id|different:source_category_id'
        ]);

        DB::transaction(function () use ($request) {
            // Өнімдерді көшіру
            Product::where('category_id', $request->source_category_id)
                  ->update(['category_id' => $request->target_category_id]);

            // Бос категорияны өшіру
            $sourceCategory = Category::find($request->source_category_id);
            $sourceCategory->delete();
        });

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категориялар сәтті біріктірілді!');
    }
}