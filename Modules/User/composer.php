<?php

// Dashboard ViewComposr
view()->composer([
  'company::dashboard.companies.*',
], \Modules\User\ViewComposers\Dashboard\UserComposer::class);
