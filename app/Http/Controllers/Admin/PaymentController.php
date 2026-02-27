<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\BalanceTopUpNotification;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.paynet.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);

        // 1. Balansni oshirish
        $user->increment('balance', $request->amount);

        // 2. Foydalanuvchiga bildirishnoma yuborish
        $user->notify(new BalanceTopUpNotification($request->amount));

        return back()->with('success', 'Pul o\'tkazildi va foydalanuvchiga xabar yuborildi!');
    }

    public function findUser(Request $request)
    {
        // ID bo'yicha foydalanuvchini qidiramiz
        $user = \App\Models\User::find($request->user_id);

        if ($user) {
            return response()->json([
                'success' => true,
                'name' => $user->name
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Foydalanuvchi topilmadi'
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
