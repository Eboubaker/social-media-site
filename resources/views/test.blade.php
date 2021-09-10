<form method="post" action="{{ route('locale.update') }}">
    @csrf
    <input name="locale" value="en">
</form>
{{ request()->cookie('locale') }}