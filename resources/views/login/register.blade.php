

@extends('public.index')

@section('title', '注册')



@section('content')
    <!-- register -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>REGISTER</h3>
            </div>
            <div class="register">
                <div class="row">
                    <form class="col s12">
                        <div class="input-field">
                            <input type="text" id="name" class="validate" placeholder="NAME" required>
                        </div>
                        <div class="input-field">
                            <input type="email" id="email" placeholder="EMAIL" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="password" id="pwd" placeholder="PASSWORD" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="password" id="confirm_pwd" placeholder="PASSWORD_CONFIRM" class="validate" required>
                        </div>
                        <div class="btn button-default">REGISTER</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end register -->


    <!-- loader -->
    <div id="fakeLoader"></div>
    <!-- end loader -->

@endsection
<script src="/js/jquery-3.2.1.min.js"></script>
<script>
    $(function () {
        //点击注册
        $('.btn').on('click',function () {
            var name = $('#name').val();    //昵称
            var email = $('#email').val();  //邮箱
            var pwd = $('#pwd').val();      //密码
            var confirm_pwd = $('#confirm_pwd').val(); //确认密码
            var data = {name:name,email:email,pwd:pwd,confirm_pwd:confirm_pwd};
            $.ajax({
                url:'/registerDo',
                type:'post',
                data:data,
                dataType:'json',
                success:function (msg) {
                    if(msg.error == 0){
                        alert(msg.msg);
                        location.href="{{url('/login')}}";
                    }else{
                        alert(msg.msg);
                    }
                }
            })
        })
        //验证邮箱唯一
        $('#email').on('blur',function () {
            var email = $('#email').val();
            $.ajax({
                url:'/uniqueness',
                type:'post',
                data:{email:email},
                dataType:'json',
                success:function (msg) {
                        alert(msg.msg);
                }
            })
        });
    })
</script>

