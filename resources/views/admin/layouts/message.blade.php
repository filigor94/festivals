@if($flash = session('message'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert fresh-color alert-success">
                <strong>{{ $flash }}</strong>
            </div>
        </div>
    </div>
@endif