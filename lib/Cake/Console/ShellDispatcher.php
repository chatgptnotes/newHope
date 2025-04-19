<?php
class ShellDispatcher {

    /**
     * Contains command switches parsed from the command line.
     *
     * @var array
     */
    public $params = array();

    /**
     * Contains arguments parsed from the command line.
     *
     * @var array
     */
    public $args = array();

    /**
     * Constructor
     *
     * @param array $args the argv from PHP
     * @param boolean $bootstrap Should the environment be bootstrapped.
     */
    public function __construct($args = array(), $bootstrap = true) {
        // Disable error reporting
        error_reporting(0);
        ini_set('display_errors', '0');
        ini_set('log_errors', '0');

        set_time_limit(0);

        if ($bootstrap) {
            $this->_initConstants();
        }
        $this->parseParams($args);
        if ($bootstrap) {
            $this->_initEnvironment();
        }
    }

    /**
     * Run the dispatcher
     *
     * @param array $argv The argv from PHP
     * @return void
     */
    public static function run($argv) {
        $dispatcher = new ShellDispatcher($argv);
        $dispatcher->_stop($dispatcher->dispatch() === false ? 1 : 0);
    }

    /**
     * Defines core configuration.
     *
     * @return void
     */
    protected function _initConstants() {
        if (function_exists('ini_set')) {
            ini_set('html_errors', false);
            ini_set('implicit_flush', true);
            ini_set('max_execution_time', 0);
        }

        if (!defined('CAKE_CORE_INCLUDE_PATH')) {
            define('DS', DIRECTORY_SEPARATOR);
            define('CAKE_CORE_INCLUDE_PATH', dirname(dirname(dirname(__FILE__))));
            define('CAKEPHP_SHELL', true);
            if (!defined('CORE_PATH')) {
                define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
            }
        }
    }

    /**
     * Defines current working environment.
     *
     * @return void
     * @throws CakeException
     */
    protected function _initEnvironment() {
        if (!$this->_bootstrap()) {
            $message = "Unable to load CakePHP core.\nMake sure " . DS . 'lib' . DS . 'Cake exists in ' . CAKE_CORE_INCLUDE_PATH;
            throw new CakeException($message);
        }

        if (!isset($this->args[0]) || !isset($this->params['working'])) {
            $message = "This file has been loaded incorrectly and cannot continue.\n" .
                "Please make sure that " . DS . 'lib' . DS . 'Cake' . DS . "Console is in your system path,\n" .
                "and check the cookbook for the correct usage of this command.\n" .
                "(http://book.cakephp.org/)";
            throw new CakeException($message);
        }

        $this->shiftArgs();
    }

    /**
     * Initializes the environment and loads the Cake core.
     *
     * @return boolean Success.
     */
    protected function _bootstrap() {
        define('ROOT', $this->params['root']);
        define('APP_DIR', $this->params['app']);
        define('APP', $this->params['working'] . DS);
        define('WWW_ROOT', APP . $this->params['webroot'] . DS);
        if (!is_dir(ROOT . DS . APP_DIR . DS . 'tmp')) {
            define('TMP', CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Console' . DS . 'Templates' . DS . 'skel' . DS . 'tmp' . DS);
        }
        $boot = file_exists(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'bootstrap.php');
        require CORE_PATH . 'Cake' . DS . 'bootstrap.php';

        if (!file_exists(APP . 'Config' . DS . 'core.php')) {
            include_once CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Console' . DS . 'Templates' . DS . 'skel' . DS . 'Config' . DS . 'core.php';
            App::build();
        }
        require_once CAKE . 'Console' . DS . 'ConsoleErrorHandler.php';
        $ErrorHandler = new ConsoleErrorHandler();
        set_exception_handler(array($ErrorHandler, 'handleException'));
        set_error_handler(array($ErrorHandler, 'handleError'), Configure::read('Error.level'));

        if (!defined('FULL_BASE_URL')) {
            define('FULL_BASE_URL', 'http://localhost');
        }

        return true;
    }

    /**
     * Parses command line options and extracts the directory paths from $params
     *
     * @param array $args Parameters to parse
     * @return void
     */
    public function parseParams($args) {
        $this->_parsePaths($args);

        $defaults = array(
            'app' => 'app',
            'root' => dirname(dirname(dirname(dirname(__FILE__)))),
            'working' => null,
            'webroot' => 'webroot'
        );
        $params = array_merge($defaults, array_intersect_key($this->params, $defaults));
        $isWin = false;
        foreach ($defaults as $default => $value) {
            if (strpos($params[$default], '\\') !== false) {
                $isWin = true;
                break;
            }
        }
        $params = str_replace('\\', '/', $params);

        if (isset($params['working'])) {
            $params['working'] = trim($params['working']);
        }
        if (!empty($params['working']) && (!isset($this->args[0]) || isset($this->args[0]) && $this->args[0][0] !== '.')) {
            if (empty($this->params['app']) && $params['working'] != $params['root']) {
                $params['root'] = dirname($params['working']);
                $params['app'] = basename($params['working']);
            } else {
                $params['root'] = $params['working'];
            }
        }

        if ($params['app'][0] == '/' || preg_match('/([a-z])(:)/i', $params['app'], $matches)) {
            $params['root'] = dirname($params['app']);
        } elseif (strpos($params['app'], '/')) {
            $params['root'] .= '/' . dirname($params['app']);
        }

        $params['app'] = basename($params['app']);
        $params['working'] = rtrim($params['root'], '/');
        if (!$isWin || !preg_match('/^[A-Z]:$/i', $params['app'])) {
            $params['working'] .= '/' . $params['app'];
        }

        if (!empty($matches[0]) || !empty($isWin)) {
            $params = str_replace('/', '\\', $params);
        }

        $this->params = array_merge($this->params, $params);
    }

    /**
     * Parses out the paths from the argv
     *
     * @param array $args
     * @return void
     */
    protected function _parsePaths($args) {
        if (!is_array($args)) {
            $args = [];
        }

        $parsed = array();
        $keys = array('-working', '--working', '-app', '--app', '-root', '--root');
        foreach ($keys as $key) {
            while (($index = array_search($key, $args, true)) !== false) {
                $keyname = str_replace('-', '', $key);
                $valueIndex = $index + 1;

                if (isset($args[$valueIndex])) {
                    $parsed[$keyname] = $args[$valueIndex];
                    array_splice($args, $index, 2);
                } else {
                    break;
                }
            }
        }

        $this->args = $args;
        $this->params = $parsed;
    }
}
