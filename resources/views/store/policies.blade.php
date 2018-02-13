@extends('store.layouts.main')
@section('content')
<div>
    <div class="page-header">
        <h1>Policies &amp; Procedures</h1>
    </div>
	
		<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Dividend Program</div>
		<div class="faq_answer">

		<p>When you put your trust in Golden Cabinet Herbal Pharmacy, we reward you!</p>

		<p>Anytime you request that we bill your patient directly for granule formulas, Classical Pearls or Blue Dragon patents, you receive 15% of what we collect back to you in the form of a dividend credit.  This credit is calculated quarterly, and is available for you to use on anything in our pharmacy, including custom granule formulas, patents, acupuncture needles, topicals, etc.  Some practitioners use their credits to cover the cost of herbs for patients with financial constraints.</p>

		<p>Please don't hesitate to contact us if you have any questions or concerns regarding the dividend program.  We are happy to talk you through it, as well as tell you about all of the exciting products you can spend your credits on.</p>
	</div>

	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Classical Pearls Shipments</div>
	<div class="faq_answer">

		<p>Requests for shipments that are comprised of only Classical Pearls products must be ordered directly through Classical Pearls, LLC.  You can place your order over the phone by calling (503) 695-2985 or by emailing your order to orders@classicalpearls.org.  You can also place your order online by visiting www.classicalpearls.org. If you do not have an active practitioner or student account with Classical Pearls, simply follow the instructions on their website to set up an account which allows you to purchase products online.</p>
	</div>
	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Student Purchases</div>
	<div class="faq_answer">

		<p>Students of Chinese medicine with an active student ID from an accredited college are able to purchase any Classical Pearls or Blue Dragon patents at the practitioner wholesale rate, for personal use only. Students also qualify for the 10% practitioner discount on all granule formulas, for personal use only. Students may also purchase acupuncture needles at the wholesale rate. </p> 

		<p>*Students who are filling scripts for themselves that have been written by licensed practitioners do not qualify for the 10% discount, as the prescribing practitioner is receiving a dividend for that order. </p>
	</div>
	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Practitioner Payments</div>
	<div class="faq_answer">

		<p>If you request that we bill you directly for any patient granules formulas or patents, please email or call in the prescription along with the patient name and contact phone number.  Once your patient picks the product up, we will charge your credit card on file and email you a copy of the paid invoice.</p>
	</div>
	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Patient Payments</div>
	<div class="faq_answer">

		<p>If you request that we bill your patient directly for any granule formulas or patents, please provide us with the prescription along with patient name and contact phone number.  If you are prescribing a patent please let us know if you would like us to charge your patient the retail rate (which allows for you to collect dividends), or the wholesale rate (waiving your dividend collection).  If you have any questions regarding this, please see our “Dividend Policy”, or call us and we can talk you through it.</p>
	</div>
	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Quality Assurance</div>
	<div class="faq_answer">

		<p>You can rest assured that we take every precaution to ensure that what you ask us to prepare is what ends up in your patient’s hands.  Every granule formula we prepare is carefully documented to record that not only the correct herbs and amounts are being poured, but also that the correct patient and dosage is associated with that formula.  At each stage of processing, we take the time to double check each primary data point and we maintain an electronic data log that provides additional checks and balances while also assuring that each formula is filled with both accuracy and precision. We do all this because we value your trust and we take pride in our ability to exceed your expectations in quality and integrity.</p>

	</div>


	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Returns</div>
	<div class="faq_answer">

		<p>At Golden Cabinet Herbal Pharmacy, we are committed to sourcing the highest quality products and we truly value customer satisfaction.  As a general rule, we do not accept returns on any products unless the product is in some way defective.  In compliance with cGMP standards, we cannot re-sell items that are returned to us.  If you are dissatisfied in any way with a prepared product (not a custom granule prescription), please contact us to discuss the situation, as credits or refunds may be given on a discretionary basis.  Any errors on our part, however, are completely refundable and we will make sure to correct the situation immediately.</p>
		
	</div>
	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Prescriptions</div>
	<div class="faq_answer">
		<p>All herbal granules, acupuncture needles, Classical Pearls, Blue Dragon Herbs and Spring Wind Soft Plasters are available to licensed practitioners and students of accredited Chinese Medicine Colleges only, or by prescription from a licensed practitioner.  All other items are available for the general public to purchase without a prescription.</p>
	</div>
	<div class="faq_answer">
	<div class="faq_question faq_closed" onclick="toggleFAQ(this); return false;">Refills</div>
		<p>All refills on prescription items must be approved by the prescribing practitioner.  Practitioners can give us standing orders for patients or may allow multiple refills if a patient will be using the same formula for a longer period of time.  If a patient does not have available refills, we will attempt to contact the practitioner for authorization.  In order to expedite the process of refills, we encourage practitioners to always give us information about refill authorizations when ordering prescriptions.  Please note, we will not refill a formula that has not been refilled for over a year – a new prescription would be needed.</p>
	</div>
		<br /><br />
		


@push('js')

@endpush
@endsection