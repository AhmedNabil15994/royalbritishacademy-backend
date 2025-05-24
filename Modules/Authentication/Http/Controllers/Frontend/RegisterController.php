<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use PragmaRX\Countries\Package\Countries;
use Modules\Authentication\Mail\WelcomeMail;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Frontend\RegisterRequest;
use Modules\Authentication\Notifications\Frontend\WelcomeNotification;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository as AuthenticationRepo;
use Modules\Cart\Traits\CartTrait;

class RegisterController extends Controller
{
    use Authentication, CartTrait;

    protected $auth;
    
    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function show(Request $request)
    {
        return view('authentication::frontend.register', compact('request'));
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->auth->register($request->validated());
        if ($registered) {
            $this->loginAfterRegister($request);
            auth()->user()->notify(new WelcomeNotification);
            if (isset($request->from) && $request->from == 'checkout') {
                $this->updateCartKey(get_cookie_value(config('core.config.constants.CART_KEY')), $registered->id);
                return redirect()->route('frontend.cart.index');
            }
            return $this->redirectTo($request);
        } else {
            return redirect()->back()->with(['errors' => 'try again']);
        }
    }

    public function redirectTo($request)
    {
        if ($request['redirect_to'] == 'address') {
            return redirect()->route('frontend.order.address.index');
        }

        return redirect()->route('frontend.home');
    }

    public function countries()
    {
        $countries = Country::pluck('title', 'id');

        return $countries;
    }

    public function usersTimeZone()
    {
        return array(
            'Pacific/Midway' => "Midway Island",
            'US/Samoa' => "Samoa",
            'US/Hawaii' => "Hawaii",
            'US/Alaska' => "Alaska",
            'US/Pacific' => " Pacific Time (US &amp; Canada)",
            'America/Tijuana' => "Tijuana",
            'US/Arizona' => " Arizona",
            'US/Mountain' => " Mountain Time (US &amp; Canada)",
            'America/Chihuahua' => " Chihuahua",
            'America/Mazatlan' => "Mazatlan",
            'America/Mexico_City' => "Mexico City",
            'America/Monterrey' => " Monterrey",
            'Canada/Saskatchewan' => " Saskatchewan",
            'US/Central' => "Central Time (US &amp; Canada)",
            'US/Eastern' => "Eastern Time (US &amp; Canada)",
            'US/East-Indiana' => "Indiana (East)",
            'America/Bogota' => "Bogota",
            'America/Lima'     => "Lima",
            'America/Caracas'  => "Caracas",
            'Canada/Atlantic'  => "Atlantic Time (Canada)",
            'America/La_Paz'   => " La Paz",
            'America/Santiago' => " Santiago",
            'Canada/Newfoundland' => " Newfoundland",
            'America/Buenos_Aires' => "Buenos Aires",
            'Greenland' => "Greenland",
            'Atlantic/Stanley' => "Stanley",
            'Atlantic/Azores' => "Azores",
            'Atlantic/Cape_Verde' => "Cape Verde Is.",
            'Africa/Casablanca' => "Casablanca",
            'Europe/Dublin' => " Dublin",
            'Europe/Lisbon' => " Lisbon",
            'Europe/London' => " London",
            'Africa/Monrovia' => "Monrovia",
            'Europe/Amsterdam' => "Amsterdam",
            'Europe/Belgrade' => "Belgrade",
            'Europe/Berlin' => "Berlin",
            'Europe/Bratislava' => "Bratislava",
            'Europe/Brussels' => "Brussels",
            'Europe/Budapest' => "Budapest",
            'Europe/Copenhagen' => "Copenhagen",
            'Europe/Ljubljana' => "Ljubljana",
            'Europe/Madrid' => "Madrid",
            'Europe/Paris' => "Paris",
            'Europe/Prague' => "Prague",
            'Europe/Rome' => "Rome",
            'Europe/Sarajevo' => "Sarajevo",
            'Europe/Skopje' => "Skopje",
            'Europe/Stockholm' => " Stockholm",
            'Europe/Vienna' => " Vienna",
            'Europe/Warsaw' => "Warsaw",
            'Europe/Zagreb' => "Zagreb",
            'Europe/Athens' => " Athens",
            'Europe/Bucharest' => "Bucharest",
            'Africa/Cairo' => "Cairo",
            'Africa/Harare' => "Harare",
            'Europe/Helsinki' => "Helsinki",
            'Europe/Istanbul' => "Istanbul",
            'Asia/Jerusalem' => "Jerusalem",
            'Europe/Kiev' => " Kyiv",
            'Europe/Minsk' => " Minsk",
            'Europe/Riga' => " Riga",
            'Europe/Sofia' => "Sofia",
            'Europe/Tallinn' => "Tallinn",
            'Europe/Vilnius' => "Vilnius",
            'Asia/Baghdad' => " Baghdad",
            'Asia/Kuwait' => "Kuwait",
            'Africa/Nairobi' => "Nairobi",
            'Asia/Riyadh' => "Riyadh",
            'Europe/Moscow' => "Moscow",
            'Asia/Tehran' => "Tehran",
            'Asia/Baku' => "Baku",
            'Europe/Volgograd' => "Volgograd",
            'Asia/Muscat' => "Muscat",
            'Asia/Tbilisi' => "Tbilisi",
            'Asia/Yerevan' => " Yerevan",
            'Asia/Kabul' => "Kabul",
            'Asia/Karachi' => "Karachi",
            'Asia/Tashkent' => "Tashkent",
            'Asia/Kolkata' => "Kolkata",
            'Asia/Kathmandu' => "Kathmandu",
            'Asia/Yekaterinburg' => "Ekaterinburg",
            'Asia/Almaty' => "Almaty",
            'Asia/Dhaka' => "Dhaka",
            'Asia/Novosibirsk' => " Novosibirsk",
            'Asia/Bangkok' => "Bangkok",
            'Asia/Jakarta' => "Jakarta",
            'Asia/Krasnoyarsk' => "Krasnoyarsk",
            'Asia/Chongqing' => "Chongqing",
            'Asia/Hong_Kong' => " Hong Kong",
            'Asia/Kuala_Lumpur' => " Kuala Lumpur",
            'Australia/Perth' => "Perth",
            'Asia/Singapore' => "Singapore",
            'Asia/Taipei' => "Taipei",
            'Asia/Ulaanbaatar' => " Ulaan Bataar",
            'Asia/Urumqi' => " Urumqi",
            'Asia/Irkutsk' => " Irkutsk",
            'Asia/Seoul' => " Seoul",
            'Asia/Tokyo' => "Tokyo",
            'Australia/Adelaide' => " Adelaide",
            'Australia/Darwin' => " Darwin",
            'Asia/Yakutsk' => "Yakutsk",
            'Australia/Brisbane' => " Brisbane",
            'Australia/Canberra' => " Canberra",
            'Pacific/Guam' => " Guam",
            'Australia/Hobart' => " Hobart",
            'Australia/Melbourne' => " Melbourne",
            'Pacific/Port_Moresby' => " Port Moresby",
            'Australia/Sydney' => "Sydney",
            'Asia/Vladivostok' => "Vladivostok",
            'Asia/Magadan' => "Magadan",
            'Pacific/Auckland' => "Auckland",
            'Pacific/Fiji' => "Fiji",
        );
    }
}
