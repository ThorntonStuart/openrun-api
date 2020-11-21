<?php

namespace App\Http\Controllers\Api\Auth\Social;

use App\Constants\SocialProviders;
use App\Http\Controllers\Api\Auth\Social\AbstractSocialController;
use Illuminate\Http\Request;

class GoogleSocialController extends AbstractSocialController
{
    /**
     * @var string
     */
    protected $providerName = SocialProviders::GOOGLE;

    /**
     * @inheritdoc
     */
    protected function getProvider()
    {
        return $this->socialite->driver(SocialProviders::GOOGLE);
    }
}
