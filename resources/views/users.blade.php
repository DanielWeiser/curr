@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item h5">
                    <a class="nav-link" href="/home">Conversion</a>
                </li>
                <li class="nav-item h5">
                    <a class="nav-link" href="/admin">Requests</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="add_class">
    <div class="container col-md-4 float-left" style="margin-left:65px">
        @foreach($users as $user => $user_inf)
            <div class="row border rounded" style="margin-top:15px;">
                <div class="col-md-8 ">
                    <p class="h5" style="margin-top:15px;">{{$user}}</p>
                    <p class="text-muted">{{$user_inf[0]->email}}</p>
                </div>
                <div style="margin-top:22px; margin-left:50px">
                    <button type="button" class="btn  float-right btn-outline-secondary" v-on:click="user_information('{{$user}}', {{$user_inf}}, inf_flag = true)">
                        Edit
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="container col-md-6 float-right" v-if="inf_flag" style="margin-top:15px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><h5>Edit user information</h5></div>
                            <button type="button" class="btn btn-sm float-right btn-light" v-on:click="inf_flag = false" style="margin-right:10px">&#10005</button>
                        </div>
                    </div>
                    <!-- change username and email (not dynamic) -->
                    <!-- <div class="card-body">
                        <p class="h5">Username: @{{username}}</p>
                        <form class="was-validated" action="javascript:void(0);"> 
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-8">
                                    <input v-model="new_username" type="text" class="form-control is-invalid" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col">
                                    <button v-on:click="edit_name({{$user_inf[0]->user_id}})" class="btn btn-light">Edit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <p class="h5">Email: @{{email}}</p>
                        <form class="was-validated" action="javascript:void(0);"> 
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-8">
                                    <input v-model="new_email" type="email" class="form-control is-invalid" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col">
                                    <button v-on:click="edit_email({{$user_inf[0]->user_id}})" class="btn btn-light">Edit</button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                    <div class="row" style="margin-left:4px; margin-right:4px; margin-bottom:15px;">
                        <div class="col-md-6 float-left" v-for="inf in user_inf">
                            <div class="card-body border rounded" style="margin-top:15px;">
                                <div class="row">
                                    <div class="col">
                                        @{{inf.code}}
                                    </div>
                                    <div class="col">
                                        <button v-if = "inf.curr_state" v-on:click="off_curr(inf.user_id, inf.curr_id)" type="button" class="btn btn-sm float-right btn-outline-danger">&#10005</button>
                                        <button v-if = "!inf.curr_state" v-on:click="on_curr(inf.user_id, inf.curr_id)" type="button" class="btn btn-sm float-right btn-outline-success">&#10003</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
