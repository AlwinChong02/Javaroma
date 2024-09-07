
$(document).ready(function() {
    var steamGrp = [steamLeft, steamRight, steamMid],
        steamLeft = $('svg #steam-left'),
        steamRight = $('#steam-right'),
        steamMid = $('#steam-mid'),
        svg = $('svg'),
        rotate = new TimelineMax({paused:false, repeat: -1}),
        pulse = new TimelineMax({paused:false, repeat: -1, yoyo:true}),
        rise = new TimelineMax({paused:false, repeat: -1});
    
  
    rotate.to([steamLeft, steamRight, steamMid], 2, {rotationY:"+=360deg", transformOrigin:"50% 50%", ease: Linear.easeOut});
    
    pulse.set([steamLeft, steamRight, steamMid], {opacity: "0", ease: Linear.easeInOut})
         .to([steamLeft, steamRight, steamMid], 1.5, {opacity: ".75", ease: Linear.easeInOut});
    
    rise.staggerTo([steamMid, steamLeft, steamRight], 2, {y: "-=50px", ease: Linear.easeOut}, .5);
  });