@extends('layouts.charts')
@php
/**Workshop Busy Periods**/
use App\ChartsHelper;
$chrt = new ChartsHelper();
$thechart = $chrt->createChartWorkshopUsage($template);
@endphp

@section('chart')
    {!! $thechart->title('Average number of simultaneous prints')
            ->dimensions(0,$height)
            ->render() !!}
@endsection
