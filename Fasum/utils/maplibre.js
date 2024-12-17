window.onload = function () {
    const map = new maplibregl.Map({
        container: "map", // container id
        style: "https://api.maptiler.com/maps/streets-v2/style.json?key=OhgaEDrPq0oVSbqCll1O", // style URL
        center: [104.0354718802255, 1.1291339818308566], // starting position [lng, lat]
        zoom: 12, // starting zoom
    });

    const loadCustomMarker = async () => {
        const customMarkerImage = await map.loadImage("../public/pin.png");
        if (!map.hasImage("custom-marker")) map.addImage("custom-marker", customMarkerImage.data);

        const customMarkerPersonImage = await map.loadImage("../public/location-pin.png");
        if (!map.hasImage("custom-marker-person")) map.addImage("custom-marker-person", customMarkerPersonImage.data);
    };

    loadCustomMarker();

    const clickableDivs = document.querySelectorAll("[data-latitude]");

    clickableDivs.forEach((div) => {
        div.addEventListener("click", () => {
            if (map.getLayer("route")) {
                map.removeLayer("route");
                map.removeSource("route");
            }
            // Get the coordinates from the data attribute
            const latitude = div.getAttribute("data-latitude");
            const longitude = div.getAttribute("data-longitude");
            const endCoordinate = [longitude, latitude];

            const newEndCoordinate = {
                type: "FeatureCollection",
                features: [
                    {
                        type: "Feature",
                        properties: {},
                        geometry: {
                            type: "Point",
                            coordinates: endCoordinate,
                        },
                    },
                ],
            };
            // Set the coordinates to the 'end' input field
            const endInput = document.getElementById("end");
            endInput.value = `${latitude}, ${longitude}`;

            // if the route already exists on the map, we'll reset it using setData
            if (map.getSource("point")) {
                map.getSource("point").setData(newEndCoordinate);
            } else {
                map.addLayer({
                    id: "point",
                    type: "symbol",
                    source: {
                        type: "geojson",
                        data: {
                            type: "FeatureCollection",
                            features: [
                                {
                                    type: "Feature",
                                    properties: {},
                                    geometry: {
                                        type: "Point",
                                        coordinates: endCoordinate,
                                    },
                                },
                            ],
                        },
                    },
                    layout: {
                        "icon-image": "custom-marker",
                        "icon-size": 0.8, // Adjust size if needed
                        "icon-anchor": "bottom",
                        "icon-allow-overlap": true,
                    },
                });
            }

            // Optionally, log the coordinates for debugging
            // console.log(`Coordinates set to end input: ${latitude}, ${longitude}`);
        });
    });

    document.getElementById("findRouteButton").addEventListener("click", async () => {
        // Get input values
        const startInput = document.getElementById("start").value;
        const endInput = document.getElementById("end").value;

        if (!startInput || !endInput) {
            alert("Please provide both start and end coordinates!");
            return;
        }

        try {
            // Replace with actual coordinates extracted from user input
            const startCoordinates = startInput.split(",").map((coord) => coord.trim());
            const endCoordinates = endInput.split(",").map((coord) => coord.trim());

            if (startCoordinates.length !== 2 || endCoordinates.length !== 2) {
                alert("Invalid coordinate format. Use 'latitude,longitude'.");
                return;
            }

            // API URL
            const apiKey = "5b3ce3597851110001cf6248584d5528ebb1452ca4390f3e0f849215";
            const url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${startCoordinates[1]},${startCoordinates[0]}&end=${endCoordinates[1]},${endCoordinates[0]}`;

            // Call the API
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`API error: ${response.statusText}`);
            }

            const data = await response.json();

            // Handle the API response (e.g., display route)
            // console.log("Route data:", data);

            const route = data.features[0].geometry.coordinates;
            const geojson = {
                type: "Feature",
                properties: {},
                geometry: {
                    type: "LineString",
                    coordinates: route,
                },
            };
            // if the route already exists on the map, we'll reset it using setData
            if (map.getSource("route")) {
                map.getSource("route").setData(geojson);
            }
            // otherwise, we'll make a new request
            else {
                map.addLayer({
                    id: "route",
                    type: "line",
                    source: {
                        type: "geojson",
                        data: geojson,
                    },
                    layout: {
                        "line-join": "round",
                        "line-cap": "round",
                    },
                    paint: {
                        "line-color": "#3887be",
                        "line-width": 5,
                        "line-opacity": 0.75,
                    },
                });
            }
        } catch (error) {
            console.error("Error fetching route:", error);
            alert("Failed to fetch the route. See console for details.");
        }
    });

    map.on("load", () => {
        map.on("click", (event) => {
            if (map.getLayer("route")) {
                map.removeLayer("route");
                map.removeSource("route");
            }
            const coords = Object.keys(event.lngLat).map((key) => event.lngLat[key]);
            const end = {
                type: "FeatureCollection",
                features: [
                    {
                        type: "Feature",
                        properties: {},
                        geometry: {
                            type: "Point",
                            coordinates: coords,
                        },
                    },
                ],
            };
            if (map.getLayer("end")) {
                map.getSource("end").setData(end);
            } else {
                map.addLayer({
                    id: "end",
                    type: "symbol",
                    source: {
                        type: "geojson",
                        data: {
                            type: "FeatureCollection",
                            features: [
                                {
                                    type: "Feature",
                                    properties: {},
                                    geometry: {
                                        type: "Point",
                                        coordinates: coords,
                                    },
                                },
                            ],
                        },
                    },
                    layout: {
                        "icon-image": "custom-marker-person",
                        "icon-size": 1, // Adjust size if needed
                        "icon-anchor": "bottom",
                        "icon-allow-overlap": true,
                    },
                });
            }

            // Set the coordinates to the 'end' input field
            const startInput = document.getElementById("start");
            startInput.value = `${coords[1]}, ${coords[0]}`;
        });
    });
};
