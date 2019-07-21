@extends('public.index')

@section('title', '登录')

@section('content')

    <!-- login -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>LOGIN</h3>
            </div>
            <div class="login">
                <div class="row">
                    <form class="col s12">
                        <div class="input-field">
                            <input type="text" class="validate" id="email" placeholder="EMAIL" required>
                        </div>
                        <div class="input-field">
                            <input type="password" class="validate" id="pwd" placeholder="PASSWORD" required>
                        </div>
                        <a href=""><h6>Forgot Password ?</h6></a>
                        <a href="javascript:;" class="btn button-default">LOGIN</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end login -->

    <!-- loader -->
    <div id="fakeLoader"></div>
    <!-- end loader -->

@endsection
<script src="/js/jquery-3.2.1.min.js"></script>
<script>

    $(document).ready(function () {
        $('.btn').on('click',function () {
            var email = $('#email').val();
            var pwd  = $('#pwd').val();
            var data = {email:email,pwd:pwd};
            $.ajax({
                url:"{{url('/loginDo')}}",
                data:data,
                type:'post',
                dataType:'json',
                success:function (msg) {
                    if(msg.error == 0){
                        alert(msg.msg);
                        location.href="{{url('/index')}}";
                    }else{
                        alert(msg.msg);
                    }
                }
            })
        })
    })

</script>
