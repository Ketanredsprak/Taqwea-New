<!doctype html>
<html lang="{{config('app.locale')}}" dir="rtl">

<head>
    <meta content="width=device-width" name="viewport">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <title>{{config('app.name')}}</title>
</head>

<body bgcolor="#fff" style="text-align:right;">
    <table align="center" style="border-collapse:collapse;padding:50px; font-family:Tahoma, Geneva, sans-serif;background-color:#F6F6F9;font-size:16px;border: 2px solid #486F5D;width:800px;">
        <tbody>
            <tr>
                <td colspan="1" align="center" style="padding:20px 10px;">
                    <img vspace="0" hspace="0" align="center" height="43" style="display: block; height: 50px;" alt="logo" src="{{asset('assets/images/logo.png')}}" />
                </td>
            </tr>
        </tbody>

        @yield('content')

        <tbody>
            <tr>
                <td style="padding-top:15px;padding-bottom:5px;">
                    <p style="font-size:16px;color:#1C2753;font-family:Tahoma, Geneva, sans-serif;line-height:30px;padding-left: 25px;margin-top:0; margin-bottom:0;">
                    {{__('message.warm_regards')}},<br>
                    {{__('message.taqwea_team')}}
                    </p>
                </td>
            </tr>
            <tr>
                <td style="padding-top:15px;padding-bottom:5px;">
                    <p style="font-size:16px;color:#1C2753;font-family:Tahoma, Geneva, sans-serif;line-height:30px;padding-left: 25px;margin-top:0; margin-bottom:0;">
                        {{__('message.download_our_mobile_apps')}}:
                    </p>
                </td>
            </tr>
            <tr>
                <td style="padding-top:5px;padding-bottom:5px; padding-left: 25px;">
                    <a href="{{getSetting('google_link')}}"><img height="35px" src="{{asset('assets/images/google-play-btn.jpg')}}" alt="google-play"></a>
                    <a href="{{getSetting('app_store_link')}}"><img height="35px" src="{{asset('assets/images/app-store-btn.jpg')}}" alt="app-store"></a>
                </td>
            </tr>
            <tr>
                <td style="padding-top:5px;padding-bottom:15px;">
                    <p style="font-size:16px;color:#1C2753;font-family:Tahoma, Geneva, sans-serif;line-height:30px;padding-left: 25px;margin-top:0; margin-bottom:0;">
                        {{__('message.this_is_a_system_generated_message')}}.</p>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="padding-top:5px;padding-bottom:15px; padding-left: 25px;">
                    <img vspace="0" hspace="0" height="43" style="display: block; height: 50px;" alt="logo" src="{{asset('assets/images/logo.png')}}" />
                </td>
            </tr>
            <!-- <tr>
                <td style="padding-top:15px;padding-bottom:15px;">
                    <p style="font-size:16px;color:#1C2753;font-family:Tahoma, Geneva, sans-serif;line-height:30px;padding-left: 25px;margin-top:0; margin-bottom:0;">
                        {{config('app.name')}} Team
                    </p>
                </td>
            </tr>
            <tr> -->
                <td style="padding-top:10px;padding-bottom:10px;background: #486F5D;">
                    <p style="font-size:14px;color:#fff;font-family:Tahoma, Geneva, sans-serif;text-align:center; margin: 0;">© {{date('Y')}} Copyright {{config('app.name')}} inc.</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>