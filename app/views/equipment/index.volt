<div class="page-header">
    <h1>
        Оргтехника
    </h1>
</div>

{{ content() }}

{{ form("equipment/search", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

<div class="form-group pl-0 col-12">
    <div class="input-group col-12">
        {{ text_field("type", "size" : 30, "class" : "form-control", "id" : "fieldType", "placeholder" : "Введите тип") }}
        <div class="input-group-append">
            <a class="btn btn-info" href="#advancedSearch" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="comment">Расширенный поиск</a>
        </div>
        {{ submit_button('Найти', 'class': 'btn btn-default d-inline') }}
    </div>
</div>

<!-- begin advanced search -->
<div class="collapse multi-collapse pl-3" id="advancedSearch" style="max-height: 50vh; overflow-x: hidden; overflow-y: auto;">

<div class="form-group">
    <label for="fieldManufacturer" class="col-sm-2 control-label">Производитель</label>
    <div class="col-12">
        {{ text_field("manufacturer", "size" : 30, "class" : "form-control", "id" : "fieldManufacturer") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldSpecification" class="col-sm-2 control-label">Характеристики</label>
    <div class="col-12">
        {{ text_area("specification", "cols" : 30, "rows" : 4, "class" : "form-control", "id" : "fieldSpecification") }}
    </div>
</div>

</div> <!-- end advanced search -->

{{ end_form() }}

{% if page is defined %}
    {{ partial('equipment/pagination', [ 'page': page ]) }}
{% endif %}