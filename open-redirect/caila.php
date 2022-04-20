<?php
class CAILA
{
  // Properties
  public $blacklistedDomains;
  public $whitelistedDomains;

  function __construct($options)
  {
    $this->blacklistedDomains = isset($options['blacklistedDomains'])
      ? $options['blacklistedDomains']
      : [];
    $this->whitelistedDomains = isset($options['whitelistedDomains'])
      ? $options['whitelistedDomains']
      : [];
  }

  function getURLClassification($url)
  {
    $host = $this->getSimplifiedHost($url);

    if ($host === 'invalid') {
      return 'invalid';
    }

    // run against the blacklist
    for ($i = 0; $i < count($this->blacklistedDomains); $i++) {
      // generate pattern to make sure that even the subdomains are handled
      $pattern = '/' . preg_quote($this->blacklistedDomains[$i], '/') . '$/';
      // check if the blacklist pattern matches the host
      if (preg_match($pattern, $host)) {
        return 'blacklisted';
      }
    }

    // run against the whitelist
    for ($i = 0; $i < count($this->whitelistedDomains); $i++) {
      // generate pattern to make sure that even the subdomains are handled
      $pattern = '/' . preg_quote($this->whitelistedDomains[$i], '/') . '$/';
      // check if the whitelist pattern matches the host
      if (preg_match($pattern, $host)) {
        return 'whitelisted';
      }
    }

    return 'normal';
  }

  function getSimplifiedHost($url)
  {
    // get the hostname from the URL
    $host = parse_url($url, PHP_URL_HOST);
    $port = parse_url($url, PHP_URL_PORT);

    // if the URL contains a port number, append it
    if ($port) {
      $host .= ':' . $port;
    }

    if ($this->isHostIsDomain($host)) {
      return strtolower($host);
    } elseif ($this->isHostIsIP($host)) {
      // if host is a proper IPv4
      // just fine
      return $host;
    } elseif ($this->isHostIPv4v6Embedding($host)) {
      // if host is IPv6/IPv4 embedding format
      // get the IPv4 part by separating using ":"
      $parts = explode(':', $host);
      $host = $parts[count($parts) - 1];
      // then remove ] in the right
      $host = rtrim($host, '] ');
      return $host;
    } else {
      return 'invalid';
    }
  }

  function isHostIsDomain($host)
  {
    // if IP is in format of domain.tld:PORT
    $parts = explode(':', $host);
    if (count($parts) > 2) {
      return false;
    }

    $host = $parts[0];
    $port = $parts[1];

    if (
      preg_match(
        '/^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$/',
        $host
      ) &&
      // port must be empty or in range of 1-65535
      (is_null($port) || ($port >= 1 && $port <= 65535))
    ) {
      return true;
    }

    return false;
  }

  function isHostIsIP($host)
  {
    // if IP is in format of IP:PORT
    $parts = explode(':', $host);
    if (count($parts) > 2) {
      return false;
    }

    $ip = $parts[0];
    $port = $parts[1];

    if (
      preg_match(
        '/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/',
        $ip
      ) &&
      // port must be empty or in range of 1-65535
      (is_null($port) || ($port >= 1 && $port <= 65535))
    ) {
      return true;
    }

    return false;
  }

  function isHostIPv4v6Embedding($host)
  {
    return preg_match(
      '/^(\[::ffff:|\[0:0:0:0:0:ffff:)(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\]$/',
      $host
    );
  }
}
?>
