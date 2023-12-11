<footer class="bg-[#e9e9e9] border-[#838383] text-black">
    <div class="max-w-screen-xl mx-auto px-6 py-4" id="AiForFuture">
        <div class="p-4 py-6 lg:py-8">
            <div class="mb-6 md:mb-0">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('/assets/img/logo/footer-logo.svg') }}" class="tab:scale-125"
                        alt="Intel Digital Readiness Logo" />
                </a>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="relative">
                <p class="text-justify">Intel technologies may require enabled
                    hardware, software, or service activation. // No product or component can be absolutely secure.
                    // Your costs and results may vary. // Performance varies by use, configuration, and other
                    factors.
                    // See our complete legal <a
                        href="https://edc.intel.com/content/www/us/en/products/performance/benchmarks/overview/#GUID-26B0C71C-25E9-477D-9007-52FCA56EE18C"
                        class="text-primary font-bold hover:underline">Notices and Disclaimers</a>. // Intel is
                    committed to respecting
                    human rights and avoiding complicity in human rights abuses. See <a
                        href="https://www.intel.com/content/www/us/en/policy/policy-human-rights.html"
                        class="text-primary font-bold hover:underline">Intel’s Global Human Rights Principles</a>.
                    Intel’s products
                    and software are intended only to be used in applications that do not cause or contribute to a
                    violation of an internationally recognized human right.</p>
            </div>
            <div class="relative tab:-top-10">
                <div class="md:flex col-start-8 col-span-4">
                    <div class="mb-6 md:mb-0 md:flex-1">
                        <h2 class="text-sm font-semibold text-darker-blue">
                            INFO
                        </h2>

                        <ul class="mt-4 flex flex-col gap-2">
                            <li>
                                <a href="{{ route('track-info.entrepreneur-track') }}" class="text-sm font-normal hover:underline">
                                    Entrepreneur Track
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('track-info.skills-track') }}" class="text-sm font-normal hover:underline">
                                    Skills Track
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-6 md:mb-0 md:flex-1">
                        <h2 class="text-sm font-semibold text-darker-blue">
                            SUPPORT
                        </h2>

                        <ul class="mt-4 flex flex-col gap-2">
                            <li>
                                <a href="{{ route('faq') }}" class="text-sm font-normal hover:underline">
                                    FAQs
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('contact') }}" class="text-sm font-normal hover:underline">
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-6 md:mb-0 md:flex-1">
                        <h2 class="text-sm font-semibold text-darker-blue">
                            LEGAL
                        </h2>

                        <ul class="mt-4 flex flex-col gap-2">
                            <li>
                                <a href="{{ route('privacy-policy') }}"
                                    class="text-sm font-normal hover:underline">
                                    Privacy Policies
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('terms-of-use') }}"
                                    class="text-sm font-normal hover:underline">
                                    Terms &amp; Conditions
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-6 border-black sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-center tab:text-left">&copy; {{ date('Y') }} <a
                    href="{{ url('/') }}" class="hover:underline">Mentorship Platform</a>. All
                Rights Reserved.
            </span>

        </div>
    </div>
</footer>
