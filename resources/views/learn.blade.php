@extends('layouts.layout')
@section('content')

    <div class="title m-b-md">
        Learn to 3D print
    </div>
    <div class="container well text-left">
        <div>
            <p>
                Since 2016-17 a 30 minute Introduction to 3D Printing with the FEE 3D Printing Service have been offered as part of UG and MSc Student Workshop Introductions (for UGs in Part I Induction Week, for MSc project students in Mar/Apr). Additional 2 hour hands-on sessions have been offered in June.
                Since the 3D Printing Service started, UG students, PGRs and other members of FEE wishing to use the UP! 3D Printers have always been able to request advice from the 3D Printing Service Demonstrators during the Open Access sessions.
            </p>
            <p>
                To supplement these face-to-face options, and provide a more complete explanation/reminder of how to set-up and use the UP! 3D Printers, the following video clips were assembled as a draft training video please go to the <a href="https://www.youtube.com/watch?v=j8jcmwBK-bE&feature=player_embedded"> Watch this video </a> on YouTube link. ( A further version with higher resolution video will be prepared.)<br>
            </p>
            <p>
                Printer manuals are available to download from here
                <ul class="list-group">
                    <li class="list-group-item"><a href={{ asset('files/UP_Manual.pdf') }}>UP Manual</a></li>
                    <li class="list-group-item"><a href={{ asset('files/UPBOX_Manual.pdf') }}>UP BOX Manual</a></li>
                </ul>
            </p>
            <p>
                Any queries meanwhile, please contact the Workshop Coordinator
                @foreach($coordinators as $coordinator)
                    <a href="mailto:{{$coordinator->email}}">{{$coordinator->first_name}} {{$coordinator->last_name}}</a>
                @endforeach
            </p>
        </div>
    </div>
@endsection
