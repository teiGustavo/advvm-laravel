<div class="row mb-3 text-left">
    <label for="{{ $id }}" class="col-sm-2 col-form-label">{{ $label }}</label>
    <div class="col-sm-10">
        <input type="{{ $type }}" id="{{ $id }}" min="{{ $min }}" {{ $attributes->class(['form-control text-light']) }} max="{{ $max }}" style="background: #2f2841; border: none;">
    </div>
</div>

{{--class="form-control text-light"--}}
