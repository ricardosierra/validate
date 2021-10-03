<?php

namespace Validate;

class Url implements \Validate\Contracts\Validate
{
    public static function toDatabase(string $url)
    {
        $url = str_replace('http://', '', $url);
        $url = str_replace('https://', '', $url);
        return $url;
    }

    public static function toUser($url)
    {
        return 'https://'.$url;
    }

    public static function validate($url): bool
    {
        if (strpos($url, ' ') !== false) {
            return false;
        }
        return true;
    }

    /**
     * @return false|string[]
     *
     * @psalm-return array{scheme?: string, user?: string, pass?: string, host?: string, port?: string, path?: string, query?: string, fragment?: string}|false
     */
    public static function break(string $url)
    {
        return self::splitUrl($url);
    }

    public static function isSame(string $to, string $from): bool
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }


    /**
     * Given a URL calculates the page's directory
     *
     * @params string $url target URL
     * @return string Directory
     */
    public function parseDir($url)
    {
        $slash = strrpos($url, '/');
        return substr($url, 0, $slash+1);
    }

    /**
     * Link Checking Functions
     */

    /**
     * Uniformly cleans a link to avoid duplicates
     *
     * 1. Changes relative links to absolute (/bar to http://www.foo.com/bar)
     * 2. Removes anchor tags (foo.html#bar to foo.html)
     * 3. Adds trailing slash if directory (foo.com/bar to foo.com/bar/)
     * 4. Adds www if there is not a subdomain (foo.com to www.foo.com but not bar.foo.com)
     *
     * @params string $relativeUrl link to clean
     * @parmas string $baseUrl directory of parent (linking) page
     * @return string cleaned link
     */
    public function cleanLink($relativeUrl, $baseUrl)
    {
        $relativeUrl = self::urlToAbsolute($baseUrl, $relativeUrl); //make them absolute, not relative

        if (stripos($relativeUrl, '#') !== false) {
            $relativeUrl = substr($relativeUrl, 0, stripos($relativeUrl, '#')); //remove anchors
        }

        if (!preg_match('#(^http://(.*)/$)|http://(.*)/(.*)\.([A-Za-z0-9]+)|http://(.*)/([^\?\#]*)(\?|\#)([^/]*)#i', $relativeUrl)) {
            $relativeUrl .= '/';
        }

        $relativeUrl = preg_replace('#http://([^.]+).([a-zA-z]{3})/#i', 'http://www.$1.$2/', $relativeUrl);
        return $relativeUrl;
    }


    /**
     * Performs a regular expression to see if a given link is an image
     *
     * @params string $link target link
     * @return bool true on image, false on anything else
     */
    public static function isImage($link)
    {
        if (preg_match('%\.(gif|jpe?g|png|bmp)$%i', $link)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks to see that a given link is within the domain/host whitelist
     *
     * Improved from original to use regular expression and match hosts.
     *
     * @params string $link target link
     * @return bool true if out of domain, false if on domain whitelist
     */
    public static function outOfDomain($link, $domainArray)
    {
        if (!is_array($domainArray)) {
            $domainArray[] = $domainArray;
        }

        // get host name from URL
        preg_match("/^(http:\/\/)?([^\/]+)/i", $link, $matches);
        $host = $matches[2];
        // echo "<br />host: $host";
        // get last two segments of host name
        // preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        foreach ($domainArray as $domain) {
            if ($domain == $host) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks to see that a given link matches a pattern in the exclude list
     *
     * @params string $link target link
     * @return bool true if matches exclude, false if no match
     */
    public function excludeByPattern($link, $excludedArray = [])
    {
        if (!is_array($excludedArray)) {
            $excludedArray[] = $excludedArray;
        }

        foreach ($excludedArray as $pattern) {
            if (preg_match($pattern, urldecode($link))) {
                echo "<p>matched exclude pattern <b>$pattern</b> in ".urldecode($link)."</p>";
                return true;
            }
        }
        return false;
    }

    /**
     * Checks to see if a given link is in fact a mailto: link
     *
     * @params string $link Link to check
     * @return bool true on mailto:, false on everything else
     */
    public static function isMailto($link)
    {
        if (stripos($link, 'mailto:')===false) {
            return false;
        } else {
            return true;
        }
    }

    /* Depreciated (I think)

    public function count_slashes($url) {
        if (strlen($url)<7) return 0;
        return substr_count($url,'/',7);
    }

    public function get_slashes($url) {
        if (preg_match_all('#/#',$url,$matches,PREG_OFFSET_CAPTURE,7)) return $matches[0];
        else return array();
    }
    */

    /**
     * Converts a relative URL (/bar) to an absolute URL (http://www.foo.com/bar)
     *
     * Inspired from code available at http://nadeausoftware.com/node/79,
     * Code distributed under OSI BSD (http://www.opensource.org/licenses/bsd-license.php)
     *
     * @params string $baseUrl Directory of linking page
     * @params string $relativeURL URL to convert to absolute
     *
     * @return false|string Absolute URL
     */
    public static function urlToAbsolute($baseUrl, $relativeUrl)
    {
        // If relative URL has a scheme, clean path and return.
        if (!$r = self::splitUrl($relativeUrl)) {
            return false;
        }


        if (!empty($r['scheme'])) {
            if (!empty($r['path']) && $r['path'][0] == '/') {
                $r['path'] = self::urlRemoveDotSegments($r['path']);
            }

            return self::joinUrl($r);
        }
    
        // Make sure the base URL is absolute.
        $b = self::splitUrl($baseUrl);
        if ($b === false || empty($b['scheme']) || empty($b['host'])) {
            return false;
        }

        $r['scheme'] = $b['scheme'];
    
        // If relative URL has an authority, clean path and return.
        if (isset($r['host'])) {
            if (!empty($r['path'])) {
                $r['path'] = self::urlRemoveDotSegments($r['path']);
            }

            return self::joinUrl($r);
        }
        unset($r['port']);
        unset($r['user']);
        unset($r['pass']);
    
        // Copy base authority.
        $r['host'] = $b['host'];
        if (isset($b['port'])) {
            $r['port'] = $b['port'];
        }
        if (isset($b['user'])) {
            $r['user'] = $b['user'];
        }
        if (isset($b['pass'])) {
            $r['pass'] = $b['pass'];
        }
    
        // If relative URL has no path, use base path
        if (empty($r['path'])) {
            if (!empty($b['path'])) {
                $r['path'] = $b['path'];
            }

            if (!isset($r['query']) && isset($b['query'])) {
                $r['query'] = $b['query'];
            }

            return self::joinUrl($r);
        }
    
        // If relative URL path doesn't start with /, merge with base path
        if ($r['path'][0] != '/') {
            $base = mb_strrchr($b['path'], '/', true, 'UTF-8');
            if ($base === false) {
                $base = '';
            }
            $r['path'] = $base . '/' . $r['path'];
        }
        $r['path'] = self::urlRemoveDotSegments($r['path']);
        return self::joinUrl($r);
    }

    /**
     * Required public function of URL to absolute
     *
     * Inspired from code available at http://nadeausoftware.com/node/79,
     * Code distributed under OSI BSD (http://www.opensource.org/licenses/bsd-license.php)
     *
     * @return string
     */
    public static function urlRemoveDotSegments(string $path): string
    {
        // multi-byte character explode
        $inSegs  = preg_split('!/!u', $path);
        $outSegs = array( );
        foreach ($inSegs as $seg) {
            if ($seg == '' || $seg == '.') {
                continue;
            }
            if ($seg == '..') {
                array_pop($outSegs);
            } else {
                array_push($outSegs, $seg);
            }
        }
        $outPath = implode('/', $outSegs);
        if ($path[0] == '/') {
            $outPath = '/' . $outPath;
        }

        // compare last multi-byte character against '/'
        if ($outPath != '/' 
            && (mb_strlen($path)-1) == mb_strrpos($path, '/')
        ) {
            $outPath .= '/';
        }

        return $outPath;
    }

    /**
     * Required public function of URL to absolute
     *
     * Inspired from code available at http://nadeausoftware.com/node/79,
     * Code distributed under OSI BSD (http://www.opensource.org/licenses/bsd-license.php)
     *
     * @return false|string[]
     *
     * @psalm-return array{scheme?: string, user?: string, pass?: string, host?: string, port?: string, path?: string, query?: string, fragment?: string}|false
     */
    public static function splitUrl(string $url, $decode=true)
    {
        $parts = [];
        $m = [];
        $xunressub     = 'a-zA-Z\d\-._~\!$&\'()*+,;=';
        $xpchar        = $xunressub . ':@%';

        $xscheme       = '([a-zA-Z][a-zA-Z\d+-.]*)';

        $xuserinfo     = '((['  . $xunressub . '%]*)' .
                        '(:([' . $xunressub . ':%]*))?)';

        $xipv4         = '(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})';

        $xipv6         = '(\[([a-fA-F\d.:]+)\])';

        $xhost_name    = '([a-zA-Z%]+)';
        // $xhost_name    = '([a-zA-Z\d-.%]+)'; @todo alterado pq tava dando erro nesse parser

        $xhost         = '(' . $xhost_name . '|' . $xipv4 . '|' . $xipv6 . ')';
        $xport         = '(\d*)';
        $xauthority    = '((' . $xuserinfo . '@)?' . $xhost .
                        '?(:' . $xport . ')?)';

        $xslash_seg    = '(/[' . $xpchar . ']*)';
        $xpath_authabs = '((//' . $xauthority . ')((/[' . $xpchar . ']*)*))';
        $xpath_rel     = '([' . $xpchar . ']+' . $xslash_seg . '*)';
        $xpath_abs     = '(/(' . $xpath_rel . ')?)';
        $xapath        = '(' . $xpath_authabs . '|' . $xpath_abs .
                        '|' . $xpath_rel . ')';

        $xqueryfrag    = '([' . $xpchar . '/?' . ']*)';

        $xurl          = '^(' . $xscheme . ':)?' .  $xapath . '?' .
                        '(\?' . $xqueryfrag . ')?(#' . $xqueryfrag . ')?$';
    
    
        // Split the URL into components.
        if (!preg_match('!' . $xurl . '!', $url, $m)) {
            return false;
        }
    
        if (!empty($m[2])) {
            $parts['scheme']  = strtolower($m[2]);
        }
    
        if (!empty($m[7])) {
            if (isset($m[9])) {
                $parts['user']    = $m[9];
            } else {
                $parts['user']    = '';
            }
        }
        if (!empty($m[10])) {
            $parts['pass']    = $m[11];
        }
    
        if (!empty($m[13])) {
            $h=$parts['host'] = $m[13];
        } elseif (!empty($m[14])) {
            $parts['host']    = $m[14];
        } elseif (!empty($m[16])) {
            $parts['host']    = $m[16];
        } elseif (!empty($m[5])) {
            $parts['host']    = '';
        }
        if (!empty($m[17])) {
            $parts['port']    = $m[18];
        }
    
        if (!empty($m[19])) {
            $parts['path']    = $m[19];
        } elseif (!empty($m[21])) {
            $parts['path']    = $m[21];
        } elseif (!empty($m[25])) {
            $parts['path']    = $m[25];
        }
    
        if (!empty($m[27])) {
            $parts['query']   = $m[28];
        }
        if (!empty($m[29])) {
            $parts['fragment']= $m[30];
        }
    
        if (!$decode) {
            return $parts;
        }
        if (!empty($parts['user'])) {
            $parts['user']     = rawurldecode($parts['user']);
        }
        if (!empty($parts['pass'])) {
            $parts['pass']     = rawurldecode($parts['pass']);
        }
        if (!empty($parts['path'])) {
            $parts['path']     = rawurldecode($parts['path']);
        }
        if (isset($h)) {
            $parts['host']     = rawurldecode($parts['host']);
        }
        if (!empty($parts['query'])) {
            $parts['query']    = rawurldecode($parts['query']);
        }
        if (!empty($parts['fragment'])) {
            $parts['fragment'] = rawurldecode($parts['fragment']);
        }
        return $parts;
    }

    /**
     * Required public function of URL to absolute
     *
     * Inspired from code available at http://nadeausoftware.com/node/79,
     * Code distributed under OSI BSD (http://www.opensource.org/licenses/bsd-license.php)
     *
     * @return string
     *
     * @param string[] $parts
     */
    public static function joinUrl(array $parts, $encode=true): string
    {
        if ($encode) {
            if (isset($parts['user'])) {
                $parts['user']     = rawurlencode($parts['user']);
            }
            if (isset($parts['pass'])) {
                $parts['pass']     = rawurlencode($parts['pass']);
            }
            if (isset($parts['host']) 
                && !preg_match('!^(\[[\da-f.:]+\]])|([\da-f.:]+)$!ui', $parts['host'])
            ) {
                $parts['host']     = rawurlencode($parts['host']);
            }
            if (!empty($parts['path'])) {
                $parts['path']     = preg_replace(
                    '!%2F!ui',
                    '/',
                    rawurlencode($parts['path'])
                );
            }

            if (isset($parts['query'])) {
                $parts['query']    = rawurlencode($parts['query']);
            }

            if (isset($parts['fragment'])) {
                $parts['fragment'] = rawurlencode($parts['fragment']);
            }
        }
    
        $url = '';
        if (!empty($parts['scheme'])) {
            $url .= $parts['scheme'] . ':';
        }
        if (isset($parts['host'])) {
            $url .= '//';
            if (isset($parts['user'])) {
                $url .= $parts['user'];
                if (isset($parts['pass'])) {
                    $url .= ':' . $parts['pass'];
                }
                $url .= '@';
            }
            if (preg_match('!^[\da-f]*:[\da-f.:]+$!ui', $parts['host'])) {
                $url .= '[' . $parts['host'] . ']';
            } // IPv6
            else {
                $url .= $parts['host'];
            }             // IPv4 or name
            if (isset($parts['port'])) {
                $url .= ':' . $parts['port'];
            }
            if (!empty($parts['path']) && $parts['path'][0] != '/') {
                $url .= '/';
            }
        }
        if (!empty($parts['path'])) {
            $url .= $parts['path'];
        }
        if (isset($parts['query'])) {
            $url .= '?' . $parts['query'];
        }
        if (isset($parts['fragment'])) {
            $url .= '#' . $parts['fragment'];
        }
        return $url;
    }
}
