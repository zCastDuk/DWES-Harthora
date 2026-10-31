@props([
    'name',
    'label',
    'type' => 'text',
    'required' => false,
])

<div class="grid gap-6 md:grid-cols-1">
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>

    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
           value="{{ $type === 'password' ? '' : old($name) }}"
           @required($required)
           class="mt-2 w-full rounded-xl border border-cyan-200 px-4 py-3 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">

    @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
