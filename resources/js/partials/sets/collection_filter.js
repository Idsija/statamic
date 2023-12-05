document.addEventListener("DOMContentLoaded", function() {

    var checkboxes = document.querySelectorAll('.filter_item');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('click', function(event) {
            var form = document.getElementById('collection_filter');
            form.submit();
        });
    });
});
