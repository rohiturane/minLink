<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Link;
use App\Support\Analytics;
use App\Support\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use App\Models\LinkVisit;
use App\Models\Tag;
use Carbon\CarbonPeriod;
use GuzzleHttp\Client;
use Illuminate\Http\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::with('user','link_visits')->get();

        return view('admin.links.index', compact('links'));
    }

    public function create()
    {
        $domains = Domain::where('status', 1)->get();
        $tags = Tag::pluck('name');
        return view('admin.links.create', compact('domains','tags'));
    }

    public function store(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'url' => 'required',
            // 'title' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput(); 
        }

        $link = new Link();
        $link->uuid = Str::orderedUuid();
        $link->code = !empty($request->get('code')) ? $request->get('code') : Str::random(5);
        $link->url = $request->get('url');
        $link->type = $request->has('type') ? $request->get('type') : 1;
        $link->title = $request->has('title') ? $request->get('title') : page_title($request->get('url'));
        $link->tags = json_encode($request->get('tags'));
        $link->description = $request->get('description');
        $link->password = $request->get('password');
        $link->archived = $request->has('archived') ? $request->get('archived') : false;
        $link->disabled = $request->has('disabled') ? $request->get('disabled') : false;
        $link->domain_id = $request->get('domain_id');
        $link->expires_at = !empty($request->get('expires_at')) ? Carbon::create($request->get('expires_at')) : null;
        if(auth()->check())
        {
            $link->user_id = auth()->user()->id;
        }
        $link->save();

        session()->flash('status','success');
        session()->flash('message', 'Links Saved Successfully');

        return redirect('/admin/links');
    }

    public function edit($uuid)
    {
        $link = Link::where('uuid', $uuid)->first();
        $tags = Tag::pluck('name');
        $domains = Domain::where('status', 1)->get();

        return view('admin.links.create', compact('domains', 'link','tags'));
    }

    public function update($uuid, Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'url' => 'required',
            // 'title' => 'required'
        ]);

        if($validate->fails())
        {
            return back()->withErrors($validate)->withInput(); 
        }

        $link = Link::where('uuid', $uuid)->first();

        $link->type = $request->has('type') ? $request->get('type') : 1;
        $link->title = $request->get('title');
        $link->tags = json_encode($request->get('tags'));
        $link->description = $request->get('description');
        $link->password = $request->get('password');
        $link->archived = $request->has('archived') ? $request->get('archived') : false;
        $link->disabled = $request->has('disabled') ? $request->get('disabled') : false;
        $link->domain_id = $request->get('domain_id');
        $link->expires_at = !empty($request->get('expires_at')) ? Carbon::create($request->get('expires_at')) : null;
        if(auth()->check())
        {
            $link->user_id = auth()->user()->id;
        }
        $link->save();

        session()->flash('status','success');
        session()->flash('message', 'Links Updated Successfully');

        return redirect('/admin/links');
    }

    public function delete($uuid)
    {
        $link = Link::where('uuid', $uuid)->first();

        if(!$link)
        {
            session()->flash('status','success');
            session()->flash('message', 'Something went Wrong!! try again');

            return redirect('/admin/links');
        }

        // LinkVisit::where('link_id', $link->id)->delete();
        $link->delete();

        session()->flash('status','success');
        session()->flash('message', 'Link Deleted Successfully');

        return redirect('/admin/links');
    }

    /**
     * Save the visit and redirect to the destination
     *
     * @param  Request  $request
     * @param $code
     * @return Application|RedirectResponse|Redirector|void
     * @throws Exception
     */
    public function visit(Request $request, $code)
    {
        /** @var Link $link */
        $link = Link::where('code', $code)->first();
        if($link) {
            // Verify domain
            if ($domain = Domain::find(setting('app_domain'))) {
                if ($link->domain_id) {
                    if (
                        (parse_url($link->domain->domain)['host'] != parse_url(url('/'))['host']) &&
                        (parse_url($link->domain->domain)['host'] != parse_url($domain->domain)['host'])
                    ) {
                        return abort(404);
                    }
                } else {
                    if (parse_url(url('/'))['host'] != parse_url($domain->domain)['host']) {
                        return abort(404);
                    }
                }
            }
            if ($link->domain_id) {
                if (parse_url($link->domain->domain)['host'] != parse_url(url('/'))['host']) {
                    return abort(404);
                }
            }
            // Verify disabled
            if ($link->disabled) {
                return abort(404);
            }
            // Verify expiration date
            if ($link->expires_at && (Carbon::now()->greaterThanOrEqualTo($link->expires_at))) {
                return abort(404);
            }
            // Verify password
            if (!empty($link->password) && ($request->post('password') != $link->password)) {
                $error = null;
                if ($request->has('password')) {
                    $error = __('Password does not match');
                }
                return view('frontend.short.password', ['link' => $link, 'error' => $error]);
            }
            //dd($request->ip());
            $agent = new Agent();
            $linkVisit = new LinkVisit();
            $linkVisit->link_id = $link->id;
            $linkVisit->platform = Str::slug(strtolower($agent->platform()), '-');
            $linkVisit->device = $this->getDevice($agent);
            $linkVisit->browser = strtolower($agent->browser());
            $linkVisit->location = ($request->ip() == "127.0.0.1" ? '-': strtolower(geoip($request->ip())['iso_code']));
            $linkVisit->crawler = $agent->isRobot();
            $linkVisit->referrer = Str::contains($request->server('HTTP_REFERER'), url('/')) ? null : $request->server('HTTP_REFERER');
            $linkVisit->ip = $request->ip();
            if ($linkVisit->save()) {
                return redirect($link->url);
            } else {
                throw new Exception('Unable to save visit log');
            }
        } else {
            return redirect('/admin/dashboard');
        }
    }

    /**
     * Return qr code of link
     *
     * @param  Request  $request
     * @param $code
     * @return Application|ResponseFactory|Response|void
     */
    public function qr(Request $request, $code)
    {
        $link = Link::where('code', $code)->get();
        if ($link->count() != 0) {
            /** @var Link $link */
            $link = $link[0];
            // Verify domain
            if ($link->domain_id && (parse_url($link->domain->domain)['host'] != parse_url(url('/'))['host'])) {
                return abort(404);
            } else {
                if (!$link->domain_id && $domain = Domain::find(setting('app_domain'))) {
                    if ((parse_url($domain->domain)['host'] != parse_url(url('/'))['host'])) {
                        return abort(404);
                    }
                }
            }
            // Verify disabled
            if ($link->disabled) {
                return abort(404);
            }
            // Verify expiration date
            if ($link->expires_at && (Carbon::now()->greaterThanOrEqualTo($link->expires_at))) {
                return abort(404);
            }
            // Return QR
            return response(QrCode::format('png')->size((int) $request->has('s') ? $request->get('s') : '150')->generate($link->getLink()))->header('Content-Type', 'image/png');
        }
        return abort(404);
    }

    public function getDevice($agent)
    {
        if ($agent->isMobile()) {
            return 'mobile';
        } else {
            if ($agent->isTablet()) {
                return 'tablet';
            } else {
                return 'desktop';
            }
        }
    }

    public function analytics(Link $link, Request $request)
    {
        $reports = [
            'link' => [],
            'platforms' => [],
            'devices' => [],
            'browsers' => [],
            'locations' => [],
            'referrers' => [],
            'clicks' => [],
        ];
        $reports['link'] = $link;
        // Range
        if ($request->get('range') == 'yearly') {
            $start = Carbon::now()->subYear()->startOfYear();
            $end = Carbon::now()->endOfYear();
        } else {
            if ($request->get('range') == 'monthly') {
                $start = Carbon::now()->subMonth()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
            } else {
                $start = Carbon::now()->subWeek()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
            }
        }
        // Platform report
        $platformLinkVisits = (new Analytics('platform', $start, $end))->link($link->id)->notNull()->get();
        foreach ($platformLinkVisits as $platformLinkVisit) {
            $reports['platforms'][] = [
                'code' => $platformLinkVisit['platform'],
                'label' => Chart::platformName($platformLinkVisit['platform']),
                'value' => $platformLinkVisit['count'],
                'color' => Chart::platformColor($platformLinkVisit['platform'])
            ];
        }
        // Device report
        $deviceLinkVisits = (new Analytics('device', $start, $end))->link($link->id)->notNull()->get();
        foreach ($deviceLinkVisits as $deviceLinkVisit) {
            $reports['devices'][] = [
                'label' => Str::ucfirst($deviceLinkVisit['device']),
                'value' => $deviceLinkVisit['count']
            ];
        }
        // Browser report
        $browserLinkVisits = (new Analytics('browser', $start, $end))->link($link->id)->notNull()->get();
        foreach ($browserLinkVisits as $browserLinkVisit) {
            $reports['browsers'][] = [
                'code' => Chart::browserCode($browserLinkVisit['browser']),
                'label' => Chart::browserName($browserLinkVisit['browser']),
                'value' => $browserLinkVisit['count'],
                'color' => Chart::browserColor($browserLinkVisit['browser'])
            ];
        }
        // Location report
        $locationLinkVisits = (new Analytics('location', $start, $end))->link($link->id)->notNull()->get();
        foreach ($locationLinkVisits as $locationLinkVisit) {
            $reports['locations'][Str::upper($locationLinkVisit['location'])] = $locationLinkVisit['count'];
        }
        // Referrer report
        $referrerLinkVisits = (new Analytics('referrer', $start, $end))->link($link->id)->limit(20)->get();
        foreach ($referrerLinkVisits as $referrerLinkVisit) {
            $reports['referrers'][] = [
                'code' => $referrerLinkVisit['referrer'],
                'label' => Chart::referrerLabel($referrerLinkVisit['referrer']),
                'value' => $referrerLinkVisit['count']
            ];
        }
        // Clicks by day report
        if ($request->get('range') == 'yearly') {
            for ($i = 1; $i <= 12; $i++) {
                $reports['clicks'][] = [
                    'date' => Carbon::createFromFormat('m', $i)->startOfMonth()->toISOString(),
                    'clicks' => LinkVisit::where('link_id', $link->id)->whereMonth('created_at', $i)->count(),
                    'color' => '#3a1143'
                ];
            }
        } else {
            if ($request->get('range') == 'monthly') {
                $period = CarbonPeriod::create(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
            } else {
                $period = CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
            }
            foreach ($period as $day) {
                $reports['clicks'][] = [
                    'date' => $day->toISOString(),
                    'clicks' => LinkVisit::where('link_id', $link->id)->whereDay('created_at', $day)->count(),
                    'color' => '#3a1143'
                ];
            }
        }
        return response()->success($reports);
    }

    public function preview(Link $link)
    {
        $preview = 'links/'.md5($link->id);
        $generated = Storage::disk('private')->exists($preview);
        if ($generated && Carbon::now()->diffInDays(Carbon::create(date('c', Storage::disk('private')->lastModified($preview)))) >= 30) {
            $generated = false;
        }
        if (!$generated) {
            try {
                $client = new Client();
                $response = $client->get('https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.$link->url.'&screenshot=true');
                $content = json_decode($response->getBody()->getContents(), true);
                if (isset($content['lighthouseResult']['audits']['final-screenshot']['details']['data'])) {
                    $image = explode(',', $content['lighthouseResult']['audits']['final-screenshot']['details']['data']);
                    $data = $image[1];
                    $data = str_replace(['_', '-'], ['/', '+'], $data);
                    $data = base64_decode($data);
                    Storage::disk('private')->put($preview, $data);
                    return response()->success([
                        'mime' => Storage::disk('private')->getMimetype($preview),
                        'image' => base64_encode($data)
                    ]);
                }
            } catch (Exception $e) {
                return response()->success([
                    'mime' => File::mimeType('../public/images/default.png'),
                    'image' => base64_encode(File::get('../public/images/default.png'))
                ]);
            }
        } else {
            return response()->success([
                'mime' => Storage::disk('private')->getMimetype($preview),
                'image' => base64_encode(Storage::disk('private')->get($preview))
            ]);
        }
        return response()->success([
            'mime' => File::mimeType('../public/images/default.png'),
            'image' => base64_encode(File::get('../public/images/default.png'))
        ]);
    }

    public function generateLink(Request $request)
    {
        $input_array = $request->all();

        $validate = Validator::make($input_array, [
            'link' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json(['status' => false, 'message' => 'Something went wrong!!']);
        }

        $link = new Link();
        $link->uuid = Str::orderedUuid();
        $link->code = Str::random(5);
        $link->url = $request->get('link');
        $link->type = 1;
        $link->title = page_title($request->get('link'));
        $link->archived = false;
        $link->disabled = false;
        if(auth()->check())
        {
            $link->user_id = auth()->user()->id;
        }
        $link->save();

        return response()->json(['status'=>true, 'link' => $link]);
    }
}
