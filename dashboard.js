function loadContacts(filterType = 'all') {
    fetch(`get_contacts.php?filter=${filterType}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#contacts-table tbody');
            tableBody.innerHTML = '';

            data.forEach(contact => {
                const row = `
                    <tr>
                        <td><strong>${contact.title} ${contact.firstname} ${contact.lastname}</strong></td>
                        <td>${contact.email}</td>
                        <td>${contact.company}</td>
                        <td><span class="badge ${contact.type.toLowerCase()}">${contact.type}</span></td>
                        <td><a href="#" onclick="viewDetails(${contact.id})">View</a></td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', () => loadContacts('all'));