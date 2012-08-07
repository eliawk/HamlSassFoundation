jQuery(document).ready ($) ->
    
  if(Modernizr.touch)
    $('body').scrollTop(1)
    
    if($('.gallery a').length > 0)
      myPhotoSwipe = $('.gallery a').photoSwipe()
    
  else
    # determino se il menu è position:fixed
    position = $('.navigation').css('position')
    posiziona_nav()  
            
    $(window).resize ->
      posiziona_nav()
      
    
    #fix per z-index dei video youtube (iframe)
    $(".flex-video iframe").each ->
      url = $(this).attr("src")
      $(this).attr "src", url + "?wmode=transparent"  
      
    # Aggiungo rel=gallery alle gallerie
    $('.gallery-item a').attr('rel','galleria')
    
    
    # Fancybox
    $('a[href$=".gif"], a[href$=".jpg"], a[href$=".png"], a[href$=".bmp"]').fancybox
      prevEffect		: 'none',
      nextEffect		: 'none'
    
    $('.map').fancybox
      maxWidth	: 800,
      maxHeight	: 600,
      fitToView	: false,
      width		: '75%',
      height		: '75%',
      autoSize	: false,
      closeClick	: false,
      openEffect	: 'none',
      closeEffect	: 'none'

  $(window).load ->
    $('#slider').orbit
      animation: 'fade',                 
      animationSpeed: 800,
      timer: true,
      advanceSpeed: 10000,
      pauseOnHover: false,
      startClockOnMouseOut: false,
      startClockOnMouseOutAfter: 1000,
      directionalNav: false, 		
      captions: false
    
    
    
       
  

posiziona_nav = () ->
  window_width = $(window).width()
  if(window_width > 767)
    parent_width = $('.navigation').parent().css('width')
    position =  'fixed'
  else
    parent_width = 'auto'
    position =  'relative'
    
  $('.navigation').css('width', parent_width)
  $('.logo').css('width', parent_width)
  
  $('.navigation').css('position', position)
  $('.logo').css('position', position)
    
          
  

