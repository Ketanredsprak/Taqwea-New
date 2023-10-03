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

    "accepted" => "تم القبول :attribute",
    "active_url" => " :attribute لا تمثّل رابطًا صحيحًا",
    "after" => "يجب على أن تكون  :attribute تاريخًا لاحقًا على :date ",
    "after_or_equal" => "يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.",
    "alpha" => "يجب ألا تحتوي  :attribute سوى على حروف",
    "alpha_dash" => "يجب ألا تحتوي  :attribute سوى على حروف وأرقام وشرطة تحتية فقط",
    "alpha_num" => "يجب ألا تحتوي  :attribute سوى على حروف وأرقام فقط",
    "array" => "يجب أن تكون  :attribute  مصفوفة",
    "before" => "يجب أن تكون  :attribute تاريخًا سابقًا على :date ",
    "before_or_equal" => "يجب أن تكون  :attribute تاريخًا سابقًا على أو مساويًا :date " ,
    'between' => [
        "numeric" => "يجب أن تكون سمة :attribute بين :min و :max.",
        "file" => "يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.",
        "string" => "يجب أن يكون :Attribute بين :min و :max حرفًا.",
        "array" => "يجب أن يحتوي :attribute على ما بين :min و :max من العناصر." ,
    ],
    "boolean" => "يجب أن يكون الحقل :attribute صوابًا أو خطأً.",
    "confirmed" => "تأكيد  :attribute غير متطابق",
    "date" => " :attribute ليست تاريخًا صحيحًا",
    "date_equals" => "يجب أن يكون :attribute تاريخًا مساويًا لـ :date",
    "date_format" => " لا يطابق :attribute التنسيق :format.",
    "different" => "يجب أن يكون :attribute و :other مختلفين.",
    "digits" => "يجب أن يكون :attribute :digits digits",
    "digits_between" => "يجب أن تكون السمة :attribute بين :min و:max أرقام",
    "dimensions" => "تحتوي   :attribute على أبعاد صورة غير صحيحة",
    "distinct" => "يحتوي حقل  :attribute قيمة مُكرّرة.",
    "email" => "يجب أن تكون  :attribute بريدًا الكترونيا صحيحًا",
    "ends_with" => "يجب أن ينتهي :attribute بأحد العناصر التالية :values    ",
    "exists" => "الـسمة التي تم إدخالها غير موجودة",
    "file" => "يجب أن تكون  :attribute ملف",
    "filled" => "حقل  :attribute يجب أن يحتوي على قيمة" ,
    'gt' => [
        "numeric" => "يجب أن تكون سمة :attribute أكبر من :value.",
        "file" => "يجب أن يكون حجم :attribute أكبر من :value كيلوبايت.",
        "string" => "يجب أن تكون سمة :attribute أكبر من :value حرفاً",
        "array" => "يجب أن يحتوي :attribute على أكثر :from عناصر value" ,
    ],
    'gte' => [
        "numeric" => "يجب أن يكون :attribute أكبر من أو يساوي :value",
        "file" => "يجب أن يكون :attribute أكبر من أو يساوي :value كيلوبايت",
        "string" => "يجب أن يكون :attribute أكبر من أو يساوي :value أحرف",
        "array" => "يجب أن يحتوي :attributrte على :value من العناصر أو أكثر"
    ],
    "image" => "يجب أن تكون  :attribute صورة",
    "in" => " :attribute المختارة غير صحيحة",
    "in_array" => "الحقل:attribute غير موجود في:other.",
    "integer" => "يجب أن تكون  :attribute عددًا صحيحًا",
    "ip" => "يجب أن تكون  :attribute عنوان IP صحيح",
    "ipv4" => "يجب أن تكون  :attribute عنوان بروتوكول الإنترنت صحيح من الإصدار الرابع ",
    "ipv6" => "يجب أن تكون  :attribute عنوان صحيح بروتوكول الإنترنت من  الإصدار السادس صحيح",
    "json" => "يجب أن تكون  :attribute سلسة جاسون صحيحة",
    'lt' => [
        "numeric" => "يجب أن يكون :attribute أقل من :value.",
        "file" => "يجب أن يكون :attribute أقل من :value كيلوبايت",
        "string" => "يجب أن يكون :attribute أقل من :value حرفا",
        "array" => "يجب أن يحتوي :attribute على أقل من :value  من العناصر",
    ],
    'lte' => [
        "numeric" => "يجب أن يكون :attribute أقل من أو يساوي :value ",
        "file" => "يجب أن يكون :attribute أقل من أو يساوي :value كيلوبايت",
        "string" => "يجب أن يكون :attribute أقل من أو يساوي :value الأحرف",
        "array" => "يجب ألا يحتوي :attribute على أكثر من :value  من العناصر" ,
    ],
    'max' => [
        "numeric" => "قد لا يكون :attribute أكبر من :max",
        "file" => "قد لا يكون :attribute أكبر من :max كيلوبايت.",
        "string" => "يجب ألا يكون :attribute أكبر من :max حرفاً",
        "array" => "لا يجوز أن يحتوي :attribute على أكثر من :max من العناصر" ,
    ],
    "mimes" => "يجب أن يكون attribute: ملفًا من النوع :values",
    "mimetypes" => "يجب أن يكون attribute: ملفًا من النوع :values",
    "min" => [
         "numeric" => "يجب أن تكون قيمة :attribute على الأقل :min",
         "file" => "يجب أن تكون قيمة :attribute على الأقل :min كيلوبايت",
         "string" => "يجب ألا يقل عدد أحرف :attribute عن :min من الأحرف",
         "array" => "يجب أن يحتوي :attribute على الأقل على :min من العناصر"
      ],
    "not_in" => "المختار :attribute غير صحيحة",
    "not_regex" => "تنسيق  :attribute غير صحيح",
    "numeric" => "يجب أن تكون  :attribute رقم.",
    "password" => "كلمة المرور غير صحيحة",
    "present" => "يجب أن يكون حقل  :attribute حاضرًا",
    "regex" => "تنسيق  :attribute غير صحيح",
    "required" => "الرجاء إدخال:attribute",
    "required_if" => "يكون حقل :attribute مطلوبًا عندما :other هو :value",
    "required_unless" => "يكون الحقل :attribute مطلوبًا ما لم :other في :value",
    "required_with" => "يكون حقل :attribute مطلوبًا عندما :values موجود",
    "required_with_all" => "يكون حقل :attribute مطلوبًا عندما :values موجودة",
    "required_without" => "يكون الحقل :attribute مطلوبًا عندما يكون :values غير موجود",
    "required_without_all" => "يكون حقل :attribute مطلوبًا في حالة عدم وجود أي من :values.",
    "same" => "يجب أن تتطابق السمة :attribute و :other",
    "size" => [
             "numeric" => "يجب أن يكون :attribute :size ",
             "file" => "يجب أن يكون :attribute :size كيلوبايت",
             "string" => "يجب أن يكون :attribute :size حرفًا",
             "array" => "يجب أن يحتوي :attribute على :size"
          ],
    "starts_with" => "يجب أن يبدأ:attribute بواحد مما يلي:values",
    "string" => "يجب أن تكون  :attribute سلسلة",
    "timezone" => "يجب أن تكون  :attribute منطقة صحيحة",
    "unique" => "لقد تم أخذ  :attribute بالفعل",
    "uploaded" => "لم ينجح رفع  :attribute",
    "url" => "تنسيق  :attribute غير صحيح",
    "uuid" => "يجب أن تكون  :attribute مُعرف فريد عالمي صحيح",
    "check_email_format" => "الرجاء إدخال عنوان بريد الكتروني صحيح",
    "check_email_exist" => "تم الإدخال :attribute موجودة بالفعل.",
    "not_register" => " :attribute غير مسجلة",
    "password_regex" => "الرجاء إدخال كلمة مرور من 8 أحرف وأرقام على الأقل مع 1 رمز مميز وو1 حرف كبير و1 رقم",
    "password_required" => "حقل كلمة المرور مطلوب",
    "otp_required" => "الرجاء إدخال كمة المرور لمرة واحدة صحيحة",
    "validate_new_password" => "لا يمكن أن تكون كلمة المرور الجديدة مثل القديمة.",
    "user_not_registered" => "المستخدم غير موجود بنفس أوراق الهوية.",
    "current_password_not_match" => "كلمة المرور الحالية غير صحيحة",
    "email_exist" => "البريد الالكتروني موجود بالفعل",
    "experience_required" => "الرجاء اختيار خبرة.",
    "select_required" => "يرجى تحديد :attribute",
    "terms_of_service_accepted" => "الرجاء الموافقة على شروط وأحكام تقوية",
    "referral_code_not_exists" => "الرمز المرجعي الذي تم إدخاله غير صحيح",
    "max_file" => " قد لا تكون السمة :attribute أكبر من :max :unit",
    "check_max_points" => "لا يمكن أن تكون النقاط أكبر من النقاط المتاحة.",
    "point_regex" => "يجب أن تكون النقاط مضاعفات الرقم 100.",
    "is_featured" => "يجب أن يكون يوم الميزة عددًا صحيحًا.",
    "class_hours" => "يجب أن تكون ساعات الفصل عوامة.",
    "webinar_hours" => "يجب أن تكون ساعات المحاضرة عائمة.",
    "subject" => "الرجاء تحديد الموضوع",
    "category" => "الرجاء تحديد الفئة",
    "class_without_all" => "يكون حقل ساعات الفصل الدراسي مطلوبًا في حالة عدم وجود أي من ساعات المحاضرة / البرامج التعليمية على الويب /",
    "two_decimal_regex" => "الرجاء إدخال قيمة عشرية مكونة من رقمين",


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
            "rule-name" => "رسالة-مخصصة",
        ],
        'amount' => [
            "regex" => "يجب أن يكون المبلغ من رقمين بعد العلامة العشرية.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
   
    'attributes' => [
        "name"                  => "الاسم",
        "en.name"               => "اسم",
        "username"              => "اسم المُستخدم",
        "email"                 => "البريد الالكتروني",
        "first_name"            => "الاسم الأول",
        "last_name"             => "اسم العائلة",
        "password"              => "كلمة المرور",
        "password_confirmation" => "تأكيد كلمة المرور",
        "city"                  => "المدينة",
        "country"               => "الدولة",
        "address"               => "عنوان السكن",
        "phone"                 => "الهاتف",
        "mobile"                => "الجوال",
        "age"                   => "العمر",
        "sex"                   => "الجنس",
        "gender"                => "النوع",
        "day"                   => "اليوم",
        "month"                 => "الشهر",
        "year"                  => "السنة",
        "hour"                  => "ساعة",
        "minute"                => "دقيقة",
        "second"                => "ثانية",
        "title"                 => "العنوان",
        "content"               => "المُحتوى",
        "description"           => "الوصف",
        "excerpt"               => "المُلخص",
        "date"                  => "التاريخ",
        "time"                  => "الوقت",
        "available"             => "مُتاح",
        "size"                  => "الحجم",
        "en.bio"                => "نبذة عنا",
        'en.name'               => 'اسم',
        "confirm_password"      => "تأكيد كلمة المرور",
        "blog_title"            => "عنوان المنتج",
        "blog_description"      => "وصف المنتج",
        "total_fees"            => "الرسوم الكلية",
        "current_password"      => "كلمة المرور الحالية",
        "new_password"          => "كلمة المرور الجديدة",
        "degree"                => "الدرجة العلمية",
        "university"            => "جامعة",
        "certificate_name"      => "اسم الشهادة",
        "en.class_description"  => "وصف",
        "en.class_name"         => "الاسم",
        "class_time"            => "الوقت",
        "class_date"            => "التاريخ",
        "en.blog_title"         => "عنوان المنتج",
        "en.blog_description"   => "وصف المنتج",
        "amount"                => "مقدار",
        "en.degree"             => "الدرجة العلمية",
        "en.university"         => "جامعة",
        "en.certificate_name"   => "اسم الشهادة",
        "min"                   => "دقيقة",
        "duration"              => "المدة",
        "extra_hour_charge"     => "رسوم ساعة إضافية",
        "en.topic_title"        => " لقب ",
        "en.topic_description"  => " جدول أعمال ",
        "sub_topics.*"          => " أبرز الخيار واحد على الأقل ",
        "phone_number"          => "رقم الهاتف المحمول",
        "category"              => "الفئة",
        "level"                 => "مستوى",
        "image"                 => "صورة",
        "card_type"             => "نوع البطاقة",
        "ar.degree"             => "اسم الدرجة العربية",
        "ar.university"         => "اسم الجامعة بالعربية",
        "ar.certificate_name"   => "اسم الشهادة بالعربية",
        "ar.bio"                => "نبذة عنا",
        "ar.name"               => "اسم",
        "user_role"             => "دور المستخدم",
        "class_image"           => "صورة",
        "category_id"           => "فئة",
        "subject_id"            => "موضوع",
        "level_id"              => "مستوى",
        "hourly_fees"           => "رسوم بالساعة",
        "empty"                 => "فارغة",
        "ar.class_name"         => "اسم عربي",
        "ar.class_description"  => "وصف عربي",
        "ar.blog_title"         => "عنوان المنتج بالعربية",
        "ar.blog_description"   => "وصف المنتج بالعربية",
        "media"                 => "وسائل الإعلام",
        "ar.topic_title"        => "عنوان عربي",
        "ar.topic_description"  => "أجندة عربية",
        "sub_topics_ar.*"       => "أبرز الخيار واحد على الأقل ",
        'review'                => 'مراجعة',
        'dispute_reason'        => 'سبب النزاع',
    ],
    'values' => [
        "empty" => "فارغة",
    ],
];
