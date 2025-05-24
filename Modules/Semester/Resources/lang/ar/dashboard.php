<?php

return [
    'semesters' => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'clinic'            => 'كلينك',
            'description'       => 'الوصف',
            'doctors'           => 'الدكتور',
            'image'             => 'الصورة',
            'is_news'           => 'المركز الاعلامي',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'trainer'            => 'المدرب',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان المقال',
            'type'              => 'نوع المقال',
            'video'             => ' الفيديو',
        ],
        'routes'    => [
            'create'    => 'اضافة المقالات',
            'index'     => 'المقالات',
            'update'    => 'تعديل المقال',
        ],
        'validation' => [
            'clinic_id'     => [
                'required'  => 'من فضلك اختر عيادة',
            ],
            'description'   => [
                'required'  => 'من فضلك ادخل الوصف',
            ],
            'doctor_id'     => [
                'required'  => 'من فضلك اختر دكتور',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان المقال',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
            'type_'         => [
                'required'  => 'من فضلك اختر نوع المقال',
            ],
        ],
    ],
];
