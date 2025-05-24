<?php

return [
    'categories'        => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'image'             => 'الصورة',
            'color'             => 'اللون',
            'main_category'     => 'قسم رئيسي',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'restore'            => 'إسترجاع',
            'tabs'              => [
                'category_level'    => 'مستوى الاقسام',
                'general'           => 'بيانات عامة',
                'seo'               => 'SEO',
            ],
            'title'             => 'عنوان',
            'sort'              => 'الترتيب',
        ],
        'routes'    => [
            'create'    => 'اضافة ',
            'index'     => 'الجامعات',
            'update'    => 'تعديل ',
        ],
        'validation'=> [
            'category_id'   => [
                'required'  => 'من فضلك اختر مستوى القسم',
            ],
            'image'         => [
                'required'  => 'من فضلك اختر الصورة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'materials'        => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'image'             => 'الصورة',
            'color'             => 'اللون',
            'main_category'     => 'قسم رئيسي',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'restore'            => 'إسترجاع',
            'tabs'              => [
                'category_level'    => 'مستوى الاقسام',
                'general'           => 'بيانات عامة',
                'seo'               => 'SEO',
            ],
            'title'             => 'عنوان',
        ],
        'routes'    => [
            'create'    => 'اضافة ',
            'index'     => 'المواد',
            'update'    => 'تعديل ',
        ],
        'validation'=> [
            'category_id'   => [
                'required'  => 'من فضلك اختر مستوى القسم',
            ],
            'image'         => [
                'required'  => 'من فضلك اختر الصورة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
