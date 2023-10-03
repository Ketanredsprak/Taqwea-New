@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords($user->student->name)}},
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.your')}} {{$user->class->class_type}} <strong> {{$user->class->class_name}}</strong> {{__('message.schedule')}} {{convertDateToTz($user->class->start_time,'UTC','d M Y h:i A', $user->student->time_zone)}} {{__('message.has_been_cancelled')}}<strong> {{$user->class->tutor()->withTrashed()->getResults()->translateOrDefault()->name}}</strong>. {{__('message.please_book_a_new')}} {{$user->class->class_type}}. {{__('message.we_are_sry_for_the')}}.
            </p>
        </td>
    </tr>
</tbody>

@endsection
