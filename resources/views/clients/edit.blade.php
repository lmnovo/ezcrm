@extends('crudbooster::admin_template')
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
        <div class='panel panel-default'>
        <div class='panel-heading' style="background-color: #f5f5f5; color: black;">
            <strong><i class="fa fa-user-plus"></i> {{trans('crudbooster.Edit_Clients')}} </strong>
        </div>
        <div class='panel-body'>


            <?php
            $action = CRUDBooster::mainpath("editsaveclient");
            $return_url = ($return_url)?:g('return_url');
            ?>

            <form class='form-horizontal' id="form" enctype="multipart/form-data" action='<?php echo e($action); ?>'>

                <input type="hidden" name="lead_id" id="lead_id" value="{{ $id }}">

                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <br>
                    <label class="control-label col-sm-2">Name <span class="text-danger" title="This field is required">*</span></label>

                    <div class="col-sm-10">
                        <input type="text" title="Name" required="" placeholder="You can only enter the letter" maxlength="70" class="form-control" name="name" id="name" value="{{ $lead->name }}" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-lastname" style="">
                    <label class="control-label col-sm-2">Last Name <span class="text-danger" title="This field is required">*</span></label>

                    <div class="col-sm-10">
                        <input type="text" title="Last Name" required="" placeholder="You can only enter the letter" maxlength="70" class="form-control" name="lastname" id="lastname" value="{{ $lead->lastname }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-email" style="">
                    <label class="control-label col-sm-2">Email <span class="text-danger" title="This field is required">*</span></label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" title="Email" required="" maxlength="255" class="form-control" name="email" id="email" value="{{ $lead->email }}">
                        </div>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-telephone" style="">
                    <label class="control-label col-sm-2">Telephone <span class="text-danger" title="This field is required">*</span></label>

                    <div class="col-sm-10">
                        <input type="text" title="Telephone" required="" class="form-control" name="telephone" id="telephone" value="{{ $lead->telephone }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-zip_code" style="">
                    <label class="control-label col-sm-2">ZipCode </label>

                    <div class="col-sm-10">
                        <input type="text" title="ZipCode" placeholder="You can enter letters and numbers" class="form-control" name="zip_code" id="zip_code" value="{{ $lead->zip_code }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-state" style="">
                    <label class="control-label col-sm-2">State </label>

                    <div class="col-sm-10">
                        <select class="form-control" id="state" placeholder="Select" name="state" required>
                            <option >***Select Data***</option>
                            @foreach($states as $state)
                                @if($state->abbreviation == $lead->state)
                                    <option selected="true" value="{{ $state->abbreviation }}" id="{{ $state->id }}">{{ $state->name }}</option>;
                                @else
                                    <option value="{{ $state->abbreviation }}" id="{{ $state->id }}">{{ $state->name }}</option>;
                                @endif
                            @endforeach
                        </select>
                        <div class="text-danger">

                        </div><!--end-text-danger-->
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-city" style="">
                    <label class="control-label col-sm-2">City </label>

                    <div class="col-sm-10">
                        <input type="text" title="City" maxlength="200" class="form-control" name="city" id="city" value="{{ $lead->city }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group peta header-group-0 ">
                    <label class="control-label col-sm-2">Address </label>

                    <div class="col-sm-10">


                        <div class="input-group">
                            <input type="text" class="form-control" id="address" value="" name="address">
                            <input type="hidden" name="input-latitude-address" id="input-latitude-address" value="">
                            <input type="hidden" name="input-longitude-address" id="input-longitude-address" value="">
                            <span class="input-group-btn">
						        <button class="btn btn-primary" onclick="showMapModaladdress()" type="button"><i class="fa fa-map-marker"></i> Browse Map</button>
						      </span>
                        </div><!-- /input-group -->


                        <div id="googlemaps-modal-address" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title"><i class="fa fa-search"></i> Browse Map</h4>
                                    </div>
                                    <div class="modal-body">

                                        <input id="input-search-autocomplete-address" class="controls pac-input" autofocus="" type="text" placeholder="Search location here...">
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
                                        <div class="map" id="map-address"></div>
                                        <br>
                                        <p>
                                            <span class="text-info" style="font-weight: bold">Current Location :</span><br>
                                            <span id="current-location-span-address">-</span>
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
                            center: {lat: 0.000000, lng: 0.000000 },
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

                </script>

                <div class="form-group header-group-0 " id="form-group-photo" style="">
                    <label class="col-sm-2 control-label">Photo </label>

                    <div class="col-sm-10">

                        <input type="file" id="photo" title="Photo" class="form-control" name="photo">
                        <p class="help-block"></p>
                        <div class="text-danger"></div>

                    </div>

                </div>

                <div class="form-group header-group-0 " id="form-group-estado" style="">
                    <label class="control-label col-sm-2">Type <span class="text-danger" title="This field is required">*</span></label>

                    <div class="col-sm-10">
                        <select class="form-control" id="estado" placeholder="Select" name="estado" required>
                            <option >***Select Data***</option>
                            @foreach($estados as $estado)
                                @if($estado->id == $lead->estado)
                                    <option selected="true" value="{{ $estado->id }}" id="{{ $estado->id }}">{{ $estado->name }}</option>;
                                @else
                                    <option value="{{ $estado->id }}" id="{{ $estado->id }}">{{ $estado->name }}</option>;
                                @endif
                            @endforeach
                        </select>
                        <div class="text-danger">

                        </div><!--end-text-danger-->
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-id_usuario" style="">
                    <label class="control-label col-sm-2">Assign To <span class="text-danger" title="This field is required">*</span></label>

                    <div class="col-sm-10">
                        <select class="form-control" id="id_usuario" placeholder="Select" name="id_usuario" required>
                            <option >***Select Data***</option>
                            @foreach($users as $user)
                                @if($user->id == $lead->id_usuario)
                                    <option selected="true" value="{{ $user->id }}" id="{{ $user->id }}">{{ $user->name }}</option>;
                                @else
                                    <option value="{{ $user->id }}" id="{{ $user->id }}">{{ $user->name }}</option>;
                                @endif
                            @endforeach
                        </select>
                        <div class="text-danger">

                        </div><!--end-text-danger-->
                        <p class="help-block"></p>

                    </div>
                </div>


        </div>

            <div class="box-footer" style="background: #F5F5F5">
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">


                        <a href="http://18.220.213.59/crm/customers25?" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>


                        <input type="submit" name="submit" value="Save" class="btn btn-success">

                    </div>
                </div>
            </div>

        </form>

    </div>









@endsection