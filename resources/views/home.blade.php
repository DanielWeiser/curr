@extends('layouts.app')
@section('content')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="d-flex justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @if ($user_name != 'admin')
                    <li class="nav-item h5">
                        <a class="nav-link" href="/newcurr">New currencies</a>
                    </li>
                @else
                    <li class="nav-item h5">
                        <a class="nav-link" href="/admin">Requests</a>
                    </li>
                    <li class="nav-item h5">
                        <a class="nav-link" href="/users">Users</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
<div class="container  add_class">
    <div class="d-flex justify-content-center" style="margin-top: 100px;">
        <div class="row">
            <div class="d-flex justify-content-center dropdown col">
                <div class="btn-group dropleft">
                    <button class="btn btn-lg btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0, 7">
                        <img :src="flag_from"  height="35" style="padding-right: 10px; margin-left: 5px;">@{{code_from}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($currency as $curr)
                            <button class="dropdown-item" type="button" v-on:click="change_curr_from('{{$curr->code}}', '{{$curr->flag}}', '{{$curr->rate}}')">
                                <img src="flags/{{$curr->flag}}"  height="35" style="padding-right: 12px;">
                                {{$curr->code}}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col d-flex justify-content-center" style="margin-top: 7px;">
                <input type="number" class="form-control" v-model="curr_num" v-on:keyup="conv_in()">
            </div>
            <div class="d-flex justify-content-center dropdown col">
                <div class="btn-group dropright">
                    <button class="btn btn-lg btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0, 7">
                        <img :src="flag_to"  height="35" style="padding-right: 10px;">@{{code_to}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($currency as $curr)
                            <button class="dropdown-item" type="button" v-on:click="change_curr_to('{{$curr->code}}', '{{$curr->flag}}', '{{$curr->rate}}')">
                            <img src="flags/{{$curr->flag}}"  height="35" style="padding-right: 12px;">
                                {{$curr->code}}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="d-flex justify-content-center" style="margin-top: 25px;">
        <p class="h5">@{{curr_num}} @{{code_from}} = @{{res}} @{{code_to}}</p>
    </div>
</div>
@endsection
