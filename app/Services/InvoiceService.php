<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Str;

class InvoiceService
{
    public function index()
    {
        $invoices = Invoice::get();

        return $invoices;
    }

    public function save($params)
    {
        $data = [
            'uuid' => Str::orderedUuid(),
            'title' => $params['title'],
            'html_content' => $params['html_content'],
            'status' => $params['status'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];

        $invoice = Invoice::create($data);

        return $invoice;
    }

    public function get($uuid)
    {
        $invoice = Invoice::where('uuid', $uuid)->first();

        return $invoice;
    }

    public function update($uuid, $params)
    {
        $data = [
            'title' => $params['title'],
            'html_content' => $params['html_content'],
            'status' => $params['status'],
            'updated_by' => auth()->user()->id,
        ];

        $invoice = Invoice::where('uuid', $uuid)->update($data);

        return $invoice;
    }

    public function destory($uuid)
    {
        $invoice = Invoice::where('uuid', $uuid)->first();

        if(!$invoice)
        {
            return false;
        }

        $invoice->delete();

        return true;
    }

    public function getDropdownList()
    {
        return Invoice::where('status','1')->pluck('title','uuid');
    }
}