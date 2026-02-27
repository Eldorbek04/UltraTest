<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::latest()->paginate(5);
        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
                'regex:/^[\pL\s]+$/u', // faqat harflar va bo‘shliq
            ],
        ], [
            'name.required' => 'Kategoriya nomi kiritilishi shart',
            'name.unique'   => 'Bunday kategoriya allaqachon mavjud',
            'name.regex'    => 'Faqat harflar yozilishi mumkin',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    
        return redirect()
            ->route('admin.category.index')
            ->with('success', "Muvaffaqiyatli qo‘shildi");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
                'regex:/^[\pL\s]+$/u', // faqat harflar va bo‘shliq
            ],
        ], [
            'name.required' => 'Kategoriya nomi kiritilishi shart',
            'name.unique'   => 'Bunday kategoriya allaqachon mavjud',
            'name.regex'    => 'Faqat harflar yozilishi mumkin',
        ]);
    
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    
        return redirect()
            ->route('admin.category.index')
            ->with('success', "Kategoriya muvaffaqiyatli yangilandi");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Bitta Kategorya
          O\'chirildi');
    }
}
