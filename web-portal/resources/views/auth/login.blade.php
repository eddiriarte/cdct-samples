@extends('layouts.one-column-centered')

@section('content')

    <h1 class="title">Login</h1>

    <div class="card">
        <div class="card-content">
            <div class="content">

                <form method="POST" action="/login">
                    <div class="field">
                        <label for="username" class="label">Username</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="email" placeholder="Username" id="username" name="username" value="{{ $username ?? '' }}">
                            <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link is-light">Cancel</button>
                        </div>
                        <div class="control">
                            <button class="button is-link" type="submit">Submit</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection
