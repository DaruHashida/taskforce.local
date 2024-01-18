ymaps.ready(init);

    function init()
    { var suggestView = new ymaps.suggestView('location'),
    map,
    placemark,
    suggest = document.getElementById('location'),
    submit = document.getElementById('submit'),
    mapArea = document.getElementById('map'),
    validity = document.getElementById('loc_valid');

    submit.addEventListener('click', function (e)
    {
        geocode();
    });

    function geocode()
    {
        var suggestVal = suggest.value;
        ymaps.geocode(suggestVal).then(
            function (res)
            {   var obj = res.geoObjects.get(0),
                error,
                hint;
                if (obj)
                {
                    switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision'))
                    {
                        case 'exact':
                            break;
                        case 'number':
                        case 'near':
                        case 'range':
                            error='Неточный адрес дома, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'street':
                            error = 'Неполный адрес дома, требуется уточнение';
                            hint = 'Уточните номер дома';
                        case 'other':
                        default:
                            error='Неточный адрес, требуется уточнение';
                            hint = 'Уточните адрес';
                    }

                }
                else {
                    error = 'Адрес не найден';
                    hint = 'Уточните адрес';
                }

                if (error) {
                    showError(error);
                    showMessage(hint);
                }
                else {
                    showResult(obj);
                }
            }
        );
    }


    function showResult(obj)
    {
        validity.value = '';

        var mapContainer = mapArea,
            bounds = obj.properties.get('boundedBy'),
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            ),
            fullAddress = [obj.getCountry(),obj.getAddressLine()].join(', '),
            shortAddress = [obj.getThoroughfare(),obj.getPremiseNumber(), obj.getPremise()].join(' ');
        mapState.controls = [];
        createMap(mapState, shortAddress);
        showMessage(fullAddress);
    }

    function showError(message)
    {
        validity.value = message;
        if (map)
        {
            map.destroy();
            map = null;
        }
    }

    function createMap (state,caption)
    {
        if(!map)
        {
            map = new ymaps.Map('map',state);
            placemark = new ymaps.Placemark(
                map.getCenter(),{
                    iconCaption: caption,
                    balloonContent:caption
                },{
                    preset: 'islands#redDotIconWithCaption'
                });
            map.geoObjects.add(placemark);
        }
        else
        {
            map.setCenter(state.center,state.zoom);
            placemark.geometry.setCoordinates(state.center);
            placemark.properties.set({iconCaption: caption, balloonContent: caption});
        }
    }

    function showMessage (message)
    {
        suggest.value = message;
    }
    }