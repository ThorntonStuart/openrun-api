<?php

namespace App\Http\Controllers\Api\Auth\Social;

use App\Constants\SocialProviders;
use App\Http\Controllers\Api\Auth\Social\AbstractSocialController;
use Illuminate\Http\Request;

class FacebookSocialController extends AbstractSocialController
{
    /**
     * @var string
     */
    protected $providerName = SocialProviders::FACEBOOK;
    
    /**
     * @inheritdoc
     */
    protected function getProvider()
    {
        return $this->socialite->driver(SocialProviders::FACEBOOK);
    }
}
