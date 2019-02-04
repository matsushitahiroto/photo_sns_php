$(document).ready(function(){
  var thumbs = document.querySelectorAll('.thumb');
  for(var i = 0; i < thumbs.length; i++) {
    thumbs[i].onclick = function() {
      document.getElementById('bigImage').src = this.dataset.image;
      document.getElementById('imageLink').href = this.dataset.image;
    };
  }
});
