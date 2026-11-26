@if(count($errors) > 0)
    {{-- <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> --}}
    <script>
        window.onload = function() {
            @foreach($errors->all() as $error)
                notif({
                    msg: "{{ $error }}",
                    type: "error"
                })
            @endforeach
        }
    </script>
@endif

{{-- This is for the add message --}}
@if(session()->has('add'))
    <script>
        window.onload = function() {
            notif({
                msg: "{{ trans('messages.add') }}",
                type: "success"
            })
        }
    </script>
@endif

{{-- This is for the edit message --}}
@if(session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: "{{ trans('messages.edit') }}",
                type: "success"
            })
        }
    </script>
@endif


{{-- This is for the delete message --}}
@if(session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: "{{ trans('messages.delete') }}",
                type: "success"
            })
        }
    </script>
@endif
