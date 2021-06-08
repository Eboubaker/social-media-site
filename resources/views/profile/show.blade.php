@extends('layouts.app')     

@section('content')
<nav-bar class="hidden sm:block"></nav-bar>
<div class="flex pt-14">
    <div class="w-1/6 min-h-screen bg-white divide-y space-y-2">
        <div class="flex flex-col items-center py-4">
            <img class="rounded-full h-44 w-44 mb-4" src="/img/150x150.png" alt="" />
            <p class="text-xl">Abdelhak Darbeida</p>
            <p class="text-sm">@abdelhak.darbeida</p>
        </div>
        <div class="flex flex-col place-items-center divide-y space-y-2">
            <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">Profile <span class="material-icons">arrow_drop_down_circle</span></a>
            <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">Account <span class="material-icons">arrow_drop_down_circle</span></a>
            <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">Saved Content <span class="material-icons">arrow_drop_down_circle</span></a>
            <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">Settings <span class="material-icons">arrow_drop_down_circle</span></a>
            <a class="flex justify-between items-center w-full px-2 pt-2 text-center" href="#">About <span class="material-icons">arrow_drop_down_circle</span></a>
        </div>
    </div>
    <div class="flex-auto">content</div>
</div>
    
@endsection
