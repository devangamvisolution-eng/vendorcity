<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class FrontCityContext
{
    public function handle($request, Closure $next)
    {
        $city = $request->route()->parameter('city');

        if ($city) {
            session(['search_city_name' => $city]);

            $formattedCity = ucwords(str_replace('-', ' ', $city));
            $cityData = \DB::table('cities')->where('name', $formattedCity)->first();
            if ($cityData) {
                session(['search_city_id' => $cityData->id]);
            }

            URL::defaults(['city' => $city]);

            // Check if controller method expects 'city' parameter
            $route = $request->route();
            $hasCityParam = false;
            try {
                $controller = $route->getController();
                $method = $route->getActionMethod();
                if ($controller && $method && method_exists($controller, $method)) {
                    $reflector = new \ReflectionMethod($controller, $method);
                    foreach ($reflector->getParameters() as $parameter) {
                        if ($parameter->getName() === 'city') {
                            $hasCityParam = true;
                            break;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // If reflection fails, default to forgetting
            }

            if (!$hasCityParam) {
                $request->route()->forgetParameter('city');
            }
        }

        return $next($request);
    }
}
