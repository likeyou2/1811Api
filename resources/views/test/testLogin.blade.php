<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录发送验证码</title>
    <script src="/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<form>
    <input type="tel" id="tel">
    <button id="btn" type="button">发送短信</button>
</form>
</body>
</html>
<script>
    $(function(){
        $('#btn').on('click',function(){
            var tel = $('#tel').val();
            $.ajax({
                url:'http://vm.1811.com/test/testLoginDo',
                type:'post',
                dataType:'json',
                data:{tel:tel},
                success:function(msg){
                    console.log(msg);
                }
            })
        })
    })
</script>