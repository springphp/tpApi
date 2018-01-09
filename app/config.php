<?php

// 所有配置
$config             = @include APP_PATH.'/common/config/config.php';
$config['database'] = @include APP_PATH.'/common/config/database.php';

return $config;
