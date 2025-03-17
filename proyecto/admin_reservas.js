function openModal(action, id = null) {
    document.getElementById('modal-overlay').classList.remove('hidden');
    document.getElementById('modal').classList.remove('hidden');

    if (action === 'edit' && id !== null) {
        fetch(`get_reservation.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('reservation-id').value = data.id;
                    document.getElementById('reservation-date').value = data.reservation_date.replace(' ', 'T');
                    document.getElementById('number-of-people').value = data.number_of_people;
                    document.getElementById('customer-name').value = data.customer_name;
                    document.getElementById('customer-email').value = data.customer_email;
                    document.getElementById('customer-phone').value = data.customer_phone;
                    document.getElementById('table-number').value = data.table_number;
                }
            })
            .catch(error => {
                console.error('Error fetching reservation:', error);
                alert('Error al obtener los datos de la reserva.');
            });
    } else {
        document.getElementById('reservation-form').reset();
        document.getElementById('reservation-id').value = '';
    }
}

function closeModal() {
    document.getElementById('modal-overlay').classList.add('hidden');
    document.getElementById('modal').classList.add('hidden');
}

function saveReservation(event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('id', document.getElementById('reservation-id').value);
    formData.append('reservation_date', document.getElementById('reservation-date').value);
    formData.append('number_of_people', document.getElementById('number-of-people').value);
    formData.append('customer_name', document.getElementById('customer-name').value);
    formData.append('customer_email', document.getElementById('customer-email').value);
    formData.append('customer_phone', document.getElementById('customer-phone').value);
    formData.append('table_number', document.getElementById('table-number').value);

    const url = formData.get('id') ? 'update_reservation.php' : 'add_reservation.php';

    fetch(url, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Reserva guardada correctamente');
                closeModal();
                location.reload();
            } else {
                alert('Error al guardar la reserva: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error saving reservation:', error);
            alert('Error al guardar la reserva.');
        });
}

