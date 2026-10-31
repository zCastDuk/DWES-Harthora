@props([
    'name',
    'type' => 'text',
    'required' => false,
    'placeholder' => 'Escribe aquí',
])

<input type="{{ $type }}" id="{{ $name }}" placeholder= "{{$placeholder}}" name="{{ $name }}"
       value="{{ $type === 'password' ? '' : old($name) }}"
       @required($required)
       class="mt-2 w-full rounded-xl border border-cyan-200 px-4 py-3 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">

@error($name)
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
