var admin_id = $('#wrapper').data('admin-id');

function updateAdminProfile() {
    $.ajax({
        url: 'queries/getAdminDetails.php',
        type: 'GET',
        data: { admin_id: admin_id },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error
                });
            } else {
                $('#firstname').val(data.firstname);
                $('#lastname').val(data.lastname);
                $('#admin_id').val(data.admin_id);
                $('#email').val(data.email);
                $('#displayName').text(data.firstname + ' ' + data.lastname);
                $('#displayEmail').text(data.email);
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'AJAX Error',
                text: xhr.responseText
            });
        }
    });
}

updateAdminProfile();
