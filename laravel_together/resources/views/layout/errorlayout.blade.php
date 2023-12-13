
@forelse ($errors->all() as $val)
<div id="errorMsg" class="form-text error-color"> {{$val}}</div>
@empty
@endforelse