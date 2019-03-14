<div class="page-header">
    <h1>
        Характеристики
    </h1>
</div>

{{ content() }}

<div class="d-flex justify-content-end py-3">
    {{ link_to('specifications/new', '<i class="fas fa-plus"></i><span class="font-weight-bold"> Добавить</span>', 'class' : 'btn btn-sm btn-success') }}
</div>

{{ form("specifications/search", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

<div class="form-group pl-0 col-12">
    <div class="input-group col-12">
        {{ text_field("name", "size" : 30, "class" : "form-control", "id" : "fieldName", 'placeholder':'Введите название') }}
        {{ submit_button('Найти', 'class': 'btn btn-default d-inline') }}
    </div>
</div>

{{ end_form() }}

{% if page is defined %}
    {{ partial('specifications/pagination', [ 'page': page ]) }}
{% endif %}