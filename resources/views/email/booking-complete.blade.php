@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords($user->student->name)}} ,
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.congrats')}} {{$user->class->class_type == 'class' ? __('labels.class') : __('labels.webinar')}} <strong>{{$user->class->class_name}}</strong> {{__('message.completed')}}.{{__('message.your_chat_window_for_this_day',['class' => $user->class->class_type == 'class' ? __('labels.class') : __('labels.webinar') ])}}
            </p>
        </td>
    </tr>
</tbody>

@endsection
