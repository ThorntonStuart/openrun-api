<?php

namespace App\Http\Controllers\Api\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressTransformer;
use App\Services\AddressLookupService;
use Illuminate\Http\Request;

class AddressesLookupController extends Controller
{
    /**
     * @var AddressLookupService $addressLookupService
     */
    protected AddressLookupService $addressLookupService;

    /**
     * @param AddressLookupService $addressLookupService
     * @return void
     */
    public function __construct(AddressLookupService $addressLookupService)
    {
        $this->addressLookupService = $addressLookupService;
    }

    public function __invoke(Request $request)
    {
        $addresses = $this->addressLookupService->getAddresses($request->input('search'));

        return AddressTransformer::collection($addresses);
    }
}
