document.addEventListener('DOMContentLoaded', () => {
    // Helper to get query params
    const urlParams = new URLSearchParams(window.location.search);
    const contactId = urlParams.get('id') || 1; // Default to 1 for testing if not set

    const notesContainer = document.querySelector('.notes-section');
    const addNoteBtn = document.createElement('button'); // Creating the button dynamically since it's missing

    // Select existing buttons
    const assignBtn = document.querySelector('.btn-assign');
    const switchBtn = document.querySelector('.btn-switch');

    // Setup Add Note Button
    const noteInputContainer = document.querySelector('.input-container');
    const noteTextArea = document.getElementById('new-note');

    if (noteInputContainer) {
        addNoteBtn.className = 'btn btn-primary'; // Assuming btn-primary exists or just btn
        addNoteBtn.textContent = 'Add Note';
        addNoteBtn.style.marginTop = '10px';
        addNoteBtn.style.padding = '10px 20px';
        addNoteBtn.style.backgroundColor = '#4f46e5'; // styling matching the other buttons roughly or generic
        addNoteBtn.style.color = 'white';
        addNoteBtn.style.border = 'none';
        addNoteBtn.style.borderRadius = '5px';
        addNoteBtn.style.cursor = 'pointer';

        noteInputContainer.appendChild(addNoteBtn);

        addNoteBtn.addEventListener('click', () => {
            const comment = noteTextArea.value.trim();
            if (!comment) return alert('Please enter a note');

            addNote(contactId, comment);
        });
    }

    // Load notes initially
    loadNotes(contactId);

    // Initial Event Listeners
    if (assignBtn) {
        assignBtn.addEventListener('click', () => {
            updateContact(contactId, 'assign_to_me');
        });
    }

    if (switchBtn) {
        switchBtn.addEventListener('click', () => {
            updateContact(contactId, 'switch_type');
        });
    }

    // Functions
    function loadNotes(id) {
        fetch(`api/get_notes.php?contact_id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) throw new Error(data.error);

                // Clear existing static notes (heading is first child, keep it)
                const heading = notesContainer.querySelector('h2');
                notesContainer.innerHTML = '';
                if (heading) notesContainer.appendChild(heading);

                data.forEach(note => {
                    const noteDiv = document.createElement('div');
                    noteDiv.className = 'note-item';

                    const author = document.createElement('h3');
                    author.textContent = `${note.firstname} ${note.lastname}`;

                    const p = document.createElement('p');
                    p.textContent = note.comment;

                    const dateSpan = document.createElement('span');
                    dateSpan.className = 'note-date';
                    // Format date nicely
                    const dateObj = new Date(note.created_at);
                    dateSpan.textContent = dateObj.toLocaleString('en-US', {
                        month: 'long', day: 'numeric', year: 'numeric',
                        hour: 'numeric', minute: 'numeric', hour12: true
                    });

                    noteDiv.appendChild(author);
                    noteDiv.appendChild(p);
                    noteDiv.appendChild(dateSpan);

                    notesContainer.appendChild(noteDiv);
                });
            })
            .catch(err => console.error('Error loading notes:', err));
    }

    function addNote(id, comment) {
        const formData = new FormData();
        formData.append('contact_id', id);
        formData.append('comment', comment);

        fetch('api/add_note.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    noteTextArea.value = ''; // clear input
                    loadNotes(id); // Reload notes
                    alert('Note added successfully');
                } else {
                    alert('Error adding note: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(err => console.error('Error:', err));
    }

    function updateContact(id, action) {
        const formData = new FormData();
        formData.append('contact_id', id);
        formData.append('action', action);

        fetch('api/update_contact.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (action === 'assign_to_me') {
                        if (data.assigned_to_name) {
                            // Update Assigned To text
                            const details = document.querySelectorAll('.detail-block');
                            details.forEach(detail => {
                                const label = detail.querySelector('label');
                                if (label && label.textContent.trim() === 'Assigned To') {
                                    const p = detail.querySelector('p');
                                    if (p) p.textContent = data.assigned_to_name;
                                }
                            });
                            // Also update button to disabled or change text?
                            // Optional: assignBtn.textContent = 'Assigned to me';
                            // assignBtn.disabled = true;
                            alert('Contact assigned to you.');
                        } else {
                            location.reload();
                        }
                    } else if (action === 'switch_type') {
                        if (data.new_type) {
                            const isSales = data.new_type === 'Sales Lead';
                            // Update button text to the OPPOSITE option
                            switchBtn.innerHTML = switchBtn.innerHTML.replace(
                                isSales ? 'Sales Lead' : 'Support',
                                isSales ? 'Support' : 'Sales Lead'
                            );

                            // If there was a Type field in details (not in current HTML but good for robustness)
                            const details = document.querySelectorAll('.detail-block');
                            details.forEach(detail => {
                                const label = detail.querySelector('label');
                                if (label && label.textContent.trim() === 'Type') {
                                    const p = detail.querySelector('p');
                                    if (p) p.textContent = data.new_type;
                                }
                            });

                            alert(`Contact switched to ${data.new_type}`);
                        } else {
                            alert('Contact type switched successfully');
                        }
                    }
                } else {
                    alert('Error updating contact: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(err => console.error('Error:', err));
    }
});
