function moveToLocation(lat, lng){
    const center = new google.maps.LatLng(lat, lng);
    window.map.panTo(center);
}