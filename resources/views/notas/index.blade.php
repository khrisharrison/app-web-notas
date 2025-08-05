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
        <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    </head>
    <body class="bg-gray-100 flex h-screen">
        <aside class="w-1/4 bg-white p-6 shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Mis Notas</h1>
            <div class="relative mb-6">
                <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                <input class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Buscar notas..." type="text"/>
            </div>
            <button id="new-note-btn" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center transition duration-150 ease-in-out mb-6">
                <span class="material-icons mr-2">add</span> Nueva Nota
            </button>
            <nav> 
                @foreach ($notas as $nota)
                    <div id="notes-list" data-id="{{ $nota->id }}" onclick="loadNoteContent(this)" class="bg-teal-50 p-4 rounded-lg mb-4 shadow-sm border border-teal-200 cursor-pointer hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="font-semibold text-teal-700 text-lg">{{ $nota->titulo }}</h2>
                            <span class="material-icons text-yellow-500">star</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate mb-3">{{ $nota->contenido }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <div>
                                <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full mr-1">trabajo</span>
                                <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full">desarrollo</span>
                            </div>
                            <span>{{ $nota->updated_at }}</span>
                        </div>
                    </div>
                @endforeach
            </nav>
        </aside>
        <main id="note-content-container" class="flex-1 p-8 bg-white rounded-l-3xl shadow-xl">
            <div id="note-view">
                <header class="flex justify-between items-center mb-10">
                    <h1 id="note-title" class="text-3xl font-bold text-gray-800">Selecciona una nota</h1>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-yellow-500 transition-colors">
                            <span class="material-icons text-2xl">star</span>
                        </button>
                        <button id="edit-note-btn" class="text-gray-500 hover:text-orange-500 transition-colors">
                            <span class="material-icons text-2xl">edit</span>
                        </button>
                        <button id="delete-note-btn" class="text-gray-500 hover:text-red-500 transition-colors">
                            <span class="material-icons text-2xl">delete</span>
                        </button>
                    </div>
                </header>
                <article class="text-gray-700 leading-relaxed">
                    <p id="note-content" class="mb-4 text-lg">El contenido aparecerá aquí...</p>
                </article>
                <footer class="mt-12 pt-6 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
                    <div>
                        <span id="note-update">Última modificación: 2024-01-15</span>
                        <span class="mx-2">|</span>
                        <span>211 caracteres</span>
                    </div>
                    <div>
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium mr-2">trabajo</span>
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium">desarrollo</span>
                    </div>
                </footer>
            </div>
            <!-- Vista para crear nueva nota (inicialmente oculta) -->
            <div id="note-form" style="display: none;">
                <h2>Crear Nueva Nota</h2>
                <form id="create-note-form">
                    @csrf
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contenido">Contenido:</label>
                        <textarea id="contenido" name="contenido" rows="10" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn-save">Guardar Nota</button>
                </form>
            </div>
            <!-- Vista para editar nota existente -->
            <div id="edit-form">
                <div class="form-header">
                    <h2>Editar Nota</h2>
                </div>
                
                <div id="edit-status" class="status-message"></div>
                
                <form id="edit-note-form">
                    @csrf
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-content" class="form-label">Contenido</label>
                        <textarea class="form-control" id="edit-content" name="content" rows="10" required></textarea>
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
            <script>
                // Mostrar formulario de nueva nota
                document.getElementById('new-note-btn').addEventListener('click', function() {
                    document.getElementById('note-view').style.display = 'none';
                    document.getElementById('note-form').style.display = 'block';
                    resetNoteSelection();
                });

                // Cargar contenido de nota existente
                document.querySelectorAll('.note-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const noteId = this.getAttribute('data-id');
                        
                        // Resaltar nota seleccionada
                        document.querySelectorAll('.note-item').forEach(note => {
                            note.classList.remove('active');
                        });
                        this.classList.add('active');
                        
                        // Ocultar formulario y mostrar vista
                        document.getElementById('note-form').style.display = 'none';
                        document.getElementById('note-view').style.display = 'block';
                        
                        // Cargar contenido via AJAX
                        loadNoteContent(noteId);
                    });
                });

                // Función para cargar contenido de nota
                function loadNoteContent(element) {
                    const noteId = element.getAttribute('data-id');
                    
                    // Hacer la petición AJAX
                    axios.get(`/notas/${noteId}`)
                        .then(response => {
                            // Actualizar el contenido en el menú
                            document.getElementById('note-title').textContent = response.data.titulo;
                            document.getElementById('note-content').textContent = response.data.contenido;
                            document.getElementById('note-update').textContent = response.data.updated_at;
                        })
                        .catch(error => {
                            console.error("Error cargando la nota:", error);
                            alert('Error al cargar la nota');
                        });
                }
                // Resetear selección de notas
                function resetNoteSelection() {
                    document.querySelectorAll('.note-item').forEach(note => {
                        note.classList.remove('active');
                    });
                }

                // Enviar formulario de nueva nota
                document.getElementById('create-note-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = {
                        titulo: document.getElementById('titulo').value,
                        contenido: document.getElementById('contenido').value
                    };

                    axios.post('/notas', formData)
                        .then(response => {
                            alert('Nota creada con éxito!');
                            // Recargar la lista de notas
                            location.reload();
                        })
                        .catch(error => {
                            console.error("Error creando nota:", error);
                            alert('Error al crear la nota');
                        });
                });
            </script>
        </main>
    </body>
</html>