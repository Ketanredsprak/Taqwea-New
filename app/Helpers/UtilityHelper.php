<?php

use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Bank;
use Tymon\JWTAuth\JWT;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Language;
use Tymon\JWTAuth\Token;
use Lcobucci\JWT\Builder;
use Illuminate\Support\Str;
use App\Models\RatingReview;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Lcobucci\JWT\Signer\Key;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Bepsvpt\SecureHeaders\SecureHeaders as SecureHeaders;
use Alkoumi\LaravelHijriDate\Hijri;

/**
 * Method generateOtp
 *
 * @return int
 */
function getExternalId()
{
    return mt_rand(100000000, 999999999);
}

/**
 * Method generateOtp
 *
 * @param bool $temp
 *
 * @return int
 */
function generateOtp($temp = false): int
{
    // return random_int(1000, 9999);
    return "1234";
}


/**
 * Method defaultPaginationLimit
 *
 * @return int
 */
function defaultPaginationLimit(): int
{
    return 10;
}

/**
 * Method getLoggedInUser
 *
 * @return User
 */
function getLoggedInUser()
{
    return JWTAuth::parseToken()->authenticate();
}

/**
 * Method invalidateToken
 *
 * @param Request $request [explicite description]
 *
 * @return JWT
 */
function invalidateToken(Request $request): JWT
{
    $authorization = $request->header('authorization');
    $token = str_replace('Bearer ', '', $authorization);
    return JWTAuth::invalidate($token);
}

/**
 * Method invalidateTokenString
 *
 * @param string $token [explicite description]
 *
 * @return void
 */
function invalidateTokenString(string $token = '')
{
    try {
        if ($token) {
            JWTAuth::manager()->invalidate(new Token($token), false);
        }

    } catch (\Throwable $th) {
        return false;
    }

}

/**
 * Method checkAppVersion
 *
 * @param Request $request [explicite description]
 *
 * @return array
 */
function checkAppVersion(Request $request)
{
    $response = [
        'success' => true
    ];

    $appVersion = $request->header('app-version');
    $deviceType = $request->header('device-type');
    if (!empty($deviceType) && !empty($appVersion)) {
        if ($deviceType == 'ios') {
            $data = DB::table('settings')
                ->where('setting_key', 'ios_app_version')
                ->first();
            // if ($data && $data->setting_value >= $appVersion) {
            if (version_compare($appVersion, $data->setting_value, '<')) {
                $response = [
                    'success' => false,
                    'data' => [],
                    'message' => 'There is a newer version available for download! Please update the app by visiting the App store.',
                    'url' => 'https://itunes.apple.com/app/'
                ];
            }
        } elseif ($deviceType == 'android') {
            $data = DB::table('settings')
                ->where('setting_key', 'android_app_version')
                ->first();
            // if ($data && $data->setting_value >= $appVersion) {
            if (version_compare($appVersion, $data->setting_value, '<')) {
                $response = [
                    'success' => false,
                    'data' => [],
                    'message' => 'There is a newer version available for download! Please update the app by visiting the Play store.'
                ];
            }
        }
    }

    return $response;
}

/**
 * Method setUserLanguage
 *
 * @param string $language [explicite description]
 *
 * @return void
 */
function setUserLanguage($language)
{
    $language = ($language) ?? config('app.locale');
    App::setLocale($language);
    setLanguageInCookie($language);
}

/**
 * Method sendMail
 *
 * @param string|User|Collection $to       [explicite description]
 * @param Mailable               $template [explicite description]
 *
 * @return void
 */
function sendMail($to, $template)
{
    // Mail::to($to)->locale('ar')->send($template);
    return true;
}


/**
 * Method changeDateToFormate
 *
 * @param $date   [explicite description]
 * @param $format [explicite description]
 *
 * @return void
 */
function changeDateToFormat($date, $format = '')
{
    $format = !empty($format) ? $format : 'Y-m-d';
    return date($format, strtotime($date));
}

/**
 * Method currentDate
 *
 * @param string $format
 *
 * @return date
 */
function currentDateByFormat($format)
{
    return date($format);
}

/**
 * Method convertMinutesToHours
 *
 * @param int $minutes [explicite description]
 *
 * @return void
 */
function convertMinutesToHours(int $minutes)
{
    $hours = floor($minutes / 60);
    $min = $minutes - ($hours * 60);

    if (!$min) {
        return $hours;
    }
    return $hours . ":" . $min;
}

/**
 * Method generateReferralCode
 *
 * @param int $length [explicite description]
 *
 * @return string
 */
function generateReferralCode(int $length = 8): string
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length);
}

/**
 * Get all active languages
 *
 * @return Language
 */
function getLanguages()
{
    return Language::active()->get();
}

/**
 * Set user language in cookies
 *
 * @param string $code [explicite description]
 *
 * @return String
 */
function setLanguageInCookie($code): string
{
    if (isset($_COOKIE["language"]) && !empty($_COOKIE["language"])) {
        unset($_COOKIE['language']);
    }

    Cookie::queue(
        Cookie::make(
            'language',
            $code,
            time() + (365 * 24 * 60 * 60)
        )
    );
    return $code;
}

/**
 * Get user language from cookies
 *
 * @return String
 */
function getLanguageInCookie()
{
    $code = null;
    if (!empty(Cookie::get('language'))) {
        $code = Cookie::get('language');
    }
    return $code;
}

/**
 * Get user email with stars
 *
 * @param String $email
 *
 * @return String
 */
function obfuscateEmail($email)
{
    $em   = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em) - 1));
    $len  = floor(strlen($name) / 2);

    return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
}
/**
 * Method getSetting
 *
 * @param string $key [explicite description]
 *
 * @return mixed
 */
function getSetting(string $key)
{
    $value = 0;
    $setting = Setting::where('setting_key', $key)->first();
    if ($setting) {
        $value = $setting->setting_value;
    }

    return $value;
}

/**
 * Get sub category
 *
 * @param int $id
 *
 * @return Category
 */
function getSubCategory($id)
{
    return Category::withTranslation()->where('parent_id', $id)->get();
}

/**
 * Method pageLoader
 *
 * @return void
 */
function pageLoader()
{
    echo '<div class="pageLoader text-center"><div class="spinner-border" role="status"></div></div>';
}

/**
 * Get duration in hours and min
 *
 * @param int $minutes [explicite description]
 *
 * @return String
 */
function getDuration($minutes)
{
    $text = '';
    if ($minutes >= 60) {
        $hours = (int)($minutes / 60);
        $minutes = $minutes % 60;
        if ($hours) {
            $text .= $hours . ' '.trans('labels.h');
        }

        if ($minutes) {
            $text .= ' ' . $minutes . ' '.trans('labels.min');
        }
    } else {
        $text = $minutes . ' '.trans('labels.min');
    }
    return $text;
}

/**
 * Method generateClientSecret
 *
 * @return string
 */
function generateClientSecret(): string
{
    $applePrivateKeyFilePath = storage_path('app/AuthKey_M2DP95S5NA.key');
    if (file_exists($applePrivateKeyFilePath)) {
        $clientSecretPrepared = 'file://' . $applePrivateKeyFilePath;
    }

    $signer = new Sha256();
    $privateKey = new Key($clientSecretPrepared);

    $token = (new Builder())->issuedBy('Q84UD28472')
        ->withHeader('kid', 'M2DP95S5NA')
        ->withHeader('type', 'JWT')
        ->withHeader('alg', 'ES256')
        ->issuedAt(Carbon::now()->timestamp)
        ->expiresAt(Carbon::now()->days(31)->timestamp)
        ->withClaim('aud', 'https://appleid.apple.com')
        ->withClaim('sub', 'com.codiant.taqwea-lms.signin')
        ->getToken($signer, $privateKey); // Retrieves the generated token

    return (string) $token;
}

/**
 * Convert time to time zone
 *
 * @param $date   [explicite description]
 * @param $fromTz [explicite description]
 * @param $format [explicite description]
 * @param $toTz   [explicite description]
 *
 * @return String
 */
function convertDateToTz(
    $date,
    $fromTz = '',
    $format = 'Y-m-d H:i:s',
    $toTz = '',
    $withoutTranslate = ''
) {

    if ($toTz == '' && (Session::get('timezone'))) {
        $toTz = Session::get('timezone');
    } else if ($toTz == '') {
        $toTz = config('app.timezone');
    }

    if (!$fromTz) {
        $fromTz = config('app.timezone');
    }
    $date = new \DateTime($date, new \DateTimeZone($fromTz));
    $date->setTimezone(new \DateTimeZone($toTz));
    $date = $date->format($format);
    if ($withoutTranslate) {
        return $date;
    }
    return Carbon::parse($date)->translatedFormat($format);
}

/**
 * Get current date time
 *
 * @param $format   [explicite description]
 * @param $timezone [explicite description]
 *
 * @return String
 */
function nowDate($format = 'Y-m-d H:i:s', $timezone = null)
{
    $timezone = $timezone ? $timezone : Session::get('timezone');
    return Carbon::now()->setTimezone($timezone)->format($format);
}

/**
 * Check class/blog is already book
 *
 * @param $id
 * @param $type
 *
 * @return bool
 */
function checkClassBlogBooked($id, $type)
{
    if (Auth::check()) {
        $user = Auth::user();
        $query = TransactionItem::whereIn(
            'status',
            [TransactionItem::STATUS_CONFIRMED]
        );
        if ($type == 'class') {
            $query->where('class_id', $id);
        } elseif ($type == 'blog') {
            $query->where('blog_id', $id);
        }
        $query->where('student_id', $user->id);
        $check  = $query->first();
        if (!empty($check)) {
            return true;
        }
    }
    return false;
}

/**
 * Get price filter text
 *
 * @param $start
 *
 * @return Array
 */
function getPriceText($start)
{
    $currency = config('app.currency.default');
    $last = ($start < 100) ? $start + 50 : $start + 100;
    if ($start === 0) {
        $text = trans('labels.less_than') . ' ' . $currency . ' ' . $last;
    } elseif ($start === 500) {
        $text = $currency. ' ' . $start . '+';
    } else {
        $text = $currency . ' ' . $start . ' - ' . $currency . ' ' . $last;
    }
    $value = $start . ',' . $last;
    return [$value, $text, $last];
}

/**
 * Method makeSlug
 *
 * @param string $string
 * @param object $model
 * @param string $key
 * @param string $separator
 *
 * @return void
 */
function makeSlug(
    string $string,
    $model = null,
    $key = '',
    $separator = "-",
    $withTrashed = false
) {
    $slug = Str::slug($string, $separator);
    $query = $model::whereSlug($slug);
    if ($withTrashed) {
        $query->withTrashed();
    }
    $checkExists = $query->exists();
    if ($model && $key && $checkExists) {
        $qry = $model::where("slug", 'Like', '%'.$slug.'%');
        if ($withTrashed) {
            $qry->withTrashed();
        }
        $max = $qry->count();
        if ($max) {
            $max = $max+1;
            $slug = "{$slug}-$max";
        }
    }
    return $slug;
}

/**
 * Method getUserLanguage
 *
 * @param array $params
 *
 * @return String
 */
function getUserLanguage($params = [])
{
    $language = config('app.locale');
    if (isset($params['language'])) {
        $language = $params['language'];
    }
    return $language;
}

/**
 * Method generateScriptNonce
 *
 * @param string $type [explicite description]
 *
 * @return string
 */
function generateScriptNonce(string $type): string
{
    return SecureHeaders::nonce($type);
}

/**
 * Method get car types
 *
 * @param string $type [explicite description]
 *
 * @return string
 */
function getCardTypes($type = null)
{
    $data = ['VISA', 'MASTER'];
    $html = '<select class="form-control form-select" name="paymentBrand">';
    foreach ($data as $value) {
        $select = ($type == $value) ? 'selected="selected"' : '';
        $html .= '<option ' . $select . ' value="' . $value . '">' . $value . '</option>';
    }
    return $html .= '</select>';
}

/**
 * Function expiryDays
 *
 * @param Date $date
 *
 * @return int
 */
function expiryDays($date)
{
    $date = Carbon::parse($date);
    $now = Carbon::now();
    $day = $date->diffInDays($now);
    $return = '';
    if ($day == 0) {
        $return = trans('labels.today_expiry');
    } elseif ($day == 1) {
        $return = $day . ' ' . trans('labels.day');
    } else {
        $return = $day . ' ' . trans('labels.days');
    }
    return $return;
}

/**
 * Function classBookingBefore
 *
 * @param Date $date
 *
 * @return date
 */
function classBookingBefore($date)
{
    $classBookTime = config('services.class_booking_before');
    return Carbon::parse($date)->subMinute($classBookTime);
}

/**
 * Function remainingChatDays
 *
 * @param Date $date
 *
 * @return str
 */
function remainingChatDays($date)
{
    $expired = __('labels.expired');
    $day = __('labels.day');
    $days = __('labels.days');
    $hour = __('labels.hour');
    $hours = __('labels.hours');
    $minute = __('labels.minute');
    $minutes = __('labels.minutes');
    $remaining = __('labels.remaining');
    $date = Carbon::parse($date)->addDay(config('services.message_day'));
    $search = array('from now', 'days', 'day', 'hours', 'hour', 'minutes', 'minute');
    $replace = array($remaining, $days, $day, $hours, $hour, $minutes, $minute);
    $now = $date->diffForHumans(['parts' => 2, 'join' => true]);
    return (Str::contains($now, 'ago')) ? $expired : str_replace($search, $replace, $now);
}

/**
 * Function GetAverageRating
 *
 * @param int $userId
 *
 * @return string
 */
function getAverageRating(int $userId)
{
    $avgRating = "0.0";
    $query = RatingReview::select(
        DB::raw("AVG(rating) AS avg_rating")
    )
        ->where('to_id', $userId);
    $rating = $query->first();
    if ($rating) {
        $avgRating = number_format($rating['avg_rating'], 1);
    }
    return $avgRating;
}

/**
 * Function convertHijriDate
 *
 * @param date $date
 *
 * @return date
 */
function convertGeorgianToHijriDate($date)
{
    return Hijri::MediumDate($date);
}

/**
 * Method updateUserTimeZOne
 *
 * @param int    $user_id
 * @param string $timeZone
 *
 * @return void
 */
function updateUserTimeZOne($user_id, $timeZone) :void
{
    $user = User::find($user_id);
    $user->time_zone = $timeZone;
    $user->save();
}

/**
 * Method calculationRefundAmount
 *
 * @param object $transactionItem
 *
 * @return array
 */
function calculationRefundAmount($transactionItem):array
{
    $totalAmount = $transactionItem->transaction->total_amount
    -$transactionItem->transaction->vat-$transactionItem->transaction->transaction_fees;

    $refundData['vat_percent'] = round(100 * ($transactionItem->transaction->vat / $totalAmount), 2);

    $refundData['transaction_percent'] =  round(
        (100 * ($transactionItem->transaction->transaction_fees / ($transactionItem->transaction->vat+$totalAmount))),
        1
    );

    $refundAmount = $transactionItem->total_amount;

    $refundData['vat'] = $refundAmount
        * ($refundData['vat_percent']/ 100);

    $refundData['transactionFees'] = ($refundAmount
        + $refundData['vat'])
        * ($refundData['transaction_percent'] / 100);

    $refundData['amount']  = round(($refundAmount + $refundData['vat'] + $refundData['transactionFees']), 2);

    return $refundData;
}

function formatAmount($amount)
{
    return number_format($amount, 2, '.', '');
}

/**
 * Method getShareLinks
 *
 * @param string $url
 * @param string $text
 *
 * @return array
 */
function getShareLinks(string $url, string $text)
{
    return Share::page(
        urlencode($url),
        $text
    )
        ->facebook()
        ->twitter()
        ->whatsapp()
        ->getRawLinks();
}

/**
 * Method GetBankName
 *
 * @return void
 */
function getBankName()
{
    return Bank::where('status', Bank::BANK_ACTIVE)->withTranslation()->get();
}

/**
 * Method getTransactionYears used in revenue report
 *
 * @return array
 */
function getTransactionYears()
{
    $years = [(int) date('Y')];
    $transaction = Transaction::first();
    if ($transaction) {
        $currentYear = (int) date('Y');
        $year = Carbon::parse($transaction->created_at)->format("Y");
        for ($i=$currentYear; $i >= $year; $i--) {
            array_push($years, $i);
        }
        $years = array_flip($years);
        array_unique($years);
        $years = array_keys($years);
    }
    return $years;
}
