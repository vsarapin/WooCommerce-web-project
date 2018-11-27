jQuery( function( $ ) {

        var novaposhta = {

            $checkout_form: $( 'form.checkout' ),

            init: function () {
                this.$checkout_form.on( 'change', 'select.shipping_method, input[name^="shipping_method"]',  this.changeShippingMethod );
                var url = window.location.href;

                if (url.match('/checkout/')) {

                    novaposhta.clearCityField();
                    
                    novaposhta.createModalWindow();

                    //Make request to get list of city
                    novaposhta.getListOfCity();
                }
            },

            createModalWindow: function() {
                 var modal = '<div id="dialog">';
                     modal += '   <div id="dialog-box"><div id="message-wait">Пожалуйста подождите</div></div>';
                     modal += '</div>';


                $('body').append(modal);

                $("#dialog").dialog({
                    title: "",
                    autoOpen: false,
                    modal: true,
                    draggable: false,
                    resizable: false,
                    closeOnEscape: false,
                    open: function(event, ui) {
                        $(".ui-dialog-titlebar-close").hide();
                        document.querySelector('[aria-labelledby="ui-id-1"]').style.outline = "none";
                    },
                    minWidth: 520,
                    minHeight: 100,
                });
            },

            showModalRequest: function() {

                $("#dialog").dialog("open");
            },

            changeShippingMethod: function() {
                var shipping_method  =  $( 'select.shipping_method, input[name^="shipping_method"][type="radio"]:checked').val();

                novaposhta.clearCityField();
                novaposhta.clearDepartmentList();

                if (shipping_method == 'integrate_np') {
                    novaposhta.showList();
                    novaposhta.showCity();
                } else {
                    novaposhta.hideList();
                    novaposhta.hideCity();
                }
            },
            
            eventShippingMethod: function() {
                var shipping_method  =  $( 'select.shipping_method, input[name^="shipping_method"][type="radio"]:checked').val();

                if (shipping_method == 'integrate_np') {
                    novaposhta.showList();
                    novaposhta.showCity();
                } else {
                    novaposhta.hideList();
                    novaposhta.hideCity();
                }
            },

            clearCityField: function() {

                if ( $( '#ship-to-different-address' ).find( 'input' ).is( ':checked' ) ) {
                    $( '#shipping_city' ).val('');
                    $("select#novaposhta_city").find("option#empty-city").attr("selected", "selected");
                } else {
                    $( '#billing_city' ).val('');
                    $("select#novaposhta_city").find("option#empty-city").attr("selected", "selected");
                }
            },

            clearDepartmentList: function() {

                $("#novaposhta_department_field").remove();
            },

            showCity: function() {
                $("#billing_city").css('display', 'none');
                $("#novaposhta_city").css('display', 'block');
            },

            hideCity: function() {
                $("#billing_city").css('display', 'block');
                $("#novaposhta_city").css('display', 'none');
            },

            createListCity: function(data) {

                var html = '<select name="novaposhta_city" id="novaposhta_city" class="select "  data-placeholder="Select city" >';
                html += '  <option id ="empty-city" value="" >Выберите населенный пункт</option>';
                for (var city in data.cities) {
                    html += '  <option value="'+ data.cities[city].city +'" >'+ data.cities[city].city +'</option>';
                }
                html += '</select>';

                if ( $( '#ship-to-different-address' ).find( 'input' ).is( ':checked' ) ) {
                    $("#shipping_city").css('display', 'none');
                    $("#shipping_city").after(html)
                } else {
                    $("#billing_city").css('display', 'none');
                    $("#billing_city").after(html)
                }
            },

            changeOnCity: function() {

                $("#novaposhta_city").on('change', function () {

                    if ( $( '#ship-to-different-address' ).find( 'input' ).is( ':checked' ) ) {
                        $( '#shipping_city' ).val($("#novaposhta_city").val());
                    } else {
                        $( '#billing_city' ).val($("#novaposhta_city").val());
                    }
                    novaposhta.getListOfDepartment();
                });

            },

            hideList: function() {

                $("#novaposhta_department_field").css('display', 'none');
            },

            showList: function() {

                $("#novaposhta_department_field").css('display', 'block');
            },

            getListOfCity: function() {

                var req_data = {

                    action: 'list_of_city',
                    security: dataForIntegrateNPShipping.security
                };

                $("#novaposhta_department_field").remove();

                //Send AJAX request
                $.ajax({
                    url: dataForIntegrateNPShipping.ajax,
                    type: "POST",
                    dataType: "JSON",
                    beforeSend: function() {
                        novaposhta.showModalRequest();

                    },
                    complete: function() {
                        $("#dialog").dialog("close");
                    },
                    data: req_data,
                    success: function (data) {

                        novaposhta.createListCity(data);
                        novaposhta.eventShippingMethod();
                        novaposhta.changeOnCity();
                    }
                });


            },

            getListOfDepartment: function() {

                var req_data = {

                    action: 'list_of_department',
                    security: dataForIntegrateNPShipping.security,
                    city: $( '#billing_city' ).val()

                };

                if ( $( '#ship-to-different-address' ).find( 'input' ).is( ':checked' ) ) {
                    req_data['city'] = $( '#shipping_city' ).val();
                }

                $("#novaposhta_department_field").remove();

                //Send AJAX request
                $.ajax({
                    url: dataForIntegrateNPShipping.ajax,
                    type: "POST",
                    dataType: "JSON",
                    beforeSend: function() {
                        novaposhta.showModalRequest();

                    },
                    complete: function() {
                        $("#dialog").dialog("close");
                    },
                    data: req_data,
                    success: function (data) {

                        novaposhta.createListFrame(data);
                        novaposhta.eventShippingMethod();
                        novaposhta.changeOnDepartment();

                        if ( $( '#ship-to-different-address' ).find( 'input' ).is( ':checked' ) ) {
                            //$( ':input#shipping_city').trigger('change');
                        } else {
                            ///alert('Here');
                            //$( ':input#billing_city' ).trigger('change');
                        }
                    }
                });


            },

            createListFrame: function(data) {

                $("#novaposhta_department_field").remove();

                var html = '<p class="form-row form-row my-field-class form-row-wide" id="novaposhta_department_field" style="display: none"><label for="novaposhta_department" class="">Список отделений Новой Почты&nbsp;</label>';
                html += '<select name="novaposhta_department" id="novaposhta_department" class="select "  data-placeholder="Select department" >';
                html += '  <option value="" >Отделение Новой Почты</option>';
                for (var city in data.houses) {
                    html += '  <option value="'+ data.houses[city].warehouse +'" >'+ data.houses[city].warehouse +'</option>';
                }
                html += '</select>';
                html += '</p>';

                if ( $( '#ship-to-different-address' ).find( 'input' ).is( ':checked' ) ) {
                    $("#shipping_city_field").after(html);
                } else {
                    $("#billing_city_field").after(html);
                }
            },

            changeOnDepartment: function () {


                $("#novaposhta_department").on('change', function () {

                    var req_data = {

                        action: 'chosen_department',
                        security: dataForIntegrateNPShipping.security,
                        department: $("#novaposhta_department").val()

                    };
                    //Send AJAX request
                    $.ajax({
                        url: dataForIntegrateNPShipping.ajax,
                        type: "POST",
                        dataType: "JSON",
                        beforeSend: function() {
                            novaposhta.showModalRequest();
                        //
                        },
                        complete: function() {
                            $("#dialog").dialog("close");
                        },
                        data: req_data,
                        timeout: 30000,
                        success: function (data) {
                               alert(data.department);
                        }
                    });
                });
            }
        }

        novaposhta.init();
}); 
