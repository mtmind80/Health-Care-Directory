<?php namespace App\Services\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;

/**
 *   Default validation rules:  (http://laravel.com/docs/5.0/validation#available-validation-rules)
 *
 *   Accepted
 *   Active URL
 *   After (Date)
 *   Alpha
 *   Alpha Dash
 *   Alpha Numeric
 *   Array
 *   Before (Date)
 *   Between
 *   Boolean
 *   Confirmed
 *   Date
 *   Date Format
 *   Different
 *   Digits
 *   Digits Between
 *   E-Mail
 *   Exists (Database)
 *   Image (File)
 *   In
 *   Integer
 *   IP Address
 *   Max
 *   MIME Types
 *   Min
 *   Not In
 *   Numeric
 *   Regular Expression
 *   Required
 *   Required If
 *   Required With
 *   Required With All
 *   Required Without
 *   Required Without All
 *   Same
 *   Size
 *   String
 *   Timezone
 *   Unique (Database)
 *   URL
 *
 */
class ValidatorExtended extends IlluminateValidator
{

    private $_customMessages;

    public function __construct($translator, $data, $rules, $messages = array(), $customAttributes = array())
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        if (session('lang') == 'sp') {
            $this->_customMessages = [
                'text'                  => 'Texto no v&aacute;lido en campo ":attribute".',
                'plain_text'            => 'El campo ":attribute" no puede contener caracteres html.',
                'slug'                  => 'El campo ":attribute" solo puede contener letras min&uacute;sculas y -.',
                'identifier'            => 'El campo ":attribute" solo puede contener letras, n&uacute;meros y _.',
                'file_name'             => 'Entrada no v&aacute;lida en campo ":attribute".',
                'positive'              => 'El campo ":attribute" debe ser un n&uacute;mero positivo.',
                'zero_or_positive'      => 'El campo ":attribute" debe ser cero o un n&uacute;mero positivo.',
                'float'                 => 'El campo ":attribute" debe ser un n&uacute;mero real.',
                'currency'              => 'El campo ":attribute" debe ser de tipo moneda.',
                'zip_code'              => 'Entrada no v&aacute;lida en campo ":attribute".',
                'postal_code'           => 'Entrada no v&aacute;lida en campo ":attribute".',
                'person_name'           => 'Entrada no v&aacute;lida en campo ":attribute".',
                'phone'                 => 'Entrada no v&aacute;lida en campo ":attribute".',
                'credit_card'           => 'Entrada no v&aacute;lida en campo ":attribute".',
                'instagram'             => 'Entrada no v&aacute;lida en campo ":attribute".',
                'address'               => 'Entrada no v&aacute;lida en campo ":attribute".',
                'location'              => 'Entrada no v&aacute;lida en campo ":attribute".',
                'iso_date'              => 'Entrada no v&aacute;lida en campo ":attribute".',
                'us_date'               => 'Entrada no v&aacute;lida en campo ":attribute".',
                'sp_date'               => 'Entrada no v&aacute;lida en campo ":attribute".',
                'any_date'              => 'Entrada no v&aacute;lida en campo ":attribute".',
                'time'                  => 'Entrada no v&aacute;lida en campo ":attribute".',
                'iso_date_time'         => 'Entrada no v&aacute;lida en campo ":attribute".',
                'us_date_time'          => 'Entrada no v&aacute;lida en campo ":attribute".',
                'relative_url'          => 'Entrada no v&aacute;lida en campo ":attribute".',
                'url_segment'           => 'Entrada no v&aacute;lida en campo ":attribute".',
                'friendly_url_segments' => 'Entrada no v&aacute;lida en campo ":attribute".',
                'subdomain'             => 'Entrada no v&aacute;lida en campo ":attribute".',
                'int_percent'           => 'Entrada no v&aacute;lida en campo ":attribute".',
                'boolean'               => 'El campo ":attribute" debe ser boleano.',
                'alpha_numeric'         => 'El campo ":attribute" debe ser alphanumerico.',
                'lower'                 => 'El campo ":attribute" solo puede contener letras mi$uacute;sculas.',
            ];
        } else {
            $this->_customMessages = [
                'text'                  => 'Invalid text in field ":attribute".',
                'plain_text'            => 'The field ":attribute" can not contain html tags.',
                'slug'                  => 'The field ":attribute" can only contain lowercase letters and dashes.',
                'identifier'            => 'The field ":attribute" can only contain letters, numbers and underscore.',
                'file_name'             => 'Invalid entry in field ":attribute".',
                'positive'              => 'The field ":attribute" must be a positive number.',
                'zero_or_positive'      => 'The field ":attribute" must be zero or a positive number.',
                'float'                 => 'The field ":attribute" must be a float number.',
                'currency'              => 'The field ":attribute" must be a currency format value.',
                'zip_code'              => 'Invalid zip code in field ":attribute".',
                'postal_code'           => 'Invalid entry in field ":attribute".',
                'person_name'           => 'Invalid entry in field ":attribute".',
                'phone'                 => 'Invalid entry in field ":attribute".',
                'credit_card'           => 'Invalid entry in field ":attribute".',
                'instagram'             => 'Invalid entry in field ":attribute".',
                'address'               => 'Invalid entry in field ":attribute".',
                'location'              => 'Invalid entry in field ":attribute".',
                'iso_date'              => 'Invalid entry in field ":attribute".',
                'us_date'               => 'Invalid entry in field ":attribute".',
                'sp_date'               => 'Invalid entry in field ":attribute".',
                'any_date'              => 'Invalid entry in field ":attribute".',
                'time'                  => 'Invalid entry in field ":attribute".',
                'iso_date_time'         => 'Invalid entry in field ":attribute".',
                'us_date_time'          => 'Invalid entry in field ":attribute".',
                'relative_url'          => 'Invalid entry in field ":attribute".',
                'url_segment'           => 'Invalid entry in field ":attribute".',
                'friendly_url_segments' => 'Invalid entry in field ":attribute".',
                'subdomain'             => 'Invalid entry in field ":attribute".',
                'int_percent'           => 'Invalid entry in field ":attribute".',
                'boolean'               => 'The field ":attribute" must be boolean.',
                'alpha_numeric'         => 'The field ":attribute" must be alphanumeric.',
                'lower'                 => 'The field ":attribute" must only contain lowercase letters.',
            ];
        }

        $this->setCustomMessages($this->_customMessages);
    }

    protected function validateText($attribute, $value)
    {
        $value = str_replace('&lt;', '<', $value);
        $value = str_replace('&lt;', '>', $value);

        // <, / or none, any spaces or none, those words, any character or none, and >
        return !preg_match('/(<\/?\s*(javascript|script|onmouseover|onmousedown|onclick)\b.*?>)/i', $value);
    }

    protected function validatePlainText($attribute, $value)
    {
        return (bool)preg_match('/^[^<>]+$/', $value);
    }

    protected function validateSlug($attribute, $value)
    {
        return (bool)preg_match('/^[a-z]{1}[a-z\-]*$/', $value);
    }

    protected function validateIdentifier($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-Z_]{1}[a-zA-Z0-9_]*$/', $value);
    }

    protected function validateFileName($attribute, $value)
    {
        return preg_match('/^[0-9a-zA-Z_]{1}[0-9a-zA-Z\s_\-\.]*$/', $value);
    }

    protected function validatePositive($attribute, $value)
    {
        return (bool)preg_match('/^[1-9]{1}[0-9]*(\.[0-9]+)?$/', $value);
    }

    protected function validateZeroOrPositive($attribute, $value)
    {
        return (bool)preg_match('/^[0-9]+$/', $value);
    }

    protected function validateFloat($attribute, $value)
    {
        return (bool)preg_match('/^(\-)?[0-9]+(\.)?([0-9]+)?$/', $value);
    }

    protected function validateCurrency($attribute, $value)
    {
        return (bool)preg_match('/^(0\.)?\d+(\.\d{1,2})?$/', $value);
    }

    protected function validateZipcCode($attribute, $value)
    {
        return (bool)preg_match('/^[0-9]{5}(\-[0-9]{4})?$/', $value);
    }

    protected function validatePostalCode($attribute, $value)
    {
        return (bool)preg_match('/^[0-9a-zA-Z_\s\-]+$/', $value);
    }

    protected function validatePersonName($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s\-\'\.]+$/', $value);
    }

    protected function validatePhone($attribute, $value)
    {
        return (bool)preg_match('/^[0-9\(\)\[\]\-\.\s]+$/', $value);
    }

    protected function validateCreditCard($attribute, $value)
    {
        return (bool)preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/', $value);
    }

    protected function validateInstagram($attribute, $value)
    {
        return (bool)preg_match('/^[0-9a-zA-Z@_\-]+$/', $value);
    }

    protected function validateAddress($attribute, $value)
    {
        return (bool)preg_match('/^[0-9a-zA-ZáéíóúñÁÉÍÓÚÑ\s_,\-\.#\%]+$/', $value);
    }

    protected function validateLocation($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s_,\-]+$/', $value);
    }

    protected function validateIsoDate($attribute, $value)
    {
        return (bool)preg_match('/^[0-9]{2,4}(\-|\/)(([1-9])|(0[1-9])|(1[0-2]))(\-|\/)(([1-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))$/', $value);
    }

    protected function validateUsDate($attribute, $value)
    {
        return (bool)preg_match('/^(([1-9])|(0[1-9])|(1[0-2]))(\-|\/)(([1-9])|([0-2][0-9])|(3[0-1]))(\-|\/)[0-9]{2,4}$/', $value);
    }

    protected function validateSpDate($attribute, $value)
    {
        return (bool)preg_match('/^(([1-9])|([0-2][0-9])|(3[0-1]))(\-|\/)(([1-9])|(0[1-9])|(1[0-2]))(\-|\/)[0-9]{2,4}$/', $value);
    }

    protected function validateAnyDate($attribute, $value)
    {
        return (bool)($this->validateIsoDate($attribute, $value) || $this->validateUsDate($attribute, $value) || $this->validateSpDate($attribute, $value));
    }

    protected function validateTime($attribute, $value)
    {
        return (bool)preg_match('/^[0-9]{1,2}:[0-9]{2}(:[0-9]{2})?( (am|pm|AM|PM))?$/', $value);
    }

    protected function validateIsoDateTime($attribute, $value)
    {
        return (bool)preg_match('/^[0-9]{2,4}(\-|\/)(([1-9])|(0[1-9])|(1[0-2]))(\-|\/)(([1-9])|(0[1-9])|([1-2][0-9])|(3[0-1])) [0-9]{1,2}:[0-9]{2}(:[0-9]{2})?( (am|pm|AM|PM))?$/', $value);
    }

    protected function validateUsDateTime($attribute, $value)
    {
        return (bool)preg_match('/^(([1-9])|(0[1-9])|(1[0-2]))(\-|\/)(([1-9])|([0-2][0-9])|(3[0-1]))(\-|\/)[0-9]{2,4} [0-9]{1,2}:[0-9]{2}(:[0-9]{2})?( (am|pm|AM|PM))?$/', $value);
    }

    protected function validateRelativeUrl($attribute, $value)
    {
        return (bool)preg_match('/^(\/)?[a-zA-Z0-9_\-\.\/]+$/', $value);
    }

    protected function validateUrlSegment($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9_\-\.]+$/', $value);
    }

    protected function validateFriendlyUrlSegments($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9_\-\/]+$/', $value);
    }

    protected function validateSubdomain($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9_\-]+$/', $value);
    }

    protected function validateIntPercent($attribute, $value)
    {
        return (bool)preg_match('/^(([1-9]{1}[0-9]{0,1})|(100{1}))\s*%{0,1}$/', $value);
    }

    protected function validateAlphaNumeric($attribute, $value)
    {
        return (bool)preg_match('/^[0-9a-zA-Z]+$/', $value);
    }

    protected function validateBoolean($attribute, $value)
    {
        return (bool)preg_match('/^(on|off|true|false|1|0)$/', $value);
    }

    protected function validateLower($attribute, $value)
    {
        return (bool)preg_match('/^[a-z]+$/', $value);
    }

    protected function validateVideoId($attribute, $value)
    {
        return (bool)preg_match('/^[a-zA-Z1-9]{1}[a-zA-Z0-9_\-]+$/', $value);
    }

}