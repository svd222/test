/**
 * Created by svd on 29.09.16.
 */
$('#myBtn').click(
    function(evt) {
        var url = $('#url').val();
        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data, status, jqXHR) {
                $('#modalBody').html(data);
                $('#myModal').modal();
                console.log('status: ' + status);
            },
            error: function(jqXHR, status, error) {
                console.log('status: ' + status + ', reason: ' + error);
            }
        });
    }
);
