<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task Api Documentation</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 400;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 25px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            <code style="font-size: 20px;">
                <h3>Api ინსტრუქცია.</h3>
                <ol>
                    <li>
                        მომხმარებლის რეგისტრაცია:
                        <ul>
                            <li>GET მეთოდი: <a href="{{ url()->current() }}/api/v1/register?name=&email=&password=" target="_blink">{{ url()->current() }}/api/v1/register?name={name}&email={email}&password={password}</a></li>
                            <li>
                                POST მეთოდი: {{ url()->current() }}/api/v1/register
                                <ul>
                                    <li>Request პარამეტრები: name{name}, email{email}, password{password}</li>
                                </ul>
                            </li>
                        </ul>
                    </li><br />
                    <li>
                        მომხმარებლის ავტორიზაცია:
                        <ul>
                            <li>GET მეთოდი: <a href="{{ url()->current() }}/api/v1/login?email=&password=" target="_blink">{{ url()->current() }}/api/v1/login?email{email}&password{password}</a></li>
                            <li>
                                POST მეთოდი: {{ url()->current() }}/api/v1/login
                                <ul>
                                    <li>Request პარამეტრები: email{email}, password{password}</li>
                                </ul>
                            </li>
                        </ul>
                    </li><br />
                    <li>
                        ტოკენის გენერაცია თუ მომხმარებელის არის ვერიფიცირებული:
                        <ul>
                            <li>GET მეთოდი: <a href="{{ url()->current() }}/api/v1/create?access_token=" target="_blink">{{ url()->current() }}/api/v1/create?access_token{მომხმარებლის token}</a></li>
                            <li>
                                POST მეთოდი: {{ url()->current() }}/api/v1/create
                                <ul>
                                    <li>Request პარამეტრები: access_token{მომხმარებლის token}</li>
                                </ul>
                            </li>
                        </ul>
                    </li><br />
                    <li>
                        გენერირებული ტოკენის წაშლა, თუ მომხმარებელი არის ვერიფიცირებული და token არის მის მიერ შექმნილი:
                        <ul>
                            <li>
                                POST მეთოდი: {{ url()->current() }}/api/v1/delete
                                <ul>
                                    <li>Header პარამეტრი: Auth{token}</li>
                                    <li>Request პარამეტრი: token{token (დაგენერირებული ტოკენი)}</li>
                                </ul>
                            </li>
                        </ul>
                    </li><br />
                    <li>
                        მომხმარებლის (Logout):
                        <ul>
                            <li>
                                POST მეთოდი: {{ url()->current() }}/api/v1/logout
                                <ul>
                                    <li>Header პარამეტრი: Auth{token}</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ol><br />

                <h3>Atisan command.</h3>
                <ol>
                    <li>
                        ვადაგასული token -ების წაშლას ცხრილიდან:
                        <ul>
                            <li>Command: php artisan remove:expired-tokens</li>
                        </ul>
                    </li>
                </ol>
            </code>
        </div>
    </body>
</html>
