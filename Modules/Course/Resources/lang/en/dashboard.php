<?php

return [
    'courses' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'trainer' => 'trainer',
            'course_content' => 'course content',
            'title' => 'Title',
            'type' => 'type',
            'categories' => 'universities',
            'materials' => 'Materials',
        ],
        'days'  =>  [
            'sat'   =>  'Saturday',
            'sun'   =>  'Sunday',
            'mon'   =>  'Monday',
            'tue'   =>  'Tuesday',
            'wed'   =>  'Wednesday',
            'thu'   =>  'Thursday',
            'fri'   =>  'Friday',
        ],
        'form' => [
            'address' => 'Address of classes',
            'description' => 'Description',
            'image' => 'Image',
            'target' => 'target',
            'class_time' => 'class time',
            'expire_after' => 'Expire after / days number',
            'intro_video' => 'Intro Video',
            'is_certificated' => 'Is Certificated',
            'is_published' => 'Published',
            'lang' => 'longitude',
            'lat' => 'latitude',
            'level' => 'level',
            'map' => 'Map Embed iframe',
            'price' => 'Price',
            'requirements' => 'About course',
            'restore' => 'Restore from trash',
            'status' => 'Status',
            'university' => 'University',
            'materials' => 'Materials',
            'start_date' => 'start date',
            'end_date'   => 'end date',
            'latest' => 'added latest',
            'tabs' => [
                'categories' => 'universities',
                'gallery' => 'Gallery',
                'general' => 'General Info.',
                'targets' => 'targets',
                'schedule' => 'Course schedule'
            ],
            'available_days' => 'available days',
            'time' => 'time',
            'duration' => 'duration',
            'is_live' => 'live',
            'course_start_date' => 'Course Start Date',
            'genderTypes' => [
                'male' => 'male',
                'female' => 'female',
            ],
            'genderType' => 'gender type',
            'title' => 'Title',
            'trainers' => 'Trainer',
            'type' => 'In footer',
            'period' => 'Period (days number)',
            'short_desc' => ' short description',

            'end_at' => 'Offer End At',

            'offer' => 'Course Offer',
            'percentage' => 'Percentage',
            'offer_price' => 'Offer Price',
            'offer_status' => 'Offer Status',

            'start_at' => 'Offer Start At',

            'offer_type' => [
                'label' => 'Type',
                'amount' => 'Amount',
                'percentage' => 'Percentage',
            ],
        ],
        'routes' => [
            'create' => 'Create Courses',
            'index' => 'Courses',
            'update' => 'Update Course',
        ],

    ],
    'notes' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'trainer' => 'trainer',
            'course_content' => 'course content',
            'title' => 'Title',
            'type' => 'type',
            'category' => 'category',
        ],
        'form' => [
            'description' => 'Description',
            'image' => 'Image',
            'price' => 'Price',
            'restore' => 'Restore from trash',
            'status' => 'Status',
            'trainer' => 'trainer',
            'pdf' => 'pdf',
            'tabs' => [
                'categories' => 'universities',
                'general' => 'General Info.',
            ],
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Notes',
            'index' => 'Notes',
            'update' => 'Update Notes',
        ],

    ],
    'coursereviews' => [
        'datatable' => [
            'created_at' => 'created_at',
            'date_range' => 'date_range',
            'options'    => 'options',
            'status'     => 'status',
            'course'     => 'course',
            'user'       => 'user',
            'stars'      => 'stars',
        ],

        'form' => [
            'status' => 'status',
            'in_slider' => 'in slider',
            'desc'  => 'desc ',
            'answers' => 'answers',
            'yes' => 'yes',
            'no' => 'no',
            'stars' => 'stars',
            'tabs' => [
                'general' => 'General Info.',
            ],
        ],
        'routes' => [
            'index'  => 'courses reviews',
            'update' => 'edit courses reviews',
        ],

    ],
    'lessons' => [
        'datatable' => [
            'course' => 'Course',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'semester' => 'semester',

            'title' => 'Title',
        ],
        'form' => [
            'address' => 'Address of classes',
            'courses' => 'Course',
            'image' => 'Image',
            'semesters' => 'semesters',
            'desc'    => 'Description',
            'restore' => 'Restore from trash',
            'status' => 'Status',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Courses Lessons',
            'index' => 'Courses Lessons',
            'update' => 'Update Course Lesson',
        ],

    ],
    'videos' => [
        'video_status' => 'Video Status',
        'title' => 'Title',
        'loaded' => 'Loaded',
        'loading' => 'Loading',
        'failed' => 'Failed',
        'not_found' => 'Not Found',
    ],
    'lessoncontents' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'video_status' => 'Video Status',
            'title' => 'Title',
            'course'         => 'course',

            'loaded' => 'Loaded',
            'loading' => 'Loading',
            'failed' => 'Failed',
            'not_found' => 'Not Found',
            'lesson' => 'Lesson',
        ],
        'form' => [
            'address' => 'Address of classes',

            'image'   => 'Image',
            'is_certificated' => 'Is Certificated',
            'is_published' => 'Published',
            'restore' => 'Restore from trash',
            'start_date' => 'Start date',
            'start_time' => 'Start time',
            'status' => 'Status',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'exams' => 'exams',
            'trainers' => 'Trainers',
            'type' => 'type of content',
            'order' => 'order',
            'types' => [
                'resource' => 'file',
                'video'    => 'video link',
                'exam'         => 'exam',
                'pdf_files'         => 'Pdf Files',
            ],
            'lessons' => 'lessons',
        ],
        'routes' => [
            'create' => 'Create Lesson Content',
            'index' => 'Lesson Contents',
            'update' => 'Update Lesson Contents',
        ],

    ],
    'levels' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'title' => 'Title',
            'desc' => 'description',
            'short_desc' => 'short description',
            'loading' => 'Loading',
            'failed' => 'Failed',
            'not_found' => 'Not Found',
        ],
        'form' => [
            'desc' => 'Description',
            'short_desc' => 'Short Description',
            'image' => 'Image',
            'pdf' => 'pdf file',
            'restore' => 'Restore from trash',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'start_exam' => 'start level exam',
            'end_exam' => 'end level exam',
            'price' => 'السعر',
            'paid' => 'paid',
            'required_start_exam' => 'required start exam',
            'required_end_exam' => 'required end exam',
            'pdf' => ' pdf file',
            'restore' => 'restore',
            'status' => 'status',

            'requirements' => 'About course',
        ],
        'routes' => [
            'create' => 'Create level',
            'index' => 'levels',
            'update' => 'Update level',
        ],
    ],
    'reviewquestions' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'title' => 'Title',
            'desc' => 'description',
            'short_desc' => 'short description',
            'loading' => 'Loading',
            'failed' => 'Failed',
            'not_found' => 'Not Found',
        ],
        'form' => [
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',

            'status' => 'status',


        ],
        'routes' => [
            'create' => 'Create review questions',
            'index'  => 'review questions',
            'update' => 'Update review questions',
        ],
    ],
];
