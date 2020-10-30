@extends('layouts.master')
@section('content')
<div class="container">
    <h2>Register</h2>
    <div class="login-box pt-5 mt-5">
        <form action="#" method="post">
            @csrf()
            <div class="form-group">
                <label for="name">Username :</label>
                <input type="text" class="form-control" id="username"  name="username">
            </div>
            <div class="form-group">
                <label for="picture">Password :</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <button type="submit" class="btn btn-primary">LOGIN</button>
        </form>
    </div>
</div>
@endsection
