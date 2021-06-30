
@extends('layouts.app')     

@section('content')
    <nav-bar class="hidden sm:block"></nav-bar>
    <div class="pt-16">
        <main role="main">
          <div class="flex flex-col items-start py-2 w-8/12 bg-white mx-auto">
            <section class="w-10/12 mx-auto " >
                <script id="profilejson" type="application/json">
                    {!! $profileJson !!}
                </script>
                <image-upload imageUrl="{{ $profile->avatarImage->url }}" uploadTarget="/"></image-upload>
            </section>
          </div>
        </main>
    </div>
    <div class="content my-10 w-full">
        @if (Session::has('status'))
            <div x-data="{}" x-init="$dispatch('notice', {type: 'success', text: 'Your Settings Are Saved'})"></div>
        @elseif(!$errors->isEmpty())
            <div x-data="{}" x-init="$dispatch('notice', {type: 'danger', text: '{{ $errors->all()[0] }}'})"></div>
        @endif
        <div class="w-8/12 mx-auto">
            <div class="border-b border-gray-400">
                <div class="w-full text-3xl felx">
                    <img class="w-24 h-24" src="{{ $profile->avatarImage->url }}">
                    <p>Profile Settings</p>
                </div>
            </div>
            <form class="mt-5" method="post" action="{{ route('profile.update') }}">
                @csrf
                <div class="mb-5">
                    <div class="ml-1 text-indigo-700 uppercase tracking-tight font-semibold" style="margin-bottom: -4px">User</div>
                    <div class="p-5 bg-white rounded-lg shadow-lg border-t-2 border-indigo-700">
                        <div>
                            <label class="block tracking-wide font-bold text-xs uppercase text-gray-700">Name</label>
                            <input name="username" value="{{ Auth::user()->name }}" placeholder="Name" class="appearance-none block bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500" type="text">
                        </div>
                        <div class="w-full border-b border-gray-300 my-5"></div>
                        <div>
                            <label class="block tracking-wide font-bold text-xs uppercase text-gray-700">Push Notifications</label>
                            <div class="w-12 relative my-1 cursor-pointer">
                                <?php $active =  Auth::user()->settings->emailNotificationsEnabled;$active = $active ? 1 : 0?>
                                <div data-toggle="{{ $active }}" class="toggle h-8 w-12 {{ $active ? 'bg-purple-600' : 'bg-gray-300'}} rounded-full">
                                    <div class="mt-1 -ml-6 w-6 h-6 absolute transition-all transform ease-linear duration-100 flex items-center justify-center rounded-full bg-white shadow-toggle border-gray-300 top-0" style="left: {{ $active && 0? '94%' : '54%'}};">
                                        <input name="emailNotificationsEnabled" value="{{ $active }}" hidden>
                                    </div>
                                </div>
                            </div>
                            <label data-if-active="You will receive email notifications" data-if-not-active="You will not receive email notifications" class="desc if-active block tracking-tighter text-xs text-gray-600"></label>
                        </div>
                    </div>
                </div>


                <div class="mb-5">
                    <div class="ml-1 text-green-700 uppercase tracking-tight font-semibold" style="margin-bottom: -4px">Conversion</div>
                    <div class="p-5 bg-white rounded-lg shadow-lg border-t-2 border-green-700">
                        <div>
                            <label class="block tracking-wide font-bold text-xs uppercase text-gray-700">Conversion Unit</label>
                            <input name="pointsConversionUnit" value="{{ Auth::user()->settings->pointsConversionUnit }}" placeholder="Division Unit" class="appearance-none block bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500" type="number">
                            <label class="block tracking-tighter text-xs text-gray-600">This will convert all points max value to this value <br>Ex: a 12/20 point will become 60/100 if you set the conversion unit to 100</label>
                        </div>
                        <div class="w-full border-b border-gray-300 my-5"></div>
                        <div>
                            <label class="block tracking-wide font-bold text-xs uppercase text-gray-700">Conversion Multiplication</label>
                            <input name="pointsMultiplication" value="{{ Auth::user()->settings->pointsMultiplication }}" placeholder="Multiplication Unit" class="appearance-none block bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500" type="number">
                            <label class="block tracking-tighter text-xs text-gray-600">This will multiply all point values by this value<br>Ex: a 12/20 point will become 48/80 if you set the multiplication to 4</label>
                        </div>
                    </div>
                </div>


                <div class="mb-5">
                    <div class="ml-1 text-red-700 uppercase tracking-tight font-semibold" style="margin-bottom: -4px">Security</div>
                    <div class="p-5 bg-white rounded-lg shadow-lg border-t-2 border-red-700">
                        <div>
                            <label class="block tracking-wide font-bold text-xs uppercase text-gray-700">Profile Visibility</label>
                            <div class="w-12 relative my-1 cursor-pointer">
                                <?php $active =  Auth::user()->settings->emailNotificationsEnabled;$active = $active ? 1 : 0?>
                                <div data-toggle="{{ $active }}" class="toggle h-8 w-12 {{ $active ? 'bg-purple-600' : 'bg-gray-300'}} rounded-full">
                                    <div class="mt-1 -ml-6 w-6 h-6 absolute transition-all transform ease-linear duration-100 flex items-center justify-center rounded-full bg-white shadow-toggle border-gray-300 top-0" style="left: {{ $active ? '94%' : '54%'}};">
                                        <input name="profileLocked" value="{{ $active }}" hidden>
                                    </div>
                                </div>
                            </div>
                            <label data-if-active="others can see your profile" data-if-not-active="others can't see your profile" class="desc if-active block tracking-tighter text-xs text-gray-600"></label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-1">
                    <button class="btn btn-primary w-32">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.2.1/cdn.min.js" integrity="sha512-6W+GlrV+mX4hcspaL8830mcCU42F4141eECFcSvGc7ZjhLHjGDLOv4NhbNKikXmVk3klci3uJkCE4378FUWSEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush