@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords(@$transaction->user->name)}} ,
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.blog_purchase_details')}}<br /><br />
                <strong>{{__('message.blog_name')}}</strong>- {{ @$transaction->transactionItems[0]->blog->blog_title}}<br />
                <strong>{{__('message.tutor_name')}}</strong>- {{ @$transaction->transactionItems[0]->blog->tutor->name}}<br />

                <strong>{{__('message.payment_details')}}-</strong><br />
                {{__('message.amount')}}- {{config('app.currency.default')}} {{@$transaction->transactionItems[0]->amount+@$transaction->transactionItems[0]->commission}}<br />
                {{__('message.vat')}} ({{getSetting('vat')}}%)- {{config('app.currency.default')}} {{@$transaction->vat}}<br />
                {{__('message.transaction_fee')}}- ({{getSetting('transaction_fee')}}%)- {{config('app.currency.default')}} {{@$transaction->transaction_fees}}<br />
                <strong>{{__('message.total_amount')}}- {{config('app.currency.default')}} {{@$transaction->total_amount}}</strong><br />

            </p>
        </td>
    </tr>
</tbody>

@endsection