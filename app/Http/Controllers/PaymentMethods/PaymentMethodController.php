<?php

namespace App\Http\Controllers\PaymentMethods;

use Illuminate\Http\Request;
use App\Cart\Payments\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Requests\PaymentMethodStoreRequest;

class PaymentMethodController extends Controller
{
    // protected $gateway;
    public function __construct(Gateway $gateway)
    {
        $this->middleware(['auth:api']);
        $this->gateway=$gateway;
    }
    public function index(Request $request){
        return PaymentMethodResource::collection($request->user()->paymentMethods);
    }
    public function store(PaymentMethodStoreRequest $request){
        // dd($this->gateway);
        $card=$this->gateway->withUser($request->user())
            ->createCustomer()
            ->addCard($request->token);
        return new PaymentMethodResource($card);
    }
}
