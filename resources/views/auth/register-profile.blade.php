@extends('layouts.app')

@section('content')
<button class="absolute top-0 left-0 hover:bg-gray-200 rounded-full focus:outline-none focus:ring-1 focus:ring-black w-12 h-12 flex items-center justify-center m-4">
    {{-- <span class="material-icons w-12 h-12">arrow_back</span> --}}
    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
</button>
    <div id="register-component" class="flex flex-wrap h-screen bg-gray-100 justify-center pt-12">
        <div class="w-screen h-5/6 mx-8 md:w-1/2">
            <ul class="flex flex-col justify-center ml-2 mb-0 list-none pt-3 pb-4 sm:flex-row">
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a
                            class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal cursor-pointer"
                            v-on:click="toggleTabs('{{ \App\Models\SocialProfile::class }}')"
                            v-bind:class="{'text-logo-black bg-white': openTab !== '{{ \App\Models\SocialProfile::class }}', 'text-white bg-logo-red': openTab === '{{ \App\Models\SocialProfile::class }}'}"
                    >
                        <i class="fas fa-space-shuttle text-base mr-1"></i> Social Account
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a
                            class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal cursor-pointer"
                            v-on:click="toggleTabs('{{ \App\Models\BusinessProfile::class }}')"
                            v-bind:class="{'text-logo-black bg-white': openTab !== '{{ \App\Models\BusinessProfile::class }}', 'text-white bg-logo-black': openTab === '{{ \App\Models\BusinessProfile::class }}'}"
                    >
                        <i class="fas fa-cog text-base mr-1"></i> Buisness Account
                    </a>
                </li>
            </ul>
            <div
                    class="relative flex flex-col min-w-0 break-words bg-white w-full h-5/6 mb-6 shadow-lg rounded sm:h-full"
            >
                <div class="px-4 py-5 flex-auto">
                    <div class="tab-content tab-space">
                        <form class="grid grid-cols- gap-4 mx-2" method='post' action="{{ route('register') }}">
                        @csrf
                            <input hidden v-model="choice" name='profileChoice'/>
                            <div v-bind:class="{'hidden': openTab !== '{{ \App\Models\SocialProfile::class }}', 'block': openTab === '{{ \App\Models\SocialProfile::class }}'}">
                                <p class="pb-4 text-center">Social Account for friends and family</p>
                                    <input
                                            class=""
                                            type="text"
                                            name="first-name"
                                            id="first-name"
                                            placeholder="First Name"
                                    />
                                    <input
                                            class=""
                                            type="text"
                                            name="last-name"
                                            id="last-name"
                                            placeholder="Last Name"
                                    />
                                    <div class="flex space-x-2 justify-start items-center">
                                        <label for="birth-date">Birhtday:</label>
                                        <input
                                            type="date"
                                            name="birth-date"
                                            id="birth-date"
                                        />
                                    </div>
                            </div>
                            <div v-bind:class="{'hidden': openTab !== '{{ \App\Models\BusinessProfile::class }}', 'block': openTab === '{{ \App\Models\BusinessProfile::class }}'}">
                                <p class="pb-4 text-center">Buisness Account for colleuges and customers</p>
                                    <input
                                            class="focus:border-logo-black focus:ring-logo-black"
                                            type="text"
                                            name="owner-full-name"
                                            id="first-name"
                                            placeholder="Owner full name"
                                    />
                                    <input
                                            class="focus:border-logo-black focus:ring-logo-black"
                                            type="text"
                                            name="company-name"
                                            id="company-name"
                                            placeholder="Company Name"
                                    />
                                    <select
                                            class="focus:border-logo-black focus:ring-logo-black"
                                            name="job-category"
                                            id="job-category"
                                    >
                                        <option selected>Business Category</option>
                                        @foreach(\App\Models\BusinessCategory::all() as $category)
                                            <option value="{{ $category->getKey() }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div v-bind:class="{'hidden': openTab !== 'credentials', 'block': openTab === 'credentials'}">
                                <p class="pb-4 text-center">Account credentials</p>
                                <input
                                        class="focus:border-logo-black focus:ring-logo-black"
                                        type="text"
                                        name="login"
                                        placeholder="email or phone"
                                />
                                <input
                                        class="focus:border-logo-black focus:ring-logo-black"
                                        type="password"
                                        name="password"
                                        placeholder="password"
                                />
                            </div>
                            <button type="button" v-bind:class="{'hidden': openTab === 'credentials', 'block': openTab !== 'credentials'}" class="rounded-md border-gray-300 focus:border-red-300 focus:ring-red-300 shadow-sm p-2 text-logo-white bg-logo-black hover:bg-gray-900 cursor-pointer sm:mt-8 sm:w-1/2 sm:justify-self-center"
                            v-on:click="toggleTabs('credentials')">Next</button>
                            <button v-bind:class="{'hidden': openTab !== 'credentials', 'block': openTab === 'credentials'}" class="rounded-md border-gray-300 focus:border-red-300 focus:ring-red-300 shadow-sm p-2 text-logo-white bg-logo-black hover:bg-gray-900 cursor-pointer sm:mt-8 sm:w-1/2 sm:justify-self-center"
                                    type="submit">
                                Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load',function() {
            new Vue({
                el: '#register-component',
                data() {
                    return {
                        openTab: '{{ \App\Models\SocialProfile::class }}',
                        choice: '{{ \App\Models\SocialProfile::class }}'
                    };
                },
                methods: {
                    toggleTabs: function (tab) {
                        this.openTab = tab;
                        if(tab === '{{ \App\Models\SocialProfile::class }}')
                        {
                            this.choice = '{{ \App\Models\SocialProfile::class }}';
                        }else if(tab === '{{ \App\Models\BusinessProfile::class }}'){
                            this.choice = '{{ \App\Models\BusinessProfile::class }}';
                        }else if(tab === 'credentials')
                        {

                        }
                    },
                }
            });
        });
    </script>
@endpush