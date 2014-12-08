(function($) {
  $.facebox = function(data, klass) {
    $.facebox.init()
    $.facebox.loading()
    $.isFunction(data) ? data.call($) : $.facebox.reveal(data, klass)
  }

  $.facebox.settings = {
    loading_image : 'imagens/win8/carregando.png',
    close_image   : 'imagens/win8/fechar.png',
    image_types   : [ 'png', 'jpg', 'jpeg', 'gif' ],
    facebox_html  : '\
  <div id="facebox" style="display:none;"> \
    <div class="popup"> \
      <table> \
        <tbody> \
          <tr> \
            <td class="body"> \
              <div class="content"> \
              </div> \
            </td> \
          </tr> \
        </tbody> \
      </table> \
    </div> \
  </div>'
  }

  $.facebox.loading = function() {
    if ($('#facebox .loading').length == 1) return true

    $('#facebox .content').empty()
    $('#facebox .body').children().hide().end().
      append('<div class="loading"><img src="'+$.facebox.settings.loading_image+'" style="margin-top:40px;"/></div>')

    var pageScroll = $.facebox.getPageScroll()
    $('#facebox').css({
      top:	pageScroll[1],
      left:	pageScroll[0]
    }).show()

    $(document).bind('keydown.facebox', function(e) {
      if (e.keyCode == 27) $.facebox.close()
    })
  }

  $.facebox.reveal = function(data, klass) {
    if (klass) $('#facebox .content').addClass(klass)
    $('#facebox .content').append(data)
    $('#facebox .loading').remove()
    $('#facebox .body').children().fadeIn('normal')
  }

  $.facebox.close = function() {
    $(document).trigger('close.facebox')
    return false
  }

  $(document).bind('close.facebox', function() {
    $(document).unbind('keydown.facebox')
    $('#facebox').fadeOut(function() {
      $('#facebox .content').removeClass().addClass('content')
    })
  })

  $.fn.facebox = function(settings) {
    $.facebox.init(settings)

    var image_types = $.facebox.settings.image_types.join('|')
    image_types = new RegExp('\.' + image_types + '$', 'i')

    function click_handler() {
      $.facebox.loading(true)

      // support for rel="facebox[.inline_popup]" syntax, to add a class
      var klass = this.rel.match(/facebox\[\.(\w+)\]/)
      if (klass) klass = klass[1]

      // div
      if (this.href.match(/#/)) {
        var url    = window.location.href.split('#')[0]
        var target = this.href.replace(url,'')
        $.facebox.reveal($(target).clone().show(), klass)

      // image
      } else if (this.href.match(image_types)) {
        var image = new Image()
        image.onload = function() {
          $.facebox.reveal('<div class="image"><img src="' + image.src + '" /></div>', klass)
        }
        image.src = this.href

      // ajax
      } else {
        $.get(this.href, function(data) { $.facebox.reveal(data, klass) })
      }

      return false
    }

    this.click(click_handler)
    return this
  }

  $.facebox.init = function(settings) {
    if ($.facebox.settings.inited) {
      return true
    } else {
      $.facebox.settings.inited = true
    }
    if (settings) $.extend($.facebox.settings, settings)
    $('body').append($.facebox.settings.facebox_html)

    var preload = [ new Image(), new Image() ]
    preload[0].src = $.facebox.settings.close_image
    preload[1].src = $.facebox.settings.loading_image

    $('#facebox').find('.b:first, .bl, .br, .tl, .tr').each(function() {
      preload.push(new Image())
      preload.slice(-1).src = $(this).css('background-image').replace(/url\((.+)\)/, '$1')
    })

    $('#facebox .close').click($.facebox.close)
    $('#facebox .close_image').attr('src', $.facebox.settings.close_image)
  }

  // getPageScroll() by quirksmode.com
  $.facebox.getPageScroll = function() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;	
    }
    return new Array(xScroll,yScroll) 
  }
  
/*	var timer;
	$(window).bind('scroll',function () {
		clearTimeout(timer);
		timer = setTimeout( refresh , 600 );
	});
	var refresh = function () { 
		$('#facebox').animate({"top": ($(window).scrollTop()) + "px"}, "fast" );
	};*/


  // adapter from getPageSize() by quirksmode.com
  $.facebox.getPageHeight = function() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }	
    return windowHeight
  }
})(jQuery);
