<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Podrazumijevane vrijednosti autentifikacije
    |--------------------------------------------------------------------------
    |
    | Ova opcija definira podrazumije authentificiranog "čuvara" i password
    | reset "broker" za vašu aplikaciju. Možete promijeniti ove vrijednosti
    | ako je potrebno, ali su savršeni početak za većinu aplikacija.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Autentifikacijski Guard-ovi
    |--------------------------------------------------------------------------
    |
    | Zatim, možete definirati svaki autentifikacijski guard za vašu aplikaciju.
    | Naravno, odlična default konfiguracija je definirana za vas
    | koja koristi sesijski spremnik (engl. session storage) plus korisnički provider Eloquent.
    |
    | Svi autentifkacijski guard-ovi imaju davatelja usluge (engl. user provider) koji definira kako
    | korisnici ustvari preuzimaju iz vaše baze podataka ili drugog sistema spremnika
    | koji se koristi u aplikaciji. Obično se koristi Eloquent.
    |
    | Podržava: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Davaoci korisničke usluge (engl. User Providers)
    |--------------------------------------------------------------------------
    |
    | Svi autentifikacijski guard-ovi imaju davaoca korisničke usluge, koji definira
    | kako se korisnici u stvari pruzimaju iz vaše baze podataka ili drugog sistema pohrane
    | koji aplikacija koristi. Obično se koristi Eloquent.
    |
    | Ako imate više korisničkih tablica ili modela, možete konfigurirati više
    | provider-a da predstavljaju model / tablicu. Ovi provider-i tada mogu
    | biti pridruni svim dodatnim guard-ovima koje ste definirali.
    |
    | Podržava: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Password-a
    |--------------------------------------------------------------------------
    |
    | Ove opcije konfiguracije određuju ponašanje Laravel-ove funkcionalnosti reset-ovanja
    | password-a, uključujući tablicu koja se koristi skladištenje tokena i davaoca
    | usluge korisniku (engl. user provider) koji se poziva da bi zaista preuzeo korisnike.
    |
    | Vrijeme isteka je broj minuta u kojem će se svaki reset token smatrati validnime.
    | Ova bezbjednosno svojstvo održava tokene kratkog vijeka tako da imaju manje
    | vremena za ocjenjivanje. Ovo možete promijeniti po potrebi.
    |
    | Podešavanje regulatora (engl. throttle setting) je broj sekundi koje korisnik mora
    | sačekati prije nego generira novi password za reset tokena. Ovo spriječava korisnika
    | da brzo generira veliku količinu tokena za reset password-a.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Vremensko ograničenje za potvrdu lozinke
    |--------------------------------------------------------------------------
    |
    | Ovdje možete definirati koliko sekundi prije potvrde password-a iskače
    | prozor i od korisnika se traži da ponovo unese svoj password pomoću ekrana
    | za potvrdu. Podrazumjevano je da vremensko ograničenje traje tri sata.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
