@extends('layouts.email.app')

@section('content')

<tbody>
    <tr>
        <td style=" padding-top:20px;padding-bottom: 20px;">
            <h2 style="color:#1C2753;font-size:24px;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px; padding-top:10px;padding-bottom: 0;margin-top:0;margin-bottom:0;">
             {{__('message.hi')}} {{$data['name']}} ,
            </h2>
        </td>

    </tr>
    <tr>
        <td style="padding-top:5px;padding-bottom:15px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.taqwea_accountant_has_debited')}} {{@$data['type'] == "debit" ? __('message.debit') : __('message.credit')}} {{$data['no_of_points']}} {{__('message.points_to_your_wallet')}}
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top:5px;padding-bottom:15px;">
            <p style="font-size:15px;color:#000;font-family:Tahoma, Geneva, sans-serif;padding-left: 25px;margin-bottom:0;margin-top:0;">
                {{__('message.current_points_balance')}} = {{$data['total_point']}}
            </p>
        </td>
    </tr>
</tbody>

@endsection