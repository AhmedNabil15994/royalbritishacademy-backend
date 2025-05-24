<?php

view()->composer([
  'apps::dashboard.index',
], \Modules\Order\ViewComposers\Dashboard\OrderComposer::class);


view()->composer([
  'order::dashboard.orders.index',
], \Modules\Order\ViewComposers\Dashboard\OrderStatusComposer::class);
