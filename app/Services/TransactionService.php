<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\UserInvoice;
use Illuminate\Support\Str;


class TransactionService
{
    public function store($params)
    {

        $data = [
            'uuid' => Str::orderedUuid(),
            'transaction_no' => Str::random(10)
        ];
        $data = array_merge($params, $data);
        
        $transaction = Transaction::create($data);

        return $transaction;
    }

    public function index()
    {
        if(auth()->user()->role == 'user')
        {
            $transactions = Transaction::where('user_id', auth()->user()->id)->get();
        } else {
            $transactions = Transaction::get();
        }
        return $transactions;
    }

    public function get($uuid)
    {
        $transaction = Transaction::with('user')->where('uuid', $uuid)->first();
        return $transaction;
    }
}