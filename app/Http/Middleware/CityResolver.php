<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin\City;
use App\Models\Admin\Country;
use App\Models\Admin\State;
use App\Helpers\Helper;
use Illuminate\Support\Str;

class CityResolver
{
    public function handle($request, Closure $next)
    {
        /**
         * Detect base folder from APP_URL (Handles Local, Beta, Live)
         * Examples:
         * - http://localhost/vendorcitybeta → vendorcitybeta
         * - https://client.com/demo/v1 → demo, v1
         * - https://vendorscity.com → no folder
         */
        $baseUrl = trim(parse_url(config('app.url'), PHP_URL_PATH), '/');
        $baseFolders = [];

        if (!empty($baseUrl)) {
            $baseFolders = explode('/', $baseUrl);
        }

        // Get requested URL segment
        $segment = $request->segment(1);

        // Remove base folder segment dynamically
        if (in_array(strtolower($segment), $baseFolders)) {
            $segment = $request->segment(2);
        }

        /**
         * 1. URL HAS CITY SLUG → ALWAYS USE IT
         */
        if (!empty($segment) && !$this->isReservedSlug($segment)) {

            $city = City::whereRaw("LOWER(REPLACE(name,' ','-')) = ?", [$segment])->first();

            if ($city) {
                $this->setCitySession($city, $segment);
                return $next($request);
            }
        }

        /**
         * 2. SESSION EXISTS → DO NOT CALL API
         */
        if (session()->has('search_city_id')) {
            return $next($request);
        }

        /**
         * 3. NO SLUG + NO SESSION → CALL API ONCE
         */
        if (!session()->has('user_geo_checked')) {

            $geo  = Helper::getUserLocation();  // API CALL
            $slug = Str::slug($geo['city'] ?? '');

            session(['user_geo_checked' => true]); // Lock so API does NOT run again

            if (!empty($slug)) {

                $city = City::whereRaw("LOWER(REPLACE(name,' ','-')) = ?", [$slug])->first();

                if ($city) {
                    $this->setCitySession($city, $slug);

                    // Redirect ONLY from home
                    if ($this->isHomepage($request, $baseFolders)) {
                        return redirect()->to(url($slug));
                    }

                    return $next($request);
                }
            }
        }

        /**
         * 4. FALLBACK → Dubai
         */
        $defaultCity = City::where('name', 'Dubai')->first();
        if ($defaultCity) {
            $slug = Str::slug($defaultCity->name);
            $this->setCitySession($defaultCity, $slug);
            return redirect()->to(url($slug));
        }

        return $next($request);
    }


    private function isReservedSlug($slug)
    {
        return in_array(strtolower($slug), ['admin', 'login', 'logout', 'config-cache', 'accept-quotation', 'request-accept']);
    }

    private function isHomepage($request, $baseFolders)
    {
        $path = trim($request->path(), '/');

        // Homepage: "/", "vendorcitybeta/", etc.
        return $path === '' || in_array($path, $baseFolders);
    }

    private function setCitySession($city, $slug)
    {
        $country = Country::find($city->country);
        $state   = State::find($city->state);

        session([
            'search_city_id'      => $city->id,
            'search_city_name'    => $slug,
            'search_country_id'   => $country->id ?? null,
            'search_country_name' => $country->country ?? null,
            'search_state_id'     => $state->id ?? null,
            'search_state_name'   => $state->state ?? null,

            'user_geo_location'   => [
                'city'         => $city->name,
                'state_prov'   => $state->state ?? null,
                'country_name' => $country->country ?? null,
            ],
        ]);
    }
}
