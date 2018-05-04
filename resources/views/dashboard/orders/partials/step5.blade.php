<h2>Review &amp; Submit</h2>
<section>
        <h3 style="font-size: 1.8rem;"><i class="fas fa-clipboard-check"></i> Review &amp; Submit</h3>    
        <hr />        
        <div style="width: 100%">
            <div class="col-md-5 float-left">
                <p><strong>Patient:</strong> <span id="finalPatient"></span></p>
                <p><strong>Dosage:</strong> <span id="finalDosage"></span></p>
                <p><strong>Frequency:</strong> <span id="finalFrequency"></span></p>
                <p><strong>Refills:</strong> <span id="finalRefills"></span></p>
                <p><strong>Special Instructions:</strong><br />
                    <span id="finalSpecialInstructions"></span>
                </p>
                <p><strong>Payment:</strong> <span id="finalPayment"></span></p>
                <p><strong>Shipping:</strong> <span id="finalShipping"></span></p>
                <p><strong>Notes:</strong><br />
                    <span id="finalNotes"></span>
                </p>
                <p><strong>Formula Cost:</strong> <span id="finalFormulaCost"></span></p>
                <p><strong>Discount:</strong> <span id="finalDiscount"></span></p>
                <p><strong>Shipping Cost:</strong> <span id="finalShippingCost"></span></p>
                <p><strong>Total:</strong> <span id="finalTotal"></span></p>
            </div>
            <div class="col-md-7 float-left">
                    <div class="table-responsive">
                    <table class="table w-100">
                        <tr>
                            <th>Pinyin</th>
                            <th>Common Name</th>
                            <th>$/g	Grams</th>
                            <th>Subtotal</th>
                        </tr>
                        <tbody id="ingListFinal"></tbody>
                    </table>
                </div>   
            </div>
        </div>
        <hr style="width: 100%; clear: both">
        <span style="font-size: 0.8rem;"><i class="fas fa-exclamation-triangle text-danger"></i> If you hit the "Back" button on your browser, the order will be cancelled.</span>
        
    </section>

    @push('js')
    <script>
        //<button class="btn btn-success btn-lg" type="submit">Submit Order</button>
    </script>
    @endpush