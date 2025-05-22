<?php

namespace App\Http\Controllers;

use App\Models\PaypalTransaction;
use Illuminate\Http\Request;

class PaypalTransactionController extends Controller
{
    public function index()
{
    // Remove the where clause to see all transactions
    $transactions = PaypalTransaction::with('user') // Add eager loading of user relationship
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('SupperAdmin_dashboard.Sales.payment', compact('transactions'));
}
}
