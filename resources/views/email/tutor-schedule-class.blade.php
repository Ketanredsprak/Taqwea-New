@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords($bookings[0]->class->tutor->name)}},
            </h2>
        </td>
    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.your_schedule_class_is_full')}}.
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{$bookings[0]->class->class_name}} - {{convertDateToTz($bookings[0]->class->start_time,'UTC','h:i A', $bookings[0]->class->tutor->time_zone)}} {{__('message.for')}} {{getDuration($bookings[0]->class->duration)}}</br>

                {{__('message.student_names')}}-
                @foreach($bookings as $booking)
                {{$loop->iteration}}. {{$booking->student->name}}</br>
                @endforeach
            </p>
        </td>
    </tr>

</tbody>

@endsection