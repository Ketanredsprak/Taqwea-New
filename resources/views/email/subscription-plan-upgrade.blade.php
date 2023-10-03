@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hi')}} {{ucwords($user->tutor->name)}},
            </h2>
        </td>
    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.congrats_you_have_success')}}<strong> {{ ucwords($user->subscription->subscription_name)  }}</strong>. {{__('message.you_will_receive_following_benefits')}}.
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.benefit_details')}}-</br>

                {{$user->class_hours}} {{__('message.number_of_hours')}}</br>
                {{$user->webinar_hours}} {{__('message.number_of_webinar_hours')}}</br>
                {{$user->blog}} {{__('message.number_of_blog_hours')}}</br>
                @if($user->subscription->subscription_name != 'Basic')
                {{__('message.your_plan_will_be_active_till')}} {{$user->start_date}} || {{$user->end_date}}.
                @endif
            </p>
        </td>
    </tr>

</tbody>

@endsection