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
    Hello {{ $username }}, This is your Verification Code: {{ $code }}

    <footer>
        {{--    don't forget copyright, terms of service, etc...    --}}
        {{--    terms have it's own route name, check the route file, or do php artisan route:list    --}}
    </footer>
</body>
