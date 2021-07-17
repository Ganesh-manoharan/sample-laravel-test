<?php
use App\AppConst;
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

    'accepted' => 'Se debe aceptar el atributo :.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute debe ser una fecha posterior a: fecha.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'El :attribute debe ser una fecha posterior o igual a: fecha.',
    'alpha_dash' => 'El :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute solo puede contener letras y números.',
    'array' => 'El :attribute debe ser una matriz.',
    'before' => 'El :attribute debe ser una fecha anterior a: fecha.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a: fecha.',
    'between' => [
        'numeric' => 'El :attribute debe estar entre: min y: max.',
        'file' => 'El :attribute debe estar entre: min y: max kilobytes.',
        'string' => 'El :attribute debe estar entre: min y: max caracteres.',
        'array' => 'El :attribute debe tener entre: min y: max elementos.',
    ],
    'boolean' => 'El campo de :attribute debe ser verdadero o falso.',
    'confirmed' => 'La confirmación del :attribute no coincide.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a: fecha',
    'date_format' => 'El :attribute no coincide con el formato: formato.',
    'different' => 'El :attribute y: otro deben ser diferentes.',
    'digits' => 'El :attribute debe ser: dígitos dígitos.',
    'digits_between' => 'El :attribute debe estar entre: min y: max dígitos.',
    'dimensions' => 'El :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'El campo de :attribute tiene un valor duplicado.',
    'email' => 'El :attribute debe ser una dirección de correo electrónico válida.',
    'ends_with' => 'El :attribute debe terminar con uno de los siguientes valores::.',
    'exists' => AppConst::EXISTS,
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El campo de :attribute debe tener un valor.',
    'gt' => [
        'numeric' => 'El: atributo debe ser mayor que: valor.',
        'file' => 'El :attribute debe ser mayor que: valor kilobytes.',
        'string' => 'El :attribute debe ser mayor que los caracteres de valor.',
        'array' => 'El :attribute debe tener más de: elementos de valor.',
    ],
    'gte' => [
        'numeric' => 'El: atributo debe ser mayor o igual que: valor.',
        'file' => 'El :attribute debe ser mayor o igual que: valor kilobytes.',
        'string' => 'El :attribute debe ser mayor o igual que los caracteres de valor.',
        'array' => 'El :attribute debe tener: elementos de valor o más.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => AppConst::EXISTS,
    'in_array' => 'El campo de :attribute no existe en: otro.',
    'integer' => 'El :attribute debe ser un número entero.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El: atributo debe ser menor que: valor.',
        'file' => 'El :attribute debe ser menor que: valor kilobytes.',
        'string' => 'El :attribute debe tener menos de: valores de caracteres.',
        'array' => 'El :attribute debe tener elementos menores que: valor.',
    ],
    'lte' => [
        'numeric' => 'El: atributo debe ser menor o igual que: valor.',
        'file' => 'El :attribute debe ser menor o igual que: valor kilobytes.',
        'string' => 'El :attribute debe ser menor o igual que los caracteres de valor.',
        'array' => 'El :attribute no debe tener más de: elementos de valor.',
    ],
    'max' => [
        'numeric' => 'El :attribute no puede ser mayor que: máx.',
        'file' => 'El :attribute no puede ser mayor que: kilobytes máx.',
        'string' => 'El :attribute no puede ser mayor que: máximo de caracteres.',
        'array' => 'El :attribute no puede tener más de: max elementos.',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo:: valores.',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo:: valores.',
    'min' => [
        'numeric' => 'El :attribute debe ser al menos: min.',
        'file' => 'El :attribute debe tener al menos: min kilobytes.',
        'string' => 'El :attribute debe tener al menos: min caracteres.',
        'array' => 'El :attribute debe tener al menos: elementos mínimos.',
    ],
    'not_in' => AppConst::EXISTS,
    'not_regex' => AppConst::REGEX,
    'numeric' => 'El :attribute debe ser un número.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El campo de :attribute debe estar presente.',
    'regex' => AppConst::REGEX,
    'required' => 'El campo de :attribute es obligatorio.',
    'required_if' => 'El campo: atributo es obligatorio cuando: otro es: valor.',
    'required_unless' => 'El campo de :attribute es obligatorio a menos que: otro esté en: valore',
    'required_with' => 'El campo de :attribute es obligatorio cuando: valores está presente.',
    'required_with_all' => 'El campo de :attribute es obligatorio cuando: hay valores presentes.',
    'required_without' => 'El campo de :attribute es obligatorio cuando: valores no está presente.',
    'required_without_all' => 'El campo de :attribute es obligatorio cuando ninguno de los valores: está presente.',
    'same' => 'El :attribute y: otro deben coincidir.',
    'size' => [
        'numeric' => 'El :attribute debe ser: tamaño.',
        'file' => 'El :attribute debe ser: tamaño kilobytes.',
        'string' => 'El :attribute debe tener: caracteres de tamaño.',
        'array' => 'El :attribute debe contener: artículos de tamaño.',
    ],
    'starts_with' => 'El :attribute debe comenzar con uno de los siguientes valores::.',
    'string' => 'El :attribute debe ser una cadena.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => 'El :attribute ya se ha tomado.',
    'uploaded' => 'El :attribute no se pudo cargar.',
    'url' => AppConst::REGEX,
    'uuid' => 'El :attribute debe ser un UUID válido.',

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

    'attributes' => [
        'email_hash' => 'Email'
    ],

];
