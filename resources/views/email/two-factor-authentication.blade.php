@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style=" padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
                {{__('message.hello')}} {{ ucwords($user->name)}},
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:5px;padding-bottom:15px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.need_to_access_your_account')}}
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top:5px;padding-bottom:15px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.use_below_digit_verification_code')}}
            </p>
        </td>
    </tr>
    <tr>
        <td style=" padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:-24px;margin-bottom:0;">
                {{$user->otp}}
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:5px;padding-bottom:15px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.above_code_will_expire_in_minutes')}}..
            </p>
        </td>
    </tr>
</tbody>

@endsection