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
                {{__('message.your_payment_has_been_success')}}.<br />
                @php $amount = 0; @endphp
                @foreach(@$transaction->transactionItems as $key=>$transactionItem)
                @php $amount += ($transactionItem->amount+$transactionItem->commission) ; @endphp
                @if(!empty($transactionItem->classWebinar->class_type) && $transactionItem->classWebinar->class_type == "class")
                <strong>{{__('message.class_details')}}-</strong><br /><br />
                <strong>{{__('message.course_name')}}</strong>- {{ $transactionItem->classWebinar->class_name}} <br />
                <strong>{{__('message.tutor_name')}}</strong>- {{ $transactionItem->classWebinar->tutor->name}} <br />
                <strong>{{__('message.date_end_time')}}</strong>- {{ convertDateToTz(
                                $transactionItem->classWebinar->start_time,
                                'UTC',
                                'd M Y h:i A',
                                @$transaction->user->time_zone
                            )}}<br /><br />
                @endif

                @if(!empty($transactionItem->classWebinar->class_type) && $transactionItem->classWebinar->class_type == "webinar")
                <strong>{{__('message.webinar_details')}}-</strong><br /><br />
                <strong>{{__('message.course_name')}}</strong>- {{ $transactionItem->classWebinar->class_name}} <br />
                <strong>{{__('message.tutor_name')}}</strong>- {{ $transactionItem->classWebinar->tutor->name}} <br />
                <strong>{{__('message.date_end_time')}}</strong>- {{ convertDateToTz(
                                $transactionItem->classWebinar->start_time,
                                'UTC',
                                'd M Y h:i A',
                                @$transaction->user->time_zone
                            )}}<br /><br />
                @endif

                @if(!empty($transactionItem->blog))
                <strong>{{__('message.blog_details')}}-</strong><br /><br />
                <strong>{{__('message.blog_name')}}</strong>- {{ $transactionItem->blog->blog_title}}<br />
                <strong>{{__('message.tutor_name')}}</strong>- {{ $transactionItem->blog->tutor->name}}<br /><br />
                @endif
                @endforeach

                <strong>{{__('message.payment_details')}}-</strong><br />
                {{__('message.amount')}}- {{config('app.currency.default')}} {{@$amount}}<br />
                {{__('message.vat')}} ({{getSetting('vat')}}%)- {{config('app.currency.default')}} {{@$transaction->vat}}<br />
                {{__('message.transaction_fee')}} ({{getSetting('transaction_fee')}}%)- {{config('app.currency.default')}} {{@$transaction->transaction_fees}}<br />
                <strong>{{__('message.total_amount')}}- {{config('app.currency.default')}} {{@$transaction->total_amount}}</strong><br />

            </p>
        </td>
    </tr>
</tbody>

@endsection