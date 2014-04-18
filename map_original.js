/* vim: set syntax=javascript: */
/* TODO: unter Einträge bearbeiten sollen die koordinaten auch gesetzt werden, wenn sie unter einem bereits bestehenden icon liegen */

var map;
var poiLayers = new Array();
var clusterStrategies = new Array();
var select;

var coord_elem_lon = 'entry_lon';
var coord_elem_lat = 'entry_lat';

var urlPoi = 'export.php';
var urlGroups = 'groups.php';

if(openlayers_defined()) {
    OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
    defaultHandlerOptions: {
        'single': true,
        'double': false,
        'pixelTolerance': 0,
        'stopSingle': false,
        'stopDouble': false
    },
    initialize: function(options) {
        this.handlerOptions = OpenLayers.Util.extend({}, this.defaultHandlerOptions);
        OpenLayers.Control.prototype.initialize.apply(this, arguments); 
        this.handler = new OpenLayers.Handler.Click(this, {'click': this.trigger}, this.handlerOptions);
    }, 
        trigger: function(e) {
            var lonlat = map.getLonLatFromPixel(e.xy).transform(this.map.getProjectionObject(),this.map.displayProjection);
            document.getElementById(coord_elem_lon).value = lonlat.lon;
            document.getElementById(coord_elem_lat).value = lonlat.lat;
            alert('Koordinaten gesetzt');
        }
    });
}

function xmlGetRequestSync(url, params) {
    if (window.XMLHttpRequest) {
        xmlReq = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlReq = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        return null;
    }

    if(params != null) {
        url = url + '?' + params;
    }

    xmlReq.open("GET", url, false);
    xmlReq.send(null);
    if(xmlReq.status == 200) {
        return xmlReq.responseText;
    }
    return null;
}

function openlayers_defined() {
    if(typeof(OpenLayers) == "undefined")
        return false;
    else
        return true;
}

function google_api_defined() {
    if(typeof(google) != "undefined" && 
        typeof(google.maps) != "undefined" &&
        typeof(google.maps.MapTypeId) != "undefined") {

        return true;
    } else {
        return false;
    }
}

function coord_elems_exists() {
    if(document.getElementById(coord_elem_lon) != null && document.getElementById(coord_elem_lat) != null) {
        return true;
    }
    return false;
}

function get_poi_url_bbox(groups) {
    if(typeof(groups) == "undefined") {
        var groups = "0";
    }

    return urlPoi + "?format=txt" + "&groups=" + groups;
}

function onFeatureSelect(event) {
    if(!event.cluster) {
        var feature = event.feature.cluster[0];
        if(event.feature.attributes.count < 2) {
            // Single element in a cluster
            var content = "<h1>" + feature.attributes.title + "</h1>" + feature.attributes.description;
        } else {
            // More elements in a cluster
            var content = "<h1>Mehrere Punkte in dem Gebiet</h1>Reinzoomen um mehr zu sehen";
        }
        popup = new OpenLayers.Popup.FramedCloud("nix", 
            feature.geometry.getBounds().getCenterLonLat(),
            new OpenLayers.Size(100,100),
            content,
            null, 
            true, 
            onPopupClose);
        popup.maxSize = new OpenLayers.Size(500, 500);
        // popup.closeOnMove = true;            // this closes, when map is moved or zoomed. see Event moveend / function closeAllPopups

        feature.popup = popup;
        map.addPopup(popup);
    }
}

function closePopup(feature) {
    if(feature && feature.popup) {
        map.removePopup(feature.popup);
        feature.popup.destroy();
        delete feature.popup;
        return true;
    }
    return false;
}

function onFeatureUnselect(event) {
    if(!event.cluster && event.feature) {
        var feature = event.feature.cluster[0];
        closePopup(feature);
    }
}

function setClustering(state) {
    /* It seems not possible to switch clustering on or off. Therefor set distance to 1 Pixel to switch off. */
    for(x in clusterStrategies) {
        if(state) {
            if(clusterStrategies[x].distance_old != 0) {
                clusterStrategies[x].distance = clusterStrategies[x].distance_old;
                clusterStrategies[x].distance_old = 0;
            } else {
                break;
            }
        } else {
            if(clusterStrategies[x].distance_old == 0) {
                clusterStrategies[x].distance_old = clusterStrategies[x].distance;
                clusterStrategies[x].distance = 1;
            } else {
                break;
            }
        }
    }
}

function eventMoveEnd(event) {
    if(event.zoomChanged == true) {
        /* Check if zoom is on last level */
        if(event.object.map.zoom < 18) {
            setClustering(true);
        } else {
            setClustering(false);
        }


        /* Close all Popups when layer zoomed.
           Not when Layer is moved */
        features = event.object.features;
        for(featnum in features) {
            myfeat = features[featnum];
            if(myfeat.cluster.length > 0) {
                closePopup(features[featnum].cluster[0]);
            }
        }
    }
}

function onPopupClose(event) {
    select.unselectAll();
}

function setCenter4326(lonlat, zoom) {
    map.setCenter(lonlat.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")), zoom);
}


function init(){
    if(!openlayers_defined()) {
        document.getElementById('map').innerHTML = "<strong>OpenLayers not defined.<br />* Maybe you didnt enable JavaScript.<br />* Maybe OpenLayers or your connection to Openlayers is broken.<br /><br />On further errors, write to the mail-adress you can find under contacts.</strong>";
        return false;
    }
    map = new OpenLayers.Map('map', { 
        maxExtent: new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34),
        numZoomLevels: 30,
        maxResolution: 156543.0399,
        units: 'm',
        projection: new OpenLayers.Projection("EPSG:4326"),
        displayProjection: new OpenLayers.Projection("EPSG:4326")
    });


    // var layerMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik", {attribution: ""});
    // var layerTaH = new OpenLayers.Layer.OSM.Osmarender("Tiles@Home", {attribution: ""});
    var layerOsm = new OpenLayers.Layer.OSM();
    map.addLayers([layerOsm]);

    if(google_api_defined()) {
        /*
        var gphy = new OpenLayers.Layer.Google(
            "Google Physical", 
            {type: google.maps.MapTypeId.TERRAIN}
        );
        */
        var ghyb = new OpenLayers.Layer.Google(
            "Google Hybrid",
            {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20}
        );
        /* map.addLayers([gphy, ghyb, gsat]); */
        map.addLayers([ghyb]);
    }


    map.addControl(new OpenLayers.Control.LayerSwitcher());
    /* map.addControl(new OpenLayers.Control.MousePosition()); */
    map.addControl(new OpenLayers.Control.ScaleLine());


    if(coord_elems_exists()) {
        var click = new OpenLayers.Control.Click();
        map.addControl(click);
        click.activate();
    }

    map.setCenter(0,0, 30);

    var group_req = xmlGetRequestSync(urlGroups, null);
    if(group_req != null) {
        var groups = eval(group_req);
    }

    for(groupnum in groups) {
        group = groups[groupnum];


        var style = new OpenLayers.Style({
            externalGraphic: "${externalGraphic}",
            graphicWidth: "${graphicWidth}",
            graphicHeight: "${graphicHeight}",
            graphicXOffset: "${graphicXOffset}",
            graphicYOffset: "${graphicYOffset}",
            graphicOpacity: 0.7
            //pointRadius: Math.floor(Math.max(group.iconh, group.iconw) * 2)
        }, {
            context: {
                externalGraphic: function(feature){
                    if(feature.attributes.count > 1) {
                        return groups[feature.layer.groupnum].multi_icon;
                    } else {
                        return groups[feature.layer.groupnum].icon; 
                    }
                },
                graphicWidth: function(feature){
                    if(feature.attributes.count > 1) {
                        return parseInt(groups[feature.layer.groupnum].multi_iconw);
                    } else {
                        return parseInt(groups[feature.layer.groupnum].iconw);
                    }
                },
                graphicHeight: function(feature){
                    if(feature.attributes.count > 1) {
                        return parseInt(groups[feature.layer.groupnum].multi_iconh);
                    } else {
                        return parseInt(groups[feature.layer.groupnum].iconh);
                    }
                },
                graphicXOffset: function(feature){
                    if(feature.attributes.count > 1) {
                        return parseInt(groups[feature.layer.groupnum].multi_iconx);
                    } else {
                        return parseInt(groups[feature.layer.groupnum].iconx);
                    }
                },
                graphicYOffset: function(feature){
                    if(feature.attributes.count > 1) {
                        return parseInt(groups[feature.layer.groupnum].multi_icony);
                    } else {
                        return parseInt(groups[feature.layer.groupnum].icony);
                    }
                }
            }
        });

        var strategy_cluster = new OpenLayers.Strategy.Cluster({
            distance: Math.floor(Math.max(group.iconh, group.iconw)),
            distance_old: 0     /* This is used when zoom-level is at maximum. Then clustering is switched off. Used for old value. See setClustering() */
        });
        clusterStrategies.push(strategy_cluster);

        var strategy_bbox = new OpenLayers.Strategy.BBOX();
        var layer = new OpenLayers.Layer.Vector(group.name, {
            projection: map.displayProjection,
            strategies: [strategy_bbox, strategy_cluster],
            styleMap: new OpenLayers.StyleMap({
                "default": style,
                "select": {
                    graphicOpacity: 1
                }
                // "temporary":
            }),
            protocol: new OpenLayers.Protocol.HTTP({
                url: get_poi_url_bbox(group.id),
                format: new OpenLayers.Format.Text({
                    // extractStyles: true,
                    // extractAttributes: true
                })
            })
        });
        layer.groupnum = groupnum;
        layer.events.on({
            "featureselected": coord_elems_exists() ? null : onFeatureSelect,
            "featureunselected": coord_elems_exists() ? null: onFeatureUnselect,
            "moveend": eventMoveEnd
        });

        map.addLayer(layer);
        strategy_bbox.update({force: true});

        poiLayers.push(layer);
    }

    select = new OpenLayers.Control.SelectFeature(poiLayers, 
        {onSelect: onFeatureSelect, 
        onUnselect: onFeatureUnselect});

    map.addControl(select);
    select.activate();   
}
