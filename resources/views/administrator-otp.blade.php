<!-- Login Box -->
<div id="admin-otp-verify" style="display: none;">
    <div id="content">
        <div class="container-fluid"><br>
            <br>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="panel-title text-center">
                                <i class="fa fa-lock"></i>Đăng Nhập Số Điện Thoại
                            </h1>
                            <br>
                        </div>
                        <div class="panel-body">
                            <div id="user-signed-in" class="form-group">
                                <div id="user-info" style="margin: 15px;">
                                    <div id="phone">
                                        <input id="numberPhone" class="form-control" type="text" value="" placeholder="Số điện thoại"/>
                                    </div>
                                    <div class="clearfix" style="margin: 15px;"></div>
                                    <div style="margin: 15px;" id="recaptcha-container"></div>
                                    <div>
                                        <button onClick="sendOTP()" class="btn btn-success btn-block" id="send-otp">Gửi OTP</button>
                                    </div>
                                </div>
                                <div id="user-info-varify" style="margin: 15px;">
                                    <div id="varify">
                                        <input id="verification" class="form-control" type="text" value="" placeholder="Mã OTP"/>
                                    </div>
                                    <div class="clearfix" style="margin: 15px;"></div>
                                    <div>
                                        <button onClick="verifyOTP()" class="btn btn-success btn-block" id="verify-otp-login" disabled>Đăng nhập OTP</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">Copyright © 2021 By Giáo Phận Phú Cường, All rights reserved. Powered by
        <a href="/"> Catholic.App.Team</a><br>Version 1.0.0.0
    </footer>
</div>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('admin-otp-verify').removeAttribute('style');
    });
</script>
<!-- Login Box -->