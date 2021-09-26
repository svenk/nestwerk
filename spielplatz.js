var spielplaetze = {};
var msgs = [];

$(function(){
    /* Requiring leaflet */
    
    var muenster_center = [ 51.96316724571617, 7.624406018610712 ];
    
    var map = L.map('mapid').setView(muenster_center, 14);   
    
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    
    $.when(
        $.getJSON("spielplaetze.geojson", (data)=>{
            spielplaetze = data;
            //L.geoJSON(data).addTo(map);
        }),
        $.ajax({
            type: 'GET',
            url: "msg.log",
            cache: false,
            dataType: 'text',
            success: (data)=> {
                debugText = data;
                msgs = $.csv.toArrays(data);
            }
        })
    ).then(function(){
            // a mapping { playground: [ messages ] }
            playground_msgs = {};
            
            // filter only entries within the last hour, append them to list
            const current_time = Math.floor(Date.now() / 1000);
            for (let i = 0; i < msgs.length; i++) {
                // format: 0, 1, 2 = timestamp, playground id, message (html safe)
                // note that all are strings
                post_time = Number(msgs[i][0]);
                if(post_time < current_time - 60*60)  continue;

                playground_id = Number(msgs[i][1]);
                if(!playground_msgs[playground_id])
                    playground_msgs[playground_id] = [];
                
                playground_msgs[playground_id].push(msgs[i][2]);
            }
            
            L.geoJSON(spielplaetze, {
                onEachFeature: (feature, layer) => {
                    // does this feature have a property named popupContent?
                    Object.keys(playground_msgs).forEach((k, idx) => {
                        if(feature.properties.ID == k) {
                            layer.bindPopup("Message: " + playground_msgs[k].join(", "));
                            feature.hasMsg = true;
                        }
                    });
                },

                pointToLayer: function (feature, latlng) {
                    settings = {}
                    console.log("PointToLayer", feature);
                    Object.keys(playground_msgs).forEach((k, idx) => {
                        if(feature.properties.ID == k) {
                            css = { color: "red" };
                            console.log("Setting red");
                        }
                    });
                    return L.circleMarker(latlng, settings);
                }, 
                style: function(feature) {
                    css = {};
                    console.log("Style feature", feature);
                    Object.keys(playground_msgs).forEach((k, idx) => {
                        if(feature.properties.ID == k) {
                            css = { color: "red" };
                            console.log("Setting red");
                        }
                    });
                    return css;
                }
            }).addTo(map);
            
            // display the list
            /*
            Object.keys(playground_msgs).forEach((k, msgs) => {
                playground_coords = debugData.features.filter(e => e.properties.ID == k)[0].geometry.coordinates
                
                L.marker(playground_coords).addTo(map)
            }
            */
    });

/*
L.marker([51.5, -0.09]).addTo(map)
    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
    .openPopup();
*/

});


function announce() {
    $("body").appen
}
