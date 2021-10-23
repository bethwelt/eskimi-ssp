@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <create-campaign />
        </div>
        <div class="col-md-6 posts-container" >
            <all-campaigns />
        </div>
    </div>
</div>
@endsection