<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Request {

    private static $allinfo;
    public $MobileDetect;
    public $CrawlerDetect;
    public $SypexGeo;
    //
    public $dev_types;
    public $platforms;
    public $browsers;
    public $geo_countryes;
    public $geo_alfa2;
    public $geo_alfa3;
    public $geo_numeric;
    //
    public $useragent;
    public $client_ip;
    public $client_long_ip;
    public $is_crawler;
    public $device_type;
    public $platform;
    public $browser;
    public $geodata;
    public $dev_hash;
    //
    public $referer;
    public $referer_domain;

    public function __construct()
    {
        $this->CrawlerDetect = new \Jaybizzle\CrawlerDetect\CrawlerDetect();
        $this->MobileDetect  = new \Detection\MobileDetect();
        $this->SypexGeo      = new \IgI\SypexGeo\SxGeo(APPPATH . 'vendor/igi/sypexgeo/src/IgI/SypexGeo/SxGeo.dat');

        $this->dev_types     = config_item('devs');
        $this->platforms     = config_item('platforms');
        $this->browsers      = config_item('browsers');
        $this->geo_countryes = config_item('geo_name');
        $this->geo_alfa2     = config_item('geo_alfa2');
        $this->geo_alfa3     = config_item('geo_alfa3');
        $this->geo_numeric   = config_item('geo_numeric');

        $this->useragent      = $this->get_useragent();
        $this->client_ip      = $this->get_real_ip();
        $this->client_long_ip = $this->ip_2_long();
        $this->is_crawler     = $this->is_crawler();
        $this->device_type    = $this->get_device_type();
        $this->platform       = $this->get_platform();
        $this->browser        = $this->get_browser();
        $this->geodata        = $this->geodata();
        $this->dev_hash       = $this->get_dev_hash();
        $this->referer        = $this->get_referer();
        $this->referer_domain = $this->get_referer_domain();
    }


    public static function allinfo()
    {
        if (!isset(self::$allinfo)) {

            $classname = __CLASS__;

            self::$allinfo = (new $classname)->info();
        }

        return self::$allinfo;
    }


    public function info()
    {
        return (object) array(
                    'useragent'      => $this->get_useragent(),
                    'client_ip'      => $this->get_real_ip(),
                    'client_long_ip' => $this->ip_2_long(),
                    'is_crawler'     => $this->is_crawler(),
                    'device_type'    => $this->get_device_type(),
                    'platform'       => $this->get_platform(),
                    'browser'        => $this->get_browser(),
                    'geodata'        => (object) $this->geodata(),
                    'dev_hash'       => $this->get_dev_hash(),
                    'referer'        => $this->get_referer(),
                    'referer_domain' => $this->get_referer_domain(),
        );
    }


    public function info_array()
    {
        return array(
            'useragent'      => $this->get_useragent(),
            'client_ip'      => $this->get_real_ip(),
            'client_long_ip' => $this->ip_2_long(),
            'is_crawler'     => $this->is_crawler(),
            'device_type'    => $this->get_device_type(),
            'platform'       => $this->get_platform(),
            'browser'        => $this->get_browser(),
            'geodata'        => $this->geodata(),
            'dev_hash'       => $this->get_dev_hash(),
            'referer'        => $this->get_referer(),
            'referer_domain' => $this->get_referer_domain(),
        );
    }


    protected function get_referer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }


    protected function get_referer_domain()
    {
        return isset($this->referer) ? parse_url($this->referer, PHP_URL_HOST) : null;
    }


    protected function get_useragent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }


    protected function get_real_ip()
    {
        $clients = array(
            isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : '',
            isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '',
            isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',
            isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
        );

        foreach ($clients as $raw_ip) {
            $ip_list   = explode(',', $raw_ip);
            $client_ip = trim(end($ip_list));

            if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                return $client_ip;
            }
        }

        return '0.0.0.0';
    }


    protected function ip_2_long()
    {
        return sprintf("%u", ip2long($this->client_ip));
    }


    protected function is_crawler()
    {
        return (int) $this->CrawlerDetect->isCrawler();
    }


    protected function get_device_type()
    {
        if ($this->is_crawler) {
            return 'Bot';
        } else if ($this->MobileDetect->isTablet()) {
            return 'Tablet';
        } else if ($this->MobileDetect->isMobile()) {
            return 'Mobile';
        }

        return 'Computer';
    }


    protected function get_platform()
    {
        if ($this->is_crawler) {
            return 'unknown_platform';
        }

        if ($this->device_type == 'Tablet' || $this->device_type == 'Mobile') {
            if ($this->MobileDetect->isIOS()) {
                return 'iOS';
            } elseif ($this->MobileDetect->isAndroidOS()) {
                return 'Android';
            } elseif ($this->MobileDetect->isSymbianOS()) {
                return 'Symbian';
            } elseif ($this->MobileDetect->isBlackBerryOS()) {
                return 'Black_Berry';
            } elseif ($this->MobileDetect->isWindowsMobileOS()) {
                return 'Windows_Mobile';
            } elseif ($this->MobileDetect->isWindowsPhoneOS()) {
                return 'Windows_Phone';
            }
            return 'unknown_platform';
        } else {
            if (preg_match('/windows nt 10/i', $this->useragent)) {
                return 'Windows_10';
            } elseif (preg_match('/windows nt 6\.3/i', $this->useragent)) {
                return 'Windows_8_1';
            } elseif (preg_match('/windows nt 6\.2/i', $this->useragent)) {
                return 'Windows_8';
            } elseif (preg_match('/windows nt 6\.1/i', $this->useragent)) {
                return 'Windows_7';
            } elseif (preg_match('/windows nt 5\.2/i', $this->useragent)) {
                return 'Windows_Server';
            } elseif (preg_match('/windows nt 5\.1|windows xp/i', $this->useragent)) {
                return 'Windows_XP';
            } elseif (preg_match('/windows nt 5\.0/i', $this->useragent)) {
                return 'Windows_2000';
            } elseif (preg_match('/windows me/i', $this->useragent)) {
                return 'Windows_ME';
            } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $this->useragent)) {
                return 'Mac_OS';
            } elseif (preg_match('/ubuntu/i', $this->useragent)) {
                return 'Ubuntu';
            } elseif (preg_match('/linux/i', $this->useragent)) {
                return 'Linux';
            } elseif (preg_match('/windows nt 6\.0/i', $this->useragent)) {
                return 'Windows_Vista';
            }

            return 'unknown_platform';
        }
    }


    protected function get_browser()
    {
        if ($this->is_crawler) {
            return 'unknown_browser';
        }

        if ($this->device_type == 'Tablet' || $this->device_type == 'Mobile') {
            if ($this->MobileDetect->isChrome()) {
                return 'Chrome_m';
            } elseif ($this->MobileDetect->isOpera()) {
                return 'Opera_m';
            } elseif ($this->MobileDetect->isDolfin()) {
                return 'Dolphin_m';
            } elseif ($this->MobileDetect->isFirefox()) {
                return 'Firefox_m';
            } elseif ($this->MobileDetect->isUCBrowser()) {
                return 'UCBrowser_m';
            } elseif ($this->MobileDetect->isPuffin()) {
                return 'Puffin_m';
            } elseif ($this->MobileDetect->isSafari()) {
                return 'Safari_m';
            } elseif ($this->MobileDetect->isEdge()) {
                return 'Edge_m';
            } elseif ($this->MobileDetect->isIE()) {
                return 'IE_m';
            } elseif (preg_match('/.*(Linux;.*AppleWebKit.*Version\/\d+\.\d+.*Mobile).*/i', $this->useragent)) {
                return 'Android_m';
            }
            return 'unknown_browser';
        } else {

            if (preg_match('/firefox/i', $this->useragent)) {
                return 'Firefox_d';
            } elseif (preg_match('/opr|opera/i', $this->useragent)) {
                return 'Opera_d';
            } elseif (preg_match('/chrome/i', $this->useragent)) {
                return 'Chrome_d';
            } elseif (preg_match('/maxthon/i', $this->useragent)) {
                return 'Maxthon_d';
            } elseif (preg_match('/safari/i', $this->useragent)) {
                return 'Safari_d';
            } elseif (preg_match('/edge/i', $this->useragent)) {
                return 'Edge_d';
            } elseif (preg_match('/msie|trident/i', $this->useragent)) {
                return 'IE_d';
            }

            return 'unknown_browser';
        }
    }


    protected function get_dev_hash()
    {
        return hash('CRC32', $this->client_ip . $this->useragent, false);
    }


    protected function geodata()
    {
        $alfa2 = $this->SypexGeo->getCountry($this->client_ip);

        $geocode = $alfa2 ? strtoupper($alfa2) : 'XX';

        if (mb_strlen($geocode, "UTF-8") == 2) {
            $key = array_search($geocode, $this->geo_alfa2);
        } elseif (mb_strlen($geocode, "UTF-8") == 3) {
            $key = array_search($geocode, $this->geo_alfa3);
        } else {
            $key = array_search($geocode, $this->geo_countryes);
        }

        if ($key) {
            return array(
                'name'    => $this->geo_countryes[$key],
                'alfa2'   => $this->geo_alfa2[$key],
                'alfa3'   => $this->geo_alfa3[$key],
                'numeric' => $this->geo_numeric[$key]
            );
        }

        return array(
            'name'    => 'unknown',
            'alfa2'   => 'XX',
            'alfa3'   => 'XXX',
            'numeric' => '000'
        );
    }


}
