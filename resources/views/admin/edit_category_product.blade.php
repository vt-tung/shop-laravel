@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
               Update category product
            </header>
            <div class="panel-body">
                 <?php
                    $message = Session::get('messageupdatecategory');
                    if($message){
                      ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          {{$message}}
                        </div>
                      <?php
                      Session::put('messageupdatecategory',null);
                    }
                ?>
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-category-product/'.$category->category_id )}}" method="post">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category name:</label>
                        <input type="text" value="{{$category->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Category description:</label>
                        <textarea style="resize: none" rows="8" class="form-control" name="category_product_desc" id="ckeditor6" >{{$category->category_desc}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Category keyword:</label>
                        <textarea style="resize: none" rows="8" class="form-control" name="meta_keywords" id="ckeditor9" >{{$category->meta_keywords}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Thuộc danh mục</label>
                          <select name="category_parent" class="form-control input-sm m-bot15">
                            <option value="0">---Danh mục cha---</option>
                            {!!$htmlOption!!}
                        </select>
                    </div>
                    <button type="submit" name="update_category_product" class="btn btn-info">Update category</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection