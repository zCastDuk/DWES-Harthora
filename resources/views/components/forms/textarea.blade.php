@props([
    'name',
    'id',
    'placeholder' => 'Escribe aquí',
    'required' => false,
])

<textarea id="{{$id}}" name="{{$name}}" rows="4" placeholder="{{$placeholder}}"
          @required($required)
          class="mt-2 w-full rounded-xl border border-cyan-200 px-4 py-3 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"></textarea>
@error($name)
<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
