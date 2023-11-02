<?php

namespace App\Services;

use App\Models\Country;
use App\Models\State;

class CountryService
{
    public function countryList($data = [])
    {
        $countries = Country::query();
        
        if(!empty($data['region_id']))
        {
            $countries = $countries->where('region_id', $data['region_id']);
        }

        if(!empty($data['subregion_id']))
        {
            $countries = $countries->where('subregion_id', $data['subregion_id']);
        }
        

        return  $countries->get();
    }

    public function stateList($data = [])
    {
        $states = State::query();

        if(!empty($data['country_id']))
        {
            $states = $states->where('country_id', $data['country_id']);
        }

        return $states->get();
    }
}