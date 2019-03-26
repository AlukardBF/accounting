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
                <th scope="col"><p class="text-center m-0">Характеристики</p></th>
                <th scope="col"><p class="text-center m-0">Действия</p></th>
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for equipment in page.items %}
            <tr>
                <td class="hidden">{{ equipment.getEquipmentId() }}</td>
                <td>{{ equipment.getType() }}</td>
                <td>{{ equipment.getManufacturer() }}</td>
                <td>{{ equipment.getSpecification() }}</td>
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
{% if page is defined %}
<div class="d-flex justify-content-center px-3">
    {{ pagination('link' : 'equipment/search?page=%d','current' : page.current,'next' : page.next,'before' : page.before,'count' : page.total_pages) }}
</div>
{% endif %}
