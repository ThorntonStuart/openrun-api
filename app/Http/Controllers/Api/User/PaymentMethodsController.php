<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $methods = $request->user()->hasPaymentMethod()
            ? collect($request->user()->paymentMethods())->map(fn ($method) => [
                'id' => $method->id,
                'brand' => $method->card->brand,
                'last_four' => $method->card->last4,
                'exp_month' => $method->card->exp_month,
                'exp_year' => $method->card->exp_year,
            ])->toArray()
            : [];
        
        return response()->json($methods);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $paymentMethodId = $request->input('payment_method_id');

        if (is_null($user->stripe_id)) {
            $user->createAsStripeCustomer();
        }

        $user->addPaymentMethod($paymentMethodId);
        $user->updateDefaultPaymentMethod($paymentMethodId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
