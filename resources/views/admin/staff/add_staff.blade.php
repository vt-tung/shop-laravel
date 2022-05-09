@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Add staff
                </header>
                 <?php
                    $message = Session::get('messageaddstaff');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('messageaddstaff',null);
                    }
                    ?>
                <div class="panel-body">

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-staff')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name:</label>
                            <input type="text" name="admin_name" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Account:</label>
                            <input type="text" name="admin_email" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">admin_phone:</label>
                            <input type="text" name="admin_phone" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">admin_password:</label>
                            <input type="password" name="admin_password" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Permission:</label>
                              <select name="admin_role" class="form-control input-sm m-bot15" required="">
                                    <option value="">---Choose---</option>
                                    <option value="1">Admin</option>
                                    <option value="0">Staff</option>
                            </select>
                        </div>
                        <button type="submit" name="add_staff" class="btn btn-info">Add staff</button>
                        </form>
                    </div>
                </div>
            </section>
    </div>
@endsection