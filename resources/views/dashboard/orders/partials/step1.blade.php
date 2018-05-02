
        <h2>Patient/Formula</h2>
        <section>
         <h3 style="font-size: 1.8rem;"><i class="fas fa-user-plus"></i> Patient Information</h3>
         <hr />       
        <div class="form-group row">
                <label for="patientLookup" class="col-sm-2 col-form-label">Patient</label>
                <div class="col-sm-10">
                        <select class="form-control" id="patientLookup">
                                <option id="patient_greeting">Please Select a Patient</option>
                                <option id="add_patient">Add a New Patient</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                        </select>
                </div>
        </div>

        <div class="form-group row">
                        <label for="formulaLookup" class="col-sm-2 col-form-label">Formula</label>
                        <div class="col-sm-10">
                                <select class="form-control" id="formulaLookup">
                                        <option id="formula_greeting">Please Select a Formula</option>
                                        <option id="add_formula">Add a New Formula</option>
                                        @foreach($formulas as $formula)
                                        <option value="{{ $formula->id }}">{{ $formula->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                </div>
        <hr />
        <div class="form-group row">
                <label for="formulaLookup" class="col-sm-2 col-form-label">Formula Cost</label>
                <div class="col-sm-10">
                        $<span id="formulaCost">0.00</span>
                </div>
        </div>
        <hr />
        <div class="form-group row">
                <label for="formulaLookup" class="col-sm-2 col-form-label">Discount/Dividend</label>
                <div class="col-sm-10">
                        <select id="chooseDividend" name="dividend" class="form-control">
                                <option>Please Select Dividend or Discount</option>
                                <option id="" value="0.90">Apply 10% Discount (no dividend credit)</option>
                                <option id="" value="0.85">No Discount (15% dividend credit)</option>
                        </select>
                </div>
        </div>
        <hr />
        <div class="form-group row">
                <label for="formulaLookup" class="col-sm-2 col-form-label">Total</label>
                <div class="col-sm-10">
                        $<span id="formulaTotal">0.00</span>
                </div>
        </div> 	
        <hr />
        <span style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle text-danger"></i> If you hit the "Back" button on your browser, the order will be cancelled.</span>
                
        </section>           