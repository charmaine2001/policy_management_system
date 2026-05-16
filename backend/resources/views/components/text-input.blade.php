@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-zimnat-blue focus:ring-zimnat-blue rounded-md shadow-sm']) }}>
