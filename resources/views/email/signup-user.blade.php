@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hello')}} {{ucwords($user->name)}} ,
            </h2>
        </td>
    </tr>
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.welcome_to_the_taqwea_platform_as')}} <strong> {{ucfirst($user->user_type)}}</strong> {{__('message.we_are_so_lucky_to_have_you')}}..
            </p>
        </td>
    </tr>
    @if($user->user_type == 'student')
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.student_provides_a_platform_you_can_find')}}.
            </p>
        </td>
    </tr>
    @else
    <tr>
        <td style="padding-top:20px;padding-bottom: 20px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.tutor_provides_a_platform_to_teach_different_subjects')}}.
            </p>
        </td>
    </tr>
    @endif
</tbody>

@endsection