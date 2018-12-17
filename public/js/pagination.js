$('.table > tbody > tr').dblclick(function() {
    material_value_id = this.firstElementChild.innerText;
    $(location).attr('pathname', 'accounting/material_value/show/' + material_value_id);
});