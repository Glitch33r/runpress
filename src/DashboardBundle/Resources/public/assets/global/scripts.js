$(function() {
	$('body').on('change', '.ajax-checkbox', function() {
	    $.post('/admin/ajax/checkbox', {
	        id: $(this).attr('data-id'),
	        entity: $(this).attr('data-entity'),
	        field: $(this).attr('data-field'),
	        checked: this.checked
	    })
	})
});