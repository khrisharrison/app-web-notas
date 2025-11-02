@props(['disabled' => false])

<!-- Standard text input with dark mode support -->
<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full border border-gray-300 bg-white text-gray-900 placeholder-gray-400 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 dark:bg-slate-700 dark:border-gray-600 dark:text-slate-100 dark:placeholder-slate-400 dark:focus:border-indigo-400']) }}>
