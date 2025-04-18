<script>
    let rowIndex = 1;

    $('#add-row').click(function () {
        let newRow = $('.repeater-item:first').clone();

        // Clear selected values
        newRow.find('select').val('');

        // Update the name attributes with the new index
        newRow.find('select').each(function () {
            let name = $(this).attr('name');
            name = name.replace(/\[\d+\]/, '[' + rowIndex + ']');
            $(this).attr('name', name);
        });

        $('#repeater-wrapper').append(newRow);
        rowIndex++;
    });

    // Remove row on click
    $(document).on('click', '.remove-row', function () {
        if ($('.repeater-item').length > 1) {
            $(this).closest('.repeater-item').remove();
        }
    });
</script>
