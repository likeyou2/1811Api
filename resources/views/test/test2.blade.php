@extends('test.test1')

@section('head')
    @parent

@endsection


@section('sidebar')
    @parent
    <p>继承模板</p>
@endsection

@section('content')
    <p>这里是主体内容，完善中...</p>
@endsection