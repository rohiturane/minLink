<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Support\Str;

class BusinessService
{
    public function index()
    {
        $businesses = Business::get();

        return $businesses;
    }

    public function store($params)
    {
        $data = [
            'uuid' => Str::orderedUuid(),
            'user_id' => auth()->user()->id,
            'logo' => empty($params['logo']) ? NULL : $params['logo'],
            'name' => $params['name'],
            'address' => $params['address'],
            'email' => $params['email'],
            'mobile' => $params['mobile'],
            'note' => $params['note'],
            'status' => $params['status'],
            'default_invoice_id' => empty($params['default_invoice_id']) ? NULL : $params['default_invoice_id'],
        ];

        $business = Business::create($data);

        return $business;
    }

    public function get($uuid)
    {
        return Business::where('uuid', $uuid)->first();
    }

    public function update($uuid, $params)
    {
        $business = Business::where('uuid', $uuid)->first();

        $data = [
            'logo' => empty($params['logo']) ? $business->logo : $params['logo'],
            'name' => $params['name'],
            'address' => $params['address'],
            'email' => $params['email'],
            'mobile' => $params['mobile'],
            'note' => $params['note'],
            'status' => $params['status'],
            'default_invoice_id' => empty($params['default_invoice_id']) ? NULL : $params['default_invoice_id'],
        ];

        $business->update($data);

        return $business;
    }

    public function destory($uuid)
    {
        $business = Business::where('uuid', $uuid)->first();
        if(!$business)
        {
            return false;
        }
        $business->delete();

        return true;
    }

    public function getDropdownList()
    {
        return Business::where('status','1')->pluck('name','uuid');
    }
}