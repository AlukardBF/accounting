<div class="page-header">
    <h1>
        Характеристики
    </h1>
</div>

{{ content() }}

{{ form("material_value/search_specifications", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

<div class="form-group pl-0 col-12">
    <div class="input-group col-12">
        {{ text_field("name", "size" : 30, "class" : "form-control", "id" : "fieldName", 'placeholder':'Введите название') }}
        {{ submit_button('Найти', 'class': 'btn btn-default d-inline') }}
    </div>
{{ hidden_field("material_value_id") }}
</div>

{{ end_form() }}

{% if page is defined %}
    {{ partial('material_value/specifications_pagination', [ 'page': page, 'material_value_id': material_value_id ]) }}
{% endif %}

<script>
    var id = "<? echo $material_value_id; ?>";
    $('input[name="material_value_id"]').val(id);
</script>