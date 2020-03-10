<?php

/**
 * This file is part of Laravel Social Share
 *
 * @license     MIT
 * @package     Shanmuga\SocialShare
 * @category    Facades
 * @author      Shanmugarajan
 */

namespace Shanmuga\SocialShare\Facades;

use Illuminate\Support\Facades\Facade;

class SocialShareFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SocialShare';
    }
}