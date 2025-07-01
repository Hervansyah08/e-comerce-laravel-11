<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-[#edede9]">
    <div class="flex justify-center">
        <div class="rounded-lg border border-gray-200 bg-white p-12 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="text-center">
                <p class="text-xl text-center font-bold leading-tight text-gray-900 dark:text-white">
                    Email verification has been sent to your email address
                </p>
                <div class="flex justify-around mt-6">
                    <form action="/email/verification-notification" method="post">
                        @csrf
                        <button type="submit"
                            class="text-white bg-gray-800  hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                            RESEND VERIFICATION EMAIL
                        </button>
                    </form>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="focus:outline-none text-white  bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            LOGOUT
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>



</html>
