@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Add New Question
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 text-left well">
            
                <form method="post" action="/faq/create">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <label for="question">Question: </label> <br>
                    <input type="text" name="question" class="form-control" id="message" value="{{old('question')}}" />
                    <td><span class="" id="number_error"></span> </td> <br>
                    <label for="answer">Answer: </label> <br>
                    <input type="text" name="answer" class="form-control" id="message" value="{{old('answer')}}"/>
                    <td><span class="" id="serial_error"></span> </td> <br>
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg btn-success">Add</button>
                    <a href="/faq" class="btn btn-lg btn-primary">View FAQ</a>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

