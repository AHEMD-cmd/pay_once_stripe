<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
   
    public function __invoke(Request $request)
    {
        return redirect('/');
    }
}
