<?php
namespace Config;

use App\Services\FraudDetection\ValidationRules\NotFraud;
use Engine\Http\RequestValidation\Rules\Email;
use Engine\Http\RequestValidation\Rules\ExistsDB;
use Engine\Http\RequestValidation\Rules\Integer;
use Engine\Http\RequestValidation\Rules\IsString;
use Engine\Http\RequestValidation\Rules\LoggedIn;
use Engine\Http\RequestValidation\Rules\MatchesOther;
use Engine\Http\RequestValidation\Rules\Max;
use Engine\Http\RequestValidation\Rules\Min;
use Engine\Http\RequestValidation\Rules\NotExistsDB;
use Engine\Http\RequestValidation\Rules\Required;

class RequestValidation implements ConfigInterface{

    public array $rules = [
        'string' => IsString::class,
        'int' => Integer::class,
        'email' => Email::class,
        'equalTo'=> MatchesOther::class,
        'required'=> Required::class,
        'exists'=>ExistsDB::class,
        'notExists'=>NotExistsDB::class,
        'min'=>Min::class,
        'max'=>Max::class,
        'loggedIn'=>LoggedIn::class,
        'notFraud'=>NotFraud::class

    ];

    public static function load(): RequestValidation
    {
        return new RequestValidation();
    }
}