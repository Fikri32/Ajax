<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

      
    </head>
    <body>
      <div class="container pt-5 ">
        <a href="javascript:void(0)" id="createCategory" class="btn btn-primary mb-3">Tambah</a>
     
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($category as $d)
          <tr>
            <td>{{$d->nama}}</td>
            <td>
              <a href="" id="editCategory" class="btn btn-warning">Edit</a>
              <a href="javascript:void(0)" data-id="{{ $d->id }}" id="deleteCategory" class="btn btn-danger">Delete</a>
            </td>
          </tr>
          @empty
              
          @endforelse
         
        </tbody>
      </table>
      </div>  
      {{-- modal --}}
      <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
              <form id="CategoryForm" name="CategoryForm" class="form-horizontal">
                @csrf
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Name" value="" maxlength="50" required="">
                  </div>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </body>
    <script type="text/javascript">
      $(function () {
    
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        // $.ajax({
        //   url:" categoryData",
        //   type:'GET',
        //   success:function(data){
        //       $('#nama').html('data.nama');
              
            
        //     },
        // })
    
       
        $('#createCategory').click(function () {
            $('#saveBtn').val("create-Category");
            $('#CategoryForm').trigger("reset");
            $('#modelHeading').html("Create New Category");
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e){
          e.preventDefault();

          var name = $('#name').val();

          $.ajax({
            data:$('#CategoryForm').serialize(),
            url:"",
            type:"POST",
            dataType:'json',
            success:function(data){
              $('#CategoryForm').trigger('reset');
              $('#ajaxModel').modal('hide');
            
            },
            error:function(data){
              console.log('Error');
              $('#saveBtn').html('Save Changes');
            }
          });
        });

        $('body').on('click', '#deleteCategory', function () {

          var Category = $(this).data("id");
          var token = $("meta[name='csrf-token']").attr("content");
          confirm("Are You sure want to delete !");

          $.ajax(
            {
                url: "category"+'/'+Category,
                type: 'DELETE',
                data: {
                    "id": Category,
                    "_token": token,
                },
                success: function (){
                    console.log("it Works");
                }
            });
          });
    
        
    
      });
    </script>
</html>
