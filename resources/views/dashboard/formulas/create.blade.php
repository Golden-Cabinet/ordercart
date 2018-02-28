@extends('dashboard.layouts.main')
@section('content')
<h4>Create A New Formula</h4>
<hr />


        <button id="addRow" class="btn btn-info">Add Ingredient</button>
        <div class="table-responsive">
    <table id="newFormulasTable" class="ca-dt-bootstrap table" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col">Pinyin</th>
                    <th scope="col">Grams</th>
                    <th scope="col">$/gram</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tfoot>
                
            </tfoot>
        </table>

    </div>


@push('js')
<script>
        $(document).ready(function() {
            
        var table =  $('#newFormulasTable').DataTable( { 
                "bLengthChange": false,
                data: null,                
                "bInfo" : false,
                "paging": false,
                "ordering": false,
                "searching": false
            } );


            var counter = 1;

            $('#newFormulasTable').on("click", "button", function(){
                console.log($(this).parent());
                table.row($(this).parents('tr')).remove().draw(false);
              });
         
            $('#addRow').on( 'click', function () {
                table.row.add( [
                    '<input type="text" id="pinyinlist" name="pinyin_'+counter+'" class="form-control">',
                    '<input type="text" name="pinyin_'+counter+'" class="form-control">',
                    '<input type="text" name="pinyin_'+counter+'" class="form-control">',
                    '<input type="text" name="pinyin_'+counter+'" class="form-control">',                    
                    '<button id="removeRow" class="btn btn-secondary btn-small rowDelete" data-rowid="'+counter+'">Remove</button>',
                ] ).draw( false );
         
                counter++;              

            } );
         
            // Automatically add a first row of data
            $('#addRow').click();

            // show json obj on click of pinyin field
            var dataSet = [
                @foreach($ingredients as $ingredient) 
                ['{{ $ingredient["pinyin"] }}','{{ $ingredient["concentration"] }}','{{ $ingredient["brand"] }}'],
                @endforeach                
            ]; 
            
            

            //$( "#pinyinlist" ).autocomplete({
            //    source: dataSet
            //  });
            

        } );
        
</script>    
@endpush
@endsection