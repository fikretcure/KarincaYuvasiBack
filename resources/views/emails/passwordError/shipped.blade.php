<x-mail::message>
    # Hesabiniza basarisiz giris denemesi yapilmistir.Sifre bilgilerinizi kontrol etmelisiniz.Girilen sifre ektedir.

    # Datetime {{$data['date']}}
    # Email {{$data['email']}}

    # Remote Addr {{$data['remote_addr']}}
    # Server Addr {{$data['server_addr']}}
    # Browser {{$data['http_user_agent']}}

    Kolayliklar dileriz,Iyi calismalar
    {{ config('app.name') }}
</x-mail::message>
