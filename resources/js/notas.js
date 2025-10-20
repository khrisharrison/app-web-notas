// Variables globales
let currentNoteId = null;
let notes = [];

// DOM Elements
const notesContainer = document.getElementById('notes-container');
const noteView = document.getElementById('note-view');
const noteForm = document.getElementById('note-form');
const editForm = document.getElementById('edit-form');
const emptyNoteMessage = document.getElementById('empty-note-message');
const searchInput = document.getElementById('search-notes');

// Botones
const newNoteBtn = document.getElementById('new-note-btn');
const editNoteBtn = document.getElementById('edit-note-btn');
const deleteNoteBtn = document.getElementById('delete-note-btn');
const cancelCreateBtn = document.getElementById('cancel-create');
const cancelEditBtn = document.getElementById('cancel-edit');

// Formularios
const createNoteForm = document.getElementById('create-note-form');
const editNoteForm = document.getElementById('edit-note-form');

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    // Cargar notas al inicio
    loadNotes();
    
    // Event listeners
    newNoteBtn.addEventListener('click', showCreateForm);
    editNoteBtn.addEventListener('click', showEditForm);
    deleteNoteBtn.addEventListener('click', deleteCurrentNote);
    cancelCreateBtn.addEventListener('click', cancelCreate);
    cancelEditBtn.addEventListener('click', cancelEdit);
    
    createNoteForm.addEventListener('submit', createNote);
    editNoteForm.addEventListener('submit', updateNote);
    
    searchInput.addEventListener('input', filterNotes);
});

    const ROUTE = 'notas/api';

// Cargar notas desde el servidor
function loadNotes() {
    axios.get(`${ROUTE}/all`)
        .then(response => {
            notes = response.data;
            renderNotes(notes);
            
            // Si hay notas, seleccionar la primera
            if (notes.length > 0) {
                selectNote(notes[0].id);
            }
        })
        .catch(error => {
            console.error("Error cargando notas:", error);
            showStatus('create-status', 'Error al cargar las notas', 'error');
        });
}

// Renderizar notas en el aside
function renderNotes(notesToRender) {
    notesContainer.innerHTML = '';
    
    if (notesToRender.length === 0) {
        notesContainer.innerHTML = '<div class="text-center py-4 text-muted">No se encontraron notas</div>';
        return;
    }
    
    notesToRender.forEach(note => {
        const noteElement = document.createElement('div');
        noteElement.className = 'note-item';
        if (currentNoteId === note.id) {
            noteElement.classList.add('active');
        }
        noteElement.dataset.id = note.id;
        
        // Formatear fechas
        const updatedDate = new Date(note.updated_at).toLocaleDateString();
        
        noteElement.innerHTML = `
            <div class="bg-teal-50 p-4 rounded-lg mb-4 shadow-sm border border-teal-200 cursor-pointer transition-shadow">    
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-semibold text-teal-700 text-lg">${note.titulo}</h2>
                    <span class="material-icons text-gray-100 hover:text-yellow-500">star</span>
                </div>
                <p class="text-sm text-gray-600 truncate mb-3">${note.contenido }</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div>
                        <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full mr-1">categoria1</span>
                        <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full">categoria2</span>
                    </div>
                    <span>${ updatedDate }</span>
                </div>
            </div>
        `;
        
        noteElement.addEventListener('click', function() {
            selectNote(note.id);
        });
        
        notesContainer.appendChild(noteElement);
    });
}

// Filtrar notas según búsqueda
function filterNotes() {
    const searchTerm = searchInput.value.toLowerCase();
    const filteredNotes = notes.filter(note => 
        note.titulo.toLowerCase().includes(searchTerm) || 
        note.contenido.toLowerCase().includes(searchTerm)
    );
    renderNotes(filteredNotes);
}

// Seleccionar una nota para ver
function selectNote(noteId) {
    currentNoteId = noteId;
    
    // Actualizar selección visual
    document.querySelectorAll('.note-item').forEach(item => {
        item.classList.remove('active');
        if (parseInt(item.dataset.id) === noteId) {
            item.classList.add('active');
        }
    });
    
    // Cargar contenido de la nota
    axios.get(`${ROUTE}/${noteId}`)
        .then(response => {
            const note = response.data;
            
            // Actualizar vista de nota
            document.getElementById('note-title').textContent = note.titulo;
            document.getElementById('note-content').textContent = note.contenido;
            
            // Formatear fechas
            const createdDate = new Date(note.created_at).toLocaleString();
            const updatedDate = new Date(note.updated_at).toLocaleString();
            
            document.getElementById('note-created').textContent = `Creada: ${createdDate}`;
            document.getElementById('note-updated').textContent = `Actualizada: ${updatedDate}`;
            
            // Mostrar vista de nota
            noteView.style.display = 'block';
            noteForm.style.display = 'none';
            editForm.style.display = 'none';
            emptyNoteMessage.style.display = 'none';
        })
        .catch(error => {
            console.error("Error cargando nota:", error);
            showStatus('create-status', 'Error al cargar la nota', 'error');
        });
}

// Mostrar formulario para crear nueva nota
function showCreateForm() {
    // Resetear formulario
    document.getElementById('titulo').value = '';
    document.getElementById('contenido').value = '';
    document.getElementById('create-status').style.display = 'none';
    
    // Mostrar formulario
    noteForm.style.display = 'block';
    noteView.style.display = 'none';
    editForm.style.display = 'none';
    emptyNoteMessage.style.display = 'none';
    
    // Deseleccionar cualquier nota
    currentNoteId = null;
    document.querySelectorAll('.note-item').forEach(item => {
        item.classList.remove('active');
    });
}

// Cancelar creación de nota
function cancelCreate() {
    // Si hay notas, mostrar la primera, sino mostrar mensaje vacío
    if (notes.length > 0) {
        selectNote(notes[0].id);
    } else {
        noteView.style.display = 'none';
        noteForm.style.display = 'none';
        editForm.style.display = 'none';
        emptyNoteMessage.style.display = 'block';
    }
}

// Crear nueva nota
function createNote(e) {
    e.preventDefault();
    
    const titulo = document.getElementById('titulo').value;
    const contenido = document.getElementById('contenido').value;
    
    // Mostrar loader
    const saveBtn = document.getElementById('save-note-btn');
    const loader = document.getElementById('save-loader');
    saveBtn.disabled = true;
    loader.style.display = 'inline-block';
    
    axios.post(`${ROUTE}`, { titulo, contenido })
        .then(response => {
            // Ocultar loader
            saveBtn.disabled = false;
            loader.style.display = 'none';
            
            // Mostrar mensaje de éxito
            showStatus('create-status', 'Nota creada con éxito!', 'success');
            
            // Recargar notas después de un breve retraso
            setTimeout(() => {
                loadNotes();
                selectNote(response.data.id);
            }, 1500);
        })
        .catch(error => {
            // Ocultar loader
            saveBtn.disabled = false;
            loader.style.display = 'none';
            
            console.error("Error creando nota:", error);
            showStatus('create-status', 'Error al crear la nota', 'error');
        });
}

// Mostrar formulario para editar nota
function showEditForm() {
    if (!currentNoteId) return;
    
    // Cargar datos de la nota actual
    axios.get(`${ROUTE}/${currentNoteId}`)
        .then(response => {
            const note = response.data;
            
            // Llenar formulario de edición
            document.getElementById('edit-id').value = note.id;
            document.getElementById('edit-title').value = note.titulo;
            document.getElementById('edit-content').value = note.contenido;
            document.getElementById('edit-status').style.display = 'none';
            
            // Mostrar formulario de edición
            noteView.style.display = 'none';
            noteForm.style.display = 'none';
            editForm.style.display = 'block';
            emptyNoteMessage.style.display = 'none';
        })
        .catch(error => {
            console.error("Error cargando nota para editar:", error);
            showStatus('edit-status', 'Error al cargar la nota para editar', 'error');
        });
}

// Cancelar edición de nota
function cancelEdit() {
    if (currentNoteId) {
        selectNote(currentNoteId);
    } else {
        noteView.style.display = 'none';
        noteForm.style.display = 'none';
        editForm.style.display = 'none';
        emptyNoteMessage.style.display = 'block';
    }
}

// Actualizar nota existente
function updateNote(e) {
    e.preventDefault();
    
    const id = document.getElementById('edit-id').value;
    const titulo = document.getElementById('edit-title').value;
    const contenido = document.getElementById('edit-content').value;
    
    // Mostrar loader
    const updateBtn = document.getElementById('update-note-btn');
    const loader = document.getElementById('update-loader');
    updateBtn.disabled = true;
    loader.style.display = 'inline-block';
    
    axios.put(`${ROUTE}/${id}`, { titulo, contenido })
        .then(response => {
            // Ocultar loader
            updateBtn.disabled = false;
            loader.style.display = 'none';
            
            // Mostrar mensaje de éxito
            showStatus('edit-status', 'Nota actualizada con éxito!', 'success');
            
            // Recargar notas después de un breve retraso
            setTimeout(() => {
                loadNotes();
                selectNote(id);
            }, 1500);
        })
        .catch(error => {
            // Ocultar loader
            updateBtn.disabled = false;
            loader.style.display = 'none';
            
            console.error("Error actualizando nota:", error);
            showStatus('edit-status', 'Error al actualizar la nota', 'error');
        });
}

// Eliminar nota actual
function deleteCurrentNote() {
    if (!currentNoteId) return;
    
    if (confirm('¿Estás seguro de que quieres eliminar esta nota?')) {
        axios.delete(`${ROUTE}/${currentNoteId}`)
            .then(response => {
                // Recargar notas
                loadNotes();
                
                // Si hay notas, mostrar la primera, sino mostrar mensaje vacío
                if (notes.length > 0) {
                    selectNote(notes[0].id);
                } else {
                    noteView.style.display = 'none';
                    noteForm.style.display = 'none';
                    editForm.style.display = 'none';
                    emptyNoteMessage.style.display = 'block';
                }
            })
            .catch(error => {
                console.error("Error eliminando nota:", error);
                showStatus('create-status', 'Error al eliminar la nota', 'error');
            });
    }
}

// Mostrar mensajes de estado
function showStatus(elementId, message, type) {
    const statusElement = document.getElementById(elementId);
    statusElement.textContent = message;
    statusElement.className = `status-message status-${type}`;
    statusElement.style.display = 'block';
    
    // Ocultar después de 5 segundos
    setTimeout(() => {
        statusElement.style.display = 'none';
    }, 5000);
}