@extends('store.layouts.main')
@section('content')

<div class="col-md-12 w-100" >
    <h1 class="text-center mb-4">Frequently Asked Questions</h1>
    <div id="accordion" style="margin-bottom: 4rem;">
        <div class="card mb-2">
          <div class="card-header" id="headingOne">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Are the herbs used in my formula free of pesticides and other chemicals? 
              </button>
            </h5>
          </div>
      
          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                All of the herbs we source undergo advanced microbiology testing to confirm the absence of microorganisms and pesticide residues, as well as advanced heavy metal testing. These tests are conducted on both the raw material as well as the finished product, and are verified by secondary independent labs. If you would like to read more in-depth information regarding our main herbal suppler please visit their website at <a href="https://legendaryherbs.com/granules/" target="_blank">https://legendaryherbs.com/granules/</a> 
            </div>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                What do I do if I’ve lost my spoon? 
              </button>
            </h5>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                A dosage spoon will be included with each formula. If you lose your spoon you can always use a standard baking tsp to control your dosage. 1 level tsp = approx. 3g of granules. 
            </div>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                How do I prepare my formula? 
              </button>
            </h5>
          </div>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
              Shake your bottle of herbs thoroughly before each use. Add the prescribed number of level scoops to non-aluminum cup or glass. Bring water to a boil and pour the water over the herbs enough to fully dissolve your granules. Wait 30- 60 seconds; then stir vigorously to help them fully dissolve. If you want to drink your formula immediately, add cool water to the fully dissolved tea to bring it to a desired temperature. 
            </div>
          </div>
        </div>

        <div class="card mb-2">
            <div class="card-header" id="headingFour">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    What if I don’t like the taste of my formula? 
                </button>
              </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
              <div class="card-body">
                If the flavor of your formula is truly intolerable, you have some options. The best option is to simply use less water and quickly drink your formula, followed by something that tastes better as a “chaser”. Alternatively, you can skip the decoction and just mix the dry granules into applesauce or a similar food. If this is still too much to tolerate, you can always put your formula into empty gel-caps. **Please ask your practitioner before adding any sweetener to your formula! All sweeteners have their own energetic properties and may or may not complement what your formula is doing. 
              </div>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header" id="headingFive">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    How do I order a refill of my formula? 
                </button>
              </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
              <div class="card-body">
                The number of refills your practitioner specified is listed on the back of the bottle that contains your formula. If you have refills available, give us a call (503-233-4102) or send us an email (orders@goldencabinetherbs.com). Please provide us with your name and the formula ID number listed on your bottle, and we will take care of the rest. 
              </div>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header" id="headingSix">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    What do I do if my bottle says zero refills available? 
                </button>
              </h5>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
              <div class="card-body">
                If you don’t show any available refills on your bottle, contact your practitioner to let them know. They will be able to request additional refills from us. If you prefer, you can also give us a call and we will contact your practitioner on your behalf.  
              </div>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header" id="headingSeven">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    Should I take my herbs with or without food? 
                </button>
              </h5>
            </div>
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
              <div class="card-body">
                Generally speaking, it is best to enjoy your formula at least one hour before or after a meal. If the dosage on your bottle does not specify whether to take your formula with or without food, check in with your practitioner. They will have the best answer for you and your situation.  
              </div>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header" id="headingEight">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                    Why is my formula ID number different this time? 
                </button>
              </h5>
            </div>
            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
              <div class="card-body">
                Each and every formula has an individual and unique formula ID number, even if it is an exact duplicate of a previous formula. This system allows for us to track and control inventory, as well as locate your prescription quickly and confidently when you request a refill. 
              </div>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header" id="headingNine">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseThree">
                    Can you ship my herbs to me?  
                </button>
              </h5>
            </div>
            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
              <div class="card-body">
                Yes! We would be happy to ship your herbs to you and save you a trip to our pharmacy. Most formulas can be shipped anywhere in the U.S. for just $3.75. Simply call us with the address you would like us to ship to and we’ll take care of the rest. 
              </div>
            </div>
          </div>

      </div>
    </div>
		

@push('js')

@endpush
@endsection