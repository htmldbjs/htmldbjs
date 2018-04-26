var $container,
    event_state,
    orig_src,
    image_target;

var resizeableImage = {
  "initialize":function(p) {
    event_state = {};
    image_target = p.image_target;

    var firstHandle = p.firstHandle;

    if (firstHandle) {
      orig_src = new Image();

      $(image_target).wrap('<div id="imagesResizeContainer"></div>');
    }

    $(orig_src).attr("src", image_target.prop('src'));

    $container =  $('#imagesResizeContainer');
     $container.on('mousedown touchstart', 'img', resizeableImage.startMoving);
  },
  "saveEventState" : function(e){
    // Save the initial event details and container state
    event_state.container_width = $container.width();
    event_state.container_height = $container.height();
    event_state.container_left = $container.offset().left; 
    event_state.container_top = $container.offset().top;
    event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft(); 
    event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
    // This is a fix for mobile safari
    // For some reason it does not allow a direct copy of the touches property
    if(typeof e.originalEvent.touches !== 'undefined'){
      event_state.touches = [];
      $.each(e.originalEvent.touches, function(i, ob){
        event_state.touches[i] = {};
        event_state.touches[i].clientX = 0+ob.clientX;
        event_state.touches[i].clientY = 0+ob.clientY;
      });
    }
    event_state.evnt = e;
  },
  "startMoving": function(e){
    e.preventDefault();
    e.stopPropagation();
    resizeableImage.saveEventState(e);
    $(document).on('mousemove touchmove', resizeableImage.moving);
    $(document).on('mouseup touchend', resizeableImage.endMoving);
  },
  "endMoving" :function(e){
    e.preventDefault();
    $(document).off('mouseup touchend', resizeableImage.endMoving);
    $(document).off('mousemove touchmove', resizeableImage.moving);
  },
  "moving": function(e){
    var  mouse={}, touches;
    e.preventDefault();
    e.stopPropagation();
    
    touches = e.originalEvent.touches;
    
    mouse.x = (e.clientX || e.pageX || touches[0].clientX) + $(window).scrollLeft(); 
    mouse.y = (e.clientY || e.pageY || touches[0].clientY) + $(window).scrollTop();
    $container.offset({
      'left': mouse.x - ( event_state.mouse_x - event_state.container_left ),
      'top': mouse.y - ( event_state.mouse_y - event_state.container_top ) 
    });
    // Watch for pinch zoom gesture while moving
    if(event_state.touches && event_state.touches.length > 1 && touches.length > 1){
      var width = event_state.container_width, height = event_state.container_height;
      var a = event_state.touches[0].clientX - event_state.touches[1].clientX;
      a = a * a; 
      var b = event_state.touches[0].clientY - event_state.touches[1].clientY;
      b = b * b; 
      var dist1 = Math.sqrt( a + b );
      
      a = e.originalEvent.touches[0].clientX - touches[1].clientX;
      a = a * a; 
      b = e.originalEvent.touches[0].clientY - touches[1].clientY;
      b = b * b; 
      var dist2 = Math.sqrt( a + b );

      var ratio = dist2 /dist1;

      width = width * ratio;
      height = height * ratio;
      // To improve performance you might limit how often resizeImage() is called
      resizeableImage.resizeImage(width, height);
    }
  },
  "crop": function(){
      var elRevisedIMG = document.getElementById("imgRevisedImage");
      
      imgExtension = elRevisedIMG.getAttribute("data-img-type");
      $container = $("#imagesResizeContainer");
      var cropCanvas;
      var croppedLeft = $("#divCroppedImage").offset().left;
      if (croppedLeft < 0) {
        croppedLeft = 207.5 - croppedLeft;
      }
      var containerLeft = $container.offset().left;
      var finalLeft = croppedLeft - containerLeft + 2;
      var croppedTop = $("#divCroppedImage").offset().top;
      var containerTop = $container.offset().top;
      var finalTop = croppedTop - containerTop + 2.5;
      var croppedWidth = $("#divCroppedImage").width();
      var croppedHeight = $("#divCroppedImage").height();

      cropCanvas = document.getElementById("canvasImage");
      cropCanvas.width = croppedWidth;
      cropCanvas.height = croppedHeight;

      cropCanvas.getContext("2d").drawImage(elRevisedIMG, -finalLeft, -finalTop);

      if ("jpg" == imgExtension) { 
        imgType = "jpeg"; 
      } else {
        imgType = imgExtension;
      }

      var croppedSRC = cropCanvas.toDataURL("image/" + imgType);
      document.getElementById("imgCurrentImage").src = croppedSRC;
      document.getElementById("strCurrentImageSource").value = croppedSRC;
      document.getElementById("strCurrentImageType").value = imgExtension;
      
      hideDialog("divEditCurrentImage");

      document.getElementById("divCroppedImage").style.display = "none";
  }

};