@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords($classes[0]->tutor->name)}} ,
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.you_have_schedule_webinar_at_the_following')}}-.<br />

                @foreach($classes as $class)
                {{convertDateToTz($class->start_time,'UTC','h:i A', $timeZone)}}- {{$class->class_name}} <br />
                {{__('message.tutor_name')}}- {{$class->tutor->name}}<br>
                @endforeach
            </p>
        </td>
    </tr>
</tbody>

@endsection