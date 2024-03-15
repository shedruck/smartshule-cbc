<?php

/*
  PHP User Agent Class
  Author: Tom Lloyd
 */

class UserAgent
{

    public $os_array = [
              '/windows nt 10/i' => 'Windows 10',
              '/windows phone 10/i' => 'Windows Phone 10',
              '/windows phone 8.1/i' => 'Windows Phone 8.1',
              '/windows phone 8/i' => 'Windows Phone 8',
              '/windows nt 6.3/i' => 'Windows 8.1',
              '/windows nt 6.2/i' => 'Windows 8',
              '/windows nt 6.1/i' => 'Windows 7',
              '/windows nt 6.0/i' => 'Windows Vista',
              '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
              '/windows nt 5.1/i' => 'Windows XP',
              '/windows xp/i' => 'Windows XP',
              '/windows nt 5.0/i' => 'Windows 2000',
              '/windows me/i' => 'Windows ME',
              '/win98/i' => 'Windows 98',
              '/win95/i' => 'Windows 95',
              '/win16/i' => 'Windows 3.11',
              '/macintosh|mac os x/i' => 'Mac OS X',
              '/mac_powerpc/i' => 'Mac OS 9',
              '/iphone/i' => 'iPhone',
              '/ipod/i' => 'iPod',
              '/ipad/i' => 'iPad',
              '/android/i' => 'Android',
              '/linux/i' => 'Linux',
              '/ubuntu/i' => 'Ubuntu',
              '/blackberry/i' => 'BlackBerry',
              '/webos/i' => 'Mobile'
    ];
    public $browser_array = [
              '/mobile/i' => 'Handheld Browser',
              '/msie/i' => 'Internet Explorer',
              '/firefox/i' => 'Firefox',
              '/safari/i' => 'Safari',
              '/chrome/i' => 'Chrome',
              '/edge/i' => 'Edge',
              '/opera/i' => 'Opera',
              '/netscape/i' => 'Netscape',
              '/maxthon/i' => 'Maxthon',
              '/konqueror/i' => 'Konqueror'
    ];
    public $os_platform = "Other";
    public $browser = "Other";
    public $isp = "ISP Not Detected.";
    private $user_agent = NULL;

    public function __construct()
    {
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        //$this->browser = get_browser(NULL, true);
    }

    public function OS()
    {
        foreach ($this->os_array as $regex => $value)
        {
            if (preg_match($regex, $this->user_agent))
            {
                return $value;
            }
        }
        return $this->os_platform;
    }

    public function Browser()
    {
        $browser = "";
        foreach ($this->browser_array as $regex => $value)
        {
            if (preg_match($regex, $this->user_agent))
            {
                $browser = $value;
            }
        }
        return $browser == "" ? $this->browser : $browser;
    }

    public function BrowserVersion()
    {
        $detected = $this->Browser();
        $d = array_search($detected, $this->browser_array);
        $browser = str_replace(array("/i", "/"), "", $d);
        $regex = "/(?<browser>version|{$browser})[\/]+(?<version>[0-9.|a-zA-Z.]*)/i";
        if (preg_match_all($regex, $this->user_agent, $matches))
        {
            $found = array_search($browser, $matches["browser"]);
            return $matches["version"][$found];
        }
        return "";
    }

    public function isMobile()
    {
        if (preg_match('/mobile|phone|ipod/i', $this->user_agent))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isTablet()
    {
        if (preg_match('/tablet|ipad/i', $this->user_agent))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isDesktop()
    {
        if (!$this->isMobile() && !$this->isTablet())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isBot()
    {
        if (preg_match('/bot/i', $this->user_agent))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function user_agent()
    {
        return $this->user_agent;
    }

}
