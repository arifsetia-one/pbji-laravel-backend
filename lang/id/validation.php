<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':Attribute harus be accepted.',
    'accepted_if' => ':Attribute harus be accepted when :other is :value.',
    'active_url' => ':Attribute bukan URL yang valid.',
    'after' => ':Attribute harus be a date after :date.',
    'after_or_equal' => ':Attribute harus be a date after or equal to :date.',
    'alpha' => ':Attribute harus only mengandung letters.',
    'alpha_dash' => ':Attribute harus only mengandung letters, numbers, dashes and underscores.',
    'alpha_num' => ':Attribute harus only mengandung letters and numbers.',
    'array' => ':Attribute harus harus sebuah array.',
    'before' => ':Attribute harus be a date before :date.',
    'before_or_equal' => ':Attribute harus be a date before or equal to :date.',
    'between' => [
        'array' => ':Attribute harus have between :min and :max items.',
        'file' => ':Attribute harus be between :min and :max kilobytes.',
        'numeric' => ':Attribute harus be between :min and :max.',
        'string' => ':Attribute harus be between :min and :max characters.',
    ],
    'boolean' => 'Bidang :attribute harus true or false.',
    'confirmed' => ':Attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'date_equals' => ':Attribute harus be a date equal to :date.',
    'date_format' => ':Attribute does not match the format :format.',
    'declined' => ':Attribute harus be declined.',
    'declined_if' => ':Attribute harus be declined when :other is :value.',
    'different' => ':Attribute and :other harus different.',
    'digits' => ':Attribute harus be :digits digits.',
    'digits_between' => ':Attribute harus be between :min and :max digits.',
    'dimensions' => ':Attribute has invalid image dimensions.',
    'distinct' => 'Bidang :attribute has a duplicate value.',
    'doesnt_end_with' => ':Attribute may not end with one of the following: :values.',
    'doesnt_start_with' => ':Attribute may not start with one of the following: :values.',
    'email' => ':Attribute harus be a valid email address.',
    'ends_with' => ':Attribute harus end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => ':Attribute harus be a file.',
    'filled' => 'Bidang :attribute must have a value.',
    'gt' => [
        'array' => ':Attribute harus have more than :value items.',
        'file' => ':Attribute harus be greater than :value kilobytes.',
        'numeric' => ':Attribute harus be greater than :value.',
        'string' => ':Attribute harus be greater than :value characters.',
    ],
    'gte' => [
        'array' => ':Attribute harus have :value items or more.',
        'file' => ':Attribute harus be greater than or equal to :value kilobytes.',
        'numeric' => ':Attribute harus be greater than or equal to :value.',
        'string' => ':Attribute harus be greater than or equal to :value characters.',
    ],
    'image' => ':Attribute harus harus sebuah image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'Bidang :attribute does not exist in :other.',
    'integer' => ':Attribute harus harus sebuah integer.',
    'ip' => ':Attribute harus be a valid IP address.',
    'ipv4' => ':Attribute harus be a valid IPv4 address.',
    'ipv6' => ':Attribute harus be a valid IPv6 address.',
    'json' => ':Attribute harus be a valid JSON string.',
    'lt' => [
        'array' => ':Attribute harus have less than :value items.',
        'file' => ':Attribute harus be less than :value kilobytes.',
        'numeric' => ':Attribute harus be less than :value.',
        'string' => ':Attribute harus be less than :value characters.',
    ],
    'lte' => [
        'array' => ':Attribute harus not have more than :value items.',
        'file' => ':Attribute harus be less than or equal to :value kilobytes.',
        'numeric' => ':Attribute harus be less than or equal to :value.',
        'string' => ':Attribute harus be less than or equal to :value characters.',
    ],
    'mac_address' => ':Attribute harus be a valid MAC address.',
    'max' => [
        'array' => ':Attribute harus not have more than :max items.',
        'file' => ':Attribute harus not be greater than :max kilobytes.',
        'numeric' => ':Attribute harus not be greater than :max.',
        'string' => ':Attribute harus not be greater than :max characters.',
    ],
    'max_digits' => ':Attribute harus not have more than :max digits.',
    'mimes' => ':Attribute harus be a file of type: :values.',
    'mimetypes' => ':Attribute harus be a file of type: :values.',
    'min' => [
        'array' => ':Attribute harus have at least :min items.',
        'file' => ':Attribute harus be at least :min kilobytes.',
        'numeric' => ':Attribute harus be at least :min.',
        'string' => ':Attribute harus be at least :min characters.',
    ],
    'min_digits' => ':Attribute harus have at least :min digits.',
    'multiple_of' => ':Attribute harus be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => ':Attribute format is invalid.',
    'numeric' => ':Attribute harus be a number.',
    'password' => [
        'letters' => ':Attribute harus mengandung at least one letter.',
        'mixed' => ':Attribute harus mengandung at least one uppercase and one lowercase letter.',
        'numbers' => ':Attribute harus mengandung at least one number.',
        'symbols' => ':Attribute harus mengandung at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'Bidang :attribute harus present.',
    'prohibited' => 'Bidang :attribute is prohibited.',
    'prohibited_if' => 'Bidang :attribute is prohibited when :other is :value.',
    'prohibited_unless' => 'Bidang :attribute is prohibited unless :other is in :values.',
    'prohibits' => 'Bidang :attribute prohibits :other from being present.',
    'regex' => ':Attribute format is invalid.',
    'required' => 'Bidang :attribute is required.',
    'required_array_keys' => 'Bidang :attribute must mengandung entries for: :values.',
    'required_if' => 'Bidang :attribute is required when :other is :value.',
    'required_if_accepted' => 'Bidang :attribute is required when :other is accepted.',
    'required_unless' => 'Bidang :attribute is required unless :other is in :values.',
    'required_with' => 'Bidang :attribute is required when :values is present.',
    'required_with_all' => 'Bidang :attribute is required when :values are present.',
    'required_without' => 'Bidang :attribute is required when :values is not present.',
    'required_without_all' => 'Bidang :attribute is required when none of :values are present.',
    'same' => ':Attribute and :other must match.',
    'size' => [
        'array' => ':Attribute harus mengandung :size items.',
        'file' => ':Attribute harus be :size kilobytes.',
        'numeric' => ':Attribute harus be :size.',
        'string' => ':Attribute harus be :size characters.',
    ],
    'starts_with' => ':Attribute harus start with one of the following: :values.',
    'string' => ':Attribute harus be a string.',
    'timezone' => ':Attribute harus be a valid timezone.',
    'unique' => ':Attribute has already been taken.',
    'uploaded' => ':Attribute failed to upload.',
    'url' => ':Attribute harus be a valid URL.',
    'uuid' => ':Attribute harus be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
