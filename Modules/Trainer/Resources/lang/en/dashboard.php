<?php

return [
    'trainers'  => [
        'create'    => [
            'form'  => [
                'about'             => 'Description',
                'confirm_password'  => 'Confirm Password',
                'country'           => 'Country',
                'email'             => 'Email',
                'general'           => 'General Info.',
                'image'             => 'Profile Image',
                'info'              => 'Info.',
                'job_title'         => 'Job Title',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Password',
                'profile'           => 'Profile',
                'roles'             => 'Roles',
                'add_sliders'  => 'Add Sliders',
                'sliders'  => 'Sliders',
                'description'  => 'Description',
            ],
            'title' => 'Create Trainers',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Trainers',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Change Password',
                'roles'             => 'Roles',
                'add_sliders'  => 'Add Sliders',
                'sliders'  => 'Sliders',
                'description'  => 'Description',
            ],
            'title' => 'Update Trainers',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of trainer',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of trainer',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of trainer',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of trainer',
                'same'      => 'The Password confirmation not matching',
            ],
            'roles'     => [
                'required'  => 'Please select the role of trainer',
            ],
        ],
    ],

     'applies'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'cv'            => 'cv',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Apply As Instructor',
        ],
        'show'     => [
            'applier_data' => 'applier data',
        ],
        'routes'=>[
            'index' =>'Apply As Instructor',
            'show'  => 'show Apply As Instructor',
        ]


    ],
];
