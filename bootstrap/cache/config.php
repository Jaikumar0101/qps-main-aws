<?php return array (
  'app' => 
  array (
    'name' => 'QPS Claims Portal',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'asset_url' => NULL,
    'allowed_file_extension' => 
    array (
      0 => 'xlsx',
      1 => 'doc',
      2 => 'docx',
      3 => 'ppt',
      4 => 'pptx',
      5 => 'ods',
      6 => 'odt',
      7 => 'odp',
      8 => 'csv',
      9 => 'xls',
      10 => 'pdf',
      11 => 'jpg',
      12 => 'jpeg',
      13 => 'png',
      14 => 'gif',
      15 => 'svg',
      16 => 'ico',
      17 => 'webp',
      18 => 'mpeg',
      19 => 'mp4',
      20 => 'avi',
      21 => 'flv',
      22 => 'wmv',
      23 => 'mpg',
      24 => '3gp',
    ),
    'timezone' => 'Asia/Kolkata',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:golxqW84kctwScSTpbS+yaenJ0/do/p9obdRTmIZLtc=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\RouteServiceProvider',
      26 => 'App\\Providers\\ComponentServiceProvider',
      27 => 'App\\Providers\\SettingServiceProvider',
      28 => 'UniSharp\\LaravelFilemanager\\LaravelFilemanagerServiceProvider',
      29 => 'Torann\\Currency\\CurrencyServiceProvider',
      30 => 'Srmklive\\PayPal\\Providers\\PayPalServiceProvider',
      31 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      32 => 'Barryvdh\\DomPDF\\ServiceProvider',
      33 => 'Rap2hpoutre\\LaravelLogViewer\\LaravelLogViewerServiceProvider',
      34 => 'Mews\\Captcha\\CaptchaServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Currency' => 'Torann\\Currency\\Facades\\Currency',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'PayPal' => 'Srmklive\\PayPal\\Facades\\PayPal',
      'Captcha' => 'Mews\\Captcha\\Facades\\Captcha',
      'AdminBreadCrumb' => 'App\\Helpers\\Admin\\Breadcrumb',
      'AdminTheme' => 'App\\Helpers\\Admin\\AdminTheme',
      'BackendHelper' => 'App\\Helpers\\Admin\\BackendHelper',
      'Role' => 'App\\Helpers\\Role\\RoleHelper',
      'ClaimHelper' => 'App\\Helpers\\ClaimHelper',
      'FilterHelper' => 'App\\Helpers\\Claims\\ClaimFilterHelper',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'useTLS' => true,
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => 'qps_claims_portal_cache',
  ),
  'captcha' => 
  array (
    'disable' => false,
    'characters' => 
    array (
      0 => '2',
      1 => '3',
      2 => '4',
      3 => '6',
      4 => '7',
      5 => '8',
      6 => '9',
      7 => 'a',
      8 => 'b',
      9 => 'c',
      10 => 'd',
      11 => 'e',
      12 => 'f',
      13 => 'g',
      14 => 'h',
      15 => 'j',
      16 => 'm',
      17 => 'n',
      18 => 'p',
      19 => 'q',
      20 => 'r',
      21 => 't',
      22 => 'u',
      23 => 'x',
      24 => 'y',
      25 => 'z',
      26 => 'A',
      27 => 'B',
      28 => 'C',
      29 => 'D',
      30 => 'E',
      31 => 'F',
      32 => 'G',
      33 => 'H',
      34 => 'J',
      35 => 'M',
      36 => 'N',
      37 => 'P',
      38 => 'Q',
      39 => 'R',
      40 => 'T',
      41 => 'U',
      42 => 'X',
      43 => 'Y',
      44 => 'Z',
    ),
    'default' => 
    array (
      'length' => 9,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'math' => false,
      'expire' => 60,
      'encrypt' => false,
    ),
    'math' => 
    array (
      'length' => 9,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'math' => true,
    ),
    'flat' => 
    array (
      'length' => 6,
      'width' => 160,
      'height' => 46,
      'quality' => 90,
      'lines' => 6,
      'bgImage' => false,
      'bgColor' => 'rgba(0, 0, 0, 0)',
      'fontColors' => 
      array (
        0 => '#2c3e50',
        1 => '#c0392b',
        2 => '#16a085',
        3 => '#c0392b',
        4 => '#8e44ad',
        5 => '#303f9f',
        6 => '#f57c00',
        7 => '#795548',
      ),
      'contrast' => -5,
    ),
    'mini' => 
    array (
      'length' => 3,
      'width' => 60,
      'height' => 32,
    ),
    'inverse' => 
    array (
      'length' => 5,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'sensitive' => true,
      'angle' => 12,
      'sharpen' => 10,
      'blur' => 2,
      'invert' => true,
      'contrast' => -5,
    ),
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'csp' => 
  array (
    'policy' => 'App\\Security\\ContentPolicy',
    'report_only_policy' => '',
    'report_uri' => '',
    'enabled' => true,
    'nonce_generator' => 'Spatie\\Csp\\Nonce\\RandomString',
    'nonce_enabled' => true,
  ),
  'currency' => 
  array (
    'default' => 'USD',
    'api_key' => '',
    'driver' => 'database',
    'cache_driver' => NULL,
    'drivers' => 
    array (
      'database' => 
      array (
        'class' => 'Torann\\Currency\\Drivers\\Database',
        'connection' => NULL,
        'table' => 'currencies',
      ),
      'filesystem' => 
      array (
        'class' => 'Torann\\Currency\\Drivers\\Filesystem',
        'disk' => NULL,
        'path' => 'currencies.json',
      ),
    ),
    'formatter' => NULL,
    'formatters' => 
    array (
      'php_intl' => 
      array (
        'class' => 'Torann\\Currency\\Formatters\\PHPIntl',
      ),
    ),
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'insurance_claim_live',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'insurance_claim_live',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'insurance_claim_live',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'insurance_claim_live',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'qps_claims_portal_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'debugbar' => 
  array (
    'enabled' => false,
    'hide_empty_tabs' => true,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
      'path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\debugbar',
      'connection' => NULL,
      'provider' => '',
      'hostname' => '127.0.0.1',
      'port' => 2304,
    ),
    'editor' => 'phpstorm',
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'ajax_handler_auto_show' => true,
    'ajax_handler_enable_tab' => true,
    'defer_datasets' => false,
    'error_handler' => false,
    'error_level' => 32767,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => false,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => true,
      ),
      'db' => 
      array (
        'with_params' => true,
        'backtrace' => true,
        'backtrace_exclude_paths' => 
        array (
        ),
        'timeline' => false,
        'duration_background' => true,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => false,
        'show_copy' => false,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'timeline' => false,
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_middleware' => 
    array (
    ),
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'public_path' => NULL,
    'convert_entities' => true,
    'options' => 
    array (
      'font_dir' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\fonts',
      'font_cache' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\fonts',
      'temp_dir' => 'C:\\Users\\chauh\\AppData\\Local\\Temp',
      'chroot' => 'C:\\xampp\\htdocs\\qps-main-aws',
      'allowed_protocols' => 
      array (
        'file://' => 
        array (
          'rules' => 
          array (
          ),
        ),
        'http://' => 
        array (
          'rules' => 
          array (
          ),
        ),
        'https://' => 
        array (
          'rules' => 
          array (
          ),
        ),
      ),
      'log_output_file' => NULL,
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_paper_orientation' => 'portrait',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => true,
    ),
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
        'output_encoding' => '',
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' => 
      array (
        'formatter' => 'none',
      ),
      'csv' => 
      array (
        'delimiter' => NULL,
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
    ),
    'transactions' => 
    array (
      'handler' => 'db',
      'db' => 
      array (
        'connection' => NULL,
      ),
    ),
    'temporary_files' => 
    array (
      'local_path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\framework/cache/laravel-excel',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'public_uploads',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      'public_uploads' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\qps-main-aws\\public\\uploads',
        'url' => '/uploads',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
      ),
    ),
    'links' => 
    array (
      'C:\\xampp\\htdocs\\qps-main-aws\\public\\storage' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\app/public',
    ),
  ),
  'goutte' => 
  array (
    'client' => 
    array (
      'max_redirects' => 0,
    ),
  ),
  'hashids' => 
  array (
    'default' => 'main',
    'connections' => 
    array (
      'main' => 
      array (
        'salt' => '',
        'length' => 0,
      ),
      'alternative' => 
      array (
        'salt' => 'your-salt-string',
        'length' => 'your-length-integer',
      ),
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
    ),
  ),
  'larinfo' => 
  array (
    'converter' => 
    array (
      'precision' => 1,
      'use_binary' => true,
    ),
    'linfo' => 
    array (
      'show' => 
      array (
        'kernel' => true,
        'os' => true,
        'ram' => true,
        'mounts' => true,
        'webservice' => true,
        'phpversion' => true,
        'uptime' => true,
        'cpu' => true,
        'distro' => true,
        'model' => true,
        'virtualization' => true,
        'duplicate_mounts' => false,
        'mounts_options' => false,
      ),
    ),
  ),
  'lfm' => 
  array (
    'use_package_routes' => false,
    'allow_private_folder' => true,
    'private_folder_name' => 'UniSharp\\LaravelFilemanager\\Handlers\\ConfigHandler',
    'allow_shared_folder' => true,
    'shared_folder_name' => 'shares',
    'folder_categories' => 
    array (
      'file' => 
      array (
        'folder_name' => 'files',
        'startup_view' => 'list',
        'max_size' => 50000,
        'thumb' => true,
        'thumb_width' => 80,
        'thumb_height' => 80,
        'valid_mime' => 
        array (
          0 => 'image/jpeg',
          1 => 'image/pjpeg',
          2 => 'image/png',
          3 => 'image/gif',
          4 => 'application/pdf',
          5 => 'text/plain',
        ),
      ),
      'image' => 
      array (
        'folder_name' => 'photos',
        'startup_view' => 'grid',
        'max_size' => 50000,
        'thumb' => true,
        'thumb_width' => 80,
        'thumb_height' => 80,
        'valid_mime' => 
        array (
          0 => 'image/jpeg',
          1 => 'image/pjpeg',
          2 => 'image/png',
          3 => 'image/gif',
        ),
      ),
    ),
    'paginator' => 
    array (
      'perPage' => 30,
    ),
    'disk' => 'public_uploads',
    'rename_file' => false,
    'rename_duplicates' => true,
    'alphanumeric_filename' => false,
    'alphanumeric_directory' => false,
    'should_validate_size' => false,
    'should_validate_mime' => true,
    'over_write_on_duplicate' => false,
    'disallowed_mimetypes' => 
    array (
      0 => 'text/x-php',
      1 => 'text/html',
      2 => 'text/plain',
    ),
    'item_columns' => 
    array (
      0 => 'name',
      1 => 'url',
      2 => 'time',
      3 => 'icon',
      4 => 'is_file',
      5 => 'is_image',
      6 => 'thumb_url',
    ),
    'should_create_thumbnails' => true,
    'thumb_folder_name' => 'thumbs',
    'raster_mimetypes' => 
    array (
      0 => 'image/jpeg',
      1 => 'image/pjpeg',
      2 => 'image/png',
    ),
    'thumb_img_width' => 200,
    'thumb_img_height' => 200,
    'file_type_array' => 
    array (
      'pdf' => 'Adobe Acrobat',
      'doc' => 'Microsoft Word',
      'docx' => 'Microsoft Word',
      'xls' => 'Microsoft Excel',
      'xlsx' => 'Microsoft Excel',
      'zip' => 'Archive',
      'gif' => 'GIF Image',
      'jpg' => 'JPEG Image',
      'jpeg' => 'JPEG Image',
      'png' => 'PNG Image',
      'ppt' => 'Microsoft PowerPoint',
      'pptx' => 'Microsoft PowerPoint',
    ),
    'php_ini_overrides' => 
    array (
      'memory_limit' => '512M',
    ),
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Livewire',
    'view_path' => 'C:\\xampp\\htdocs\\qps-main-aws\\resources\\views/livewire',
    'layout' => 'layouts.admin.app',
    'lazy_placeholder' => NULL,
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' => 
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'smart_wire_keys' => false,
    'pagination_theme' => 'bootstrap',
    'release_token' => 'a',
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => NULL,
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'logviewer' => 
  array (
    'max_file_size' => 52428800,
    'pattern' => '*.log',
    'storage_path' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\logs',
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'mail.mathmindtrick.xyz',
        'port' => '465',
        'encryption' => 'SSL',
        'username' => 'no-reply@mathmindtrick.xyz',
        'password' => 'Zy0nQUvib',
        'timeout' => NULL,
        'auth_mode' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -t -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'no-reply@mathmindtrick.xyz',
      'name' => 'QPS Claims Portal',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\xampp\\htdocs\\qps-main-aws\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'token_prefix' => '',
    'middleware' => 
    array (
      'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
      'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '240',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'qps_claims_portal_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'user-monitoring' => 
  array (
    'config' => 
    array (
      'routes' => 
      array (
        'file_path' => 'routes/user-monitoring.php',
      ),
      'dark_mode' => false,
    ),
    'user' => 
    array (
      'model' => 'App\\Models\\User',
      'foreign_key' => 'user_id',
      'table' => 'users',
      'guard' => 'web',
      'foreign_key_type' => 'id',
    ),
    'visit_monitoring' => 
    array (
      'table' => 'visits_monitoring',
      'turn_on' => false,
      'expect_pages' => 
      array (
      ),
      'delete_days' => 0,
    ),
    'action_monitoring' => 
    array (
      'table' => 'actions_monitoring',
      'on_store' => true,
      'on_update' => true,
      'on_destroy' => true,
      'on_read' => true,
      'on_restore' => false,
      'on_replicate' => false,
    ),
    'authentication_monitoring' => 
    array (
      'table' => 'authentications_monitoring',
      'delete_user_record_when_user_delete' => true,
      'on_login' => true,
      'on_logout' => true,
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\xampp\\htdocs\\qps-main-aws\\resources\\views',
    ),
    'compiled' => 'C:\\xampp\\htdocs\\qps-main-aws\\storage\\framework\\views',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'flare' => 
  array (
    'key' => NULL,
    'flare_middleware' => 
    array (
      0 => 'Spatie\\FlareClient\\FlareMiddleware\\RemoveRequestIp',
      1 => 'Spatie\\FlareClient\\FlareMiddleware\\AddGitInformation',
      2 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddNotifierName',
      3 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddEnvironmentInformation',
      4 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionInformation',
      5 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddDumps',
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddLogs' => 
      array (
        'maximum_number_of_collected_logs' => 200,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddQueries' => 
      array (
        'maximum_number_of_collected_queries' => 200,
        'report_query_bindings' => true,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddJobs' => 
      array (
        'max_chained_job_reporting_depth' => 5,
      ),
      6 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddContext',
      7 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionHandledStatus',
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestBodyFields' => 
      array (
        'censor_fields' => 
        array (
          0 => 'password',
          1 => 'password_confirmation',
        ),
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestHeaders' => 
      array (
        'headers' => 
        array (
          0 => 'API-KEY',
          1 => 'Authorization',
          2 => 'Cookie',
          3 => 'Set-Cookie',
          4 => 'X-CSRF-TOKEN',
          5 => 'X-XSRF-TOKEN',
        ),
      ),
    ),
    'send_logs_as_events' => true,
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'auto',
    'enable_share_button' => true,
    'register_commands' => false,
    'solution_providers' => 
    array (
      0 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\BadMethodCallSolutionProvider',
      1 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\MergeConflictSolutionProvider',
      2 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\UndefinedPropertySolutionProvider',
      3 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\IncorrectValetDbCredentialsSolutionProvider',
      4 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingAppKeySolutionProvider',
      5 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\DefaultDbNameSolutionProvider',
      6 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\TableNotFoundSolutionProvider',
      7 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingImportSolutionProvider',
      8 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\InvalidRouteActionSolutionProvider',
      9 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\ViewNotFoundSolutionProvider',
      10 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\RunningLaravelDuskInProductionProvider',
      11 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingColumnSolutionProvider',
      12 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownValidationSolutionProvider',
      13 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingMixManifestSolutionProvider',
      14 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingViteManifestSolutionProvider',
      15 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingLivewireComponentSolutionProvider',
      16 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UndefinedViewVariableSolutionProvider',
      17 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\GenericLaravelExceptionSolutionProvider',
      18 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\OpenAiSolutionProvider',
      19 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\SailNetworkSolutionProvider',
      20 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownMysql8CollationSolutionProvider',
      21 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownMariadbCollationSolutionProvider',
    ),
    'ignored_solution_providers' => 
    array (
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => 'C:\\xampp\\htdocs\\qps-main-aws',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
    'settings_file_path' => '',
    'recorders' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\Recorders\\DumpRecorder\\DumpRecorder',
      1 => 'Spatie\\LaravelIgnition\\Recorders\\JobRecorder\\JobRecorder',
      2 => 'Spatie\\LaravelIgnition\\Recorders\\LogRecorder\\LogRecorder',
      3 => 'Spatie\\LaravelIgnition\\Recorders\\QueryRecorder\\QueryRecorder',
    ),
    'open_ai_key' => NULL,
    'with_stack_frame_arguments' => true,
    'argument_reducers' => 
    array (
      0 => 'Spatie\\Backtrace\\Arguments\\Reducers\\BaseTypeArgumentReducer',
      1 => 'Spatie\\Backtrace\\Arguments\\Reducers\\ArrayArgumentReducer',
      2 => 'Spatie\\Backtrace\\Arguments\\Reducers\\StdClassArgumentReducer',
      3 => 'Spatie\\Backtrace\\Arguments\\Reducers\\EnumArgumentReducer',
      4 => 'Spatie\\Backtrace\\Arguments\\Reducers\\ClosureArgumentReducer',
      5 => 'Spatie\\Backtrace\\Arguments\\Reducers\\DateTimeArgumentReducer',
      6 => 'Spatie\\Backtrace\\Arguments\\Reducers\\DateTimeZoneArgumentReducer',
      7 => 'Spatie\\Backtrace\\Arguments\\Reducers\\SymphonyRequestArgumentReducer',
      8 => 'Spatie\\LaravelIgnition\\ArgumentReducers\\ModelArgumentReducer',
      9 => 'Spatie\\LaravelIgnition\\ArgumentReducers\\CollectionArgumentReducer',
      10 => 'Spatie\\Backtrace\\Arguments\\Reducers\\StringableArgumentReducer',
    ),
  ),
  'paypal' => 
  array (
    'mode' => 'live',
    'sandbox' => 
    array (
      'client_id' => '',
      'client_secret' => '',
      'app_id' => 'APP-80W284485P519543T',
    ),
    'live' => 
    array (
      'client_id' => '',
      'client_secret' => '',
      'app_id' => '',
    ),
    'payment_action' => 'Sale',
    'currency' => 'USD',
    'notify_url' => '',
    'locale' => 'en_US',
    'validate_ssl' => true,
  ),
  'lfm-config' => 
  array (
    'use_package_routes' => true,
    'allow_private_folder' => true,
    'private_folder_name' => 'UniSharp\\LaravelFilemanager\\Handlers\\ConfigHandler',
    'allow_shared_folder' => true,
    'shared_folder_name' => 'shares',
    'folder_categories' => 
    array (
      'file' => 
      array (
        'folder_name' => 'files',
        'startup_view' => 'list',
        'max_size' => 50000,
        'thumb' => true,
        'thumb_width' => 80,
        'thumb_height' => 80,
        'valid_mime' => 
        array (
          0 => 'image/jpeg',
          1 => 'image/pjpeg',
          2 => 'image/png',
          3 => 'image/gif',
          4 => 'application/pdf',
          5 => 'text/plain',
        ),
      ),
      'image' => 
      array (
        'folder_name' => 'photos',
        'startup_view' => 'grid',
        'max_size' => 50000,
        'thumb' => true,
        'thumb_width' => 80,
        'thumb_height' => 80,
        'valid_mime' => 
        array (
          0 => 'image/jpeg',
          1 => 'image/pjpeg',
          2 => 'image/png',
          3 => 'image/gif',
        ),
      ),
    ),
    'paginator' => 
    array (
      'perPage' => 30,
    ),
    'disk' => 'public',
    'rename_file' => false,
    'rename_duplicates' => false,
    'alphanumeric_filename' => false,
    'alphanumeric_directory' => false,
    'should_validate_size' => false,
    'should_validate_mime' => true,
    'over_write_on_duplicate' => false,
    'disallowed_mimetypes' => 
    array (
      0 => 'text/x-php',
      1 => 'text/html',
      2 => 'text/plain',
    ),
    'disallowed_extensions' => 
    array (
      0 => 'php',
      1 => 'html',
    ),
    'item_columns' => 
    array (
      0 => 'name',
      1 => 'url',
      2 => 'time',
      3 => 'icon',
      4 => 'is_file',
      5 => 'is_image',
      6 => 'thumb_url',
    ),
    'should_create_thumbnails' => true,
    'thumb_folder_name' => 'thumbs',
    'raster_mimetypes' => 
    array (
      0 => 'image/jpeg',
      1 => 'image/pjpeg',
      2 => 'image/png',
    ),
    'thumb_img_width' => 200,
    'thumb_img_height' => 200,
    'file_type_array' => 
    array (
      'pdf' => 'Adobe Acrobat',
      'doc' => 'Microsoft Word',
      'docx' => 'Microsoft Word',
      'xls' => 'Microsoft Excel',
      'xlsx' => 'Microsoft Excel',
      'zip' => 'Archive',
      'gif' => 'GIF Image',
      'jpg' => 'JPEG Image',
      'jpeg' => 'JPEG Image',
      'png' => 'PNG Image',
      'ppt' => 'Microsoft PowerPoint',
      'pptx' => 'Microsoft PowerPoint',
    ),
    'php_ini_overrides' => 
    array (
      'memory_limit' => '256M',
    ),
  ),
  'wireui' => 
  array (
    'icons' => 
    array (
      'style' => 'outline',
    ),
    'modal' => 
    array (
      'zIndex' => 'z-50',
      'maxWidth' => '2xl',
      'spacing' => 'p-4',
      'align' => 'start',
      'blur' => false,
    ),
    'card' => 
    array (
      'padding' => 'px-2 py-5 md:px-4',
      'shadow' => 'shadow-md',
      'rounded' => 'rounded-lg',
      'color' => 'bg-white dark:bg-secondary-800',
    ),
    'components' => 
    array (
      'avatar' => 
      array (
        'class' => 'WireUi\\View\\Components\\Avatar',
        'alias' => 'avatar',
      ),
      'icon' => 
      array (
        'class' => 'WireUi\\View\\Components\\Icon',
        'alias' => 'icon',
      ),
      'icon.spinner' => 
      array (
        'class' => 'WireUi\\View\\Components\\Icons\\Spinner',
        'alias' => 'icon.spinner',
      ),
      'color-picker' => 
      array (
        'class' => 'WireUi\\View\\Components\\ColorPicker',
        'alias' => 'color-picker',
      ),
      'input' => 
      array (
        'class' => 'WireUi\\View\\Components\\Input',
        'alias' => 'input',
      ),
      'textarea' => 
      array (
        'class' => 'WireUi\\View\\Components\\Textarea',
        'alias' => 'textarea',
      ),
      'label' => 
      array (
        'class' => 'WireUi\\View\\Components\\Label',
        'alias' => 'label',
      ),
      'error' => 
      array (
        'class' => 'WireUi\\View\\Components\\Error',
        'alias' => 'error',
      ),
      'errors' => 
      array (
        'class' => 'WireUi\\View\\Components\\Errors',
        'alias' => 'errors',
      ),
      'inputs.maskable' => 
      array (
        'class' => 'WireUi\\View\\Components\\Inputs\\MaskableInput',
        'alias' => 'inputs.maskable',
      ),
      'inputs.phone' => 
      array (
        'class' => 'WireUi\\View\\Components\\Inputs\\PhoneInput',
        'alias' => 'inputs.phone',
      ),
      'inputs.currency' => 
      array (
        'class' => 'WireUi\\View\\Components\\Inputs\\CurrencyInput',
        'alias' => 'inputs.currency',
      ),
      'inputs.number' => 
      array (
        'class' => 'WireUi\\View\\Components\\Inputs\\NumberInput',
        'alias' => 'inputs.number',
      ),
      'inputs.password' => 
      array (
        'class' => 'WireUi\\View\\Components\\Inputs\\PasswordInput',
        'alias' => 'inputs.password',
      ),
      'badge' => 
      array (
        'class' => 'WireUi\\View\\Components\\Badge',
        'alias' => 'badge',
      ),
      'badge.circle' => 
      array (
        'class' => 'WireUi\\View\\Components\\CircleBadge',
        'alias' => 'badge.circle',
      ),
      'button' => 
      array (
        'class' => 'WireUi\\View\\Components\\Button',
        'alias' => 'button',
      ),
      'button.circle' => 
      array (
        'class' => 'WireUi\\View\\Components\\CircleButton',
        'alias' => 'button.circle',
      ),
      'dropdown' => 
      array (
        'class' => 'WireUi\\View\\Components\\Dropdown',
        'alias' => 'dropdown',
      ),
      'dropdown.item' => 
      array (
        'class' => 'WireUi\\View\\Components\\Dropdown\\DropdownItem',
        'alias' => 'dropdown.item',
      ),
      'dropdown.header' => 
      array (
        'class' => 'WireUi\\View\\Components\\Dropdown\\DropdownHeader',
        'alias' => 'dropdown.header',
      ),
      'notifications' => 
      array (
        'class' => 'WireUi\\View\\Components\\Notifications',
        'alias' => 'notifications',
      ),
      'datetime-picker' => 
      array (
        'class' => 'WireUi\\View\\Components\\DatetimePicker',
        'alias' => 'datetime-picker',
      ),
      'time-picker' => 
      array (
        'class' => 'WireUi\\View\\Components\\TimePicker',
        'alias' => 'time-picker',
      ),
      'card' => 
      array (
        'class' => 'WireUi\\View\\Components\\Card',
        'alias' => 'card',
      ),
      'native-select' => 
      array (
        'class' => 'WireUi\\View\\Components\\NativeSelect',
        'alias' => 'native-select',
      ),
      'select' => 
      array (
        'class' => 'WireUi\\View\\Components\\Select',
        'alias' => 'select',
      ),
      'select.option' => 
      array (
        'class' => 'WireUi\\View\\Components\\Select\\Option',
        'alias' => 'select.option',
      ),
      'select.user-option' => 
      array (
        'class' => 'WireUi\\View\\Components\\Select\\UserOption',
        'alias' => 'select.user-option',
      ),
      'toggle' => 
      array (
        'class' => 'WireUi\\View\\Components\\Toggle',
        'alias' => 'toggle',
      ),
      'checkbox' => 
      array (
        'class' => 'WireUi\\View\\Components\\Checkbox',
        'alias' => 'checkbox',
      ),
      'radio' => 
      array (
        'class' => 'WireUi\\View\\Components\\Radio',
        'alias' => 'radio',
      ),
      'modal' => 
      array (
        'class' => 'WireUi\\View\\Components\\Modal',
        'alias' => 'modal',
      ),
      'modal.card' => 
      array (
        'class' => 'WireUi\\View\\Components\\ModalCard',
        'alias' => 'modal.card',
      ),
      'dialog' => 
      array (
        'class' => 'WireUi\\View\\Components\\Dialog',
        'alias' => 'dialog',
      ),
    ),
  ),
  'settings' => 
  array (
    'meta_tags' => 'QPS,Qps 2,QPS 3',
    'site_name' => 'QPS Portal',
    'site_description' => 'Expert dental administration, accounting, and billing services for dental practices. Streamline your operations and focus on patient care with QPS Dental Support.',
    'site_title' => 'QPS',
    'meta_title' => 'QPS',
    'meta_description' => 'Expert dental administration, accounting, and billing services for dental practices. Streamline your operations and focus on patient care with QPS Dental Suppor',
    'site_logo' => 'uploads/logo/46c85ba6f58ff9345c84ec212cd8cccd.png',
    'site_logo_2' => NULL,
    'site_mobile_logo' => 'uploads/logo/d9b8559a56586d978cdd7c421b9a4604.png',
    'site_favicon' => NULL,
    'admin_logo' => 'uploads/logo/b8ef22721e755fdc679c2ccff8c1ddd1.png',
    'meta_os_image' => NULL,
    'google_analytics_code' => '',
    'third_party_code' => '',
    'third_party_status' => '0',
    'google_analytics_status' => '0',
    'mail_username' => 'no-reply@mathmindtrick.xyz',
    'mail_password' => 'Zy0nQUvib',
    'mail_host' => 'mail.mathmindtrick.xyz',
    'mail_port' => '465',
    'mail_encryption' => 'SSL',
    'mail_address' => 'no-reply@mathmindtrick.xyz',
    'footer_logo' => 'uploads/logo/2800954e94686a8753e3b06efdea3249.png',
    'dark_mode' => '0',
    'rozarpay_key' => 'rzp_test_ydqitl9gllLLLq',
    'rozarpay_secret' => '4p6EARdh7DQXCizhGKtB3i8g',
    'rozarpay_active' => '1',
    'paypal_account_type' => 'live',
    'paypal_live_app_id' => '',
    'paypal_live_client_id' => '',
    'paypal_live_client_secret' => '',
    'paypal_client_id' => '',
    'paypal_client_secret' => '',
    'stripe_key' => '',
    'stripe_secret' => '',
    'paytm_merchant_id' => '',
    'paytm_merchant_key' => '',
    'paytm_merchant_website' => '',
    'paytm_channel' => '',
    'paytm_industry_type' => '',
    'app_env' => 'local',
    'https_redirect' => '0',
    'app_url' => 'http://localhost',
    'app_debug' => '',
    'app_timezone' => 'Asia/Kolkata',
    'captcha' => '0',
    'editor_layout' => 'ck-editor-5',
    'app_base_url' => 'https://tnbt.testbedx.in/',
    'footer_description' => 'QPS Dental Support',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
