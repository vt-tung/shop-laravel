@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Edit staff
                </header>
                 <?php
                    $message = Session::get('messageeditstaff');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('messageeditstaff',null);
                    }
                    ?>
                <div class="panel-body">

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-staff/'.$edit_staff->admin_id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Account:</label>
                            <input type="text" name="admin_email" class="form-control" value="{{$edit_staff->admin_email}}" disabled="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Name:</label>
                            <input type="text" name="admin_name" class="form-control" value="{{$edit_staff->admin_name}}" required="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">admin_phone:</label>
                            <input type="text" name="admin_phone" class="form-control" value="{{$edit_staff->admin_phone}}" required="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">admin_password:</label>
                            <input type="password" name="admin_password" class="form-control" value="{{$edit_staff->admin_password}}" required="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Permission:</label>
                            <select name="admin_role" class="form-control input-sm m-bot15" required="">
                                <option value="">---Choose---</option>
                                <option value="1" @if($edit_staff->admin_role==1) selected="" @endif>Admin</option>
                                <option value="0" @if($edit_staff->admin_role==0) selected="" @endif>Staff</option>
                            </select>
                        </div>
                        <button type="submit" name="add_staff" class="btn btn-info">Add staff</button>
                        </form>
                    </div>
                </div>
            </section>
    </div>
@endsection