@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Add brand
                        </header>

                        <div class="panel-body">
                             <?php
                                $message = Session::get('messageaddbrand');
                                if($message){
                                  ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$message}}
                                    </div>
                                  <?php
                                  Session::put('messageaddbrand',null);
                                }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand name: </label>
                                    <input type="text" name="brand_product_name" class="form-control"  placeholder="Brand name" required="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Brand description: </label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="brand_product_desc" id="exampleInputPassword1" placeholder="Brand description..." required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Status: </label>
                                      <select name="brand_product_status" class="form-control input-sm m-bot15">
                                            <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                            
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_category_product" class="btn btn-info">Add brand</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection