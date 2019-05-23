<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>

        @foreach ($errors->all() as $message)
            <li>{{$message}}</li>
        @endforeach
    </ul>
</div>
