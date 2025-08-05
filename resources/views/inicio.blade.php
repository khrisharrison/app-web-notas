<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mis Notas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="w-1/4 bg-white p-6 shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Mis Notas</h1>
        <div class="relative mb-6">
            <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
            <input class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Buscar notas..." type="text"/>
        </div>
        <button class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition duration-150 ease-in-out mb-6">
            <span class="material-icons mr-2">add</span> Nueva Nota
        </button>
        <nav>
            <div class="bg-teal-50 p-4 rounded-lg mb-4 shadow-sm border border-teal-200 cursor-pointer hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-semibold text-teal-700 text-lg">Ideas para el proyecto</h2>
                    <span class="material-icons text-yellow-500">star</span>
                </div>
                <p class="text-sm text-gray-600 truncate mb-3">Implementar sistema de autenticación Añadir funcionalidad de exportar notas...</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div>
                        <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full mr-1">trabajo</span>
                        <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full">desarrollo</span>
                    </div>
                    <span>2024-01-15</span>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg mb-4 shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-semibold text-gray-700 text-lg">Lista de compras</h2>
                    <span class="material-icons text-gray-400 hover:text-yellow-500 transition-colors">star_border</span>
                </div>
                <p class="text-sm text-gray-600 truncate mb-3">Frutas: - Manzanas - Plátanos - Naranjas Verduras: - Lechuga - Tomates -...</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div>
                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full mr-1">personal</span>
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">compras</span>
                    </div>
                    <span>2024-01-14</span>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-semibold text-gray-700 text-lg">Reunión de equipo</h2>
                    <span class="material-icons text-gray-400 hover:text-yellow-500 transition-colors">star_border</span>
                </div>
                <p class="text-sm text-gray-600 truncate mb-3">Agenda: 1. Revisión del sprint anterior 2. Planificación del próximo sprint 3...</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div>
                        <span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-full mr-1">trabajo</span>
                        <span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-full">reuniones</span>
                    </div>
                    <span>2024-01-13</span>
                </div>
            </div>
        </nav>
    </aside>
    <main class="flex-1 p-8 bg-white rounded-l-3xl shadow-xl">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Ideas para el proyecto</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-yellow-500 transition-colors">
                    <span class="material-icons text-2xl">star</span>
                </button>
                <button class="text-gray-500 hover:text-red-500 transition-colors">
                    <span class="material-icons text-2xl">delete</span>
                </button>
            </div>
        </header>
        <article class="text-gray-700 leading-relaxed">
            <p class="mb-4 text-lg">Implementar sistema de autenticación</p>
            <p class="mb-4 text-lg">Añadir funcionalidad de exportar notas</p>
            <p class="mb-6 text-lg">Mejorar el diseño responsive</p>
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Notas adicionales:</h3>
            <ul class="list-disc list-inside space-y-2 text-lg">
                <li>Considerar integración con servicios en la nube</li>
                <li>Añadir colaboración en tiempo real</li>
            </ul>
        </article>
        <footer class="mt-12 pt-6 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
            <div>
                <span>Última modificación: 2024-01-15</span>
                <span class="mx-2">|</span>
                <span>211 caracteres</span>
            </div>
            <div>
                <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium mr-2">trabajo</span>
                <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium">desarrollo</span>
            </div>
        </footer>
    </main>
</body></html>