<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Withdrawal;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        
    $user = Auth::user();

    // Pega a conta do usuário com os saques relacionados
    $account = Account::with('withdrawals')->where('user_id', $user->id)->first();
    $setting=Setting::first();

    // Alternativamente, pegar saques direto (útil se quiser mostrar em listas separadas)
    $withdrawals = $account ? $account->withdrawals : collect();

    

    return view('admin.pages.payment.index', compact('account', 'withdrawals','setting'));

    
    }

public function store(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'account_id' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:20'],
        'payment_method' => ['required', 'string', 'max:50'],
        'amount' => ['required', 'numeric', 'min:0.01'],
    ]);

    $amountRequested = $request->input('amount');

    $account = Account::firstOrCreate(
        ['user_id' => $user->id],
        ['balance' => 0, 'amount' => 0]
    );

    if ($amountRequested > $account->balance) {
        return back()->withErrors(['amount' => "Saldo insuficiente para este saque."])->withInput();
    }

    Withdrawal::create([
        'user_id' => $user->id,
        'account_id' => $request->input('account_id'),
        'phone_number' => $request->input('phone_number'),
        'payment_method' => $request->input('payment_method'),
        'amount' => $amountRequested,
        'status' => 'pending',
    ]);

    // Atualiza saldo descontando o valor do saque
    $account->balance -= $amountRequested;
    $account->save();

    return redirect()->back()->with('success', 'Saque solicitado com sucesso.');
}


}

