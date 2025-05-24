

{!! field()->select('system','system',[
    'android' => 'android',
    'ios' => 'ios',
]) !!}
{!! field()->text('version', 'version') !!}

{!! field()->checkBox('production_status', 'production_status') !!}
{!! field()->checkBox('last_version', 'last_version') !!}
{!! field()->checkBox('force_update', 'force_update') !!}