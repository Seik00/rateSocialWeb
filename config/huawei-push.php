<?php

return [
  "APP_ID" => env('HW_PUSH_APP_ID'),
  "APP_SECRET" => env('HW_PUSH_APP_SECRET'),
  "TOKEN_URL" => env('HW_PUSH_TOKEN_URL', 'https://login.cloud.huawei.com/oauth2/v2/token'),
  "API_URL" => env('HW_PUSH_API_URL', 'https://push-api.cloud.huawei.com/v1/{appid}/messages:send'),
];