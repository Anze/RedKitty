// Set caret position easily in jQuery
// Written by and Copyright of Luke Morton, 2011
// Updated by Anze, 2011
// Licensed under MIT
(function ($) {
	// Behind the scenes method deals with browser
	// idiosyncrasies and such
	$.caretTo = function (el, index) {
		if (el.createTextRange) {
			var range = el.createTextRange();
			range.move("character", index);
			range.select();
		} else if (el.selectionStart != null) {
			el.focus();
			el.setSelectionRange(index, index);
		}
	};

	// The following methods are queued under fx for more
	// flexibility when combining with $.fn.delay() and
	// jQuery effects.

	// Set caret to a particular index
	$.fn.caretTo = function (index, offset) {
		return this.queue(function (next) {
			if (isNaN(index)) {
				var i = $(this).val().indexOf(index);

				if (offset === true) {
					i += index.length;
				} else if (offset) {
					i += offset;
				}

				$.caretTo(this, i);
			} else {
				$.caretTo(this, index);
			}

			next();
		});
	};

	// Set caret to beginning of an element
	$.fn.caretToStart = function () {
		return this.caretTo(0);
	};

	// Set caret to the end of an element
	$.fn.caretToEnd = function () {
		return this.queue(function (next) {
			$.caretTo(this, $(this).val().length);
			next();
		});
	};
}(jQuery));

// Store commands history in LocalStorage
$(function () {
	var maxHistory = 100;
	var positionCommand = -1;
	var commandCurrent = '';
	var screen = $('#console pre');
	var input = $('#console input').focus();
	var form = $('#console form');

	var addCommand = function (command) {
		var ls = localStorage['commands'];
		var commands = [];
		if (ls) {
			commands = JSON.parse(ls);
		}
		while(commands.length > maxHistory) {
			commands.shift();
		}
		commands.push(command);
		localStorage['commands'] = JSON.stringify(commands);
	};

	var getCommand = function (at) {
		var ls = localStorage['commands'];
		var commands = [];
		if (ls) {
			commands = JSON.parse(ls);
		}
		if (at < 0) {
			positionCommand = at = -1;
			return commandCurrent;
		}
		if (at >= commands.length) {
			positionCommand = at = commands.length - 1;
		}
		return commands[commands.length - at - 1];
	};

	var scroll = function () {
		window.scrollTo(0,document.body.scrollHeight);
	};

	form.submit(function () {
		var command = $.trim(input.val());
		if (command == '')
			return false;
		if (command == 'clear') {
			screen.html('');
			input.val('');
			return false;
		}
		if (command == 'help') {
			$('<span class="command">redis&rsaquo;&nbsp;'+command+'</span>').appendTo(screen);
			$('<span class="out">use standart redis <a href="http://redis.io/commands" target="_blank">commands</a> and "clear" to clear console output</span>').appendTo(screen);
			input.val('');
			return false;
		}

		$('<span class="command">redis&rsaquo;&nbsp;'+command+'</span>').appendTo(screen);
		scroll();
		input.val('');
		form.hide();
		addCommand(command);

		$.get('?command=' + command, function (output) {
			screen.append('<span class="out">'+output+'</span>');
			form.show();
			// Anze: re-apply focus on input field to allow scroll work
			$('#console input').focus();
			scroll();
		});
		return false;
	});

	input.keydown(function (e) {
		var code = (e.keyCode ? e.keyCode : e.which);

		if (code == 38) {// Up
			if (positionCommand == -1) {
				commandCurrent = input.val();
			}
			input.val(getCommand(++positionCommand)).caretToEnd();
			e.preventDefault();
		}
		else if (code == 40) {// Down
			input.val(getCommand(--positionCommand)).caretToEnd();
			e.preventDefault();
		}
		else {
			positionCommand = -1;
		}
	});

	$(document).click(function () {
		input.focus();
	});
});
