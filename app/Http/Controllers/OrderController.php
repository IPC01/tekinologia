<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Mostrar lista de pedidos
 public function index()
{
 $user = auth()->user();

 
if ($user->role && $user->role->name === 'admin') {
    // Admin vê todas as orders
    $orders = Order::with('product')->paginate(30);
} elseif ($user->role && $user->role->name === 'seller') {
    // Seller vê apenas orders dos seus produtos
    $orders = Order::whereHas('product', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with('product')->paginate(30);
} else {
    // Outros usuários não devem ver nada ou podem ser redirecionados
    abort(403, 'Acesso não autorizado.');
}


    return view('admin.pages.orders.index', compact('orders'));
}
 public function myorders()
{
    $user = auth()->user();

    $orders = Order::whereHas('product', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with('product')->paginate(30);

    return view('admin.pages.orders.index', compact('orders'));
}



    // Form para criar um pedido
    public function create()
    {
        return view('orders.create');
    }

    // Salvar novo pedido
    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'product_id'      => 'required|exists:products,id',
            'order_number'    => 'required|unique:orders,order_number',
            'price'           => 'required|numeric',
            'discount'        => 'nullable|numeric',
            'status'          => 'in:pending,processing,completed,failed',
            'payment_method'  => 'in:paypal,stripe,mpesa,emola',
            'phone'           => 'nullable|string|max:20',
            'paid_at'         => 'nullable|date',
            'currency'        => 'string|max:10',
            'notes'           => 'nullable|string',
            'platform_fee'           => 'required|string',
            'payout_amount'           => 'required|string',
        ]);

        //pagamento api
        // dd($request->all());
        Order::create($request->all());
            // Obtem o produto e seu autor
    $product = Product::findOrFail($request->product_id);
    $userId = $product->user_id; 
      // Cria ou atualiza a conta do autor do produto
    $account = Account::firstOrCreate(
        ['user_id' => $userId],
        ['balance' => 0, 'amount' => 0]
    );

    $account->balance += $request->payout_amount;
    $account->amount += $request->payout_amount;
    $account->save();

        return redirect()->back()->with('success', 'Order created successfully.');
    }

    // Mostrar detalhes do pedido
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    // Form para editar pedido
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    // Atualizar pedido
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id'         => 'sometimes|exists:users,id',
            'product_id'      => 'sometimes|exists:products,id',
            'order_number'    => 'sometimes|unique:orders,order_number,' . $order->id,
            'price'           => 'sometimes|numeric',
            'discount'        => 'nullable|numeric',
            'status'          => 'in:pending,processing,completed,failed',
            'payment_method'  => 'in:paypal,stripe,mpesa,emola',
            'phone'           => 'nullable|string|max:20',
            'paid_at'         => 'nullable|date',
            'currency'        => 'string|max:10',
            'notes'           => 'nullable|string',
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')
                         ->with('success', 'Order updated successfully.');
    }

    // Deletar pedido
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
                         ->with('success', 'Order deleted successfully.');
    }
}
