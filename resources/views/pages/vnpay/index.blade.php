@extends('layout')
@section('content')
    <div class="container th-banner">
        <div class="cl-breacrumb-product">
            <div class="cl-list-breacrumb">
                <ul class="cl-content-breacrumb">
                    <li><a href="index.php" class="cl-link" title="">Home</a></li>
                    <li><span class="cl-link disabled">PAY BY VNPAY</span></li>
                </ul>
            </div>
        </div>
        <div class="th-form-login row">
            <div class="th-form col-md-6">
                <h1 class="th-title">PAY BY VNPAY</h1>
                <form action="{{URL::to('/payment/online')}}" id="create_form" method="POST" class="login-form">       
                    {{csrf_field()}}
                    <input class="form-control" id="order_type"
                               name="order_type" type="hidden" value="fashion"/>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="cl-label-form" for="">Total : {{number_format($totalMoney,0,",",".")." "."VNĐ"}}</label>
                                        <input class="th-form-control" id="amount" name="amount" type="hidden" value="{{$totalMoney}}"/>      
                                        <input type="hidden" class="th-form-control" id="order_desc" name="order_desc" value="Transfer"/>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="cl-label-form" for="">Bank :</label>
                                        <select name="bank_code" id="bank_code" class="th-form-control" required="">
                                            <option value="">--Not selected--</option>
                                            <option value="NCB"> Ngan hang NCB</option>
                                            <option value="AGRIBANK"> Ngan hang Agribank</option>
                                            <option value="SCB"> Ngan hang SCB</option>
                                            <option value="SACOMBANK">Ngan hang SacomBank</option>
                                            <option value="EXIMBANK"> Ngan hang EximBank</option>
                                            <option value="MSBANK"> Ngan hang MSBANK</option>
                                            <option value="NAMABANK"> Ngan hang NamABank</option>
                                            <option value="VNMART"> Vi dien tu VnMart</option>
                                            <option value="VIETINBANK">Ngan hang Vietinbank</option>
                                            <option value="VIETCOMBANK"> Ngan hang VCB</option>
                                            <option value="HDBANK">Ngan hang HDBank</option>
                                            <option value="DONGABANK"> Ngan hang Dong A</option>
                                            <option value="TPBANK"> Ngân hàng TPBank</option>
                                            <option value="OJB"> Ngân hàng OceanBank</option>
                                            <option value="BIDV"> Ngân hàng BIDV</option>
                                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                                            <option value="VPBANK"> Ngan hang VPBank</option>
                                            <option value="MBBANK"> Ngan hang MBBank</option>
                                            <option value="ACB"> Ngan hang ACB</option>
                                            <option value="OCB"> Ngan hang OCB</option>
                                            <option value="IVB"> Ngan hang IVB</option>
                                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="cl-label-form" for="">Language :</label>
                                        <select name="language" id="language" class="th-form-control">
                                            <option value="vn">Tiếng Việt</option>
                                            <option value="en">English</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="text-align: center;">
                        <button type="submit" class="btn-pay_vnpay" id="btnPopup" >Payment confirmation</button>
                        <button type="button" class="btn-pay_vnpay back" onclick="window.history.back()">Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
