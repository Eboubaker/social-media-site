@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap h-screen bg-gray-100 justify-center pt-12" id="controller">
        <div class="w-screen h-5/6 mx-8 md:w-1/2">
            <ul class="flex flex-col justify-center ml-2 mb-0 list-none pt-3 pb-4 sm:flex-row">
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a
                        class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal cursor-pointer"
                        v-on:click="toggleTabs(1)"
                        v-bind:class="{'text-logo-black bg-white': openTab !== 1, 'text-white bg-logo-red': openTab === 1}"
                    >
                        <i class="fas fa-space-shuttle text-base mr-1"></i> Social Account
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a
                        class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal cursor-pointer"
                        v-on:click="toggleTabs(2)"
                        v-bind:class="{'text-logo-black bg-white': openTab !== 2, 'text-white bg-logo-black': openTab === 2}"
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
                        <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                            <p class="pb-4 text-center">Social Account for friends and family</p>
                            <form class="grid grid-cols- gap-4 mx-2">
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="text"
                                    v-model="profiles.social.firstName"
                                    name="first-name"
                                    id="first-name"
                                    placeholder="First Name"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="text"
                                    v-model="profiles.social.lastName"
                                    placeholder="Last Name"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="text"
                                    v-model="profiles.social.login"
                                    placeholder="Email or Phone Number"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="password"
                                    v-model="profiles.social.password"
                                    placeholder="Password"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="date"
                                    v-model="profiles.social.birthdate"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg text-logo-white bg-logo-red hover:bg-red-500 cursor-pointer sm:mt-8 sm:w-1/2 sm:justify-self-center"
                                    type="submit"
                                    value="Sign Up"
                                />
                            </form>
                        </div>
                        <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                            <p class="pb-4 text-center">Buisness Account for colleuges and customers</p>
                            <form class="grid grid-cols-1 gap-4 mx-2">
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="text"
                                    v-model="profiles.business.firstName"
                                    name="first-name"
                                    id="first-name"
                                    placeholder="First Name"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="text"
                                    v-model="profiles.business.lastName"
                                    name="last-name"
                                    id="last-name"
                                    placeholder="Last Name"
                                />
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="text"
                                    v-model="profiles.business.login"
                                    name="email-phone"
                                    id="email-phone"
                                    placeholder="Buisness Email or Phone Number"
                                />
                                <form-error v-if="errors.password" :errors="errors">
                                    <span>@{{ errors.body }}</span>
                                </form-error>
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    type="password"
                                    v-model="profiles.business.password"
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                />
                                <select
                                    class="p-2 font-medium border-2 outline-none rounded-lg"
                                    name="job-category"
                                    id="job-category"
                                    v-model="profiles.business.category"
                                >
                                    <option value="" selected>Buisness Category</option>
                                    <option value="food">Food</option>
                                    <option value="transport">Transport</option>
                                </select>
                                <input
                                    class="p-2 font-medium border-2 outline-none rounded-lg text-logo-white bg-logo-black hover:bg-gray-900 cursor-pointer sm:mt-8 sm:w-1/2 sm:justify-self-center"
                                    type="submit"
                                    value="Sign Up"
                                />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.onload = function(e) {
            const controller = new Vue({
                el: '#controller',
                data: {
                    submitted: false,
                    errors: [],
                    openTab: 1,
                    profiles: {
                        business: {
                            firstName: '',
                            lastName: '',
                            login: '',
                            category: ''
                        },
                        social: {
                            firstName: '',
                            lastName: '',
                            login: '',
                            birthdate: ''
                        }
                    }
                },
                methods: {
                    sendPost: function () {
                        let post = this.openTab === 1 ? this.profiles.social : this.profiles.business;
                        this.$http.post('{{ route('register') }}', post).then(function(response) {
                            this.submitted = true;
                            window.location.href = response.redirect;
                        }, function (response) {
                            // form submission failed, pass form  errors to errors array
                            this.$set('errors', response.data);
                        });
                    },
                    toggleTabs: function(tabNumber) {
                        this.openTab = tabNumber;
                    }
                }
            });
        }
    </script>
@endpush
