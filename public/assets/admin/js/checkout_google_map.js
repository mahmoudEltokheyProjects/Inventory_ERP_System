// ++++++++++++++++++++++++++++++++ Start : Google Map Code With Search +++++++++++++++++++++++++++++++++++
// async function initMap()
// {
//   // Request needed libraries.
//   const { Map } = await google.maps.importLibrary("maps");
//   const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

//   // Initialize the map centered on Cairo as a fallback.
//   const map = new Map(document.getElementById("map"),
//   {
//     center: { lat: 30.033333, lng: 31.233334 },
//     zoom: 14,
//     mapId: "4504f8b37365c3d0",
//   });
//   // ====================== Search Box for Places Autocomplete ======================
//   // Create the search box and link it to a new input element for autocomplete.
//   const searchInput = document.createElement("input");
//   searchInput.type = "text";
//   searchInput.id = "autocomplete";
//   searchInput.placeholder = "أبحث عن مكان ...";
//   searchInput.classList.add("search-map-input");
//   map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);

//   const autocomplete = new google.maps.places.Autocomplete(searchInput);
//   autocomplete.bindTo("bounds", map);

//   // Define a marker variable for autocomplete.
//   let marker;

//   // Listen for place selection from autocomplete suggestions.
//   autocomplete.addListener("place_changed", () => {
//     const place = autocomplete.getPlace();
//     if (!place.geometry || !place.geometry.location) {
//       console.log("No details available for input: '" + place.name + "'");
//       return;
//     }

//     // Place the marker on the map based on the selected place's location.
//     const position = {
//       lat: place.geometry.location.lat(),
//       lng: place.geometry.location.lng(),
//     };
//     placeMarker(position); // Use the existing placeMarker function to set the marker.
//   });

//   // ========================== Existing Search Box for Map Viewport ==========================
//   // Create the search box for bounding within the map's viewport.
//   const input = document.getElementById("pac-input");
//   const searchBox = new google.maps.places.SearchBox(input);
//   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

//   map.addListener("bounds_changed", () => {
//     searchBox.setBounds(map.getBounds());
//   });

//   // ========================== getAddress() ==========================
//   // Function to fetch address information using OpenStreetMap's Nominatim API.
//   function getAddress(lat, lng) {
//     fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
//       .then(response => response.json())
//       .then(data => {
//         const address = data.display_name || "";
//         const country = data.address.country || "";
//         const state = data.address.state || "";
//         const city = data.address.city || data.address.town || data.address.village || "";
//         const house_number = data.address.house_number || "";
//         const neighbourhood = data.address.neighbourhood || "";
//         const block_number = neighbourhood.match(/\d+/) ? neighbourhood.match(/\d+/)[0] : "";

//         console.log("Data :", data);
//         console.log("Full Address:", address);
//         console.log("Country:", country);
//         console.log("State:", state);
//         console.log("City:", city);
//         console.log("House Number:", house_number);
//         console.log("Block Number:", block_number);

//         document.getElementById('address').value = address ?? '';
//         document.getElementById('home_block_id').value = block_number ?? '';
//         document.getElementById('house_id').value = house_number ?? '';

//         const citySelect = document.getElementById("choose_city");
//         let cityExists = false;
//         for (let option of citySelect.options) {
//           if (option.text === city) {
//             cityExists = true;
//             citySelect.value = option.value;
//             break;
//           }
//         }
//       })
//       .catch(error => {
//         console.error("Error with reverse geocoding:", error);
//       });
//   }

//   // Initialize a draggable marker without a label.
//   function placeMarker(position) {
//     if (marker) {
//       marker.position = position;
//     } else {
//       marker = new AdvancedMarkerElement({
//         map,
//         position: position,
//         draggable: true,
//       });

//       marker.addListener("dragend", () => {
//         const { lat, lng } = marker.position;
//         getAddress(lat, lng);
//       });
//     }
//     map.setCenter(position);
//     getAddress(position.lat, position.lng);
//   }

//   map.addListener("click", (mapsMouseEvent) => {
//     const position = {
//       lat: mapsMouseEvent.latLng.lat(),
//       lng: mapsMouseEvent.latLng.lng(),
//     };
//     placeMarker(position);
//   });

//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(
//       (position) => {
//         const userLocation = {
//           lat: position.coords.latitude,
//           lng: position.coords.longitude,
//         };
//         placeMarker(userLocation);
//       },
//       () => {
//         console.error("Geolocation permission denied or not available.");
//         placeMarker({ lat: 30.033333, lng: 31.233334 });
//       }
//     );
//   } else {
//     console.error("Geolocation is not supported by this browser.");
//     placeMarker({ lat: 30.033333, lng: 31.233334 });
//   }
// }

// initMap();
// ++++++++++++++++++++++++++++++++ End : Google Map Code With Search +++++++++++++++++++++++++++++++++++

// ++++++++++++++++++++++++++++++++ Start : 24-11-2024 : Google Map Code With Search +++++++++++++++++++++++++++++++++++
async function initMap() {
    // Request needed libraries.
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    // Initialize the map centered on a fallback location.
    const map = new Map(document.getElementById("map"), {
      center: { lat: 29.336573, lng: 47.675529 },
      zoom: 14,
      mapId: "4504f8b37365c3d0",
    });

    // Create the search input for autocomplete
    const searchInput = document.createElement("input");
    searchInput.type = "text";
    searchInput.id = "autocomplete";
    searchInput.placeholder = "أبحث عن مكان ...";
    searchInput.classList.add("search-map-input");
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchInput);

    const autocomplete = new google.maps.places.Autocomplete(searchInput);
    autocomplete.bindTo("bounds", map);

    // Marker for the map
    let marker;

    // Listen for place selection from autocomplete suggestions
    autocomplete.addListener("place_changed", () => {
      const place = autocomplete.getPlace();
      if (!place.geometry || !place.geometry.location) {
        console.log("No details available for input: '" + place.name + "'");
        return;
      }
      const position = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng(),
      };
      placeMarker(position); // Use the placeMarker function to set the marker
    });

    // ================ start :  "Current Place" button click ================
    const detectLocationBtn = document.createElement("button");
    detectLocationBtn.id = "auto-detect-btn-id";
    // detectLocationBtn.innerHTML = '<i class="fa-solid fa-location-dot fa-lg"></i>'; // Add icon with text
    detectLocationBtn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i>'; // Add icon with text
    detectLocationBtn.classList.add("auto-detect-btn");
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(detectLocationBtn);
    detectLocationBtn.addEventListener("click", (e) => {
      // Prevent form submission
      e.preventDefault();
      getCurrentLocation();
    });
    // ================ end :  "Current Place" button click ================
    // Function to get current location and update the map and marker
    function getCurrentLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const { latitude, longitude } = position.coords;
            const userLocation = { lat: latitude, lng: longitude };
            console.log(userLocation);
            map.setCenter(userLocation);
            if (marker) {
              marker.setPosition(userLocation);
            } else {
              marker = new AdvancedMarkerElement({
                map,
                position: userLocation,
                draggable: true,
              });
            }
            map.setZoom(15);
            getAddress(userLocation.lat, userLocation.lng); // Update address fields
          },
          () => alert("Unable to retrieve location."),
          { enableHighAccuracy: true }
        );
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    // Function to fetch address from latitude and longitude
    function getAddress(lat, lng) {
      fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(response => response.json())
        .then(data => {
          // +++++++++++++ get address +++++++++++++++++++
          const address = data.display_name || "";
          const country = data.address.country || "";
          const state = data.address.state || "";
          const city = data.address.city || data.address.town || data.address.village || "";
          const house_number = data.address.house_number || "";
          const neighbourhood = data.address.neighbourhood || "";
          const block_number = neighbourhood.match(/\d+/) ? neighbourhood.match(/\d+/)[0] : "";
          // ++++++++++++ select address info ++++++++++++
          console.log("Data :", data);
          console.log("Full Address:", address);
          console.log("Country:", country);
          console.log("State:", state);
          console.log("City:", city);
          console.log("House Number:", house_number);
          console.log("Block Number:", block_number);
          document.getElementById('address').value = address ?? '';
        })
        .catch(error => alert("Error fetching address: " + error.message));
    }
    // ========================= When Click on Map =============================
    // ++++++++++++++++++++++++++++++++++++++++
    map.addListener("click", (mapsMouseEvent) => {
      const position = {
        lat: mapsMouseEvent.latLng.lat(),
        lng: mapsMouseEvent.latLng.lng(),
      };
      placeMarker(position);
    });
    // ++++++++++++++++++++++++++++++++++++++
    // Function to place a marker on the map
    function placeMarker(position) {
      if (marker) {
        marker.setPosition(position);
      } else {
        marker = new google.maps.Marker({
          map,
          position: position,
          draggable: true,
        });

        marker.addListener("dragend", () => {
          const latLng = marker.getPosition();
          getAddress(latLng.lat(), latLng.lng());
        });
      }

      map.setCenter(position);
      getAddress(position.lat, position.lng);
    }
      map.addListener("click", (mapsMouseEvent) => {
      const position = {
        lat: mapsMouseEvent.latLng.lat(),
        lng: mapsMouseEvent.latLng.lng(),
      };
      placeMarker(position);
    });
    // Attempt to get current location when the page loads
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const userLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          placeMarker(userLocation);
        },
        () => {
          console.error("Geolocation permission denied or not available.");
          placeMarker({ lat: 29.336573, lng: 47.675529 }); // Default fallback location
        }
      );
    } else {
      console.error("Geolocation is not supported by this browser.");
      placeMarker({ lat: 29.336573, lng: 47.675529 }); // Default fallback location
    }
  }

  initMap();
  // ++++++++++++++++++++++++++++++++ End : 24-11-2024 : Google Map Code With Search +++++++++++++++++++++++++++++++++++
