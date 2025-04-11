<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickesignature - Professional eSign Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            light: '#4fd1c5',
                            /* lighter teal */
                            DEFAULT: '#2c7a7b',
                            /* teal-700 */
                            dark: '#285e61',
                            /* teal-800 */
                        },
                        accent: {
                            light: '#fef08a',
                            /* yellow-200 */
                            DEFAULT: '#facc15',
                            /* yellow-400 */
                            dark: '#ca8a04',
                            /* yellow-600 */
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900">Clickesignature</span>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="#"
                            class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium">Features</a>
                        <a href="#" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium">How It
                            Works</a>
                        <a href="#pricing"
                            class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium">Pricing</a>
                        <a href="#"
                            class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{route('login')}}"
                        class="px-4 py-2 text-sm font-medium text-primary hover:text-primary-dark border border-transparent rounded-md">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium text-primary-dark bg-accent hover:bg-accent-dark border border-transparent rounded-md shadow-sm">Sign
                        up</a>
                </div>
                <div class="flex items-center md:hidden">
                    <button type="button"
                        class="bg-white p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative  overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8  sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block text-teal-700">Sign documents online</span>
                            <span class="block text-accent">with confidence</span>
                        </h1>

                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-dark bg-accent hover:bg-accent-dark md:py-4 md:text-lg md:px-10">
                                    Get started
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-dark hover:bg-primary md:py-4 md:text-lg md:px-10">
                                    Live demo
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="hidden lg:block lg:absolute lg:inset-0 lg:right-0 ">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{asset('home2.jpg') }}"
                alt="Document signing">
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Everything you need for digital signatures
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Our platform provides a complete solution for all your document signing needs.
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Legally Binding Signatures</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            All signatures are legally binding and compliant with eSign laws worldwide.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Bank-Level Security</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Advanced encryption and security measures to protect your sensitive documents.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Lightning Fast</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Get documents signed in minutes, not days. Speed up your business processes.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Document Management</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Easily organize, track, and manage all your documents in one central location.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Pricing</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Simple, transparent pricing
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Choose the plan that works best for you and your team.
                </p>
            </div>

            <div class="mt-10 space-y-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-6 lg:max-w-4xl lg:mx-auto">
                <!-- Basic Plan -->
                <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Basic</h2>
                        <p class="mt-4 text-sm text-gray-500">Best for individuals and small projects</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$9</span>
                            <span class="text-base font-medium text-gray-500">/mo</span>
                        </p>
                        <a href="#"
                            class="mt-8 block w-full bg-primary border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-primary-dark">
                            Start free trial
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h3 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h3>
                        <ul class="mt-6 space-y-4">
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Up to 10 documents per month</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Basic templates</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Email support</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white rounded-lg shadow-lg divide-y divide-gray-200 border-2 border-accent">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Pro</h2>
                        <p class="mt-4 text-sm text-gray-500">Best for small businesses</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$29</span>
                            <span class="text-base font-medium text-gray-500">/mo</span>
                        </p>
                        <a href="#"
                            class="mt-8 block w-full bg-accent border border-transparent rounded-md py-2 text-sm font-semibold text-primary-dark text-center hover:bg-accent-dark">
                            Start free trial
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h3 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h3>
                        <ul class="mt-6 space-y-4">
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Up to 100 documents per month</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Advanced templates</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Priority support</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Team collaboration</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Enterprise</h2>
                        <p class="mt-4 text-sm text-gray-500">Best for large organizations</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$99</span>
                            <span class="text-base font-medium text-gray-500">/mo</span>
                        </p>
                        <a href="#"
                            class="mt-8 block w-full bg-primary border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-primary-dark">
                            Contact sales
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h3 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h3>
                        <ul class="mt-6 space-y-4">
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Unlimited documents</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Custom templates</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">24/7 dedicated support</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">API access</span>
                            </li>
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-accent-dark" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">Custom integrations</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary-dark">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to get started?</span>
                <span class="block text-accent-light">Start your free trial today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="#"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-dark bg-accent hover:bg-accent-dark">
                        Get started
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-light">
                        Learn more
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-white">Clickesignature</span>
                    </div>
                    <p class="text-gray-300 text-base">
                        Making document signing simple, secure, and efficient for everyone.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-accent">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24h11.495v-9.294H9.691V10.5h3.129V7.748c0-3.1 1.866-4.788 4.598-4.788 1.309 0 2.436.097 2.764.141v3.2l-1.898-.001c-1.487 0-1.774.707-1.774 1.743v2.287h3.548l-.463 3.206h-3.085V24h6.059c.731 0 1.325-.593 1.325-1.325V1.325C24 .593 23.407 0 22.675 0z" />


                            </svg>
                            <span class="sr-only">Facebook</span>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.954 4.569c-.885.392-1.83.656-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.949.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.594-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124-4.087-.205-7.713-2.165-10.141-5.144-.423.722-.666 1.561-.666 2.457 0 1.697.865 3.197 2.181 4.078-.803-.026-1.56-.247-2.22-.616v.061c0 2.367 1.685 4.342 3.918 4.788-.41.111-.843.171-1.287.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.395 0-.779-.023-1.17-.067 2.179 1.397 4.768 2.213 7.548 2.213 9.054 0 14.001-7.496 14.001-13.986 0-.21 0-.423-.015-.635.961-.695 1.8-1.562 2.46-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22.23 0H1.77C.79 0 0 .774 0 1.729v20.542C0 23.226.79 24 1.77 24h20.46c.98 0 1.77-.774 1.77-1.729V1.729C24 .774 23.21 0 22.23 0zM7.12 20.452H3.56V9h3.56v11.452zM5.34 7.672c-1.14 0-2.06-.92-2.06-2.06s.92-2.06 2.06-2.06 2.06.92 2.06 2.06-.92 2.06-2.06 2.06zm15.112 12.78h-3.56v-5.6c0-1.34-.03-3.06-1.86-3.06-1.86 0-2.15 1.45-2.15 2.95v5.71h-3.56V9h3.42v1.56h.05c.48-.91 1.65-1.87 3.4-1.87 3.63 0 4.3 2.39 4.3 5.5v6.26z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-8 xl:mt-0 xl:col-span-2">
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Quick Links</h3>
                    <ul class="mt-4 space-y-4">
                        <li>
                            <a href="#" class="text-base text-gray-300 hover:text-white">About Us</a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-300 hover:text-white">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-300 hover:text-white">Terms of Service</a>
                        </li>
                        <li>
                            <a href="#" class="text-base text-gray-300 hover:text-white">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-400 xl:text-center">
                    &copy; 2025 Clickesignature. All rights reserved.
                </p>
            </div>
    </footer>
</body>

</html>
