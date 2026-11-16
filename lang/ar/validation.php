<?php

return [

    /*
    |--------------------------------------------------------------------------
    | رسائل التحقق من صحة المدخلات (Validation Language Lines - Arabic)
    |--------------------------------------------------------------------------
    |
    | السطور التالية تحتوي على رسائل الخطأ الافتراضية لقواعد التحقق (Validator)
    | باللغة العربية الفصحى الواضحة والمهنية لجميع نماذج النظام.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other هو :value.',
    'active_url' => 'حقل :attribute لا يمثل رابطاً صحيحاً.',
    'after' => 'يجب أن يكون :attribute تاريخاً لاحقاً لتاريخ :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخاً لاحقاً أو مطابقاً لتاريخ :date.',
    'alpha' => 'يجب أن يحتوي حقل :attribute على حروف فقط.',
    'alpha_dash' => 'يجب أن يحتوي حقل :attribute على حروف وأرقام وشرطات فقط.',
    'alpha_num' => 'يجب أن يحتوي حقل :attribute على حروف وأرقام فقط.',
    'any_of' => 'قيمة حقل :attribute غير صحيحة.',
    'array' => 'يجب أن يكون حقل :attribute مصفوفة.',
    'ascii' => 'يجب أن يحتوي حقل :attribute على رموز وحروف أحادية البايت فقط.',
    'before' => 'يجب أن يكون :attribute تاريخاً سابقاً لتاريخ :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخاً سابقاً أو مطابقاً لتاريخ :date.',
    'between' => [
        'array' => 'يجب أن يحتوي حقل :attribute على عدد عناصر بين :min و :max.',
        'file' => 'يجب أن يكون حجم ملف :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string' => 'يجب أن يتراوح عدد حروف :attribute بين :min و :max حرفاً.',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما نعم أو لا (صحيح أو خطأ).',
    'can' => 'حقل :attribute يحتوي على قيمة غير مصرح بها.',
    'confirmed' => 'حقل تأكيد :attribute غير متطابق.',
    'contains' => 'حقل :attribute يفتقر إلى قيمة مطلوبة.',
    'current_password' => 'كلمة المرور الحالية غير صحيحة.',
    'date' => 'حقل :attribute ليس تاريخاً صحيحاً.',
    'date_equals' => 'يجب أن يكون حقل :attribute تاريخاً مطابقاً لـ :date.',
    'date_format' => 'حقل :attribute لا يتطابق مع الصيغة المحددة :format.',
    'decimal' => 'يجب أن يحتوي حقل :attribute على :decimal خانات عشرية.',
    'declined' => 'يجب رفض حقل :attribute.',
    'declined_if' => 'يجب رفض حقل :attribute عندما يكون :other هو :value.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مختلفين.',
    'digits' => 'يجب أن يتكون حقل :attribute من :digits أرقام.',
    'digits_between' => 'يجب أن يتراوح عدد أرقام :attribute بين :min و :max أرقام.',
    'dimensions' => 'أبعاد الصورة في حقل :attribute غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_contain' => 'يجب ألا يحتوي حقل :attribute على أي من القيم التالية: :values.',
    'doesnt_end_with' => 'يجب ألا ينتهي حقل :attribute بأي من القيم التالية: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ حقل :attribute بأي من القيم التالية: :values.',
    'email' => 'يجب أن يكون :attribute بريداً إلكترونياً صحيحاً.',
    'ends_with' => 'يجب أن ينتهي حقل :attribute بأحد القيم التالية: :values.',
    'enum' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'exists' => 'القيمة المحددة لـ :attribute غير موجودة في النظام.',
    'extensions' => 'يجب أن يحتوي ملف :attribute على أحد الامتدادات التالية: :values.',
    'file' => 'يجب أن يكون حقل :attribute ملفاً.',
    'filled' => 'حقل :attribute إجباري ولا يمكن تركه فارغاً.',
    'gt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يتجاوز حجم ملف :attribute :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'string' => 'يجب أن يزيد طول نص :attribute عن :value حروف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :value عناصر أو أكثر.',
        'file' => 'يجب أن يكون حجم ملف :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من أو تساوي :value.',
        'string' => 'يجب أن يكون طول نص :attribute أكبر من أو يساوي :value حروف.',
    ],
    'hex_color' => 'يجب أن يكون حقل :attribute لوناً سداسياً عشرياً صحيحاً.',
    'image' => 'يجب أن يكون حقل :attribute صورة.',
    'in' => 'قيمة حقل :attribute المختارة غير صالحة.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون حقل :attribute عدداً صحيحاً.',
    'ip' => 'يجب أن يكون حقل :attribute عنوان IP صحيحاً.',
    'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صحيحاً.',
    'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صحيحاً.',
    'json' => 'يجب أن يكون حقل :attribute نصاً بصيغة JSON صحيحة.',
    'lowercase' => 'يجب أن تكون حروف حقل :attribute صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value عناصر.',
        'file' => 'يجب أن يقل حجم ملف :attribute عن :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أصغر من :value.',
        'string' => 'يجب أن يقل طول نص :attribute عن :value حروف.',
    ],
    'lte' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :value عناصر.',
        'file' => 'يجب ألا يتجاوز حجم ملف :attribute :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أصغر من أو تساوي :value.',
        'string' => 'يجب ألا يتجاوز طول نص :attribute :value حروف.',
    ],
    'mac_address' => 'يجب أن يكون حقل :attribute عنوان MAC صحيحاً.',
    'max' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max عناصر.',
        'file' => 'يجب ألا يتجاوز حجم ملف :attribute :max كيلوبايت.',
        'numeric' => 'يجب ألا تكون قيمة :attribute أكبر من :max.',
        'string' => 'يجب ألا يتجاوز طول نص :attribute :max حرفاً.',
    ],
    'max_digits' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون ملف :attribute من نوع: :values.',
    'mimetypes' => 'يجب أن يكون ملف :attribute من نوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :min عناصر على الأقل.',
        'file' => 'يجب أن يكون حجم ملف :attribute :min كيلوبايت على الأقل.',
        'numeric' => 'يجب أن تكون قيمة :attribute :min على الأقل.',
        'string' => 'يجب أن يتكون نص :attribute من :min حروف على الأقل.',
    ],
    'min_digits' => 'يجب أن يحتوي حقل :attribute على :min أرقام على الأقل.',
    'missing' => 'يجب أن يكون حقل :attribute مفقوداً أو غير مرسل.',
    'multiple_of' => 'يجب أن تكون قيمة :attribute مضاعفاً للعدد :value.',
    'not_in' => 'قيمة حقل :attribute المختارة غير صالحة.',
    'not_regex' => 'صيغة حقل :attribute غير صحيحة.',
    'numeric' => 'يجب أن يكون حقل :attribute رقماً.',
    'password' => [
        'letters' => 'يجب أن تحتوي كلمة المرور على حرف واحد على الأقل.',
        'mixed' => 'يجب أن تحتوي كلمة المرور على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'يجب أن تحتوي كلمة المرور على رقم واحد على الأقل.',
        'symbols' => 'يجب أن تحتوي كلمة المرور على رمز خاص واحد على الأقل.',
        'uncompromised' => 'كلمة المرور المدخلة مسربة أمنياً في قواعد بيانات عامة، يرجى اختيار كلمة مرور أخرى.',
    ],
    'present' => 'يجب تقديم حقل :attribute.',
    'prohibited' => 'حقل :attribute محظور وممنوع إرساله.',
    'regex' => 'صيغة حقل :attribute غير صحيحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي حقل :attribute على مفاتيح لـ: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما يتم رفض :other.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_with_all' => 'حقل :attribute مطلوب عند وجود كل من :values.',
    'required_without' => 'حقل :attribute مطلوب عندما لا يكون :values متوفراً.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يتوفر أي من :values.',
    'same' => 'يجب أن يتطابق حقل :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :size عناصر بالضبط.',
        'file' => 'يجب أن يكون حجم ملف :attribute :size كيلوبايت بالضبط.',
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size.',
        'string' => 'يجب أن يتكون نص :attribute من :size حرفاً بالضبط.',
    ],
    'starts_with' => 'يجب أن يبدأ حقل :attribute بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون حقل :attribute نصاً.',
    'timezone' => 'يجب أن يكون حقل :attribute نطاقاً زمنياً صحيحاً.',
    'unique' => 'قيمة :attribute مستخدمة بالفعل، يرجى اختيار قيمة أخرى.',
    'uploaded' => 'فشل في رفع ملف :attribute.',
    'uppercase' => 'يجب أن تكون حروف حقل :attribute كبيرة.',
    'url' => 'يجب أن يكون حقل :attribute رابطاً إلكترونياً صحيحاً.',
    'uuid' => 'يجب أن يكون حقل :attribute معرف UUID صحيحاً.',

    /*
    |--------------------------------------------------------------------------
    | تخصيص رسائل معينة لحقول محددة (Custom Validation Rules)
    |--------------------------------------------------------------------------
    |
    | هنا يمكنك كتابة رسالة خاصة لحقل محدد، مثلاً:
    | 'email' => ['required' => 'يرجى تزويدنا ببريدك الإلكتروني للتواصل']
    |
    */

    'custom' => [
        'email' => [
            'required' => 'يرجى إدخال البريد الإلكتروني أو رقم الهاتف.',
        ],
        'password' => [
            'required' => 'يرجى إدخال كلمة المرور.',
            'min' => 'يجب ألا تقل كلمة المرور عن :min أحرف.',
        ],
        'phone' => [
            'required' => 'يرجى إدخال رقم الهاتف / الجوال.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | أسماء الحقول باللغة العربية (Custom Validation Attributes)
    |--------------------------------------------------------------------------
    |
    | استبدال أسماء الحقول الإنجليزية بالأسماء العربية الفصيحة ليظهر الخطأ:
    | "حقل البريد الإلكتروني مطلوب" بدلاً من "حقل email مطلوب"
    |
    */

    'attributes' => [
        'name' => 'الاسم الكامل',
        'full_name' => 'الاسم الكامل',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'current_password' => 'كلمة المرور الحالية',
        'phone' => 'رقم الهاتف',
        'role' => 'الدور / الرتبة',
        'avatar' => 'الصورة الشخصية',
        'code' => 'رمز التحقق',
        'recovery_code' => 'رمز الاسترداد',
        'remember' => 'تذكرني',

        // النطاق الطبي وإدارة المستشفى
        'specialization_id' => 'القسم الطبي / التخصص',
        'doctor_id' => 'الطبيب',
        'patient_id' => 'المريض',
        'appointment_date' => 'موعد الكشف',
        'appointment_time' => 'وقت الكشف',
        'notes' => 'الملاحظات',
        'address' => 'العنوان',
        'date_of_birth' => 'تاريخ الميلاد',
        'gender' => 'الجنس',
        'blood_group' => 'فصيلة الدم',
        'emergency_contact_name' => 'اسم جهة الاتصال في الطوارئ',
        'emergency_contact_phone' => 'هاتف جهة الاتصال في الطوارئ',
        'price' => 'السعر',
        'status' => 'الحالة',
        'description' => 'الوصف',
        'title' => 'العنوان',
        'is_active' => 'حالة التفعيل',
    ],

];
