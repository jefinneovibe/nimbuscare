<!DOCTYPE html>
<html lang="en">
    <head>
    <title>View Issuance</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{ URL::asset('widgetStyle/css/bootstrap.min.css')}}"><!-- Bootstrap CSS -->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ URL::asset('widgetStyle/assets/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('widgetStyle/assets/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('widgetStyle/css/bootstrap-select.css')}}" />
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">

        <!-- <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}">Main CSS -->
        <!-- argonTheme CSS -->
        <link type="text/css" href="{{ URL::asset('widgetStyle/assets/css/argon.min.css')}}" rel="stylesheet">
        <!--custom css-->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('widgetStyle/css/style.css?v1')}}">
    </head>
    <body>
        <div class="wrapper">
            <div id="mailview">
                <br><br>
                <div class="mycontainer">
                <div class=mailviewheader>
                    <div class="d-flex justify-content-between bg-white mb-3">
                        <div class="p-2"><h5 class=" blue"><b> {{ @$pipeline_details->workTypeId['name']. " -" }}  ISSUANCE APPROVALS</b></h5></div>

                        <div class="p-2 "><img class="img-responsive" src="{{URL::asset('img/main/interactive_logo.png')}}"></div>
                    </div>
                </div>


            <form name="insurer_form" id="insurer_form" method="post" action="{{url('insurer-decision')}}">
                {{csrf_field()}}
                <div class="dataatable comparesec">
                    <div id="admins">
                        <div class="materialetable">
                            <div  class="tablefixed heightfix commonfix">

                                    <div class="table_left_fix">
                                        <div class="materialetable table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th><div class="mainsquestion"><b class="blue">Questions</b></div></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="syncscroll" name="myElements">
                                                    @if(@$pipeline_details->eSlipData)
                                                        <?php $quest_feildName = []; ?>
                                                        @foreach(@$pipeline_details->eSlipData['review'] as $review)
                                                            @if($review['type'] == 'checkbox')
                                                                <?php  $quest_feildName[] =$review['fieldName'];?>
                                                                <tr class="">
                                                                    <td><div class="mainsquestion"><label class="titles">{{@$review['label']}}</label></div></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach(@$pipeline_details->eSlipData['forms'] as $forms)
                                                            <?php  $quest_feildName[] =$forms['fieldName']; ?>
                                                            <tr class="">
                                                                <td><div class="mainsquestion"><label class="titles">{{@$forms['label']}}</label></div></td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="">
                                                            <th>
                                                                <div class="mainsquestion">
                                                                    <label class="titles">Customer Decision</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="table_right_pen">
                                        <div  id="scrollstyle" class="materialetable table-responsive">
                                            <table class="table comparison">
                                                <thead>
                                                    <tr>
                                                        @if(@$Insurer)
                                                            @foreach(@$Insurer as $key =>$insuer)
                                                                <th>
                                                                    <div class="ans">
                                                                        {{$insuer['insurerDetails']['insurerName']}}
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        @endif
                                                    </tr>

                                                </thead>
                                                <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                                    @if($InsurerData)
                                                    @foreach (@$quest_feildName as $k =>$v)
                                                        <?php
                                                            $key=$v;
                                                            $insurerrr=@$InsurerData[$v];
                                                            $number=0;
                                                            $insurerCount=count($Insurer);
                                                        ?>
                                                        <tr class="">
                                                            @if(count(@$insurerrr)>0)
                                                                @foreach(@$insurerrr as $key1 =>$Insurerr)
                                                                    @if($loop->first && $key1!=$number)
                                                                        @for($i=$number;$i<($key1-$number);$i++)
                                                                            <td><div class="ans">--</div></td>
                                                                        @endfor
                                                                    @elseif(($key1-$number)>1)
                                                                        @for($i=$number;$i<($key1-$number);$i++)
                                                                            <td><div class="ans"></div></td>
                                                                        @endfor
                                                                    @endif
                                                                    <?php $number=$key1; ?>
                                                                    <td class="color{{$key1}}">
                                                                        <div class="ans">
                                                                            @if(@$formData[@$Insurerr['fieldName']]['fieldName'] == $key)
                                                                                @if(@$Insurerr['agreeStatus'] == 'agreed')
                                                                                    Covered
                                                                                @elseif(@$Insurerr['agreeStatus'] == 'disagreed')
                                                                                    Not Covered
                                                                                @else
                                                                                    {{@$Insurerr['agreeStatus']}}
                                                                                @endif
                                                                            @else
                                                                                <span class="removeTr" style="display:none"></span>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                @endforeach
                                                            @else
                                                                @for($i=0;$i<($insurerCount);$i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                        <tr>
                                                            @if(@$Insurer)
                                                                    @foreach(@$Insurer as $key =>$Insurer2)
                                                                    <td><div class="ans">
                                                                    {{@$Insurer2['customerDecision']['decision']}}
                                                                    @if(@$Insurer2['customerDecision']['comment'])
                                                                    <br>Comment:{{@$Insurer2['customerDecision']['comment']}}
                                                                    @endif
                                                                    </div></td>
                                                                @endforeach
                                                            @endif
                                                        </tr>
                                                        @endif

                                                    <input type="hidden" name="workTypeDataId" value="{{$formValues['_id']}}">
                                                    <input type="hidden" id="insurer_decision" name="insurer_decision">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                        <br>
                </div>
                                             <br>
                <div class="row justify-content-end commonbutton">
                    <button type="button" class="btn btn-primary btnload" onclick="approve()">APPROVE</button>
                    <button type="button" class="btn btn-primary btnload"  onclick="reject()">REJECT</button>
                </div>
            </form>

            </div><!--mycontainer ends-->
    </div><!--mailview ends-->
</div><!--wrapper ends--->


    <!-- jQuery -->
    <script  src="{{ URL::asset('widgetStyle/js/main/jquery-2.2.4.min.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <!-- Material kit -->
    <script src="{{ URL::asset('widgetStyle/js/main/bootstrap-material-design.min.js')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/main/material-kit.js?v=2.0.3')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/main/moment.min.js')}}"></script>

    <script src="{{ URL::asset('widgetStyle/js/main/bootstrap-select.js')}}"></script>

    <!-- Navigation -->
    <script src="{{ URL::asset('widgetStyle/js/main/snap.svg-min.js')}}"></script>

    <!-- Modal -->
    <script src="{{ URL::asset('widgetStyle/js/main/modal.js')}}"></script>


    <script>


    function approve()
    {
        $('#insurer_decision').val('approved');
        $('#insurer_form').submit();
    }
    function reject()
    {
        $('#insurer_decision').val('rejected');
        $('#insurer_form').submit();
    }


        // PreLoader
        $('.removeTr').parent().parent().parent().remove();
        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
            });
        });

// -------------------------------------------for table e quotation------------------------------------------------------------
    function resizeHandler() {
            // Treat each container separately
            $(".heightfix").each(function(i, heightfix) {
                // Stores the highest rowheight for all tables in this container, per row
                var aRowHeights = [];
                // Loop through the tables
                $(heightfix).find("table").each(function(indx, table) {
                    // Loop through the rows of current table
                    $(table).find("tr").css("height", "").each(function(i, tr) {
                        // If there is already a row height defined
                        if (aRowHeights[i])
                        // Replace value with height of current row if current row is higher.
                            aRowHeights[i] = Math.max(aRowHeights[i], $(tr).height());
                        else
                        // Else set it to the height of the current row
                            aRowHeights[i] = $(tr).height();
                    });
                });
                // Loop through the tables in this container separately again
                $(heightfix).find("table").each(function(i, table) {
                    // Set the height of each row to the stored greatest height.
                    $(table).find("tr").each(function(i, tr) {
                        $(tr).css("height", aRowHeights[i]);
                    });
                });
            });
        }
        $(document).ready(resizeHandler);
        $(window).resize(resizeHandler);

        $(function(){
            var rows = $('.materialetable tbody tr');

            rows.hover(function(){
                var i = $(this).GetIndex() + 1;
                rows.filter(':nth-child(' + i + ')').addClass('hoverx');
            },function(){
                rows.removeClass('hoverx');
            });
        });

        jQuery.fn.GetIndex = function(){
            return $(this).parent().children().index($(this));
        }
        </script>
        <script src="{{URL::asset('js/syncscroll.js')}}"></script>
        @stack('widgetScripts')

    </body>
</html>
