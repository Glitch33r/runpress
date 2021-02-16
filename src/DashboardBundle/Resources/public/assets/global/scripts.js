$(function() {
	$('body').on('change', '.ajax-checkbox', function() {
	    $.post('/admin/ajax/checkbox', {
	        id: $(this).attr('data-id'),
	        entity: $(this).attr('data-entity'),
	        field: $(this).attr('data-field'),
	        checked: this.checked
	    })
	})

	$("[data-counter='counterup']").counterUp({
        delay: 10,
        time: 1000
    });
});