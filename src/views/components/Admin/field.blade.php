<div class="field">
    <label for="">Username</label>
    <input type="text" name="" id="">
    @error('field')
        <i class="field_error text error">
            <i class="fa-solid fa-bug"></i>
            <span>{{ $message }}</span>
        </i>
    @enderror
</div>
