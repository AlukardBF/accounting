$(function() {
    changeBlocks($('#fieldType option:selected').val());

    $('#fieldType').change(function(){
        changeBlocks($(this).val());
    });

    function changeBlocks(type) {
        switch(type){
            case 'assets':{
                $('#furnitureLabel').hide();
                $('#fieldFurnitureBlock').hide();
                $('#equipmentLabel').hide();
                $('#fieldEquipmentTypeBlock').hide();
                $('#fieldEquipmentManufacturerBlock').hide();
                $('#btnLicenseSetup').hide();
                $('#btnSpecificationSetup').hide();
                $('#tables').hide();
            }break;
            case 'furniture':{
                $('#furnitureLabel').show();
                $('#fieldFurnitureBlock').show();
                $('#equipmentLabel').hide();
                $('#fieldEquipmentTypeBlock').hide();
                $('#fieldEquipmentManufacturerBlock').hide();
                $('#btnLicenseSetup').hide();
                $('#btnSpecificationSetup').hide();
                $('#tables').hide();
            }break;
            case 'equipment':{
                $('#furnitureLabel').hide();
                $('#fieldFurnitureBlock').hide();
                $('#equipmentLabel').show();
                $('#fieldEquipmentTypeBlock').show();
                $('#fieldEquipmentManufacturerBlock').show();
                $('#btnLicenseSetup').show();
                $('#btnSpecificationSetup').show();
                $('#tables').show();
            }break;
            default: {
                $('#furnitureLabel').hide();
                $('#fieldFurnitureBlock').hide();
                $('#equipmentLabel').hide();
                $('#fieldEquipmentTypeBlock').hide();
                $('#fieldEquipmentManufacturerBlock').hide();
                $('#btnLicenseSetup').hide();
                $('#btnSpecificationSetup').hide();
                $('#tables').hide();
            }
        }
    }
});