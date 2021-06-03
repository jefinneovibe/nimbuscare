@if (@$config)
    <div class="col-12 top_space row" id="{{@$config['id']}}">
    @if (@$config['label'])
      <div style="margin-bottom: 10px;" class="col-12">
        <h6 class="titles">{{@$config['label']}}</h6>
      </div>
    @endif
        @foreach ($config['columns'] as $column)
            @widget($column['widgetType'], ['data' => $column, 'value' => @$values[$column['id']]])
        @endforeach
        <div class="col-4">
            <div id="poipo" class="row">
                <div class="col-4">
                    <label class="titles bmd-label-static">Total</label>
                </div>
                <div class="col-8">
                    <div class="form-group bmd-form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">AED</span>
                            </div>
                            <input readonly onchange="calculateTotal('{{@$config['id']}}')"
                            @if (isset($values['tableWithTotal']) && $values['tableWithTotal'] != '')
                                value="{{@$values['tableWithTotal']}}"
                            @else
                                value="0"
                            @endif
                            type="text" class="form-control aed" name="{{$config['fieldName']}}[tableWithTotal]" id="{{@$config['id']}}TableWithTotal"  placeholder="Total">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('widgetScripts')
        <script>
            $(document).on('keyup','.tableTotalVal',function(){
                var parentId = $(this).offsetParent().offsetParent().offsetParent().parent().attr('id');
                calculateTotal(parentId);
            });
            function calculateTotal(getParentId){
                var total=0;
                $( '#'+getParentId ).find('.tableTotalVal').each(function( index ) {
                    thisNum = $(this).val().replace(/,/g, "");
                    total+=Number(thisNum);
                });
                $('#'+getParentId+'TableWithTotal').val(String(total).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
        </script>
    @endpush
@endif
