@extends('layouts.email.app')

@section('content')


<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords($transactionItem->classWebinar->tutor->name)}},
            </h2>
        </td>
    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                <strong> {{$transactionItem->student->name}} </strong>{{__('message.has_enrolled_for_the_scheduled')}} {{$transactionItem->classWebinar->class_type}} {{$transactionItem->classWebinar->class_name}}.
            </p>
        </td>
    </tr>
</tbody>

@endsection
