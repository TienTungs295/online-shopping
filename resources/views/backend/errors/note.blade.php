@if(count($errors) > 0)
        <div class="alert alert-danger mb-0" >
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li >{{$error}}</li>
                @endforeach
            </ul>
        </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success mb-0">{{Session::get('success')}}</div>
@elseif(Session::has('error'))
    <div class="alert alert-danger mb-0">{{Session::get('error')}}</div>
@endif
