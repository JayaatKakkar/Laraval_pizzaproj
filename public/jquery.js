function updatesubshow(pid,sid){
    console.log(pid,sid);
    $.ajax({
        url: "/get-subcategories/"+pid,
        type: "GET",
        success:function(data){
            // console.log(data);
            var list='<option>Choose Sub</option><option value="0">None</option>';
            if(data.length!=0){
                console.log("work");
                $.each(data,function(index,val){
                    if (val.id==sid) {
                        list+='<option value="'+val.id+'" selected>'+val.category_name+'</option>';
                    }else{
                         list+='<option value="'+val.id+'">'+val.category_name+'</option>';
                    }
                });
                if (sid === null || sid == 0) {
                    list = '<option>Choose Sub</option><option value="0" selected>None</option>';
                    $.each(data, function(index, val) {
                        list += '<option value="' + val.id + '">' + val.category_name + '</option>';
                    });
                }

            }else{
                list='<option>Choose Sub</option><option value="0" selected>None</option>';
            }
            $("#subcategory").html(list);
        }
    })
}
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
                        $('td:eq(0)', row).html(seq);
                    },
                "columnDefs": [
                     {
                         "targets": [0],
                         "orderable": false,
                     },
                     {
                        width:'20%',targets:2,
                     }
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

            $(document).on("click","a#updcat",function(){
                var id = $(this).data('id');
                $.ajax({
                    url: "/category/"+id+"/edit",
                    type: "GET",
                    success: function (data) {
                        console.log(data);
                        $("#categorycol").collapse('show');
                        $("#catform").attr("action",'/category/'+data.id);
                        $("div h3").text("Update Category");
                        $("#parent").val(data.parentcat==null?0:data.parentcat);
                        $("#catname").val(data.category_name);
                        $("#desc").val(data.desc)
                        updatesubshow(data.parentcat,data.subcat)
                        if(data.status=='1'){
                            $("#rdbtn1").prop("checked",true);
                        }else{
                            $("#rdbtn2").prop("checked",true);
                        }
                    }
                })
            });

            $(document).on("click","a#delcat",function(){
                var id = $(this).data('id');
                $.ajax({
                    url: "/category/"+id,
                    type: "DELETE",
                    success: function (data) {
                        console.log(data);
                        Category.ajax.reload();
                        if(data.message)
                        alert("Deleted Successfully")
                    }
                })
            })
        });
