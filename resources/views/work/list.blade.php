<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>终端用户列表展示</title>
</head>
<body>
<table border="1px">
    <tr>
        <td>用户ID</td>
        <td>用户名</td>
        <td>用户邮箱</td>
        <td>登录状态</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->u_id}}</td>
        <td>{{$v->username}}</td>
        <td>{{$v->email}}</td>
        <td>
            @if($v->status == 0) 离线
             @elseif($v->status==1)已在PC端登录
              @elseif($v->status==2)  已在APP端登录
                @endif
        </td>
    </tr>
    @endforeach
</table>
</body>
</html>