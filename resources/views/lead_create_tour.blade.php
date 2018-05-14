<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template_tour')
@section('content')

    @if($index_statistic)
        <div id='box-statistic' class='row'>
            @foreach($index_statistic as $stat)
                <div  class="{{ ($stat['width'])?:'col-sm-3' }}">
                    <div class="small-box bg-{{ $stat['color']?:'red' }}">
                        <div class="inner">
                            <h3>{{ $stat['count'] }}</h3>
                            <p>{{ $stat['label'] }}</p>
                        </div>
                        <div class="icon">
                            <i class="{{ $stat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(!is_null($pre_index_html) && !empty($pre_index_html))
        {!! $pre_index_html !!}
    @endif

    @if(g('return_url'))
        <p><a href='{{g("return_url")}}'><i class='fa fa-chevron-circle-{{ trans('crudbooster.left') }}'></i> &nbsp; {{trans('crudbooster.form_back_to_list',['module'=>ucwords(str_replace('_',' ',g('parent_table')))])}}</a></p>
    @endif

    <!-- Your html goes here -->
    <section id='content_section' class="content">

        <!-- Your Page Content Here -->
        <div >
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #337ab7; color: white;"><strong><i class="fa fa-user"></i> Add Leads</strong></div>

                <div class="panel-body" style="padding:20px 0px 0px 0px">
                    <form class='form-horizontal' method='get' id="form" enctype="multipart/form-data" action='{{CRUDBooster::adminpath("account/saved")}}'>


                        <input type="hidden" name="_token" value="na1xb4SVzi3Gw52kbxOoGR4ACBbybUIXN7QLAhAs">
                        <input type='hidden' name='return_url' value='http://127.0.0.1:8000/crm/account?m=50'/>
                        <input type='hidden' name='ref_mainpath' value='http://127.0.0.1:8000/crm/account'/>
                        <input type='hidden' name='ref_parameter' value='return_url=http://127.0.0.1:8000/crm/account?m=50&amp;parent_id=&amp;parent_field='/>
                        <div class="box-body" id="parent-form-area">

                            <link rel='stylesheet' href='http://127.0.0.1:8000/vendor/crudbooster/assets/select2/dist/css/select2.min.css'/>
                            <script src='http://127.0.0.1:8000/vendor/crudbooster/assets/select2/dist/js/select2.full.min.js'></script>
                            <style type="text/css">
                                .select2-container--default .select2-selection--single {border-radius: 0px !important}
                                .select2-container .select2-selection--single {height: 35px}
                                .select2-container--default .select2-selection--multiple .select2-selection__choice {
                                    background-color: #3c8dbc !important;
                                    border-color: #367fa9 !important;
                                    color: #fff !important;
                                }
                                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                                    color: #fff !important;
                                }
                            </style>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrycdDwxd9Yi8s-RAdgQrQiYzZVm0Asrs&libraries=places"
                                    async defer></script>
                            <style>
                                .map {
                                    height: 400px;
                                }
                                .controls {
                                    margin-top: 10px;
                                    border: 1px solid transparent;
                                    border-radius: 2px 0 0 2px;
                                    box-sizing: border-box;
                                    -moz-box-sizing: border-box;
                                    height: 32px;
                                    outline: none;
                                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
                                }

                                .pac-container {
                                    z-index: 9999999 !important;
                                }
                                .pac-input {
                                    background-color: #fff;
                                    font-family: Roboto;
                                    font-size: 15px;
                                    font-weight: 300;
                                    margin-left: 12px;
                                    padding: 0 11px 0 13px;
                                    text-overflow: ellipsis;
                                    width: 300px;
                                }

                                .pac-input:focus {
                                    border-color: #4d90fe;
                                }

                                .pac-container {
                                    font-family: Roboto;
                                }

                                .type-selector {
                                    color: #fff;
                                    background-color: #4d90fe;
                                    padding: 5px 11px 0px 11px;
                                }

                                .type-selector label {
                                    font-family: Roboto;
                                    font-size: 13px;
                                    font-weight: 300;
                                }
                            </style>

                            <div class='form-group header-group-0 ' id='form-group-name' style="">
                                <label class='control-label col-sm-2'>Name <span class='text-danger' title='This field is required'>*</span></label>

                                <div class="col-sm-10">
                                    <input type='text' title="Name" required  placeholder='You can only enter the letter'  maxlength=70 class='form-control' name="name" id="name" value=''/>

                                    <div class="text-danger"></div>
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <div class='form-group header-group-0 ' id='form-group-lastname' style="">
                                <label class='control-label col-sm-2'>Last name <span class='text-danger' title='This field is required'>*</span></label>

                                <div class="col-sm-10">
                                    <input type='text' title="Last name" required  placeholder='You can only enter the letter'  maxlength=70 class='form-control' name="lastname" id="lastname" value=''/>

                                    <div class="text-danger"></div>
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <div class='form-group header-group-0 ' id='form-group-email' style="">
                                <label class='control-label col-sm-2'>Email <span class='text-danger' title='This field is required'>*</span></label>

                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type='email' title="Email" required    maxlength=255 class='form-control' name="email" id="email" value=''/>
                                    </div>
                                    <div class="text-danger"></div>
                                    <p class='help-block'></p>
                                </div>
                            </div>

                            <div class='form-group header-group-0 ' id='form-group-telephone' style="">
                                <label class='control-label col-sm-2'>Phone <span class='text-danger' title='This field is required'>*</span></label>

                                <div class="col-sm-10">
                                    <input type='text' title="Phone" required     class='form-control' name="telephone" id="telephone" value=''/>

                                    <div class="text-danger"></div>
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <div class='form-group header-group-0 ' id='form-group-zip_code' style="">
                                <label class='control-label col-sm-2'>Zip Code </label>

                                <div class="col-sm-10">
                                    <input type='text' title="Zip Code"   placeholder='You can enter letters and numbers'   class='form-control' name="zip_code" id="zip_code" value=''/>

                                    <div class="text-danger"></div>
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <script type="text/javascript">
                                $(function() {
                                    $('#state').select2();
                                })
                            </script>

                            <div class='form-group header-group-0 ' id='form-group-state' style="">
                                <label class='control-label col-sm-2'>State </label>

                                <div class="col-sm-10">
                                    <select style='width:100%' class='form-control' id="state" name="state"  >

                                        <option value=''>** Please select a State</option>
                                        <option  value='3'>ALABAMA</option><option  value='4'>ALASKA</option><option  value='5'>ARIZONA</option><option  value='6'>ARKANSAS</option><option  value='7'>CALIFORNIA</option><option  value='10'>COLORADO</option><option  value='11'>CONNECTICUT</option><option  value='14'>DELAWARE</option><option  value='15'>FLORIDA</option><option  value='16'>GEORGIA</option><option  value='17'>HAWAI</option><option  value='18'>IDAHO</option><option  value='19'>ILLINOIS</option><option  value='20'>INDIANA</option><option  value='21'>IOWA</option><option  value='22'>KANSAS</option><option  value='23'>KENTUCKY</option><option  value='24'>LOUISIANA</option><option  value='1'>Lousiana</option><option  value='25'>MAINE</option><option  value='26'>MARYLAND</option><option  value='27'>MASSACHUSETTS</option><option  value='28'>MICHIGAN</option><option  value='29'>MINNESOTA</option><option  value='30'>MISSISSIPPI</option><option  value='2'>Missouri</option><option  value='31'>MISSOURI</option><option  value='32'>MONTANA</option><option  value='33'>NEBRASKA</option><option  value='34'>NEVADA</option><option  value='37'>NEW HAMPSHIRE</option><option  value='35'>NEW JERSEY</option><option  value='38'>NEW MEXICO</option><option  value='36'>NEW YORK</option><option selected value='0'>No Aplica</option><option  value='8'>NORTH CAROLINA</option><option  value='12'>NORTH DAKOTA</option><option  value='39'>OHIO</option><option  value='40'>OKLAHOMA</option><option  value='41'>OREGON</option><option  value='42'>PENNSYLVANIA</option><option  value='43'>RHODE ISLAND</option><option  value='9'>SOUTH CAROLINA</option><option  value='13'>SOUTH DAKOTA</option><option  value='44'>TENNESSEE</option><option  value='45'>TEXAS</option><option  value='53'>TEXAS (tax no apply)</option><option  value='46'>UTAH</option><option  value='47'>VERMONT</option><option  value='48'>VIRGINIA</option><option  value='50'>WASHINGTON</option><option  value='49'>WEST VIRGINIA</option><option  value='51'>WISCONSIN</option><option  value='52'>WYOMING</option>						<!--end-datatable-ajax-->
                                        <!--end-relationship-table-->
                                        <!--end-datatable-->
                                    </select>

                                    <div class="text-danger">

                                    </div><!--end-text-danger-->
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <div class='form-group header-group-0 ' id='form-group-city' style="">
                                <label class='control-label col-sm-2'>City </label>

                                <div class="col-sm-10">
                                    <input type='text' title="City" maxlength=200 class='form-control' name="city" id="city" value=''/>

                                    <div class="text-danger"></div>
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <div class='form-group peta header-group-0 '>
                                <label class='control-label col-sm-2'>Address </label>

                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="address"   value="" name="address">
                                        <input type="hidden" name="input-latitude-address" id="input-latitude-address" value="">
                                        <input type="hidden" name="input-longitude-address" id="input-longitude-address" value="">
                                        <span class="input-group-btn">
						        <button class="btn btn-primary" onclick="showMapModaladdress()" type="button"><i class='fa fa-map-marker'></i> Browse Map</button>
						      </span>
                                    </div><!-- /input-group -->


                                    <div id='googlemaps-modal-address' class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title"><i class='fa fa-search'></i> Browse Map</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <input id="input-search-autocomplete-address" class="controls pac-input" autofocus type="text"
                                                           placeholder="Search location here...">
                                                    <div id="type-selector-address" class="controls hide type-selector">
                                                        <input type="radio" name="type" id="changetype-all" checked="checked">
                                                        <label for="changetype-all">All</label>

                                                        <input type="radio" name="type" id="changetype-establishment">
                                                        <label for="changetype-establishment">Establishments</label>

                                                        <input type="radio" name="type" id="changetype-address">
                                                        <label for="changetype-address">Addresses</label>

                                                        <input type="radio" name="type" id="changetype-geocode">
                                                        <label for="changetype-geocode">Geocodes</label>
                                                    </div>
                                                    <div class="map" id='map-address'></div>
                                                    <br/>
                                                    <p>
                                                        <span class="text-info" style="font-weight: bold">Current Location :</span><br/>
                                                        <span id='current-location-span-address'>-</span>
                                                    </p>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" onclick="setItaddress()" data-dismiss="modal">Set It</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->




                                </div>
                            </div>
                            <script type="text/javascript">


                                var address_temp_address,latitude_temp_address,longitude_temp_address;

                                function setItaddress() {
                                    console.log(address_temp_address);
                                    $('#address').val(address_temp_address);
                                    $("#input-latitude-address").val(latitude_temp_address);
                                    $("#input-longitude-address").val(longitude_temp_address);
                                }

                                var is_init_map_address = false;
                                function showMapModaladdress() {
                                    var api_key = "AIzaSyCrycdDwxd9Yi8s-RAdgQrQiYzZVm0Asrs";

                                    if(api_key == '') {
                                        alert('GOOGLE_API_KEY is missing, please set at setting !');
                                        return false;
                                    }

                                    $('#googlemaps-modal-address').modal('show');
                                }

                                $('#googlemaps-modal-address').on('shown.bs.modal', function(){
                                    if(is_init_map_address == false) {
                                        console.log('Init Map address');
                                        initMap7();
                                        is_init_map_address = true;
                                    }
                                });

                                var geocoder;

                                function initMap7() {
                                    geocoder = new google.maps.Geocoder();
                                    var map = new google.maps.Map(document.getElementById('map-address'), {
                                        zoom: 12
                                    });

                                    var marker_default_location = new google.maps.Marker({
                                        map: map,
                                        draggable:true,
                                    });

                                    var input = /** @type    {!HTMLInputElement} */(
                                        document.getElementById('input-search-autocomplete-address'));

                                    var types = document.getElementById('type-selector-address');
                                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

                                    var autocomplete = new google.maps.places.Autocomplete(input);
                                    autocomplete.bindTo('bounds', map);

                                    var infoWindow = new google.maps.InfoWindow();

                                    // Try HTML5 geolocation.


                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition(function(position) {

                                            latitude_temp_address = position.coords.latitude;
                                            longitude_temp_address = position.coords.longitude;

                                            var pos = {
                                                lat: position.coords.latitude,
                                                lng: position.coords.longitude
                                            };

                                            geocoder.geocode({
                                                latLng: pos
                                            }, function(responses) {
                                                if (responses && responses.length > 0) {
                                                    address = responses[0].formatted_address;
                                                } else {
                                                    address = 'Cannot determine address at this location.';
                                                }

                                                $('#current-location-span-address').text(address);

                                                map.setCenter(pos);

                                                marker_default_location.setPosition(pos);

                                                address_temp_address = address;

                                                infoWindow.close();
                                                infoWindow.setContent(address);
                                                infoWindow.open(map, marker_default_location);
                                            });

                                        }, function() {
                                            console.log('GPS not found !');
                                        });
                                    } else {
                                        console.log('GPS not found !');
                                    }


                                    google.maps.event.addListener(marker_default_location, 'dragend', function(marker_default_location){

                                        geocoder.geocode({
                                            latLng: marker_default_location.latLng
                                        }, function(responses) {
                                            if (responses && responses.length > 0) {
                                                address = responses[0].formatted_address;
                                            } else {
                                                address = 'Cannot determine address at this location.';
                                            }

                                            address_temp_address = address;

                                            infoWindow.setContent(address);

                                            $('#current-location-span-address').text(address);

                                        });

                                        var latLng = marker_default_location.latLng;
                                        latitude = latLng.lat();
                                        longitude = latLng.lng();

                                        latitude_temp_address = latitude;
                                        longitude_temp_address = longitude;

                                    });

                                    autocomplete.addListener('place_changed', function() {
                                        infoWindow.close();
                                        marker_default_location.setVisible(false);

                                        var place = autocomplete.getPlace();

                                        if (!place.geometry) {
                                            window.alert("Autocomplete's returned place contains no geometry");
                                            return;
                                        }

                                        if (place.geometry.viewport) {
                                            map.fitBounds(place.geometry.viewport);
                                        } else {
                                            map.setCenter(place.geometry.location);
                                            map.setZoom(17);
                                        }

                                        marker_default_location.setPosition(place.geometry.location);
                                        marker_default_location.setVisible(true);

                                        var address = '';
                                        if (place.address_components) {
                                            address = [
                                                (place.address_components[0] && place.address_components[0].short_name || ''),
                                                (place.address_components[1] && place.address_components[1].short_name || ''),
                                                (place.address_components[2] && place.address_components[2].short_name || '')
                                            ].join(' ');
                                        }

                                        var latitude = place.geometry.location.lat();
                                        var longitude = place.geometry.location.lng();

                                        address_temp_address = address;

                                        $('#current-location-span-address').text(address);

                                        infoWindow.setContent(address);

                                        latitude_temp_address = latitude;
                                        longitude_temp_address = longitude;

                                        infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                                        infoWindow.open(map, marker_default_location);
                                    });

                                    function setupClickListener(id, types) {
                                        var radioButton = document.getElementById(id);
                                        radioButton.addEventListener('click', function() {
                                            autocomplete.setTypes(types);
                                        });
                                    }

                                    setupClickListener('changetype-all', []);
                                    setupClickListener('changetype-address', ['address']);
                                    setupClickListener('changetype-establishment', ['establishment']);
                                    setupClickListener('changetype-geocode', ['geocode']);
                                }

                            </script>		        					    								<div class='form-group header-group-0 ' id='form-group-photo' style="">
                                <label class='col-sm-2 control-label'>Photo </label>

                                <div class="col-sm-10">

                                    <input type='file' id="photo" title="Photo"    class='form-control' name="photo"/>
                                    <p class='help-block'></p>
                                    <div class="text-danger"></div>

                                </div>

                            </div>
                            <script type="text/javascript">
                                $(function() {
                                    $('#estado').select2();
                                })
                            </script>

                            <div class='form-group header-group-0 ' id='form-group-estado' style="">
                                <label class='control-label col-sm-2'>Type <span class='text-danger' title='This field is required'>*</span></label>

                                <div class="col-sm-10">
                                    <select style='width:100%' class='form-control' id="estado" required    name="estado"  >

                                        <option value=''>** Please select a Type</option>
                                        <option  value='1'>Favorite</option><option  value='2'>Junks</option><option  value='3'>Lost</option><option selected value='0'>Normal</option>						<!--end-datatable-ajax-->


                                        <!--end-relationship-table-->


                                        <!--end-datatable-->
                                    </select>
                                    <div class="text-danger">

                                    </div><!--end-text-danger-->
                                    <p class='help-block'></p>

                                </div>
                            </div>

                            <script type="text/javascript">
                                $(function() {
                                    $('#id_usuario').select2();
                                })
                            </script>

                            <div class='form-group header-group-0 ' id='form-group-id_usuario' style="">
                                <label class='control-label col-sm-2'>Assign to <span class='text-danger' title='This field is required'>*</span></label>

                                <div class="col-sm-10">
                                    <select style='width:100%' class='form-control' id="id_usuario" required    name="id_usuario"  >

                                        <option value=''>** Please select a Assign to</option>
                                        <option  value='4'>Blase</option><option  value='2'>cbenitez</option><option  value='7'>jenny</option><option  value='15'>Julio</option><option  value='12'>maite</option><option  value='9'>Marco</option><option  value='3'>mnovo</option><option  value='1'>Super Admin</option><option  value='11'>Thomas</option><option  value='16'>Umair</option>						<!--end-datatable-ajax-->


                                        <!--end-relationship-table-->


                                        <!--end-datatable-->
                                    </select>
                                    <div class="text-danger">

                                    </div><!--end-text-danger-->
                                    <p class='help-block'></p>

                                </div>
                            </div>								<input type='hidden' name="latitude" value=''/>								<input type='hidden' name="longitude" value=''/>
                        </div><!-- /.box-body -->

                        <div class="box-footer" style="background: #F5F5F5">

                            <div class="form-group">
                                <label class="control-label col-sm-2"></label>
                                <div class="col-sm-10">

                                    <a href='{{CRUDBooster::adminpath("tour/general")}}' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> Back</a>


                                    <input type="submit" name="submit" value='Save' class='btn btn-success'>

                                </div>
                            </div>



                        </div><!-- /.box-footer-->

                    </form>

                </div>
            </div>
        </div><!--END AUTO MARGIN-->

    </section><!-- /.content -->

@endsection