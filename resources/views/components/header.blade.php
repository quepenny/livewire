<nav x-data="nav">
    <div class="lg:hidden py-6 px-6 bg-gray-800">
        <div class="flex items-center justify-between">
            <div>
                <x-logo :light="true" />

                @auth
                    <p class="text-white font-bold mt-2">{{ \Illuminate\Support\Str::limit(user()->name, 22) }}</p>
                @endauth
            </div>

            <div class="flex items-center">
                <button
                    class="navbar-burger flex items-center rounded focus:outline-none"
                    @click="toggleMobileMenu"
                >
                    <x-icon
                        name="list"
                        class="text-white bg-teal-500 hover:bg-teal-600 block h-8 w-8 p-2 rounded"
                        width="60"
                        height="60"
                    />
                </button>
            </div>
        </div>
    </div>

    <div
        class="hidden lg:block navbar-menu relative z-50"
        :class="{hidden: !showMobileMenu}"
    >
        <div
            class="navbar-backdrop fixed lg:hidden inset-0 bg-gray-800 opacity-10"
            @click="toggleMobileMenu"
        ></div>

        <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-3/4 lg:w-80 sm:max-w-xs pt-6 pb-8 bg-gray-800 overflow-y-auto">
            <header class="flex w-full justify-between items-center px-6 pb-3 mb-3">
                <div>
                    <x-logo :light="true" />

                    @auth
                        <p class="text-white font-bold mt-2">{{ \Illuminate\Support\Str::limit(user()->name, 22) }}</p>
                    @endauth
                </div>
            </header>

            <div class="px-4 pb-6">
                <x-nav.group class="flex flex-col">
                    @switch($nav['active'])
                        @case('stock-check')
                            <x-nav.item
                                :text="__('Stock Check')"
                                :active="true"
                                icon="clipboard-check"
                                class="order-3"
                            />

                        @case('items')
                            <x-nav.item
                                :text="$nav['list']->name"
                                :route="route('items', $nav['list'])"
                                :active="$nav['active'] === 'items'"
                                icon="cart4"
                                class="order-2"
                            />

                        @default
                            <x-nav.item
                                :text="__('Shopping Lists')"
                                :route="route('shopping-lists')"
                                :active="$nav['active'] === 'lists'"
                                icon="card-checklist"
                                class="order-1"
                            />
                    @endswitch
                </x-nav.group>

                @guest
                    <x-nav.group>
                        <x-nav.item
                            :text="__('Sign In')"
                            :route="route('login')"
                            icon="box-arrow-in-right"
                        />

                        <x-nav.item
                            :text="__('Sign Up')"
                            :route="route('register')"
                            icon="box-arrow-up-left"
                        />
                    </x-nav.group>
                @endguest

                @auth
                    <x-nav.group>
                        <x-nav.item
                            :text="__('Settings')"
                            :route="route('settings')"
                            :active="$nav['active'] === 'settings'"
                            icon="gear"
                        />

                        <x-nav.item
                            :text="__('Log Out')"
                            :route="route('logout')"
                            :postRequest="true"
                            icon="box-arrow-up-left"
                        />
                    </x-nav.group>
                @endauth

                <x-nav.group>
                    <x-nav.item
                        :text="__('Contact')"
                        :route="route('contact')"
                        :active="$nav['active'] === 'contact'"
                        icon="telephone"
                    />

                    <x-nav.item
                        :text="__('Terms of Service')"
                        :route="route('terms')"
                        :active="$nav['active'] === 'terms'"
                        icon="file-text"
                    />

                    <x-nav.item
                        :text="__('Privacy Policy')"
                        :route="route('privacy')"
                        :active="$nav['active'] === 'privacy'"
                        icon="shield-check"
                    />

                    <x-nav.item
                        :text="__('Cookie Policy')"
                        :route="route('cookies')"
                        :active="$nav['active'] === 'cookies'"
                        icon="bar-chart"
                    />
                </x-nav.group>
            </div>
        </nav>
    </div>
</nav>
