@extends('layouts.layout')
@section('content')
	<div class="title m-b-md">
        Photo Library
    </div>
	<div class="container gallery-container">
    
	    <div class="tz-gallery">

	        <div class="row">

	           <div class="col-sm-12 col-md-4">
                <a class="lightbox" href="/Images/gallery/gal001_800x600.png">
                    <img src="/Images/gallery/gal001_800x600.png" alt="Bridge">
                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal002_800x600.png">
	                    <img src="/Images/gallery/gal002_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal003_800x600.png">
	                    <img src="/Images/gallery/gal003_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-8">
	                <a class="lightbox" href="/Images/gallery/gal004_800x600.png">
	                    <img src="/Images/gallery/gal004_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal005_800x600.png">
	                    <img src="/Images/gallery/gal005_800x600.png" alt="Bridge">
	                </a>
	            </div> 
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal006_800x600.png">
	                    <img src="/Images/gallery/gal006_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
                <a class="lightbox" href="/Images/gallery/gal007_800x600.png">
                    <img src="/Images/gallery/gal007_800x600.png" alt="Bridge">
                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal008_800x600.png">
	                    <img src="/Images/gallery/gal008_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal009_800x600.png">
	                    <img src="/Images/gallery/gal009_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-8">
	                <a class="lightbox" href="/Images/gallery/gal010_800x600.png">
	                    <img src="/Images/gallery/gal010_800x600.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal011_800x600.png">
	                    <img src="/Images/gallery/gal011_800x600.png" alt="Bridge">
	                </a>
	            </div> 
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal012_800x600.png">
	                    <img src="/Images/gallery/gal012_800x600.png" alt="Bridge">
	                </a>
	            </div>

	        </div>
	    </div>
	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>
@endsection
