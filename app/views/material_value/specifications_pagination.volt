<style>
    .hidden{
        display:none;
        visibility:hidden;
    }
</style>
<div class="row px-3">
    <table class="table table-bordered table-striped table-hover" id="paginationTable">
        <thead class="thead-dark">
            <tr>
                <th class='hidden'></th>
                <th scope="col"><p class="text-center m-0">Название характеристики</p></th>
                <th scope="col"><p class="text-center m-0">Ожидаемое максимальное значение характеристики</p></th>
                <th scope="col"><p class="text-center m-0">Действия</p></th>
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        <? $equipment_id = MaterialValue::findFirstBymaterial_value_id($material_value_id)->getEquipmentEquipmentId(); ?>
        {% for specification in page.items %}
            <tr>
                <td class="hidden">{{ specification.getSpecificationId() }}</td>
                <td>{{ specification.getName() }}</td>
                <td>{{ specification.getExpectedMaxValue() }}</td>
                <td class='actions'>
                <? $specification_id = $specification->getSpecificationId();
                    $equipmentHasSpecification = EquipmentHasSpecification::findFirst([
                            'equipment_equipment_id = ?1 AND specification_specification_id = ?2',
                            'bind' => [
                                1 => $equipment_id,
                                2 => $specification_id,
                            ],
                        ]
                    );
                    if ($equipmentHasSpecification) { ?>
                        <button class='btn btn-danger w-100 spec-rem' name='<? echo $specification_id; ?>'><i class="fas fa-edit d-inline"></i> Убрать характеристику</button>
                    <? } else { ?>
                        <button class='btn btn-success w-100 spec-add' name='<? echo $specification_id; ?>'><i class="fas fa-edit d-inline"></i> Добавить характеристику</button>
                    <? } ?>
                </td>
            </tr>
        {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>
{% if page is defined %}
<div class="d-flex justify-content-center px-3">
    {{ pagination('link' : 'location/search?page=%d','current' : page.current,'next' : page.next,'before' : page.before,'count' : page.total_pages) }}
</div>
{% endif %}

<div id="dialog-form" title="Задайте значение характеристики">
    <form id="modal-form">
        <div class="form-group">
            <label for="curval">Текущее значение</label>
            <input type="text" name="curval" id="curval" class="form-control">
        </div>
        <input type="submit" class="btn btn-success" tabindex="-1" value="Добавить">
    </form>
</div>

<script>
    var material_id = "<? echo $material_value_id ?>";
    var staticUri = "<? echo ($this->config->application->staticUri ?? '') ?>";
    $(document).ready(function() {
        var dialog, form, pressedButton, currentValue = $("#curval");
        // Добавление характеристики
        $("td.actions").on('click', 'button.spec-add', function() {
            pressedButton = $(this);
            dialog.dialog("open");
        });
        // Удаление характеристики
        $("td.actions").on('click', 'button.spec-rem', function() {
            pressedButton = $(this);
            $.ajax({
                url: staticUri + 'material_value/rem_specification/' + material_id + '/' + $(this).attr('name'),
                success: function(message) {
                    changeButton(pressedButton);
                    console.log(message);
                },
                error: function(message) {
                    alert('Ошибка при отправке ajax запроса');
                    console.log("spec-rem ajax error");
                }
            });
        });
        // Меняем кнопку
        function changeButton(elem) {
            if (elem.hasClass('spec-add')) {
                elem.html('<i class="fas fa-edit d-inline"></i> Убрать характеристику');
            } else if (elem.hasClass('spec-rem')) {
                elem.html('<i class="fas fa-edit d-inline"></i> Добавить характеристику');
            }
            elem.toggleClass('spec-add spec-rem btn-success btn-danger');
        }
        function sendAjax() {
            $.ajax({
                url: staticUri + 'material_value/add_specification/' + material_id + '/' + pressedButton.attr('name') + '/' + currentValue.val(),
                success: function(message) {
                    changeButton(pressedButton);
                    console.log(message);
                },
                error:function() {
                    alert('Ошибка при отправке ajax запроса');
                    console.log("spec-add ajax error");
                }
            });
            dialog.dialog("close");
        }
        dialog = $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 400,
            width: 350,
            modal: true,
            buttons: {
                "Добавить характеристику": sendAjax,
                Cancel: function() {
                dialog.dialog( "close" );
                }
            },
            close: function() {
                form[0].reset();
            }
        });
        form = dialog.find( "form#modal-form" ).on( "submit", function( event ) {
            event.preventDefault();
            sendAjax();
        });
    });
</script>