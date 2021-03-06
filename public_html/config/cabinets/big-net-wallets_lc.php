<?php
define('URL_PREFIX', '');
define('CORE_VERSION', rand());

//define('TPL_THEME_NAME', 'cryptoindex');
define('TPL_THEME_NAME', 'default');
define('TPL_THEME_NAME_ADMIN', 'lte');

return [
    /**
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => true,//filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    'App' => [
        'namespace'             => 'App',
        'encoding'              => env('APP_ENCODING', 'UTF-8'),
        'defaultLocale'         => 'en',//env('APP_DEFAULT_LOCALE', 'en'),
        'base'                  => false,
        'dir'                   => 'src',
        'webroot'               => 'webroot',
        'wwwRoot'               => WWW_ROOT,
        'baseDomain'            => 'big-net-wallets.lc',
        'baseProtocol'          => 'http',
        'fullBaseUrl'           => 'http://big-net-wallets.lc',
        //'appImageBaseUrl'       => '/icocabinet/img',
        //'appCssBaseUrl'         => '/icocabinet/css',
        //'appJsBaseUrl'          => '/icocabinet/js',
        //'uploadsPath'           => 'bitcoen/uploads',
        'paths'                 => [
            'plugins'   => [ROOT . DS . 'plugins' . DS],
            'templates' => [APP . 'Template' . DS . 'Themes' . DS . TPL_THEME_NAME . DS],
            'locales'   => [APP . 'Locale' . DS],
        ],
        'accessToken'           => '123',
        'appName'               => 'Dev. BigNet Wallets',
        'tokenName'             => 'TKN',
        'supportEmail'          => 'info@izzz.io',
        'mainSite'              => 'http://big-net-wallets.lc',
        'whitepaper'            => '',
        'policyUrl'             => '',
        'internalCurrency'      => 'USD',
        //'enableDeposit'         => false,
        'saleShowRatio'         => 100,
        'sandboxSqlitePath'     => TMP . '/sqlite',
        //'referalBonus'          => 10,
        //'enableSocial'          => true,
        'Template'              => [
            'subpath'            => '/themes/',
            'logo'               => 'https://static.tildacdn.com/tild3761-3439-4666-a437-653763653136/logowhite.svg',
            'favicon'            => '',
            'viewTokenPrecision' => 5,
            'viewPrecision'      => 2,
            'enableReferal'      => true,
            //'periodsTemplate'    => 'cylinders/periods',
            'periodsTemplate'    => 'periods_1',
            'startValue'         => 1000,
            'enableFAQ'          => true,
            'enableWalletEnter'  => true,
            'ga'                 => '123',
            'gtm'                => 123,
            'gevents'            => [
                'get_address' => [
                    'event'          => 'Get Address',
                    'event_category' => 'Checkout',
                    'event_action'   => 'Get address'
                    ,
                ],
                'purchased'   => [
                    'event'          => 'Purchased',
                    'event_category' => 'Checkout',
                    'event_action'   => 'Purchased Successful',
                ],
            ],
            'currenciesTable' => true,
        ],
        'timezone'              => 'UTC',
    ],

    'HybridAuth'     => [
        'providers'  => [
            'Google'   => [
                'enabled' => true,
                'keys'    => [
                    'id'     => '',
                    'secret' => '',
                ],
            ],
            'Facebook' => [
                'enabled' => true,
                'keys'    => [
                    'id'     => '',
                    'secret' => '',
                ],
                'scope'   => 'email, public_profile',
            ],
        ],
        'debug_file' => LOGS . 'testbinet_hybridauth.log',
    ],

    /**
     * Config connection for node
     */
    'Api'   => [
        'host'  => 'http://localhost:3015/',
        'pass'   => '',
    ],

    /*
     * Networks settings
     */
    'Networks' => [
        [
            'name' => 'bignet.izzz.io',
            'ticker' => 'iZ3',
            'masterContract' => '1',
            'lastBlock' => 'undefined',
            'icon'  => 'https://bignet.izzz.io/img/logo.svg',
        ],
    ],


    /*
     * Contract groups
     */
    'Contracts' => [
        'popular' => [
            [
                'id' => 'main',
                'name' => 'Main Contract',
                'from' => 'izNUhVKtDpmgCnVycSMUPusX8sdnErzAD9T',
                'address' => '1',
                /*
                'methods' => [
                    'checkContractAddress',
                    'checkContractLimits',
                    'getCurrentResources',
                    'balanceOf',
                    'totalSupply',
                    'transfer',
                ],
                */
                'abi' => '
                    [
                        {
                            "constant":false,
                            "inputs":[
                                {
                                    "name":"addr",
                                    "type":"number"
                                }
                            ],
                            "name":"checkContractAddress",
                            "outputs":[
                                {
                                    "name":"success",
                                    "type":"bool"
                                }
                            ],
                            "payable":false,
                            "type":"function"
                        },
                        {
                            "constant":false,
                            "inputs":[
                                {
                                    "name":"addr",
                                    "type":"number"
                                }
                            ],
                            "name":"checkContractLimits",
                            "outputs":[
                                {
                                    "name":"success",
                                    "type":"bool"
                                }
                            ],
                            "payable":false,
                            "type":"function"
                        },
                        {
                            "constant":true,
                            "inputs":[],
                            "name":"getCurrentResources",
                            "outputs":[
                                {
                                    "name":"",
                                    "type":"string"
                                }
                            ],
                            "payable":false,
                            "type":"function"
                        },
                        {
                            "constant":true,
                            "inputs":[],
                            "name":"balanceOf",
                            "outputs":[
                                {
                                    "name":"",
                                    "type":"uint256"
                                }
                            ],
                            "payable":false,
                            "type":"function"
                        },
                        {
                            "constant":true,
                            "inputs":[],
                            "name":"totalSupply",
                            "outputs":[
                                {
                                    "name":"",
                                    "type":"uint256"
                                }
                            ],
                            "payable":false,
                            "type":"function"
                        },
                        {
                            "constant":false,
                            "inputs":[
                                {
                                    "name":"to",
                                    "type":"text"
                                },
                                {
                                    "name":"tokens",
                                    "type":"number"
                                }
                            ],
                            "name":"transfer",
                            "outputs":[
                                {
                                    "name":"success",
                                    "type":"bool"
                                }
                            ],
                            "payable":false,
                            "type":"function"
                        }
                    ]
                ',
            ],
        ],
    ],






    /**
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security'       => [
        'salt' => env('SECURITY_SALT', '57e1814cd0573d424d1f7e2a3282346d1b0458dab9f317a0f9002290be849b71'),
    ],

    /**
     * Apply timestamps with the last modified time to static assets (js, css, images).
     * Will append a querystring parameter containing the time the file was modified.
     * This is useful for busting browser caches.
     *
     * Set to true to apply timestamps when debug is true. Set to 'force' to always
     * enable timestamping regardless of debug value.
     */
    'Asset'          => [
        // 'timestamp' => true,
    ],

    /**
     * Configure the cache adapters.
     */
    'Cache'          => [
        'default' => [
            'className' => 'File',
            'path'      => CACHE,
            'url'       => env('CACHE_DEFAULT_URL', null),
        ],

        'short' => [
            'className' => 'File',
            'duration'  => '+1 hours',
            'path'      => CACHE,
            'prefix'    => 'cake_short_',
        ],

        'payment' => [
            'className' => 'File',
            'duration'  => '+96 hours',
            'path'      => CACHE,
            'prefix'    => 'cake_payment_',
        ],

        'deposit'      => [
            'className' => 'File',
            'duration'  => '+1000 hours',
            'path'      => CACHE,
            'prefix'    => 'cake_deposit_',
        ],


        /**
         * Configure the cache used for general framework caching.
         * Translation cache files are stored with this configuration.
         * Duration will be set to '+1 year' in bootstrap.php when debug = false
         * If you set 'className' => 'Null' core cache will be disabled.
         */
        '_cake_core_'  => [
            'className' => 'File',
            'prefix'    => 'myapp_cake_core_',
            'path'      => CACHE . 'persistent/',
            'serialize' => true,
            'duration'  => '+2 minutes',
            'url'       => env('CACHE_CAKECORE_URL', null),
        ],

        /**
         * Configure the cache for model and datasource caches. This cache
         * configuration is used to store schema descriptions, and table listings
         * in connections.
         * Duration will be set to '+1 year' in bootstrap.php when debug = false
         */
        '_cake_model_' => [
            'className' => 'File',
            'prefix'    => 'myapp_cake_model_',
            'path'      => CACHE . 'models/',
            'serialize' => true,
            'duration'  => '+2 minutes',
            'url'       => env('CACHE_CAKEMODEL_URL', null),
        ],
    ],

    /**
     * Configure the Error and Exception handlers used by your application.
     *
     * By default errors are displayed using Debugger, when debug is true and logged
     * by Cake\Log\Log when debug is false.
     *
     * In CLI environments exceptions will be printed to stderr with a backtrace.
     * In web environments an HTML page will be displayed for the exception.
     * With debug true, framework errors like Missing Controller will be displayed.
     * When debug is false, framework errors will be coerced into generic HTTP errors.
     *
     * Options:
     *
     * - `errorLevel` - int - The level of errors you are interested in capturing.
     * - `trace` - boolean - Whether or not backtraces should be included in
     *   logged errors/exceptions.
     * - `log` - boolean - Whether or not you want exceptions logged.
     * - `exceptionRenderer` - string - The class responsible for rendering
     *   uncaught exceptions.  If you choose a custom class you should place
     *   the file for that class in src/Error. This class needs to implement a
     *   render method.
     * - `skipLog` - array - List of exceptions to skip for logging. Exceptions that
     *   extend one of the listed exceptions will also be skipped for logging.
     *   E.g.:
     *   `'skipLog' => ['Cake\Network\Exception\NotFoundException', 'Cake\Network\Exception\UnauthorizedException']`
     * - `extraFatalErrorMemory` - int - The number of megabytes to increase
     *   the memory limit by when a fatal error is encountered. This allows
     *   breathing room to complete logging or error handling.
     */
    'Error'          => [
        'errorLevel'        => E_ALL,
        'exceptionRenderer' => 'Cake\Error\ExceptionRenderer',
        'skipLog'           => [],
        'log'               => true,
        'trace'             => true,
    ],

    /**
     * Email configuration.
     *
     * By defining transports separately from delivery profiles you can easily
     * re-use transport configuration across multiple profiles.
     *
     * You can specify multiple configurations for production, development and
     * testing.
     *
     * Each transport needs a `className`. Valid options are as follows:
     *
     *  Mail   - Send using PHP mail function
     *  Smtp   - Send using SMTP
     *  Debug  - Do not send the email, just return the result
     *
     * You can add custom transports (or override existing transports) by adding the
     * appropriate file to src/Mailer/Transport.  Transports should be named
     * 'YourTransport.php', where 'Your' is the name of the transport.
     *
     *  'host' => 'smtp.gmail.com',
     * 'port' => 587,
     * 'username' => 'my@gmail.com',
     * 'password' => 'secret',
     * 'className' => 'Smtp',
     * 'tls' => true
     */
    'EmailTransport' => [
        'default'  => [
            'className' => 'Mail',
            // The following keys are used in SMTP transports
            'host'      => 'smtp.gmail.com',
            'port'      => 587,
            'timeout'   => 30,
            'username'  => '',
            'password'  => '',
            'client'    => null,
            'tls'       => true,
            'url'       => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
        'Mandrill' => [
            'className'      => 'MandrillTransport.Mandrill',
            'api_key'        => 'PaBGd_5wVPsZ41GKHNCGiA',
            'api_key_test'   => 'PaBGd_5wVPsZ41GKHNCGiA',
            'from'           => 'test@izzz.io',
            'merge_language' => 'handlebars', //optional, default is handlebars
            'inline_css'     => true, //optional, default is true
        ],
    ],

    /**
     * Email delivery profiles
     *
     * Delivery profiles allow you to predefine various properties about email
     * messages from your application and give the settings a name. This saves
     * duplication across your application and makes maintenance and development
     * easier. Each profile accepts a number of keys. See `Cake\Mailer\Email`
     * for more information.
     */
    'Email'          => [
        'default' => [
            'transport' => 'default',
            'from'      => 'test@izzz.io',
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
        ],
    ],

    /**
     * Connection information used by the ORM to connect
     * to your application's datastores.
     * Do not use periods in database name - it may lead to error.
     * See https://github.com/cakephp/cakephp/issues/6471 for details.
     * Drivers include Mysql Postgres Sqlite Sqlserver
     * See vendor\cakephp\cakephp\src\Database\Driver for complete list
     */
    'Datasources'    => [
        'default' => [
            'className'        => 'Cake\Database\Connection',
            'driver'           => 'Cake\Database\Driver\Mysql',
            'persistent'       => false,
            'host'             => 'localhost',
            /**
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',
            'username'         => 'root',
            'password'         => '',
            'database'         => 'icocabinet',
            'encoding'         => 'utf8',
            // 'timezone' => 'UTC',
            'flags'            => [],
            'cacheMetadata'    => true,
            'log'              => false,

            /**
             * Set identifier quoting to true if you are using reserved words or
             * special characters in your table or column names. Enabling this
             * setting will result in queries built using the Query Builder having
             * identifiers quoted when creating SQL. It should be noted that this
             * decreases performance because each query needs to be traversed and
             * manipulated before being executed.
             */
            'quoteIdentifiers' => true,

            /**
             * During development, if using MySQL < 5.6, uncommenting the
             * following line could boost the speed at which schema metadata is
             * fetched from the database. It can also be set directly with the
             * mysql configuration directive 'innodb_stats_on_metadata = 0'
             * which is the recommended value in production environments
             */
            'init'             => ['SET sql_mode = ""'],

            'url' => env('DATABASE_URL', null),
        ],

        /**
         * The test connection is used during the test suite.
         */
        'test'    => [
            'className'        => 'Cake\Database\Connection',
            'driver'           => 'Cake\Database\Driver\Mysql',
            'persistent'       => false,
            'host'             => 'localhost',
            //'port' => 'non_standard_port_number',
            'username'         => 'my_app',
            'password'         => 'secret',
            'database'         => 'test_myapp',
            'encoding'         => 'utf8',
            'timezone'         => 'UTC',
            'cacheMetadata'    => true,
            'quoteIdentifiers' => false,
            'log'              => false,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url'              => env('DATABASE_TEST_URL', null),
        ],
    ],

    /**
     * Configures logging options
     */
    'Log'            => [
        'debug' => [
            'className' => 'Cake\Log\Engine\FileLog',
            'path'      => LOGS,
            'file'      => 'debug_cylinders',
            'levels'    => ['notice', 'info', 'debug'],
            'url'       => env('LOG_DEBUG_URL', null),
        ],
        'error' => [
            'className' => 'Cake\Log\Engine\FileLog',
            'path'      => LOGS,
            'file'      => 'error_cylinders',
            'levels'    => ['warning', 'error', 'critical', 'alert', 'emergency'],
            'url'       => env('LOG_ERROR_URL', null),
        ],
    ],

    /**
     * Session configuration.
     *
     * Contains an array of settings to use for session configuration. The
     * `defaults` key is used to define a default preset to use for sessions, any
     * settings declared here will override the settings of the default config.
     *
     * ## Options
     *
     * - `cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'.
     * - `cookiePath` - The url path for which session cookie is set. Maps to the
     *   `session.cookie_path` php.ini config. Defaults to base path of app.
     * - `timeout` - The time in minutes the session should be valid for.
     *    Pass 0 to disable checking timeout.
     *    Please note that php.ini's session.gc_maxlifetime must be equal to or greater
     *    than the largest Session['timeout'] in all served websites for it to have the
     *    desired effect.
     * - `defaults` - The default configuration set to use as a basis for your session.
     *    There are four built-in options: php, cake, cache, database.
     * - `handler` - Can be used to enable a custom session handler. Expects an
     *    array with at least the `engine` key, being the name of the Session engine
     *    class to use for managing the session. CakePHP bundles the `CacheSession`
     *    and `DatabaseSession` engines.
     * - `ini` - An associative array of additional ini values to set.
     *
     * The built-in `defaults` options are:
     *
     * - 'php' - Uses settings defined in your php.ini.
     * - 'cake' - Saves session files in CakePHP's /tmp directory.
     * - 'database' - Uses CakePHP's database sessions.
     * - 'cache' - Use the Cache class to save sessions.
     *
     * To define a custom session handler, save it at src/Network/Session/<name>.php.
     * Make sure the class implements PHP's `SessionHandlerInterface` and set
     * Session.handler to <name>
     *
     * To use database sessions, load the SQL file located at config/Schema/sessions.sql
     */
    'Session'        => [
        'defaults' => 'php',
        'ini'      => [
            // Invalidate the cookie after 30 minutes without visiting
            // any page on the site.
            'session.cookie_lifetime' => 18000,
            'session.cookie_httponly' => true,
            'session.cookie_name'     => 'CROWDSALE',
        ],
        'timeout'  => 18000,
    ],
];
