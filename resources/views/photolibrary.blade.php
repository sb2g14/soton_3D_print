@extends('layouts.layout')
@section('content')
	<div class="title m-b-md">
        Photo Library
    </div>
	<div class="container gallery-container">
    
	    <div class="tz-gallery">

	        <div class="row">

	           <div class="col-sm-12 col-md-4">
                <a class="lightbox" href="/Images/gallery/IMG_0451.png">
                    <img src="/Images/gallery/IMG_0451.png" alt="Bridge">
                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/IMG_0451.png">
	                    <img src="/Images/gallery/IMG_0451.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/IMG_0451.png">
	                    <img src="/Images/gallery/IMG_0451.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-8">
	                <a class="lightbox" href="/Images/gallery/IMG_0451.png">
	                    <img src="/Images/gallery/IMG_0451.png" alt="Bridge">
	                </a>
	            </div>
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/IMG_0451.png">
	                    <img src="/Images/gallery/IMG_0451.png" alt="Bridge">
	                </a>
	            </div> 
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/IMG_0451.png">
	                    <img src="/Images/gallery/IMG_0451.png" alt="Bridge">
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
