<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mis Notas</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/css/notas.css', 'resources/js/app.js', 'resources/js/notas.js'])
</head>

<body class="bg-gray-100 flex flex-col min-h-screen dark:bg-slate-900">
    @include('layouts.navigation')
    <div class="flex flex-1 h-full">
        <aside id="notes-list" class="w-1/4 bg-white p-6 shadow-lg dark:bg-slate-800">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 dark:text-slate-100">Mis Notas</h1>
            <div class="relative mb-6">
                <span class="material-icons absolute left-3 top-6 transform -translate-y-1/2 text-gray-400">search</span>
                <input id="search-notes" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400" placeholder="Buscar notas..." type="text"/>
            </div>
            <button id="new-note-btn" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition duration-150 ease-in-out mb-6 dark:shadow-sm">
                <span class="material-icons mr-2">add</span> Nueva Nota
            </button>
            <nav> 
                <div id="notes-container">
                    <!-- Las notas se cargarán aquí con JavaScript -->
                </div>
            </nav>
        </aside>
    <main id="note-content-container" class="flex-1 p-8 bg-white shadow-xl dark:bg-slate-900 dark:shadow-none">
            <!-- Vista para nota vacía -->
            <div id="empty-note-message">
                <i class="fas fa-sticky-note"></i>
                <h1 class="text-3xl mb-4">Crea tu primera nota :)</h1>
            </div>
            <!-- Vista para mostrar nota existente -->
            <div id="note-view" style="display: none;">
                <header class="flex justify-between items-center mb-10">
                    <h1 id="note-title" class="text-3xl font-bold text-gray-800 dark:text-slate-100">Selecciona una nota</h1>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-yellow-500 transition-colors dark:text-slate-300 dark:hover:text-yellow-400">
                            <span class="material-icons text-2xl">star</span>
                        </button>
                        <button id="edit-note-btn" class="text-gray-500 hover:text-orange-400 transition-colors dark:text-slate-300 dark:hover:text-orange-300">
                            <span class="material-icons text-2xl">edit</span>
                        </button>
                        <button id="delete-note-btn" class="text-gray-500 hover:text-red-500 transition-colors dark:text-slate-300 dark:hover:text-red-400">
                            <span class="material-icons text-2xl">delete</span>
                        </button>
                    </div>
                </header>
                <article class="text-gray-700 leading-relaxed">
                    <p id="note-content" class="mb-4 text-lg">El contenido aparecerá aquí...</p>
                </article>
                <footer class="mt-12 pt-6 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500 dark:border-gray-700 dark:text-slate-400">
                    <div>
                        <span id="note-created">Creada: 2025-06-18</span>
                        <span class="mx-2">|</span>
                        <span id="note-updated">Actualizada: 2025-08-02</span>
                        <span class="mx-2">|</span>
                        <span>24 caracteres</span>
                    </div>
                    <div>
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium mr-2">categoria1</span>
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium">categoria2</span>
                    </div>
                </footer>
            </div>
            <!-- Vista para crear nueva nota (inicialmente oculta) -->
            <div id="note-form">
                <div class="form-header">
                    <h2 class="text-2xl font-bold text-gray-600 mb-3">Crear Nueva Nota</h2>
                </div>
                <div id="create-status" class="status-message"></div>
                <form id="create-note-form">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contenido">Contenido:</label>
                        <textarea id="contenido" name="contenido" rows="10" class="form-control-textarea" required></textarea>
                    </div>
                    <button type="submit" class="btn-save" id="save-note-btn">
                        <span id="save-loader" class="loader" style="display:none;"></span>Guardar Nota
                    </button>
                    <button type="button" id="cancel-create" class="btn btn-secondary btn-cancel">Cancelar</button>
                </form>
            </div>
            <!-- Vista para editar nota existente -->
            <div id="edit-form">
                <div class="form-header">
                    <h2 class="text-2xl font-bold text-gray-600 mb-3">Editar Nota</h2>
                </div>
                
                <div id="edit-status" class="status-message"></div>
                
                <form id="edit-note-form">
                    @csrf
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="edit-title" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-content" class="form-label">Contenido:</label>
                        <textarea class="form-control-textarea" id="edit-content" name="contenido" rows="10" required></textarea>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-success btn-save" id="update-note-btn">
                            <span id="update-loader" class="loader" style="display:none;"></span>
                            Actualizar Nota
                        </button>
                        <button type="button" id="cancel-edit" class="btn btn-secondary btn-cancel">Cancelar</button>
                    </div>
                </form>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        </main>
    </div>
</body>
</html>