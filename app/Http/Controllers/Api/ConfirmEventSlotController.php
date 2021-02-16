<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmEventSlotRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\PaymentFailure;

class ConfirmEventSlotController extends Controller
{
    public function __invoke(ConfirmEventSlotRequest $request, Event $event)
    {
        $user = $request->user();

        $paymentMethod = $user->findPaymentMethod($request->input('payment_method_id'));

        try {
            $charge = $user->charge($event->price, $request->input('payment_method_id'));
        } catch (PaymentActionRequired $exception) {

        } catch (PaymentFailure $exception) {

        }
        
        if ($charge->status === 'succeeded') {
            $event->participants()->save($user);
        }
        
        return response()->json(Response::HTTP_OK);
    }
}
