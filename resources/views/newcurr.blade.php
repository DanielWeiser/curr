@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item h5">
                    <a class="nav-link" href="/home">Conversion</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="container col-md-5 add_class" style="margin-top: 30px;">
    <table class="table">
        <tbody>
            @foreach ($currency as $curr)
                <tr v-if="!add_seen.includes({{$curr->id}})">
                    <td><img src="flags/{{$curr->flag}}" height="45" style="margin-left:20px;"></td>
                    <td><p class="text-center h5" style="margin-top:10px; margin-bottom: -7px;">{{$curr->curr_name}}</p></td>
                    <td><button class="btn btn-light btn-md" v-on:click="add({{$curr->id}})" style="float:right; margin-right:10px;">Add</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection