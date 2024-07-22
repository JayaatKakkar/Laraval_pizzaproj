
        $(document).ready(function() {

            // ..........Sub category Dropdown............
            $('#parent').change(function() {
                var parentId = $(this).val();
                if (parentId != 0) {
                    $.ajax({
                        url: '/get-subcategories/' + parentId,
                        type: 'GET',
                        success: function(data) {
                            var subcategoryDropdown = $('#subcategory');
                            subcategoryDropdown.empty();
                            subcategoryDropdown.append('<option value="0">None</option>');
                            $.each(data, function(key, value) {
                                subcategoryDropdown.append('<option value="' + value.id + '">' + value.category_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategory').empty();
                    $('#subcategory').append('<option value="0">None</option>');
                }
            });


            // ............DataTable for Category..............

            var Category= $("#categorytab").DataTable({

                language:{
                    search:'_INPUT_',
                    searchPlaceholder:'Search...'
                },
                "lengthChange": true,
                "serverSide": true,
                "processing": true,
                "colReorder": true,   //this is used to arrange the position of columns
                "responsive": true,
                
                "order": [[0, "asc"]],
                "ajax":{
                    url: "/viewcategory",
                    type: "POST",
                    dataType: "json"
                },
                "rowCallback": function(row, data, index) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;
                        var seq = startIndex + index + 1;
                        $('td:eq(1)', row).html(seq);
                    },
                "columnDefs": [
                     {
                         "targets": [0],
                         "orderable": false,
                     },
                    ],
                "pageLength": 10,
                dom:  '<"button-container d-md-flex justify-content-md-end"fB>rt<"button-container-footer d-md-flex justify-content-md-between"lpi>',
                // dom: "Blfrtip",
                // "B" stands for buttons
                // "l" stands for length
                // "f" stands for filtering input (search bar)
                // "r" stands for processing display element (showing "Processing..." message)
                // "t" stands for the table itself
                // "i" stands for table information summary (showing "Showing x of y entries" message)
                // "p" stands for pagination control
                buttons: [
                   
                    {
                        text: ' <i class="fa-solid fa-table-columns"></i> Column Visibility',
                        extend: 'colvis'
                    },
            
                    {
                        text: '<i class="fa-solid fa-arrow-right-from-bracket"></i> Export ',
                        className: 'btn-export',
                        extend: 'collection',
                        buttons: [
                            {
                                extend: 'pdf',
                                text: 'PDF'
                            },
                            {
                                extend: 'excel',
                                text: 'Excel'
                            },
                            {
                                extend: 'print',
                                text: 'Print'
                            }
                        ]
                    },
            
                  
                ],
                // ------------------------   pagination icon preview and next ---------------------------
                pagingType: 'simple_numbers',
                oLanguage: {
                    oPaginate: {
                    sNext: '<i class="fa-solid fa-angles-right"></i>',
                    sPrevious: '<i class="fa-solid fa-angles-left"></i>'
                    
                    }
                }  
                
            });
        });
