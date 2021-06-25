$(document).ready(function ()
{
    TODOLIST.filter_todo();
});


const TODOLIST = (()=>
{
    const APP_URL = "http://127.0.0.1:8000/api";
    let this_todo = {};
    let _id;

    this_todo.filter_todo = () =>
    {
        let filter_todo = $('#slc_todolist').val();
        this_todo.load_all_todo_list(filter_todo);
    }

    this_todo.load_all_todo_list = (filter_todo) =>
    {
        $.ajax({
            type: "GET",
            url: `${APP_URL}/todo`,
            dataType: "json",
            success: function (result) 
            {
                // console.log(data.data);
                // -- if the response is success --
                if (result.status == 'success')
                {
                    let tr;
                    let row = 1;
                    $.each(result.data, function()
                    {
                        if(`${this.completion_datetime}` !== "null" && filter_todo == 1)
                        {
                            tr += 
                            `<tr style="text-decoration:line-through">
                                <td><input type="checkbox" class="form-control" onclick = "TODOLIST.complete_task(${this.id})" checked="checked"></td>
                                <td> ${row} </td>
                                <td> ${this.name} </td>
                                <td> ${this.completion_datetime} </td>
                                <td> ${this.deadline_datetime} </td>
                                <td>
                                    <button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Edit" onclick = "TODOLIST.modal_update(${this.id})"><i class="fa fa-edit"></i> Edit</button>
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick = "TODOLIST.modal_delete_show(${this.id})"><i class="fa fa-trash"></i> Delete</button>
                                </td>
                            </tr>`;
                        }
                        else if(`${this.completion_datetime}` === "null" && filter_todo == 0)
                        {
                            tr += 
                            `<tr>
                                <td><input type="checkbox" class="form-control" onclick = "TODOLIST.complete_task(${this.id})"></td>
                                <td> ${row} </td>
                                <td> ${this.name} </td>
                                <td> ${this.completion_datetime} </td>
                                <td> ${this.deadline_datetime} </td>
                                <td>
                                    <button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Edit" onclick = "TODOLIST.modal_update(${this.id})"><i class="fa fa-edit"></i> Edit</button>
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick = "TODOLIST.modal_delete_show(${this.id})"><i class="fa fa-trash"></i> Delete</button>
                                </td>
                            </tr>`;
                        }
                        row++;
                    });
                    $('#tbl_todolist tbody').html(tr);

                    toastr.success(result.message);
                }
                // -- if the response is error --
                else if (result.status == 'error')
                {
                    toastr.warning(result.message);
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    };

    this_todo.store_todo = () =>
    {
        let  txt_name         = $('#txt_name').val();
        let  deadline         = $('#deadline').val();
        if(txt_name == "")
            toastr.warning("The name field is required.");
        else
            $.ajax({
                type: "POST",
                url: `${APP_URL}/todo`,
                data: 
                {
                    name                : txt_name,
                    deadline_datetime   : deadline,
    
                },
                dataType: "json",
                success: function (result) 
                {
                    if(result.status == 'success')
                    {
                        toastr.success(result.message);
                        $('#txt_name').val("");
                        $('#deadline').val("");
                        $('#modal_add_todo').modal("hide");
                        TODOLIST.filter_todo();
                    }
                    else if (result.status == 'warning')
                    {
                        toastr.warning(result.message);
                    }
                    else
                    {
                        toastr.error(result.message);
                    } 
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            })
    };

    this_todo.modal_update = (id) =>
    {
       $('#modal_update_todo').modal("show");
       $.ajax({
            type: "GET",
            url: `${APP_URL}/todo/${id}`,
            dataType: "json",
            success: function (data) 
            {
                console.log(data)
                if(data.status == 'success')
                {
                    _id = data.data.id;
                    var completion= moment(data.data.completion_datetime).format('YYYY-MM-DDTHH:mm');
                    var deadline= moment(data.data.deadline_datetime).format('YYYY-MM-DDTHH:mm');
                    $('#txt_edit_name').val(data.data.name);
                    $('#edit_completion').val(completion);
                    $('#edit_due_date').val(deadline);
                    
                }
                else
                {
                    toastr.error(result.message);
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    this_todo.update_todo = () =>
    {
        let  txt_edit_name         = $('#txt_edit_name').val();
        let  edit_completion       = $('#edit_completion').val();
        let  edit_due_date         = $('#edit_due_date').val();

        if(txt_edit_name == "")
            toastr.warning("The name field is required.");
        else
        $.ajax({
            type: "PATCH",
            url: `${APP_URL}/todo/${_id}`,
            data: 
            {
                name                : txt_edit_name,
                completion_datetime : edit_completion,
                deadline_datetime   : edit_due_date,

            },
            dataType: "json",
            success: function (result) 
            {
                if(result.status == 'success')
                {
                    toastr.success(result.message);
                    $('#txt_edit_name').val("");
                    $('#edit_completion').val("");
                    $('#edit_due_date').val("");
                    $('#modal_update_todo').modal("hide");
                    TODOLIST.filter_todo();
                }
                else if (result.status == 'warning')
                {
                    toastr.warning(result.message);
                }
                else
                {
                    toastr.error(result.message);
                } 
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        })
    };

    this_todo.modal_delete_show = (id) =>
    {
        _id = id;
       $('#modal_delete_todo').modal("show");
    }

    this_todo.delete_todo = () =>
    {
        $.ajax({
            type: "DELETE",
            url: `${APP_URL}/todo/${_id}`,
            dataType: "json",
            success: function (result) 
            {
                if(result.status == 'success')
                {
                   toastr.success(result.message);
                   TODOLIST.filter_todo();
                   $('#modal_delete_todo').modal("hide");
                }
                else if (result.status == 'warning')
                {
                    toastr.warning(result.message);
                }
                else
                {
                    toastr.success(result.message);
                } 
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        })
    };

    this_todo.complete_task = (id) =>
    {
       $.ajax({
            type: "PATCH",
            url: `${APP_URL}/complete/${id}`,
            dataType: "json",
            success: function (result) 
            {
                console.log(result)
                if(result.status == 'success')
                {
                    toastr.success(result.message);
                    TODOLIST.filter_todo();
                }
                else
                {
                    toastr.error(result.message);
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    return this_todo;
})();