<?php
namespace App\Services;

use App\Models\License;
use Illuminate\Support\Str;

class LicenseService
{
    public function index()
    {
        $licenses = License::get();

        return $licenses;
    }

    public function store($params)
    {
        $data = [
            'uuid' => Str::orderedUuid(), 
            'project_id' => $params['project_id'],
            'user_id' => auth()->user()->id,
            'access_code' => randomString(10),
            'host' => $params['host'],
            'is_used' => 0,
        ];

        $license = License::create($data);

        return $license;
    }

    public function get($uuid)
    {
        $license = License::where('uuid', $uuid)->first();

        return $license;
    }

    public function update($uuid, $params)
    {
        $license = License::where('uuid', $uuid)->first();

        $data = [
            'project_id' => $params['project_id'],
            'host' => $params['host'],
        ];

        $license->update($data);

        return $license;
    }

    public function destory($uuid)
    {
        $license = License::where('uuid', $uuid)->first();

        if(!$license)
        {
            return false;
        }
        $license->delete();

        return true;
    }
}