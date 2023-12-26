<?php

namespace App\Services;

use App\Models\BankInformation;
use App\Models\State;

class BankService
{
    public function bankInfo()
    {
        $banks = collect(BankInformation::get()->pluck('bank'))->unique();
        $branches = collect(BankInformation::get()->pluck('branch'))->unique();
        $districts = collect(BankInformation::get()->pluck('district'))->unique();
        $states = collect(BankInformation::get()->pluck('state'))->unique();
        // $addresses = BankInformation::groupBy('address')->pluck('address','address');

        $data = [
            'banks' => $banks,
            'branches' => $branches,
            'districts' => $districts,
            'states' => $states,
        ];

        return $data;
    }

    public function getBankInformation($data = [])
    {
        $bank_information = BankInformation::query();

        if(!empty($data['bank']))
        {
            $bank_information = $bank_information->where('bank', $data['bank']);
        }

        if(!empty($data['branch']))
        {
            $bank_information = $bank_information->where('branch', $data['branch']);
        }

        if(!empty($data['district']))
        {
            $bank_information = $bank_information->where('district', $data['district']);
        }

        if(!empty($data['state']))
        {
            $bank_information = $bank_information->where('state', $data['state']);
        }

        if(!empty($data['ifsc']))
        {
            $bank_information = $bank_information->where('ifsc', $data['ifsc']);
        }

        return $bank_information->first();
    }
}
