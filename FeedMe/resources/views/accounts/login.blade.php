@extends('/layout')

@section('content')

<h1>Log In </h1>
<div>
    <form action="/login" method="POST">
        Username: <input type="text" name="username">
        <br>
        Password: <input type="password" name="password">
        <br>
        <input type="submit">
    </form>
</div>

@stop