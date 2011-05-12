$(function() {
  $('.rsvp input[type=radio]').change(submitRsvp);
  $('.reception input[type=radio]').change(submitReception);
  $('.menu input[type=radio]').change(function() {
	  submitMenu($(this));
	  showDietary();
  });
  $('.wine input[type=radio]').change(submitWine);
  $('.special').click(showDietary);
  $('.require').focus(showDietHint);
  $('.require').blur(function() {
	  saveDietary($(this));
	  hideDietHint($(this));
  });
  showDietary();
});

function sorry(e) {
  alert("Sorry, there was a problem and we cannot record your RSVP, please try again later");
}

function saved(saved) {
  $(saved).fadeIn('fast', function() {
    $(this).delay(300).fadeOut('slow');
  });
}

function submitRsvp() {
  var radio = $(this);
  $.ajax({
    url: '/rsvp/attending',
    type: 'POST',
    data: 'guest=' + radio.attr('name') + '&rsvp=' + radio.attr('value'),
    success: function(msg) {
      saved('#saved-rsvp');
    },
    error: sorry
  });
}

function submitReception() {
  var radio = $(this);
  $.ajax({
    url: '/rsvp/reception',
    type: 'POST',
    data: 'guest=' + $(this).attr('name') + '&reception=' + $(this).attr('value'),
    success: function(msg) {
      saved('#saved-recep');
    },
    error: sorry
  });
}

function submitMenu(radio) {
  $.ajax({
    url: '/rsvp/menu',
    type: 'POST',
    data: 'guest=' + radio.attr('name') + '&menu=' + radio.attr('value'),
    success: function(msg) {
      saved('#saved-menu');
    },
    error: sorry
  });
}

function submitWine() {
  var radio = $(this);
  $.ajax({
    url: '/rsvp/wine',
    type: 'POST',
    data: 'guest=' + $(this).attr('name') + '&wine=' + $(this).attr('value'),
    success: function(msg) {
      saved('#saved-wine');
    },
    error: sorry
  });
}

function showDietary() {
  var done = false;
  $('.menu .special').each(function() {
    var diet = $('#diet-' + $(this).attr('name'));
    if ($(this).hasClass('special') && $(this).attr('checked') == true) {
      var txt = $('#diet-' + $(this).attr('name') + ' input');
      if (txt.attr('value') == '')
        txt.attr('value', 'dietary requirements').css('color', '#ccc');
      diet.slideDown();
      done = true;
    }
  });
  
  if (done)
    return;
  
  $('.menu input[type=radio]').each(function() {
	  if ($(this).attr('checked') == true && !$(this).hasClass('special')) {
		  $('#diet-' + $(this).attr('name')).slideUp();
	  }
  });
}

function saveDietary(txt) {
  $.ajax({
    url: '/rsvp/dietary',
    type: 'POST',
    data: 'guest_id=' + txt.attr('name') + '&requirements=' + txt.attr('value'),
    success: function(msg) {
      saved('#saved-menu');
    },
    error: sorry
  });
}

function showDietHint() {
  var txt = $(this);
  if (txt.attr('value') == 'dietary requirements') {
    txt.attr('value', '');
    txt.css('color', '#000');
  }
}

function hideDietHint(txt) {
  if (txt.attr('value') == '') {
    txt.css('color', '#ccc');
    txt.attr('value', 'dietary requirements');
  }
}
