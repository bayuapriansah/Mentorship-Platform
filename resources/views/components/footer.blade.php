<footer class="w-full md:flex md:items-center md:justify-between bg-lightest-blue dark:bg-gray-900">
    <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
        <div class="p-4 py-6 lg:py-8">
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('storage/assets/static/digitalreadiness-logo.svg') }}"
                        class="object-scale-down h-15 w-auto py-4" alt="Intel Digital Readiness Logo" />
                </a>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="relative">
                <p class="text-justify drop-shadow-sm shadow-blue-600/50">ntel technologies may require enabled hardware, software or service activation. // No product or component can be absolutely secure. // Your costs and results may vary. // Performance varies by use, configuration and other factors. // See our complete legal <a href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C" class="text-black font-bold">Notices and Disclaimers</a>. // Intel is committed to respecting human rights and avoiding complicity in human rights abuses. See Intel’s <a href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html" class="text-black font-bold">Global Human Rights Principles</a>. Intel’s products and software are intended only to be used in applications that do not cause or contribute to a violation of an internationally recognized human right.</p>
            </div>
            <div class="relative">
                <div class="md:flex col-start-8 col-span-4">
                    <div class="mb-6 md:mb-0 md:flex-1">
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Info</h2>
                        <ul class="text-gray-600 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                    data-tooltip-trigger="hover" class="hover:underline">For Industry Partners</a>
                            </li>
                            <li class="mb-4">
                                <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                    data-tooltip-trigger="hover" class="hover:underline">For Institution</a>
                            </li>
                            <li>
                                <a href="{{-- route('students.info') --}}" class="hover:underline">For Students</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-6 md:mb-0 md:flex-1">
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Support</h2>
                        <ul class="text-gray-600 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                {{---- <a href="/#AiForFuture" data-tooltip-target="Industry-Partners-hover"
                                    data-tooltip-trigger="hover" class="hover:underline ">About Us</a> ----}}
                                <a href="/#AiForFuture" class="hover:underline ">About Us</a>
                            </li>
                            <li class="mb-4">
                                <a href="{{-- route('faq') --}}" class="hover:underline">FAQs</a>
                            </li>
                            <li>
                                <a href="{{-- route('contact') --}}" class="hover:underline">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-6 md:mb-0 md:flex-1">
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                        <ul class="text-gray-600 dark:text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="{{-- route('privacy-policy') --}}" class="hover:underline">Privacy
                                    Policy</a>
                            </li>
                            <li>
                                <a href="{{-- route('terms-of-use') --}}" class="hover:underline">Terms &amp;
                                    Conditions</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-6 border-black border-t-2 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{-- date('Y') --}} <a
                    href="/" class="hover:underline">Simulated Internship</a>. All Rights Reserved.
            </span>

        </div>
    </div>
</footer>
