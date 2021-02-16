<?php

namespace App\Services;

use App\Models\Address;
use App\Models\LookupAddress;
use Firstclasspostcodes\Client;
use Firstclasspostcodes\ResponseError;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use VasilDakov\Postcode\Postcode;

class AddressLookupService
{
    /**
     * @var Client $postcodeClient
     */
    protected Client $postcodeClient;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->postcodeClient = new Client([
            'apiKey' => config('services.firstclasspostcodes.api_key'),
        ]);
    }

    /**
     * Retrieve addresses from database or API
     *
     * @param string $postcode
     * @return Collection
     */
    public function getAddresses(string $postcode): Collection
    {
        $postcode = new Postcode($postcode);
        $addresses = Address::whereHas('addressable', function ($query) use ($postcode) {
            return $query->where('postcode', $postcode);
        })->get();

        if ($addresses->isEmpty()) {
            $this->lookupAddressesByPostcode($postcode->normalise());
        } else {
            return $addresses;
        }
    }

    /**
     * Lookup addresses on Firstclasspostcodes
     *
     * @param string $postcode
     * @return Collection
     */
    protected function lookupAddressesByPostcode(string $postcode)
    {
        try {
            $results = $this->postcodeClient->getPostcode($postcode);
        } catch (ResponseError $exception) {
            report($exception);
            return new Collection();
        }

        if (is_null($results)) {
            return new Collection();
        }

        $data = Arr::only($results, [
            'postcode',
            'city',
            'position',
        ]);

        return collect(Arr::get($results, 'numbers'))->map(function ($result) use ($data) {
            return $this->createAddressFromPostcodeData(array_merge($data, $result));
        });
    }

    /**
     * Create a new address
     *
     * @param array $data
     * @return LookupAddress
     */
    protected function createAddressFromPostcodeData(array $data): LookupAddress
    {
        $sanitizedAddress = self::setAddressLines($data);
        $sanitizedAddress = self::convertKeys($sanitizedAddress);

        $lookupAddress = LookupAddress::firstOrCreate($sanitizedAddress);

        if (is_null($lookupAddress->address)) {
            $lookupAddress->address()->create();
        }

        return $lookupAddress;
    }

    /**
     * Set address data
     *
     * @param array $data
     * @return array
     */
    protected static function setAddressLines(array $data): array
    {
        if (Arr::has($data, 'number')) {
            $data['building_name'] = $data['number'];
            unset($data['number']);
        }

        return $data;
    }

    /**
     * Process array keys to model columns
     *
     * @param array $data
     * @return array
     */
    protected static function convertKeys(array $data): array
    {
        if (Arr::has($data, 'city')) {
            $data['town'] = $data['city'];
            unset($data['city']);
        }

        if (Arr::has($data, 'position')) {
            $data['latitude'] = Arr::get($data, 'position.latitude');
            $data['longitude'] = Arr::get($data, 'position.longitude');
            unset($data['position']);
        }

        $data['postcode'] = (new Postcode($data['postcode']))->normalise();
        
        return Arr::only($data, [
            'building_name',
            'street',
            'town',
            'postcode',
            'latitude',
            'longitude',
        ]);
    }
}