<?php

/**
 * This file is part of Laravel Social Share,
 *
 * @license     MIT
 * @package     Shanmuga\SocialShare
 * @category    Library
 * @author      Shanmugarajan
 */

namespace Shanmuga\SocialShare\Library;

use Arr;
use View;

class SocialShare
{
    protected $app, $url, $title, $media;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function load($url, $title = '', $media = '')
    {
        $this->url = $url;
        $this->title = $title;
        $this->media = $media;
        return $this;
    }

    public function services()
    {
        $services = func_get_args();

        if (empty($services)) {
            $services = array_keys($this->app->config->get('social_share.services'));
        }
        elseif (is_array($services[0])) {
            $services = $services[0];
        }

        $object = false;
        if (end($services) === true) {
            $object = true;
            array_pop($services);
        }

        $return = array();

        if ($services) {
            foreach ($services as $service) {
                $return[$service] = $this->$service();
            }
        }

        if ($object) {
            return (object) $return;
        }

        return $return;
    }

    protected function generateUrl($serviceId)
    {
        $vars = [
            'service' => $this->app->config->get("social_share.services.$serviceId", []),
            'sep' => $this->app->config->get('social_share.separator', '&'),
        ];

        if (empty($vars['service']['only'])) {
            $only = [ 'url', 'title', 'media' ];
        }
        else {
            $only = $vars['service']['only'];
        }

        foreach ($only as $varName) {
            $vars[$varName] = $this->$varName;
        }
        return trim(View::make("social_share::default", $vars)->render());
    }

    public function __call($name, $arguments)
    {
        return $this->generateUrl($name);
    }
}