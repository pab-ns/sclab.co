// Progress Bar

// Nicole
  $('#audio-n').on('timeupdate', function() {
      $('#seekbar-n').attr("value", this.currentTime / this.duration);
  });

// Vitor
$('#audio-v').on('timeupdate', function() {
    $('#seekbar-v').attr("value", this.currentTime / this.duration);
});

// Sarah
$('#audio-s').on('timeupdate', function() {
    $('#seekbar-s').attr("value", this.currentTime / this.duration);
});

// Juan Carlos
$('#audio-jc').on('timeupdate', function() {
    $('#seekbar-jc').attr("value", this.currentTime / this.duration);
});

// Anastasia
$('#audio-a').on('timeupdate', function() {
    $('#seekbar-a').attr("value", this.currentTime / this.duration);
});

// Jimmy
$('#audio-j').on('timeupdate', function() {
    $('#seekbar-j').attr("value", this.currentTime / this.duration);
});

// Reina
$('#audio-r').on('timeupdate', function() {
    $('#seekbar-r').attr("value", this.currentTime / this.duration);
});

// Oliver
$('#audio-o').on('timeupdate', function() {
    $('#seekbar-o').attr("value", this.currentTime / this.duration);
});







