<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
</head>
<body>
    {{-- !!Note You Must use inline css for all the elements no css classes is allowed --}}
    {{-- !!Note please use normal css, don't use any css tricks, this is an email, it should be simple and compatible with any email service   --}}
    {{-- !!Note javascript is not allowed   --}}
    <div style="font-family: -webkit-pictograph;width: 100%;padding: 2rem;height: 100%;background-color: white;"><div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 339 56" style="
        width: 60%;
        margin: 0 auto;
    "><g id="Group_1" data-name="Group 1" transform="translate(-935 -509)"><path id="laravel-logo_2_" data-name="laravel-logo (2)" d="M49.626,11.564a.809.809,0,0,1,.028.209V22.745a.8.8,0,0,1-.4.694l-9.209,5.3V39.25a.8.8,0,0,1-.4.694L20.42,51.01a.859.859,0,0,1-.14.058c-.018.006-.035.017-.054.022a.805.805,0,0,1-.41,0c-.022-.006-.042-.018-.063-.026a.832.832,0,0,1-.132-.054L.4,39.944A.8.8,0,0,1,0,39.25V6.334a.818.818,0,0,1,.028-.21c.006-.023.02-.044.028-.067a.788.788,0,0,1,.051-.124.748.748,0,0,1,.055-.071.815.815,0,0,1,.071-.093.781.781,0,0,1,.079-.06A.652.652,0,0,1,.4,5.64h0L10.011.107a.8.8,0,0,1,.8,0l9.61,5.533h0a.98.98,0,0,1,.088.068.946.946,0,0,1,.078.06.936.936,0,0,1,.072.094.738.738,0,0,1,.054.071.835.835,0,0,1,.052.124c.008.023.022.044.028.068a.809.809,0,0,1,.028.209V26.893l8.008-4.611V11.772a.808.808,0,0,1,.028-.208c.007-.024.02-.045.028-.068a.9.9,0,0,1,.052-.124c.015-.026.037-.047.054-.071a.823.823,0,0,1,.072-.093.768.768,0,0,1,.078-.06.807.807,0,0,1,.088-.069h0l9.611-5.533a.8.8,0,0,1,.8,0l9.61,5.533a.883.883,0,0,1,.09.068c.025.02.054.038.077.06a.935.935,0,0,1,.072.094.6.6,0,0,1,.054.071.793.793,0,0,1,.052.124.572.572,0,0,1,.028.068ZM48.052,22.282V13.158l-3.363,1.936-4.646,2.675v9.124l8.01-4.611Zm-9.61,16.505v-9.13l-4.57,2.61-13.05,7.448v9.216l17.62-10.144ZM1.6,7.719V38.787L19.22,48.93V39.716l-9.2-5.209,0,0,0,0a37.426,37.426,0,0,0-.162-.124l0,0a.762.762,0,0,1-.066-.084.855.855,0,0,1-.06-.078v0a.638.638,0,0,1-.042-.1.592.592,0,0,1-.038-.09h0a.766.766,0,0,1-.016-.117.694.694,0,0,1-.012-.09V12.33L4.965,9.654,1.6,7.72Zm8.81-5.994L2.4,6.334l8,4.609,8.006-4.61L10.41,1.725Zm4.164,28.764,4.645-2.674V7.719L15.858,9.655,11.212,12.33v20.1l3.364-1.937ZM39.243,7.164l-8.006,4.609,8.006,4.609,8.005-4.61L39.243,7.164Zm-.8,10.6L33.8,15.094l-3.363-1.936v9.124l4.645,2.674,3.364,1.937V17.769ZM20.02,38.33l11.743-6.7,5.87-3.35-8-4.606-9.211,5.3-8.4,4.833L20.02,38.33Z" transform="translate(935 511)" fill="#ff2d20" fill-rule="evenodd"></path> <text id="SocialWeb.Dev" transform="translate(1001 554)" fill="#ff2d20" font-size="42" font-family="SegoeUI, Segoe UI"><tspan x="0" y="0">SocialWeb</tspan><tspan y="0" fill="#333">.Dev</tspan></text></g></svg> <p style="
        font-size: 2rem;
        color: rgb(47 47 47);
    ">Hi <span style="
        font-weight: bold;
    ">{{  Auth::user()->first_name }},</span></p> <p style="
        font-size: 1.5rem;
    "><span>Congratulations</span>, Your account has been created now you just need to confirm your email</p> <p style="
        font-size: 1.5rem;
    ">Copy this code in the <a href="http://localhost/verify/email/notice">verification page</a></p> <h2 style="
        font-size: 4rem;
        font-weight: 400;
    ">{{ $code }}</h2></div></div>

    <footer>
        {{--    don't forget copyright, terms of service, etc...    --}}
        {{--    terms have it's own route name, check the route file, or do php artisan route:list    --}}
    </footer>
</body>
