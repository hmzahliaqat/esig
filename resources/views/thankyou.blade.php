<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Signed Successfully</title>
    @vite(['resources/js/app.js','resources/css/app.css'])

</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <!-- Success checkmark icon -->
            <div class="mx-auto bg-green-100 rounded-full h-20 w-20 flex items-center justify-center">
                <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-4">Thank You!</h1>

        <p class="text-gray-600 mb-6">Your document has been successfully signed and processed.</p>

        <div class="mb-8 py-4 px-6 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Next Steps</h2>
            <ul class="text-gray-600 text-left">
                <li class="flex items-center mb-2">
                    <svg class="h-4 w-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    A copy has been sent to your email
                </li>
                <li class="flex items-center mb-2">
                    <svg class="h-4 w-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    The document is now stored in your account
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    All parties will be notified
                </li>
            </ul>
        </div>


        <p class="text-sm text-gray-500 mt-8">
            If you have any questions, please contact our support team.
        </p>
    </div>
</body>
</html>