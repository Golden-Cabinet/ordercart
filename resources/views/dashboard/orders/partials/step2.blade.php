<h2>Dosage</h2>
<section>
    <h3 style="font-size: 1.8rem;"><i class="fas fa-prescription-bottle-alt"></i> Dosage</h3>
    <hr />
    
    <div class="form-group row">
            <label for="dosageQuantity" class="col-sm-2 col-form-label">Dosage Quantity</label>
            <div class="col-sm-10">
                    <select id="dosageQuantity" name="dosage_quantity" class="form-control">
                            <option>Please Select The Dosage Quantity</option>
                            <option value='As Directed (1 level scoop is 1.5g)'>As Directed (1 level scoop is 1.5g)</option>
                            <option value='1 level scoop (1.5g)'>1 level scoop (1.5g)</option>
                            <option value='1 slightly rounded scoop (2g)'>1 slightly rounded scoop (2g)</option>
                            <option value='1 heaping scoop (2.5g)'>1 heaping scoop (2.5g)</option>
                            <option value='2 level scoops (3g)'>2 level scoops (3g)</option>
                            <option value='2 slightly rounded scoops (4g)'>2 slightly rounded scoops (4g)</option>
                            <option value='3 level scoops (4.5g)'>3 level scoops (4.5g)</option>
                            <option value='2 heaping scoops (5g)'>2 heaping scoops (5g)</option>
                            <option value='4 level scoops (6g)'>4 level scoops (6g)</option>
                            <option value='5 level scoops (7.5g)'>5 level scoops (7.5g)</option>
                            <option value='4 slightly rounded scoops (8g)'>4 slightly rounded scoops (8g)</option>
                            <option value='6 level scoops (9g)'>6 level scoops (9g)</option>
                            <option value='4 heaping scoops (10g)'>4 heaping scoops (10g)</option>
                            <option value='Other – add dosage in “Special Instructions” below'>Other – add dosage in “Special Instructions” below</option>
                    </select>
            </div>
    </div>

    <div class="form-group row">
            <label for="timesDay" class="col-sm-2 col-form-label">Number Of Times/Day</label>
            <div class="col-sm-10">
                    <select id="timesDay" name="times_day" class="form-control">
                            <option>Please Select The Number of Times Per Day</option>
                            <option value='Once per day'>Once per day</option>
                            <option value='Two times per day'>Two times per day</option>
                            <option value='Three times per day'>Three times per day</option>
                            <option value='Four times per day'>Four times per day</option>
                            <option value='Five times per day'>Five times per day</option>
                            <option value='As Needed'>As Needed</option>
                            <option value='Other – add details in "Special Instructions" below'>Other – add details in “Special Instructions” below</option>
                    </select>
            </div>
    </div>

    <div class="form-group row">
            <label for="refillsAllowed" class="col-sm-2 col-form-label">Number of refills allowed</label>
            <div class="col-sm-10">
                    <select id="refillsAllowed" name="refills_amount" class="form-control">
                            <option>Please Select Dividend or Discount</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="unlimited">Unlimited</option>
                            <option value='Other – add details in "Special Instructions" below'>Other – add details in “Special Instructions” below</option>                
                    </select>
            </div>
    </div>

    <div class="form-group row">
            <label for="specialInstructions" class="col-sm-2 col-form-label">Special Dosage &amp; Refill Instructions</label>
            <div class="col-sm-10">
                    <textarea name="special_instructions" id="specialInstructions" class="form-control"></textarea>
            </div>
    </div>
    <span style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle text-danger"></i> If you hit the "Back" button on your browser, the order will be cancelled.</span>
</section>