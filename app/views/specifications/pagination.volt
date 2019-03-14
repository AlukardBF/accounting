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
        {% for specification in page.items %}
            <tr>
                <td class="hidden">{{ specification.getSpecificationsId() }}</td>
                <td>{{ specification.getName() }}</td>
                <td>{{ specification.getExpectedMaxValue() }}</td>
                <td>
                    {{ link_to("specifications/edit/" ~ specification.getSpecificationsId(), '<i class="fas fa-edit d-inline"></i> Изменить', 'class' : 'btn btn-success w-100') }}
                    {{ link_to("specifications/delete/" ~ specification.getSpecificationsId(), '<i class="fas fa-trash d-inline"></i> Удалить', 'class' : 'btn btn-danger w-100') }}
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
