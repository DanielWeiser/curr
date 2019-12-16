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
                        <a class="nav-link" href="/users">Users</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container col-md-5 add_class" style="margin-top: 30px;">
        <table class="table">
            <tbody>
                @foreach ($user_req as $req)
                    <tr v-if="!delete_seen.includes({{$req->curr_id}})">
                        <td><img src="flags/{{$req->flag}}" height="45" style="margin-left:20px;"></td>
                        <td><p class="text-center h5" style="margin-top:10px; margin-bottom: -7px;">{{$req->code}}</p></td>
                        <td><p class="text-center h5" style="margin-top:10px; margin-bottom: -7px;">{{$req->name}}</p></td>
                        <td style="width: 90px;">
                            <button class="btn btn-light btn-md btn-outline-success" v-on:click="del({{$req->user_id}}, {{$req->curr_id}}, '{{$req->email}}', '{{$req->code}}')" style="float:right;">
                                &#10003
                            </button>
                        </td>
                        <td style="width: 70px;">
                            <button class="btn btn-light btn-md btn-outline-danger" v-on:click="del_mail({{$req->user_id}}, {{$req->curr_id}}, '{{$req->email}}', '{{$req->code}}')" style="float:right; margin-right:10px;">
                                &#10005
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
