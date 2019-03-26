{{ stylesheet_link('css/form.css') }}

<div class="row">
    <nav>
        <ul class="pager">
            {{ link_to('specification', '<i class="fas fa-arrow-left"></i><span class="font-weight-bold"> Вернуться</span>', 'class' : 'btn btn-success') }}
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>Добавить характеристику</h1>
</div>

{{ content() }}

{{ form("specification/create", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

<div class="form-group required">
    <label for="fieldName" class="control-label">Название</label>
    <div class="col-12">
        {{ text_field("name", "size" : 30, "class" : "form-control", "id" : "fieldName", "placeholder" : "Введите название") }}
    </div>
</div>

<div class="form-group required">
    <label for="fieldExpectedMaxValue" class="control-label">Ожидаемое максимальное значение характеристики</label>
    <div class="col-12">
        {{ text_field("expected_max_value", "size" : 30, "class" : "form-control", "id" : "fieldExpectedMaxValue", "placeholder" : "Введите вещественное число") }}
    </div>
</div>

{{ hidden_field("specification_id") }}

<div class="form-group">
    <div class="col-12">
        {{ submit_button('Добавить', 'class': 'btn btn-success') }}
    </div>
</div>

{{ end_form() }}