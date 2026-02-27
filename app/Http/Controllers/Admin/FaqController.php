<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqModel;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard()
    {
        $faq = FaqModel::latest()->get();
        return view('admin.dashboard', compact('faq'));
    }

    public function index()
    {
        $faq = FaqModel::latest()->paginate(5);
        return view('admin.faq.index', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq.create');
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
            'name.unique' => 'Bunday kategoriya allaqachon mavjud',
            'name.regex' => 'Faqat harflar yozilishi mumkin',
        ]);

        FaqModel::create([
            'name' => $request->name,
            'text' => $request->text,
            'link' => $request->link,
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', "FAQ Muvaffaqiyatli yaratildi");
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
        $faq = FaqModel::find($id);
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Modelni topish
        $faq = FaqModel::findOrFail($id);

        // 2. Validatsiya
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // O'zi turgan ID ni tekshiruvdan chetlatish (ignore)
                'unique:categories,name,' . $id,
                'regex:/^[\pL\s\-]+$/u', // defis qo'shildi, chunki nomlarda kerak bo'lishi mumkin
            ],
            'text' => 'required|string', // text va link ham validatsiya qilinishi kerak
            'link' => 'nullable|url',
        ], [
            'name.required' => 'Kategoriya nomi kiritilishi shart',
            'name.unique' => 'Bunday kategoriya allaqachon mavjud',
            'name.regex' => 'Faqat harflar yozilishi mumkin',
        ]);

        // 3. Ma'lumotni yangilash
        $faq->update([
            'name' => $request->name,
            'text' => $request->text,
            'link' => $request->link,
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', "FAQ muvaffaqiyatli yangilandi");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = FaqModel::findOrFail($id);
        $faq->delete();
        return redirect()->back()->with('success', 'FAQ Muvaffaqiyatli   O\'chirildi');
    }
}
