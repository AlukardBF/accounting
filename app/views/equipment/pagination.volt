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
                <th scope="col"><p class="text-center m-0">Тип оргтехники</p></th>
                <th scope="col"><p class="text-center m-0">Производитель</p></th>
                <th scope="col"><p class="text-center m-0">Действия</p></th>
            </tr>
        </thead>
        <tbody>
        {% if page is defined %}
        {% for equipment in page %}
            <tr>
                <td class="hidden">{{ equipment.getEquipmentId() }}</td>
                <td>{{ equipment.getType() }}</td>
                <td>{{ equipment.getManufacturer() }}</td>
                <td>
                    {{ link_to("equipment/edit/" ~ equipment.getEquipmentId(), '<i class="fas fa-edit d-inline"></i> Изменить', 'class' : 'btn btn-success w-100') }}
                    {# link_to("specification/delete/" ~ equipment.getEquipmentId(), '<i class="fas fa-trash d-inline"></i> Удалить', 'class' : 'btn btn-danger w-100') #}
                </td>
            </tr>
        {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>
