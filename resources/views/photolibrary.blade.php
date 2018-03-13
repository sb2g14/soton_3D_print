@extends('layouts.layout')
@section('content')
	<div class="title m-b-md">
        Photo Library
    </div>
	<div class="container gallery-container">
        <p style="text-align:left;">Want to show what you have achieved? Email us a photo of your finished project with a short description (50 words max) and a link to your related publication (optional). Your photos help us to ensure that we can keep this service running for you and future students.<br/>
Make sure that the part you printed in the workshop is visible in the photo.
Please be aware that we can't accept any photos with people visible in them, unless you complete the <a href="intranet.soton.ac.uk/sites/commsandmarketing/Pages/Photography.%20Videos%20and%20Films/photography-permissions.aspx" target="_blank">model release agreement form</a> and send it to us together with the photo.
        </p>
    
	    <div class="tz-gallery">

	        <div class="row">

	           <div class="col-sm-12 col-md-4">
                <a class="lightbox" href="/Images/gallery/gal001_800x600.png">
                    <img src="/Images/gallery/gal001_800x600.png" alt="Quadcopter from 2nd year undergraduate project">
                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal002_800x600.png">
	                    <img src="/Images/gallery/gal002_800x600.png" alt="Propeller">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal003_800x600.png">
	                    <img src="/Images/gallery/gal003_800x600.png" alt="UAV">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-8">
	                <a class="lightbox" href="/Images/gallery/gal004_800x600.png">
	                    <img src="/Images/gallery/gal004_800x600.png" alt="Architecture Structure">
	                </a>
	            </div>
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal005_800x600.png">
	                    <img src="/Images/gallery/gal005_800x600.png" alt="UAV">
	                </a>
	            </div> 
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal006_800x600.png">
	                    <img src="/Images/gallery/gal006_800x600.png" alt="Kielsch Bottle">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
                <a class="lightbox" href="/Images/gallery/gal007_800x600.png">
                    <img src="/Images/gallery/gal007_800x600.png" alt="2nd year undergraduate loudspeaker project">
                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal008_800x600.png">
	                    <img src="/Images/gallery/gal008_800x600.png" alt="2nd year undergraduate loudspeaker project">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal009_800x600.png">
	                    <img src="/Images/gallery/gal009_800x600.png" alt="large structure">
	                </a>
	            </div>
	            <div class="col-sm-12 col-md-8">
	                <a class="lightbox" href="/Images/gallery/gal010_800x600.png">
	                    <img src="/Images/gallery/gal010_800x600.png" alt="Up! Plus 2 printer in action">
	                </a>
	            </div>
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal011_800x600.png">
	                    <img src="/Images/gallery/gal011_800x600.png" alt="Vascular network extracted from a &mu;-CT scan of a human lung tissue sample. See more: <a href='http://dx.doi.org/10.1007/s10278-017-9966-5'>DOI: 10.1007/s10278-017-9966-5</a>">
	                </a>
	            </div> 
	            <div class="col-sm-6 col-md-4">
	                <a class="lightbox" href="/Images/gallery/gal012_800x600.png">
	                    <img src="/Images/gallery/gal012_800x600.png" alt="3D printed paediatric temporal bone model drilled by ENT specialists at Southampton Children's Hospital. See more: <a href='http://eprints.soton.ac.uk/401289'>eprints.soton.ac.uk/401289</a>">
	                </a>
	            </div>

	        </div>
	    </div>
	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery',{
        captions: function(element){
            desc = element.getElementsByTagName('img')[0].alt;
            //desc = desc.replace("","");
            return desc;
        }
    });
</script>
@endsection
